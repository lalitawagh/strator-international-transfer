{{-- @if(auth()->user()->hasPermissionTo(\Kanexy\PartnerFoundation\Core\Enums\Permission::WRAPPEX_SETTINGS_VIEW)) --}}
    <li class="nav-item"><a id="cc-account-settings-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#cc-account-settings"
        role="tab" aria-controls="cc-account-settings" aria-selected="false"
        class="nav-link flex items-center px-3 py-2 mt-2 @if(session('tab') == 'cc-account-settings') active @endif">
        CC Account Settings
    </a></li>
{{-- @endif --}}

