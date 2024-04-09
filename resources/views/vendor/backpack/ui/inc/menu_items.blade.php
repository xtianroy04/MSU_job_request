@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if($user && strpos($user->roles, '') !== false) {
            $roles = explode(',', $user->roles);
        }
    @endphp

    @isset($roles)    
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
        @if(in_array('Admin', $roles))
           <x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />
           <x-backpack::menu-item title="Cost centers" icon="la la-building" :link="backpack_url('cost-center')" />
           <x-backpack::menu-item title="Service types" icon="la la-cogs" :link="backpack_url('service-type')" />
        @endif

        @if(in_array('Requester', $roles))
              <li class="nav-item"><a class="nav-link" href="{{ backpack_url('requests') }}"><i class="la la-wrench"></i> Request Service</a></li>
        @endif

        @if(in_array('Manager1', $roles))
             <li class="nav-item"><a class="nav-link" href="{{ backpack_url('services') }}"><i class="la la-tools"></i> Service Requests</a></li>
        @endif
        @if(in_array('Manager2', $roles))
              <li class="nav-item"><a class="nav-link" href="{{ backpack_url('approvedRequests') }}"><i class="la la-thumbs-up"></i> Approved Requests</a></li>
        @endif

        @if(in_array('Personnel', $roles))
              <li class="nav-item"><a class="nav-link" href="{{ backpack_url('personnelTask') }}"><i class="la la-clock-o"></i> My Task</a></li>
        @endif
    @endif
@endauth
