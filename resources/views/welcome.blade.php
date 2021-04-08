<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <div class="text"><h1 class="text-dark">Estatísticas</h1></div>

    <div id="cards" class="d-flex flex-wrap mb-4">
        <div class="card card-text">
            <p class="p-card">Total de Notícias capturadas</p>
            <p class="p-card-number">{{ $total_news }}</p>
        </div>
        <div class="card card-text">
            <p class="p-card">Notícias analisadas pelo Automata</p>
            <p class="p-card-number">{{ $total_news_predicted }}</p>
        </div>
        <div class="card card-text">
            <p class="p-card">Notícias checadas pelas agências</p>
            <p class="p-card-number">{{ $total_news_checked }}</p>
        </div>
        <div class="card card-text">
            <p class="p-card">Notícias aguardando checagem</p>
            <p class="p-card-number">{{ $total_news_to_be_checked }}</p>
        </div>
    </div>

    <div class="d-block" style="height:500px;">
        <canvas id="performanceAutomata" style="width: 100%; height: 100%;"></canvas>
    </div> 

    <div class="text"><h1 class="text-dark">Usuários</h1></div>

    <div class="d-flex flex-wrap">
        <div class="flex-row w-50 mb-1" style="height:500px;">
            <canvas id="rateFakeChart" style="width: 100%; height: 100%;"></canvas>
        </div>        
        <div class="flex-row w-50 mb-1" style="height:500px;">
            <canvas id="rateNotFakeChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>
    <div class="d-inline-block w-100 text-center">
        <form id="form_top_users" action="{{ route('welcome.show') }}" method="GET">
            @csrf
            <input type="number" id="inputTopUsers" name="inputTopUsers" placeholder="Digite um número válido"/>
            <button id="btnSubmit" type="submit">Consultar</button>
            <p id="msg" style="color: red;"></p>
        </form>
    </div>

    @push('scripts')
        <script defer>
            
            document.getElementById("btnSubmit").addEventListener('click', (e) => {
                var number = document.getElementById('inputTopUsers').value;
                if (number >= 5 && number <= 50) {
                    document.getElementById('form_top_users').submit();
                }
                else {
                    var text = document.getElementById("msg").innerHTML = "Digite um número entre 5 e 50.";
                    e.preventDefault();
                }
            });
            
           window.onload = () => {
                
                if (window.location.search == "") {
                    document.getElementById('inputTopUsers').value = 10;
                    document.getElementById('btnSubmit').click();
                }

                var obj1 = {!! $json_top_fake_users !!};
                var rates = obj1.rate_fake_news.map(function (num, idx) { return (Number(num) * 100).toFixed(2) });
                
                colors = [];
                for (i = 0; i < obj1.screen_name.length; i++)
                {
                    r = Math.floor(Math.random() * 200);
                    g = Math.floor(Math.random() * 200);
                    b = Math.floor(Math.random() * 200);
                    colors.push('rgb(' + r + ', ' + g + ', ' + b + ')');
                }
                var ctx = document.getElementById('rateFakeChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                         datasets: [{
                            data: rates,
                            backgroundColor: colors,
                         }],
                         labels: obj1.screen_name,
                    },
                    options: {
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
                                label: function(tooltipItem, data) { 
                                    var rate = rates[tooltipItem.index] + '%';
                                    return 'Taxa de ' + rate;
                                },
                                afterLabel: function(tooltipItem, data) { 
                                    return 'Fake news: ' + obj1.total_fake_news[tooltipItem.index] + '\nNotícias disseminadas: ' + obj1.total_news[tooltipItem.index];
                                }
                            }
                        },
                    },
                });
                
                var obj2 = {!! $json_top_not_fake_users !!};
                var rates_2 = obj2.rate_not_fake_news.map(function (num, idx) { return (Number(num).toFixed(2) * 100).toFixed(2) });
                
                colors = [];
                for (i = 0; i < obj2.screen_name.length; i++)
                {
                    r = Math.floor(Math.random() * 200);
                    g = Math.floor(Math.random() * 200);
                    b = Math.floor(Math.random() * 200);
                    colors.push('rgb(' + r + ', ' + g + ', ' + b + ')');
                }
                var ctx2 = document.getElementById('rateNotFakeChart').getContext('2d');
                var chart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                         datasets: [{
                            data: rates_2,
                            backgroundColor: colors,
                         }],
                         labels: obj2.screen_name,
                    },
                    options: {
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
                                label: function(tooltipItem, data) { 
                                    var rate = rates_2[tooltipItem.index] + '%';
                                    return 'Taxa de ' + rate;
                                },
                                afterLabel: function(tooltipItem, data) { 
                                    var total = obj2.total_news[tooltipItem.index];
                                    var total_real = obj2.total_not_fake_news[tooltipItem.index];
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

                var news_corrected_classified = "<?php echo $qtd_news_corrected_classified ?>";
                var news_checked = "<?php echo $total_news_checked ?>"
                var dados = [Number(news_corrected_classified), (Number(news_checked) - Number(news_corrected_classified))];

                var ctx3 = document.getElementById('performanceAutomata').getContext('2d');
                var chart3 = new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Acertos', 'Erros'],
                        datasets: [{
                            data: dados,
                            backgroundColor: ['rgba(50, 205, 50, 0.75)', 'rgba(220, 20, 60, 0.75)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        tooltips: {
                            enabled: true,
                            callbacks: {
                                afterLabel: function(tooltipItem, data) { 
                                     var qtd =  dados[tooltipItem.index];
                                     return ((qtd / (dados[0] + dados[1])) * 100).toFixed(2) + '%';
                                },
                                label: function(tooltipItem, data) { 
                                    return dados[tooltipItem.index];
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
            }
        </script>
    @endpush
</x-layouts.app>