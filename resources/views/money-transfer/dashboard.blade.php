@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    {{-- <div class="grid grid-cols-3 gap-4">
        <div>
            @include('international-transfer::widget.dashboard-piechart')
        </div>
    </div>
    <br> --}}

    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mb-3">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="{{ auth()->user()->getFullName() }}" class="rounded-full" src="{{ auth()->user()->avatar }}">

                </div>
                <div class="ml-5">
                    <div class="truncate sm:whitespace-normal font-medium text-lg">Welcome {{ auth()->user()->getFullName() }}
                    </div>
                    <div class="text-slate-500">A Stronger and Faster way to Send and Receive Money Globally.</div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Profile Info -->

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
            <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 mt-2 lg:mt-6 xl:mt-2">

                <div class="intro-y mt-0">
                    <div class="mt-0 box px-3 pb-3  h-full">
                        <div class="flex items-center py-2 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Recent Activity
                            </h2>

                        </div>

                        <div class="overflow-y-auto h-64 overflow-x-hidden scrollbar-hidden pr-1 pt-1 mt-0 pb-3">
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-9.jpg">
                                    </div>
                                    <div class="ml-3 mr-auto">
                                        <div class="font-medium">Russell Crowe</div>
                                        <div class="text-slate-500 text-xs mt-0.5">23 March 2022</div>
                                    </div>
                                    <div class="text-danger">-$74</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-9.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Robert De Niro</div>
                                        <div class="text-slate-500 text-xs mt-0.5">21 September 2022</div>
                                    </div>
                                    <div class="text-success">+$104</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-5.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">John Travolta</div>
                                        <div class="text-slate-500 text-xs mt-0.5">5 December 2022</div>
                                    </div>
                                    <div class="text-success">+$49</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-7.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Nicolas Cage</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 June 2022</div>
                                    </div>
                                    <div class="text-danger">-$155</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>

                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                            <div class="intro-x">
                                <div class="box px-0 py-2 mb-2 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="/dist/images/profile-10.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">27 November 2021</div>
                                    </div>
                                    <div class="text-danger">-$204</div>
                                </div>
                            </div>
                        </div>
                        <a href=""
                            class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View
                            More</a>
                    </div>
                </div>
            </div>
            <!--Static Code-->
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
    <!-- Chart line -->
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
                    //     {
                    //     label: 'PAID IN',
                    //     fill: false,
                    //     borderColor: '#002366', // Add custom color border (Line)
                    //     data: JSON.parse(creditChartTransaction),
                    // },
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

            report_line_chart_data = document.getElementById("chartLine").getContext('2d');

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
    <script>
        const dataTransactionDoughnut = {
            labels: {!! json_encode($pieChartTransactions->pluck('label')) !!},
            datasets: [{
                label: 'Transactions',
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
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
@endpush
