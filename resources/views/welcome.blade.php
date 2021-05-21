<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>
    <main class="welcome-page pb-3">

        <div class="row">
            <section>
                <div id="cards" class="d-flex flex-wrap gap-3 justify-content-center my-4">
                    <div class="card">
                        <p class="card-title fs-5">Total de notícias capturadas</p>
                        <p class="fs-1 text card__number-count">{{ $totalNews }}</p>
                    </div>
                    <div class="card">
                        <p class="card-title fs-5">Notícias analisadas pelo Automata</p>
                        <p class="fs-1 text card__number-count">{{ $totalNewsPredicted }}</p>
                    </div>
                    <div class="card">
                        <p class="card-title fs-5">Notícias checadas pelas agências</p>
                        <p class="fs-1 text card__number-count">{{ $totalNewsChecked }}</p>
                    </div>
                    <div class="card">
                        <p class="card-title fs-5">Notícias aguardando checagem</p>
                        <p class="fs-1 text card__number-count">{{ $totalNewsToBeChecked }}</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="row">
            <section class="col-12 col-lg-5">
                <div class="d-flex align-items-center donut-graphic-container" aria-label="Desempenho do AUTOMATA">
                    <canvas
                        id="performanceAutomata"
                        style="display: block; box-sizing: border-box; height: 400px; width: 400px;"
                    >
                    </canvas>
                </div>
            </section>

            <section class="col-12  col-lg-7">
                <div class="d-flex flex-wrap justify-content-around">
                    <div class="mb-1 data-by-user">
                        <canvas id="rateFakeChart" style="display: block; box-sizing: border-box; height: 400px; width: 400px;"></canvas>
                    </div>
                    <div class="mb-1 data-by-user">
                        <canvas id="rateNotFakeChart" style="display: block; box-sizing: border-box; height: 400px; width: 400px;"></canvas>
                    </div>
                </div>

            </section>
        </div>
    </main>
    @push('scripts')
        <script defer>
           window.addEventListener('load', function () {
               {{--      Load Top Fake Users      --}}
               const LABEL_MAX_SIZE = 10;

               const truncateLabels = labels => labels
                   .map(label => label.toString())
                   .map(label => label.length <= LABEL_MAX_SIZE ? label : label.slice(0, LABEL_MAX_SIZE) + '...')

               const getColors = (quantity) => {
                   const primaryColor = '#61cac3';
                   const secondaryColor = '#8ed3df';
                   const colors = [];
                   for (let i = 0; i < quantity; i++) {
                       const color = i % 2 === 0 ? primaryColor : secondaryColor;
                       colors.push(color);
                   }
                   return colors;
               }

                const toPercent = function (num) { return (Number(num) * 100).toFixed(2) }

                const topFakeUsers = {!! $topFakeUsersJson !!};

                const topFakeUsersRates = topFakeUsers.rate_fake_news.map(toPercent);

                const canvasDrawingContextTopFakeUsers = document.getElementById('rateFakeChart').getContext('2d');

                new Chart(canvasDrawingContextTopFakeUsers, {
                    type: 'bar',
                    data: {
                         datasets: [{
                            data: topFakeUsersRates,
                            backgroundColor: getColors(topFakeUsers.id_account_social_media.length),
                         }],
                         labels: truncateLabels(topFakeUsers.id_account_social_media),
                    },
                    options: {
                        responsive: true,
                        legend: { display: false },
                        title: {
                            display: true,
                            responsive: true,
                            text: 'Taxa de transmissão de possíveis fake news por usuário, de acordo com o Automata'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            }]
                        },
                        tooltips: {
                            enabled: true,
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Taxa de ' + topFakeUsersRates[tooltipItem.index] + '%';
                                },
                                afterLabel: function(tooltipItem) {
                                    return 'Fake news: ' + topFakeUsers.total_fake_news[tooltipItem.index] + '\nNotícias disseminadas: ' + topFakeUsers.total_news[tooltipItem.index];
                                }
                            }
                        },
                    },
                });

               {{--      Load Top NOT Fake Users      --}}
                const topNotFakeUsersJson = {!! $topNotFakeUsersJson !!};
                const topNotFakeUsersRates = topNotFakeUsersJson.rate_not_fake_news.map(toPercent);

                const canvasDrawingContextTopNotFakeUsers = document.getElementById('rateNotFakeChart').getContext('2d');
                new Chart(canvasDrawingContextTopNotFakeUsers, {
                    type: 'bar',
                    data: {
                         datasets: [{
                            data: topNotFakeUsersRates,
                            backgroundColor: getColors(topNotFakeUsersJson.id_account_social_media.length),
                         }],
                         labels: truncateLabels(topNotFakeUsersJson.id_account_social_media),
                    },
                    options: {
                        responsive: true,
                        legend: { display: false },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            }]
                        },
                        tooltips: {
                            enabled: true,
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Taxa de ' + topNotFakeUsersRates[tooltipItem.index] + '%';
                                },
                                afterLabel: function(tooltipItem) {
                                    const total = topNotFakeUsersJson.total_news[tooltipItem.index];
                                    const total_real = topNotFakeUsersJson.total_not_fake_news[tooltipItem.index];
                                    return 'Notícias reais: ' + total_real + '\nNotícias disseminadas: ' + total;
                                }
                            }
                        },
                        title: {
                            display: true,
                            responsive: true,
                            text: 'Taxa de transmissão de possíveis notícias reais por usuário, de acordo com o Automata'
                        }
                    },
                });

               {{--     Automata Performance    --}}
                const newsCorrectlyPredictedCount = '{!! $newsCorrectlyPredictedCount !!}';
                const totalNewsChecked = '{!! $totalNewsChecked !!}';
                const data = [+newsCorrectlyPredictedCount, (+totalNewsChecked - +newsCorrectlyPredictedCount)];

                const canvasDrawingContextAutomataPerf = document.getElementById('performanceAutomata').getContext('2d');
                new Chart(canvasDrawingContextAutomataPerf, {
                    type: 'doughnut',
                    data: {
                        labels: ['Acertos', 'Erros'],
                        datasets: [{
                            data,
                            backgroundColor: ['#20c997', '#dc3545'],
                            borderWidth: 1,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            enabled: true,
                            callbacks: {
                                afterLabel: function(tooltipItem) {
                                     var count =  data[tooltipItem.index];
                                     return ((count / (data[0] + data[1])) * 100).toFixed(2) + '%';
                                },
                                label: function(tooltipItem) {
                                    return data[tooltipItem.index];
                                }
                            }
                        },
                        title: {
                            display: true,
                            responsive: true,
                            text: 'Desempenho geral do Automata'
                        }
                    },
                });
           });
        </script>
    @endpush
</x-layouts.app>
