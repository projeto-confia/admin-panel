<x-layouts.app>
    <x-slot name="title">Relatório de intervenções | CONFIA</x-slot>

    <header class="my-3">
        <h1 id="main-content-title" class="text-dark">Relatório de intervenções</h1>
    </header>
    <main>
        {{--    filtros    --}}
        <div class="card mb-3 p-4">
            <form action="{{ route('intervencoes.index') }}" method="GET" class="row g-3">
                @csrf
                <div class="col-12  col-md-9">
                    <div class="form-floating">
                        <input
                           type="text"
                           class="form-control"
                           id="news_text_or_code"
                           name="news_text_or_code"
                           placeholder="Digite o texto ou código de notícia para pesquisar"
                           value="{{ old('news_text_or_code', '') }}"
                        />
                        <label for="news_text_or_code">Texto ou código da notícia</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select name="action_type" class="form-select form-select-lg" aria-label="Tipos de intervenções">
                        <option {{ old('action_type') ? '' : 'selected'  }} value="">Tipo de intervenção</option>
                        @foreach($actionTypes as $actionType)
                            <option
                                value="{{ data_get($actionType, 'value') }}"
                                {{ old('action_type') == data_get($actionType, 'value') ? 'selected' : ''  }}
                            >
                                {{data_get($actionType, 'label') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input
                            type="date"
                            class="form-control"
                            id="start_date"
                            name="start_date"
                            placeholder="dd/mm/yyyy"
                            value="{{ old('start_date', data_get($defaultDates, 'start')) }}"
                        >
                        <label for="start_date">Data Inicial</label>
                    </div>
                    @error('start_date')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input
                            type="date"
                            class="form-control"
                            id="end_date"
                            name="end_date"
                            placeholder="dd/mm/yyyy"
                            value="{{ old('end_date', data_get($defaultDates, 'end')) }}"
                        >
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
                    <button type="submit" class="btn btn-primary float-end">Pesquisar</button>
                </div>

            </form>
        </div>

        {{--    tabela    --}}
        <div class="card mb-3 p-4">
            <div class="table-responsive">
                <table class="table table-striped" aria-describedby="#main-content-title">
                    <thead>
                    <tr>
                        <th scope="col">Código da notícia</th>
                        <th scope="col">Texto</th>
                        <th scope="col">Ação</th>
                        <th scope="col">Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actionLogs as $actionLog)
                        <tr>
                            <th scope="row" class="text-center">{{ $actionLog->news->id_news }}</th>
                            <td>{{ $actionLog->news->text_news }}</td>
                            <td>{{ $actionLog->actionType->name_action }}</td>
                            <td>{{ $actionLog->datetime_log->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $actionLogs->links() }}
            </div>
        </div>
    </main>

</x-layouts.app>
