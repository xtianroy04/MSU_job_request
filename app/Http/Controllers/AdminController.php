<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\CostCenter;
use App\Models\ServiceType;
use Illuminate\Routing\Controller;
use App\Library\Widget;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        $user = auth()->guard('backpack')->user();
        $this->data['title'] = trans('backpack::base.dashboard'); 
        $widgets = [];
        $progressWidgets = [];
        $accomplishedRequest = Service::whereNotNull('service_rating')  ->orderBy('created_at', 'desc')->paginate(10);
        $needPersonnelRequest = Service::where('assigned')
                                        ->whereNull('service_rating') 
                                        ->where('status', 'Approved')     
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10);
        $satisfiedRequests = Service::where('assigned', $user->id)->whereBetween('service_rating', [4, 5])->paginate(10);
    
        if ($user) {
            // Check if the user has the "Admin" role
            if (strpos($user->roles, 'Admin') !== false) {
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-users'])
                    ->progressClass('progress-bar')
                    ->value(User::count())
                    ->description('Users');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start')
                    ->accentColor('warning') 
                    ->ribbon(['top', 'la-building'])
                    ->progressClass('progress-bar')
                    ->value(CostCenter::count())
                    ->description('Cost Centers');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('secondary') 
                    ->ribbon(['top', 'la-wrench']) 
                    ->progressClass('progress-bar')
                    ->value(ServiceType::count())
                    ->description('Service Types');
            }

             // Check if the user has the "Requester" role
             if (strpos($user->roles, 'Requester') !== false) {
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('warning') 
                    ->ribbon(['top', 'la-hourglass']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('user_id', $user->id)->where('status', 'Pending')->count())
                    ->description('Pending Request');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('danger') 
                    ->ribbon(['top', 'la-times']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('user_id', $user->id)->where('status', 'Declined')->count())
                    ->description('Declined Request');
                
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-check']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('user_id', $user->id)->where('status', 'Approved')->count())
                    ->description('Approved Request');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('warning') 
                    ->ribbon(['top', 'la-star']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('user_id', $user->id)
                                    ->where('status', 'Approved')
                                    ->whereNull('service_rating')->count())
                    ->description('Need Rate');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-check-square']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('user_id', $user->id)->whereNotNull('service_rating')->count())
                    ->description('Request Complete');
            }
            
            // Check if the user has the "Manager1" role
            if (strpos($user->roles, 'Manager1') !== false) {
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-thumbs-up']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('status', 'Approved')->whereNull('service_rating')->count())
                    ->description('Approved Request');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('danger') 
                    ->ribbon(['top', 'la-times-circle']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('status', 'Declined')->count())
                    ->description('Declined Request');

                    $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-check-circle']) 
                    ->progressClass('progress-bar')
                    ->value(Service::whereNotNull('service_rating')->count())
                    ->description('Accomplished Request');
            }

            // Check if the user has the "Manager2" role
            if (strpos($user->roles, 'Manager2') !== false) {
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('warning') 
                    ->ribbon(['top', 'la-hammer']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('status', 'Approved')->whereNull('assigned')->count()                    )
                    ->description('Need Personnel');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-thumbs-up']) 
                    ->progressClass('progress-bar')
                    ->value(Service::wherenotNull('assigned')->count())
                    ->description('Service Assigned');
            }

            // Check if the user has the "Personnel" role
            if (strpos($user->roles, 'Personnel') !== false) {
                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('warning') 
                    ->ribbon(['top', 'la-hammer']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('assigned', $user->id)->whereNull('service_rating')->count())
                    ->description('Pending Task');

                $widgets[] = Widget::make()
                    ->type('progress')
                    ->class('card mb-3')
                    ->statusBorder('start') 
                    ->accentColor('success') 
                    ->ribbon(['top', 'la-thumbs-up']) 
                    ->progressClass('progress-bar')
                    ->value(Service::where('assigned', $user->id)->whereNotNull('service_rating')->count())
                    ->description('Completed Task');
            }
        }

        Widget::add()
            ->to('before_content')
            ->type('div')
            ->class('row justify-content-center')
            ->content($widgets);

        Widget::add()
            ->type('script')
            ->stack('after_scripts')
            ->content('assets/dashboard/jquery.js');
        
        Widget::add()
            ->type('style')
            ->stack('after_styles')
            ->content('assets/dashboard/light.css');

        $counts = [
            'progressWidgets' => $progressWidgets,
            'accomplishedRequest' => $accomplishedRequest,
            'satisfiedRequests' => $satisfiedRequests,
            'needPersonnelRequest' => $needPersonnelRequest
        ];
        return view(backpack_view('dashboard'), $counts, $this->data);
    }


    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}

