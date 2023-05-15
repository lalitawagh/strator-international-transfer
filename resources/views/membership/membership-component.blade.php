@if(!auth()->user()->isSubscriber())
@if (config('services.registration_changed') == true)
    <li id="ExchangeRate-tab" class="nav-item flex-1" role="presentation">
        <a data-tw-toggle="pill" data-tw-target="#ExchangeRate-tab" type="button" role="tab"
            aria-controls="ExchangeRate-tab" aria-selected="true"
            href="{{ route('dashboard.workspaces.membership-exchangerate-information',app('activeWorkspaceId')) }}"
            class="nav-link w-full px-3 py-2 mt-2 {{ request()->routeIs('dashboard.workspaces.membership-exchangerate-information', app('activeWorkspaceId')) ? 'active' : '' }}">
            Exchange Rate
        </a>
    </li>
@endif
@endif
