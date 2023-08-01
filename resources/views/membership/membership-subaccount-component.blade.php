<div class="text-center sm:text-left bg-gray-200 col-span-12 sm:col-span-6 xxl:col-span-6 box p-5 cursor-pointer zoom-in">
    <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Sub Account Details</div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Account Number: </div>
        <div class="text-gray-600 break-all">{{ @$ccaccount?->meta['account_number']}}</div>
    </div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Sort Code: </div>
        <div class="text-gray-600 break-all">{{ @$ccaccount?->meta['routing_code']}}</div>
    </div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Balance</div>
        <div class="text-gray-600 break-all">{{ @$balances?->balance}} GBP</div>
    </div>
    <button class="btn btn-sm btn-primary float-right shadow-md ml-2 sm:mb-0 mb-2">
        <a href="{{ route('dashboard.international-transfer.balance-currency', app('activeWorkspaceId')) }}">
            View All
        </a>
    </button>
</div>
