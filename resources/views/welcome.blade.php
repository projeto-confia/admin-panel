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
               CONFIA.pages.welcome.loadAutomataPerformanceDonut({!! $newsCorrectlyPredictedCount !!}, {!! $totalNewsChecked !!});
               CONFIA.pages.welcome.loadTopFakeUsers({!! $topFakeUsersJson !!});
               CONFIA.pages.welcome.loadTopNotFakeUsers({!! $topNotFakeUsersJson !!});
           });
        </script>
    @endpush
</x-layouts.app>
