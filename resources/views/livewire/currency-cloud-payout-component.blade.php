
<div>
    @if(is_null(@$transaction?->meta['currency_cloud_payment_id']) || $transaction?->meta['currency_cloud_status'] == 'failed')
        <div class="py-5">
            <form action="{{ route("currencycloudpayout.store")}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" value="{{ $transaction?->id }}" name="payment">
                <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-8 mt-0">
                    <div class="col-span-12 md:col-span-12 form-inline mt-2" style="align-items: inherit;">
                        <div class="sm:w-5/6">
                            <input id="payout" class="form-check-input contact-type" type="radio" name="type" value="" checked>
                            <label class="form-check-label" for="payout">Currency Cloud Payout</label>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button id="PayoutSubmit" type="submit"
                        class="btn btn-sm btn-primary w-24 mr-1">Submit</button>
                </div>
            </form>
        </div>
    @endif
    @if(!is_null(@$transaction?->meta['currency_cloud_payment_id']))
        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-12">
                <div class="box">
                    <div class="overflow-x-auto overflow-y-auto">
                        <table class="table table-bordered shroting display">
                            <thead class="short-wrp dark:bg-darkmode-400 dark:border-darkmode-400">
                                <tr class="bg-gray-200 dark:bg-dark-1">
                                    <th class="whitespace-nowrap">Currency Cloud Transactions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr class="bg-gray-200 dark:bg-dark-1">
                                                <th scope="col" class="py-3 px-6 w-60">
                                                    Field
                                                </th>
                                                <th scope="col" class="py-3 px-6">
                                                    Value
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b dark:bg-gray-700 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-gray">
                                                    <h5>
                                                        Payment ID
                                                    </h5>
                                                <td
                                                    class="font-medium text-gray-900 whitespace-nowrap dark:text-gray py-4 px-6">
                                                    {{ @$transaction?->meta['currency_cloud_payment_id']}}
                                                </td>
                                                </th>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-700 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-gray">
                                                    <h5>
                                                        Payment Status
                                                    </h5>
                                                <td
                                                    class="font-medium text-gray-900 whitespace-nowrap dark:text-gray py-4 px-6">
                                                    {{ @$transaction?->meta['currency_cloud_status']}}
                                                </td>
                                                </th>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-700 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-gray">
                                                    <h5>
                                                        Payment Date
                                                    </h5>
                                                <td
                                                    class="font-medium text-gray-900 whitespace-nowrap dark:text-gray py-4 px-6">
                                                    {{ @$transaction?->meta['currency_cloud_payment_date']}}
                                                </td>
                                                </th>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-700 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-gray">
                                                    <h5>
                                                        Payment Short Reference
                                                    </h5>
                                                <td
                                                    class="font-medium text-gray-900 whitespace-nowrap dark:text-gray py-4 px-6">
                                                    {{ @$transaction?->meta['currency_cloud_short_reference']}}
                                                </td>
                                                </th>
                                            </tr>
                                            <tr class="bg-white border-b dark:bg-gray-700 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-gray">
                                                    <h5>
                                                        Payment Payer ID
                                                    </h5>
                                                <td
                                                    class="font-medium text-gray-900 whitespace-nowrap dark:text-gray py-4 px-6">
                                                    {{ @$transaction?->meta['currency_cloud_payer_id']}}
                                                </td>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
