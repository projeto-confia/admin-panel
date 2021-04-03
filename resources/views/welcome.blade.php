<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <h2 class="text-center mt-3">Bem vindo, {{$loggedUser}}.</h2>

    <div class="d-flex">
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

                if (number > 1 && number <= 50) {
                    document.getElementById('form_top_users').submit();
                }
                else {
                    var text = document.getElementById("msg").innerHTML = "Digite um número entre 1 e 50.";
                    e.preventDefault();
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                
                var {id_account_social_media, screen_name, total_fake_news} = {!! $json_top_users !!};
                
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
                            text: 'Usuários que mais transmitiram fake news (ICS)'
                        }
                    },
                    data: {
                         datasets: [{
                            data: total_fake_news,
                            backgroundColor: colors,
                         }],
                         labels: screen_name,
                    },
                });
            });

        </script>
    @endpush
</x-layouts.app>
