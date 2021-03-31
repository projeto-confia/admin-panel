<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>

    <h2 class="text-center mt-3">Bem vindo, {{$loggedUser}}.</h2>

    <div class="card">
        <canvas id="myChart" width="770" height="385" style="display:block"></canvas>
    </div>

    @push('scripts')
        <script defer>

            document.addEventListener('DOMContentLoaded', () => {
                
                var {id_account_social_media, screen_name, total_fake_news} = {!! $json_top_users !!};
                console.log(id_account_social_media, screen_name, total_fake_news);
                
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
