<div class="text-center sm:text-left bg-gray-200 col-span-12 sm:col-span-6 xxl:col-span-6 box p-5 cursor-pointer zoom-in">
    <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Sub Account Details</div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Account Number</div>
        <div class="text-gray-600 break-all">{{$account?->meta['account_number']}}</div>
    </div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Sort Code</div>
        <div class="text-gray-600 break-all">{{$account?->meta['routing_code']}}</div>
    </div>
    <div class="sm:pl-1">
        <div class="font-medium text-theme-1 dark:text-theme-10 text-l">Account Balance</div>
        <div class="text-gray-600 break-all">£ {{ $account?->balance}} </div>
    </div>
    <button class="btn btn-primary" id="ViewAll">View All</button>
</div>
<script>
document.getElementById('ViewAll').addEventListener('click', function() {
  window.location.href = "{{ route('dashboard.international-transfer.balance.index') }}";
});
</script>
