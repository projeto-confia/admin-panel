<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <h1>Notícias</h1>

    <div class="card card-search">
        <form action="/report/news_chart" method="get" class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="start_date" name="start_date" placeholder="dd/mm/yyyy">
                    <label for="start_date">Data Inicial</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="end_date" name="end_date" placeholder="dd/mm/yyyy">
                    <label for="end_date">Data Final</label>
                </div>
            </div>
            <!-- <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_all" value="all" checked>
                    <label class="form-check-label" for="classification_all">Todas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_true" value="1">
                    <label class="form-check-label" for="classification_true">Verdadeira</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_false" value="0">
                    <label class="form-check-label" for="classification_false">Falsa</label>
                </div>
            </div> -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary float-end">Gerar</button>
            </div>
        </form>
    </div>

    <div class="card">
        <canvas id="myChart" width="770" height="385" style="display:block"></canvas>
    </div>
    
    @push('scripts')
        <script defer>

            document.addEventListener('DOMContentLoaded', () => {

                var { labels, data } = {!! $data !!};
                // console.log(dataJson.labels);

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        // labels: labels,
                        labels,  // forma simplificada
                        datasets: [{
                            label: '# of Votes',
                            // data: data,
                            data, // forma simplificada
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });

        </script>
    @endpush
</x-layouts.app>
