<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <div id="cards" class="d-flex flex-wrap mb-5">
        <div class="card card-text">
            <p class="p-card">Total de Notícias capturadas</p>
            <p class="p-card-number">{{ $total_news }}</p>
        </div>
        <div class="card card-text">
            <p class="p-card">Notícias analisadas pelo ICS</p>
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

    <div class="d-flex flex-wrap">
        <div class="flex-row w-50 mb-1" style="height:600px;">
            <canvas id="rateFakeChart" style="width: 100%; height: 100%;"></canvas>
        </div>        
        <div class="flex-row w-50 mb-1" style="height:600px;">
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
                // var json = <?php echo $json_top_fake_users; ?>;
                // console.log(json);

                var {rate_fake_news, screen_name} = {!! $json_top_fake_users !!};
                var rates = rate_fake_news.map(function (num, idx) { return Number(num).toFixed(3) * 100 });
                
                colors = [];
                for (i = 0; i < screen_name.length; i++)
                {
                    r = Math.floor(Math.random() * 200);
                    g = Math.floor(Math.random() * 200);
                    b = Math.floor(Math.random() * 200);
                    colors.push('rgb(' + r + ', ' + g + ', ' + b + ')');
                }
                var ctx = document.getElementById('rateFakeChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie',
                    options: {
                        title: {
                            display: true,
                            responsive: true,
                            text: 'Taxa de transmissão de possíveis fake news por usuário, de acordo com o ICS (%).'
                        }
                    },
                    data: {
                         datasets: [{
                            data: rates,
                            backgroundColor: colors,
                         }],
                         labels: screen_name,
                    },
                });

                var {screen_name, rate_not_fake_news} = {!! $json_top_not_fake_users !!};
                var rates = rate_fake_news.map(function (num, idx) { return Number(num).toFixed(3) * 100 });
                
                colors = [];
                for (i = 0; i < screen_name.length; i++)
                {
                    r = Math.floor(Math.random() * 200);
                    g = Math.floor(Math.random() * 200);
                    b = Math.floor(Math.random() * 200);
                    colors.push('rgb(' + r + ', ' + g + ', ' + b + ')');
                }
                var ctx2 = document.getElementById('rateNotFakeChart').getContext('2d');
                var chart2 = new Chart(ctx2, {
                    type: 'pie',
                    options: {
                        title: {
                            display: true,
                            responsive: true,
                            text: 'Taxa de transmissão de possíveis notícias reais por usuário, de acordo com o ICS (%).'
                        }
                    },
                    data: {
                         datasets: [{
                            data: rates,
                            backgroundColor: colors,
                         }],
                         labels: screen_name,
                    },
                });
            }
        </script>
    @endpush
</x-layouts.app>