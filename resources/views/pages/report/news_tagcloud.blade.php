<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Tag Cloud das notícias rotuladas</h1>
    </header>

    <main>
        <div class="card card-search">
            <form action="{{ route('news_tagcloud.index') }}" method="GET" class="row g-3">
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
                    <label for="end_date">Classificação:</label>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="ground_truth_label"
                            id="classification_all"
                            value="*"
                            {{ $request->get('ground_truth_label', '*') === '*' ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="classification_all">Todas</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="ground_truth_label"
                            id="classification_true"
                            value="1"
                            {{ $request->get('ground_truth_label', '') === '1' ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="classification_true">Não Fake</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="ground_truth_label"
                            id="classification_false"
                            value="0"
                            {{ $request->get('ground_truth_label', '') === '0' ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="classification_false">Fake</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-end">Gerar</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div id="container" style="width: 100%; height:580px; margin: 0; padding: 0;"></div>
        </div>
    </main>
    @push('scripts')
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
        <script>
            anychart.onDocumentReady(function() {
                var data = {!! $reportJson !!};

                const chart = anychart.tagCloud(data);

                chart.angles([0]);
                chart.container("container");

                chart.draw();
            });
        </script>
    @endpush
</x-layouts.app>
