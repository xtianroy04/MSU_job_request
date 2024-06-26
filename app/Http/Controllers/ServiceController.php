<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Mail\ServiceRequested;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceController extends Controller
{
     // manager who will approve request service function
    public function services(Request $request)
    {
       
        $query = Service::query();
        $searchQuery = '';


        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('service_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('service_provider', 'like', '%' . $searchTerm . '%')
                ->orWhere('status', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('serviceType', function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });

            $searchQuery = $searchTerm;
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('vendor/backpack/ui/services', ['services' => $services, 'searchQuery' => $searchQuery]);
    }

    public function approve($id)
    {
        $service = Service::findOrFail($id);
        
        if ($service->status === 'Approved') {
            return redirect()->back()->with('error', 'Request has already been approved.');
        } elseif ($service->status === 'Declined') {
            return redirect()->back()->with('error', 'Request has already been disapproved.');
        }
    
        $signaturePath = 'images/signature/signature.png';
        $storagePath = public_path($signaturePath);
        Storage::disk('public')->put($signaturePath, file_get_contents($storagePath));
    
        $service->status = 'Approved';
        $service->approved_by = auth('backpack')->user()->id;  
        $service->date_approved = Carbon::now()->toDateString();
        $service->e_signature = $signaturePath; 
        $service->save();
    
        return redirect()->back()->with('success', 'Request approved successfully.');
    }

    public function decline($id)
    {
        $service = Service::findOrFail($id);
 
        if ($service->status === 'Approved') {
            return redirect()->back()->with('error', 'Request has already been approved.');
        } elseif ($service->status === 'Declined') {
            return redirect()->back()->with('error', 'Request has already been declined.');
        }

        $service->status = 'Declined';
        $service->date_declined = Carbon::now()->toDateString();
        $service->save();

        return redirect()->back()->with('success', 'Request declined successfully.');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('vendor/backpack/ui/serviceShow', compact('service'));
    }

    // manager who will assign personnel
    public function approvedRequests(Request $request)
    {
        $searchQuery = $request->input('search');

        $users = User::all();
        $personnel = $users->filter(function ($user) {
            $roles = explode(',', $user->roles);      
            return in_array('Personnel', $roles);
        });

        $approvedServicesQuery = Service::where('status', 'Approved')
                                        ->orderBy('created_at', 'desc');

        if (!empty($searchQuery)) {
            $approvedServicesQuery->where(function ($query) use ($searchQuery) {
                $query->where('service_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('service_provider', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('serviceType', function($q) use ($searchQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhere('details', 'like', '%' . $searchQuery . '%');
            });
        }

        $approvedServices = $approvedServicesQuery->paginate(10);

        return view('vendor/backpack/ui/approvedRequests', [
            'approvedServices' => $approvedServices, 
            'personnel' => $personnel,
            'searchQuery' => $searchQuery,
        ]);
    }



    public function assignPersonnel(Request $request)
    {
        $request->validate([
            'requestId' => 'required|exists:services,id',
            'personnel' => 'required|exists:users,id',
        ]);
    
        $service = Service::findOrFail($request->requestId);
    
        if ($service->assigned !== null) {
            return redirect()->back()->with('error', 'Personnel already assigned to this service.');
        }
    
        $service->assigned = $request->personnel;
        $service->date_assigned = Carbon::now()->toDateString();
        $service->save();
    
        return redirect()->back()->with('success', 'Personnel assigned successfully.');
    }
    
    // Requester Function
    public function index()
    {
        $userId = auth('backpack')->user()->id;
        $serviceTypes = ServiceType::all();
        $services = Service::where('user_id', $userId)
                            ->with('serviceType')
                            ->orderBy('created_at', 'desc')
                            ->paginate('10');

        return view('vendor/backpack/ui/requestServices', ['services' => $services, 'serviceTypes' => $serviceTypes]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'serviceProvider' => 'required',
            'serviceName' => 'required',
            'serviceType' => 'required|exists:service_types,id',
            'details' => 'required',
        ]);

        $userId = auth('backpack')->user()->id;

        $service = new Service();
        
        $service->user_id = $userId; 
        $service->service_provider = $validatedData['serviceProvider'];
        $service->service_name = $validatedData['serviceName'];
        $service->service_type_id = $validatedData['serviceType']; 
        $service->details = $validatedData['details'];
        $service->status = 'Pending';
        $service->save();

        // // Send email to users with role "Manager1"
        // $users = User::all();

        // foreach ($users as $user) {
        //     $roles = explode(',', $user->roles);
        //     if (in_array('Manager1', $roles)) {
        //         Mail::to($user->email)->send(new ServiceRequested($service));
        //     }
        // }
        
        return redirect()->route('requests')->with('success', 'Service requested successfully!');
    }

    // View details
    public function showDetails($id)
    {
        try {
            $userId = auth('backpack')->user()->id;
            $service = Service::findOrFail($id);

            if ($service->user_id !== $userId) {
                return redirect()->back()->with('error', 'You are not authorized to view this service.');
            }

            return view('vendor/backpack/ui/showDetails', compact('service'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Service not found.');
        }
    }

    // Rating
    public function rateService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id', 
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        
        if ($request->rating === null) {
            return redirect()->back()->with('error', 'Please provide a rating.');
        }

        $service = Service::findOrFail($request->service_id);
        $service->service_rating = $request->rating;
        $service->date_rated = Carbon::now()->toDateString();;
        $service->save();

        return redirect()->back()->with('success', 'Rating submitted successfully.');
    }


    // Personnel
    public function task(Request $request)
    {
        $userId = auth('backpack')->user()->id;
        $serviceTypes = ServiceType::all();
        
        $searchQuery = $request->input('search');
        $servicesQuery = Service::where('assigned', $userId)
                                ->with('serviceType')
                                ->orderBy('created_at', 'desc');
        if (!empty($searchQuery)) {
            $servicesQuery->where(function ($query) use ($searchQuery) {
                $query->where('service_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('service_provider', 'like', '%' . $searchQuery . '%')
                    ->orWhere('details', 'like', '%' . $searchQuery . '%');
            });
        }
        $services = $servicesQuery->paginate(10);
        return view('vendor/backpack/ui/personnelTask', compact('services', 'searchQuery'));
    }

    public function serviceDone($id)
    {
        $service = Service::findOrFail($id);
        
        if ($service->date_served) {
            return redirect()->back()->with('error', 'Request has already been completed.');
        } 

        $service->date_served = Carbon::now()->toDateString();
        $service->save();
    
        return redirect()->back()->with('success', 'Request completed successfully.');
    }

    
}
