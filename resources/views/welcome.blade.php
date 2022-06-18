<x-layouts.app>
    <x-slot name="title">Início | CONFIA</x-slot>
    <main class="welcome-page py-3">
        <div class="row card mb-2">

            <div class="col-12">
                <p class="card-title fs-5">Total de notícias coletadas das redes sociais</p>
                <p class="fs-1 text text-primary card__number-count">{{ $totalNewsCollectedFromSocialNetworks }}</p>
            </div>

            <div class="cards-news-wrapper col-12">
                <div class="cards_news">
                    <p class="card-title fs-5">Notícias classificadas pelo AUTOMATA</p>
                    <p class="fs-4 m-0 text text-primary">{{ $totalNewsPredicted }}</p>
                    <div class="mt-1 h-100">
                        <canvas id="totalPredicted" width="270px"></canvas>
                    </div>
                </div>

                <div class="cards_news">
                    <p class="card-title fs-5">Notícias checadas por curadoria</p>
                    <p class="fs-4 m-0 text text-primary">{{ $totalNewsChecked }}</p>
                    <div class="mt-1 h-100">
                        <canvas id="totalChecked" width="270px"></canvas>
                    </div>
                </div>

                <div class="cards_news">
                    <p class="card-title fs-5">Notícias aguardando curadoria</p>
                    <p class="fs-4 m-0 text text-primary">{{ $totalNewsToBeChecked }}</p>
                    <div class="mt-1 h-100">
                        <canvas id="totalToBeChecked" width="270px"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row gap-2 mb-2 justify-content-between">
            <section class="col-12 col-lg-4 card d-flex">
                <h2 class="fs-5 ">Desempenho do AUTOMATA</h2>
                <span class="text-muted">Detecção de Fake News<span/>

                <div class="mt-5 h-100 w-100 donut-graphic-container" aria-label="Desempenho do AUTOMATA">
                    <canvas id="performanceAutomata"></canvas>
                </div>
            </section>

            <section class="col-12  col-lg-7 card">
                <canvas id="lineChart" style="display: block; height: 385px; width: 770px;"></canvas>
            </section>
        </div>
    </main>
@push('scripts')
    <script defer>
       window.addEventListener('load', function () {
           CONFIA.pages.welcome.loadAutomataPerformanceDonut({!! $newsCorrectlyPredictedCount !!}, {!! $totalNewsFakeByAutomata !!});
           CONFIA.pages.welcome.fakeNewsByTurnLineChart({!! $fakeNewsByTurn !!});
           CONFIA.pages.welcome.createDonutChartForNewsCount('totalPredicted', {!! $totalNewsCollectedFromSocialNetworks !!}, {!! $totalNewsPredicted !!}, 'Analisadas');
           CONFIA.pages.welcome.createDonutChartForNewsCount('totalChecked', {!! $curatorshipCount !!}, {!! $totalNewsChecked !!}, 'Checadas');
           CONFIA.pages.welcome.createDonutChartForNewsCount('totalToBeChecked', {!! $curatorshipCount !!}, {!! $totalNewsToBeChecked !!}, 'Aguardando');
       });
    </script>
@endpush
</x-layouts.app>
