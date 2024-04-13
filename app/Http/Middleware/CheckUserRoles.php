<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoles
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('backpack')->user();

        if ($user && $this->hasRoles($user, $request)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
        // return redirect()->route('dashboard');
    }

    protected function hasRoles($user, $request)
    {
        $roles = explode(',', $user->roles);
        $routeName = $request->route()->getName();
        
        if ($request->route()->getName() === 'dashboard') {
            return true;
        }

        switch ($routeName) {
            case 'user.index':
            case 'user.create':
            case 'user.store':
            case 'user.show':
            case 'user.edit':
            case 'user.update':
            case 'user.destroy':
            case 'user.search': 
            case 'cost-center.index':
            case 'cost-center.create':
            case 'cost-center.store':
            case 'cost-center.show':
            case 'cost-center.edit':
            case 'cost-center.update':
            case 'cost-center.destroy':
            case 'cost-center.search':
            case 'service-type.index':
            case 'service-type.create':
            case 'service-type.store':
            case 'service-type.show':
            case 'service-type.edit':
            case 'service-type.update':
            case 'service-type.destroy':
            case 'service-type.search':
                return in_array('Admin', $roles); // Pages that can access by Admin Role
            case 'requests':
            case 'services.store':
            case 'rate.service':
            case 'service.details':
                return in_array('Requester', $roles); // Submit Request
            case 'services':
            case 'services.search':
            case 'services.approve':
            case 'services.decline':
            case 'services.show':
                return in_array('Manager1', $roles);
            case 'approvedRequests':
            case 'assign.personnel':
                return in_array('Manager2', $roles);
            case 'personnelTask';
            case 'service.done':
                return in_array('Personnel', $roles);
            default:
                return false; // Default Route
        }
    }
}
