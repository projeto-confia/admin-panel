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

                var ctx = document.getElementById('myChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                         datasets: [{
                            total_fake_news
                         }],
                         labels: [
                             screen_name
                         ],
                         options: {
                            responsive: true
                        }
                    }
                });
            });

        </script>
    @endpush
</x-layouts.app>
