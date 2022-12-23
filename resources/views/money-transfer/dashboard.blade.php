@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    {{-- <div class="grid grid-cols-3 gap-4">
        <div>
            @include('international-transfer::widget.dashboard-piechart')
        </div>
    </div>
    <br> --}}

    <div class="intro-y col-span-12 lg:col-span-12">
        <div class="grid grid-cols-12 gap-4">
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-6 intro-y h-full ">
                <livewire:international-transfer-graph />
            </div>
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-6 intro-y ">
                <div class="box shadow-lg p-2 ">
                    <div class=" text-lg font-medium mr-auto mt-2">
                        Transaction Status
                    </div>

                    <div class="h-[310px]">
                        <canvas id="transactionPieChart"></canvas>
                        {{-- <canvas id="donut-chart-widget"></canvas> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y col-span-12 lg:col-span-12 mt-5">
        <div class="gap-4">
            <div class="intro-y col-span-12">
                <div class="box shadow-lg  p-5">
                        <div class="text-lg font-medium mr-auto mt-2">Latest Transactions</div>
                        <div class="Livewire-datatable-modal pb-3">
                            <livewire:data-table model='Kanexy\InternationalTransfer\Contracts\DashboardList' params="{{$workspace?->id}}" type="money-transfer"/>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart line -->
    <script>
           var chartLine =null;
        window.addEventListener('UpdateTransactionChart', event => {
            transactionChart();

        });

        function transactionChart(){
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
                }]
            };

            const configLineChart = {
                type: 'bar',
                data,



            };

            report_line_chart_data = document.getElementById("chartLine").getContext('2d');

            if(chartLine!==null)
            {
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

