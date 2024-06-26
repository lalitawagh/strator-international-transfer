@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
<style>
    span.recent-activity {
        justify-content: center;
        display: flex;
        align-self: center;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        right: 0;
    }
</style>
@section('content')
    <div class="intro-y box px-5 pt-5 mb-3">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 flex-wrap px-5 items-center gap-3 justify-center lg:justify-start">
                <div class="w-16 h-16 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="{{ auth()->user()->getFullName() }}" class="rounded-full" src="{{ auth()->user()->avatar }}">

                </div>
                <div class="sm:ml-5 text-center sm:text-left">
                    <div class="truncate sm:whitespace-normal font-medium text-lg">Welcome
                        {{ auth()->user()->getFullName() }}
                    </div>
                    <div class="text-slate-500">A stronger and faster way to send and receive money globally.</div>
                </div>
                @if (config('services.registration_changed') == true)
                    @if ($kycSkip?->value == 'true')
                        <div class="sm:ml-auto">
                            @if (!is_null($user))
                                <a id="SubmitKYC" href="{{ route('dashboard.reupload-document', $user?->id) }}"
                                    class="btn btn-sm btn-primary sm:ml-2 py-2 sm:mb-2 mb-2">Submit KYC</a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
    <div class="intro-y col-span-12 lg:col-span-12">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-8 xl:col-span-6 mt-2 h-full ">
                <livewire:international-transfer-graph />
            </div>
            <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 mt-2 lg:mt-6 xl:mt-2">
                <div class="box shadow-lg p-2  h-full">
                    <div class=" text-lg font-medium mr-auto mt-2">
                        Transaction Status
                    </div>

                    <div class="h-[310px]">
                        <canvas id="transactionPieChart"></canvas>
                        {{-- <canvas id="donut-chart-widget"></canvas> --}}
                    </div>
                </div>
            </div>
            <!--Static Code-->
            @if (!$user->isSubscriber())
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 mt-2 lg:mt-6 xl:mt-2">

                    <div class="intro-y mt-0">
                        <div class="mt-0 box px-3 pb-3  h-full">
                            <div class="flex items-center py-2 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Recent Activity
                                </h2>

                            </div>

                            <div class="overflow-y-auto h-64 overflow-x-hidden scrollbar-hidden pr-1 pt-1 mt-0 pb-3">
                                @foreach ($recentTransactions as $recentTransaction)
                                    <div class="intro-x">
                                        <div class="box px-2 py-2 mb-2 flex items-center zoom-in">
                                            <div class="w-8 h-8 mr-2">
                                                @php
                                                    $str = $recentTransaction['meta']['sender_name'];
                                                    $strname = preg_replace('/\s+/', ' ', $str);
                                                    $name = explode(' ', $strname);
                                                    $fname = substr($name[0], 0, 1);
                                                    $lname = substr(@$name[1], 0, 1);
                                                @endphp
                                                <div
                                                    class="dark:bg-darkmode-400 dark:border-darkmode-400 bg-gray-200 bg-theme-14 text-theme-10 w-10 h-10 relative rounded-full">
                                                    <span class="recent-activity">
                                                        @isset($recentTransaction['meta']['sender_name']) {{ ucfirst($fname) }}
                                                            {{ ucfirst($lname) }}
                                                        @else
                                                            {{ ucfirst(substr($recentTransaction['meta']['sender_name'], 0, 1)) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3 mr-auto">
                                                <div class="font-medium">{{ $recentTransaction['meta']['sender_name'] }}
                                                </div>
                                                <div class="text-slate-500 text-xs mt-0.5">
                                                    {{ $recentTransaction['created_at'] }}</div>
                                            </div>
                                            <div class="text-danger">
                                                -{{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($recentTransaction->amount, $recentTransaction->meta['base_currency']) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('dashboard.international-transfer.money-transfer.index') }}"
                                class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View
                                More</a>
                        </div>
                    </div>
                </div>
            @endif
            @if ($user->isSubscriber())
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 mt-2 lg:mt-6 xl:mt-2">
                    <div class="intro-y mt-0">
                        <div class="mt-0 box px-3 pb-3  h-full">
                            <div class="flex items-center py-2 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Recent Activity
                                </h2>

                            </div>

                            <div class="overflow-y-auto h-64 overflow-x-hidden scrollbar-hidden pr-1 pt-1 mt-0 pb-3">
                                @foreach ($recentUserTransactions as $recentUserTransaction)
                                    <div class="intro-x">
                                        <div class="box px-2 py-2 mb-2 flex items-center zoom-in">
                                            <div class="w-8 h-8 mr-2">
                                                @php
                                                    $str = $recentUserTransaction->meta['second_beneficiary_name'];
                                                    $name = explode(' ', $str);
                                                    $fname = substr($name[0], 0, 1);
                                                    $lname = substr(@$name[1], 0, 1);
                                                @endphp
                                                <div
                                                    class="dark:bg-darkmode-400 dark:border-darkmode-400 bg-gray-200 bg-theme-14 text-theme-10 w-10 h-10 relative rounded-full">
                                                    <span class="recent-activity">
                                                        @isset($recentUserTransaction->meta['second_beneficiary_name']) {{ ucfirst($fname) }}
                                                            {{ ucfirst($lname) }}
                                                        @else
                                                            {{ ucfirst(substr($recentUserTransaction->meta['second_beneficiary_name'], 0, 1)) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3 mr-auto">
                                                <div class="font-medium">
                                                    {{ $recentUserTransaction->meta['second_beneficiary_name'] }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">
                                                    {{ $recentUserTransaction->created_at }}</div>
                                            </div>
                                            <div class="text-danger">
                                                -{{ \Kanexy\InternationalTransfer\Http\Helper::getExchangeRateAmount($recentUserTransaction->amount, $recentUserTransaction->meta['base_currency']) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('dashboard.international-transfer.money-transfer.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]) }}"
                                class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View
                                More</a>
                        </div>
                    </div>
                </div>
            @endif
            @if ($user->isSubscriber())
                <div class="intro-y col-span-12 md:col-span-4 lg:col-span-4 intro-y h-full">
                    <div class="box shadow-lg p-3">
                        <div class="text-lg font-medium mr-auto mt-2">Sub Account</div>
                        <ul class="mt-1">
                            <li class="w-full flex justify-between my-3"><span class="font-medium w-3/4">Account Holder Name </span>
                                <p class="w-2/3 text-sm break-all">{{ ucwords(@$subAccountInfo->meta['account_holder_name']) }}</p>
                            </li>
                            <li class="w-full flex justify-between my-3"><span class="font-medium w-3/4">Account Number</span>
                                <p class="w-2/3 text-sm break-all">{{ @$subAccountInfo->meta['account_number'] }}</p>
                            </li>
                            <li class="w-full flex justify-between my-3"><span class="font-medium w-3/4">Sort Code</span>
                                <p class="w-2/3 text-sm break-all">{{ @$subAccountInfo->meta['routing_code'] }}</p>
                            </li>
                            <li class="w-full flex justify-between my-3"><span class="font-medium w-3/4">Currency </span>
                                <p class="w-2/3 text-sm break-all">{{ ucwords(@$subAccountInfo->meta['currency']) }}</p>
                            </li>
                            <li class="w-full flex justify-between my-3"><span class="font-medium w-3/4">Type </span>
                                <p class="w-2/3 text-sm break-all">{{ ucwords(@$subAccountInfo->meta['legal_entity_type']) }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="intro-y col-span-12 lg:col-span-12 mt-5">
        <div class="gap-4">
            <div class="intro-y col-span-12">
                <div class="box shadow-lg  p-5">
                    <div class="text-lg font-medium mr-auto mt-2">Latest Transactions</div>
                    <div class="Livewire-datatable-modal pb-3">
                        <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\DashboardList'
                            params="{{ $workspace?->id }}" type="money-transfer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const dataTransactionDoughnut = {
            labels: {!! json_encode($pieChartTransactions->pluck('label')) !!},
            datasets: [{
                label: 'Transactions',
                backgroundColor: [
                    'rgb(139, 195, 74)',
                    'rgb(235, 54, 79)',
                    'rgb(76, 175, 80)',
                    'rgb(255, 87, 34)',
                    'rgb(255, 152, 0)',
                    'rgb(255, 193, 7)',
                ],
                data: {!! json_encode($pieChartTransactions->pluck('data')) !!},
            }]
        };
        const configTransactionDoughnut = {
            type: 'doughnut',
            data: dataTransactionDoughnut,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };

        var transaction_pie_chart = new Chart(
            document.getElementById('transactionPieChart'),
            configTransactionDoughnut,
        );
    </script>
    <script>
        var chartLine = null;
        window.addEventListener('UpdateTransactionChart', event => {
            transactionChart();

        });

        function transactionChart() {

            const labels = [

                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'

            ];

            // var creditChartTransaction = document.getElementById("updateCredit").innerHTML;

            var debitChartTransaction = document.getElementById("updateDebit").innerHTML;
            const data = {

                labels: labels,

                datasets: [

                    {

                        label: 'PAID OUT',

                        fill: false,

                        backgroundColor: '#002366',

                        // borderColor: '#4baef1', // Add custom color border (Line)

                        indexAxis: 'y',

                        data: JSON.parse(debitChartTransaction),

                    }

                ]

            };
            const configLineChart = {

                type: 'bar',

                data,
            };
            var report_line_chart_data = document.getElementById("chartLine").getContext('2d');
            if (chartLine !== null) {

                chartLine.destroy();

            }
            chartLine = new Chart(

                report_line_chart_data,

                configLineChart

            );
        }
        $(function() {
            transactionChart();

        });
    </script>
@endpush
