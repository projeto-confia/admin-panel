<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <h2 class="text-center mt-3">Bem vindo, {{$loggedUser}}.</h2>

    <div class="d-flex flex-wrap">
        <div class="card flex-row w-50" style="height:600px;">
            <canvas id="myChart" style="display:block; width: 100%; height: 100%;"></canvas>
        </div>
    </div>
    <div class="d-block w-50 text-center">
        <form id="form_top_users" action="{{ route('welcome.show') }}" method="GET">
            @csrf
            <input type="number" id="inputTopUsers" name="inputTopUsers" placeholder="Digite um número válido"/>
            <button id="btnSubmit" type="submit">Consultar</button>
            <p id="msg" style="color: red;"></p>
        </form>
    </div>

    @push('scripts')
        <script defer>
            
            var btn = document.getElementById('btnSubmit');

            document.getElementById("btnSubmit").addEventListener('click', (e) => {
                var number = document.getElementById('inputTopUsers').value;

                if (number > 4 && number <= 20) {
                    document.getElementById('form_top_users').submit();
                }
                else {
                    var text = document.getElementById("msg").innerHTML = "Digite um número entre 5 e 20.";
                    e.preventDefault();
                }
            });

            document.addEventListener('DOMContentLoaded', () => {

                var {id_account_social_media, screen_name, total_news, total_fake_news, total_not_fake_news} = {!! $json_top_users !!};
                var rates = total_fake_news.map(function (num, idx) { return (num / total_news[idx]).toFixed(3) * 100; })
                // console.log(rates);
                // console.log(id_account_social_media, screen_name, total_news, total_fake_news, total_not_fake_news);
                
                colors = [];
                for (i = 0; i < screen_name.length; i++)
                {
                    r = Math.floor(Math.random() * 200);
                    g = Math.floor(Math.random() * 200);
                    b = Math.floor(Math.random() * 200);

                    colors.push('rgb(' + r + ', ' + g + ', ' + b + ')');
                }

                var ctx = document.getElementById('myChart').getContext('2d');
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
            });

        </script>
    @endpush
</x-layouts.app>
