<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Número de notícias rotuladas</h1>
    </header>

    <main>
        <div class="card card-search">
            <form action="{{ route('news_chart.index') }}" method="GET" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date"
                               class="form-control"
                               id="start_date"
                               name="start_date"
                               placeholder="dd/mm/yyyy"
                               value="{{ optional($request)->start_date }}">
                        <label for="start_date">Data Inicial</label>
                    </div>
                    @error('start_date')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date"
                               class="form-control"
                               id="end_date"
                               name="end_date"
                               placeholder="dd/mm/yyyy"
                               value="{{ optional($request)->end_date }}">
                        <label for="end_date">Data Final</label>
                    </div>
                    @error('end_date')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>
                <div class="col-md-12">
                    <span class="text-muted">Por padrão os últimos 7 dias.</span>
                </div>
                <div class="col-12">
                    <x-partials.interval-navigation />
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-end">Gerar</button>
                </div>
            </form>
        </div>

        <div class="card">
            <p class="text-muted text-center">Gráfico quantitativo (valores absolutos)</p>
            <canvas id="myChart" width="770" height="385" style="display:block"></canvas>
            <p class="text-muted text-center">Data de publicação na rede social</p>
        </div>
    </main>
    @push('scripts')
        <script defer>
            document.addEventListener('DOMContentLoaded', () => {
                CONFIA.pages.newsChart({!! $reportJson !!});
            });
        </script>
    @endpush
</x-layouts.app>
