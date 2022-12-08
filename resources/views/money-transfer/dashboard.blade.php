@extends('international-transfer::layouts.master')
<link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
@section('content')
    {{-- <div class="grid grid-cols-3 gap-4">
        <div>
            @include('international-transfer::widget.dashboard-piechart')
        </div>
    </div>
    <br> --}}
    {{-- <livewire:transaction-graph-dashboard /> --}}
    <div style="display:flex;">
        <div >
            <select onchange="filter()" >
                <option value="2021">2021</option>
                <option value="2022">2022</option>
            </select >
    <canvas id="transaction" style="width:100%;height:700px;background-color:white;padding:2px;"></canvas>
        </div>
        <div style="width:50%;height:400px;background-color:white;padding:2px;margin-left:2px;">

    <canvas id="transactionPieChart" ></canvas>
    <div style="width:100%;height:180px;background-color:white;margin-top:5px;"> </div>
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
    {{-- <script>
        window.addEventListener('UpdateTransactionChart', event => {
            transactionChart();
        });

        function transactionChart(){
            const labels = {!!json_encode($paidOut->pluck('month'))!!};

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
                    borderColor: '#4baef1', // Add custom color border (Line)
                    // data: JSON.parse(debitChartTransaction),
                    data: {!!json_encode($paidOut->pluck('paidOut'))!!},
                    backgroundColor:"#70297D",
                }]
            };

            const configLineChart = {
                type: 'bar',
                data,
                options: {
                    indexAxis: 'y',
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 5,
                                maxTicksLimit: 11
                            },
                            responsive: true, // Instruct chart js to respond nicely.
                            maintainAspectRatio: true, // Add to prevent default behaviour of full-width/height

                        }],
                    },
                    y: {
                        suggestedMin: 50,
                        suggestedMax: 100
                    },
                    parsing: {
                        xAxisKey: "month",
                        yAxisKey: "total"
                    },
                    responsive: true, // Instruct chart js to respond nicely.
                    maintainAspectRatio: true // Add to prevent default behaviour of full-width/height
                }
            };

            var report_line_chart_data = document.getElementById("chartLine").getContext('2d');
            var chartLine = new Chart(
                report_line_chart_data,
                configLineChart
            );
        }

        $(function() {
            transactionChart();
        });
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script>
var xValues = {!!json_encode($paidOut->pluck('month'))!!};
var yValues = {!!json_encode($paidOut->pluck('paidOut'))!!};
function filter()
{
    alert("hai");
    yValues=[20,30,4,10,11];
}

new Chart("transaction", {
  type: "horizontalBar",
  data: {
  labels: xValues,
  datasets: [{
    backgroundColor: '#4baef1',
    data: yValues
  }]
},
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Paid Out Transactions"
    },
    scales: {
      xAxes: [{ticks: {min: 0}}]
    }
  }
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

