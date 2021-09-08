<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Notícias</h1>
    </header>
    <main>
        {{--    filtros    --}}
        <div class="card mb-3 p-4">
            <form action="{{ route('news.index') }}" method="GET" class="row g-3">
                @csrf
                <div class="col-12">
                    <div class="form-floating">
                        <input
                           type="text"
                           class="form-control"
                           id="text_news"
                           name="text_news"
                           placeholder="Digite um texto para pesquisar notícias relacionadas"
                           value="{{ optional($request)->text_news }}"
                        >
                        <label for="text_news">Digite um texto para pesquisar notícias relacionadas</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input
                            type="date"
                            class="form-control"
                            id="start_date"
                            name="start_date"
                            placeholder="dd/mm/yyyy"
                            value="{{ optional($request)->start_date }}"
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
                            value="{{ optional($request)->end_date }}"
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
                    <label>
                        Classificação da notícia:
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
                    </label>
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
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">Texto</th>
                        <th scope="col">Publicação</th>
                        <th scope="col">Avaliação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $news_item)
                        <tr>
                            <th scope="row">{{ $news_item->id_news }}</th>
                            <td>{{ $news_item->text_news }}</td>
                            <td>{{ $news_item->datetime_publication->format('d/m/Y') }}</td>
                            <td>{{ $news_item->ground_truth_label === '1' ? 'Fake' : 'Não Fake' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $news->links() }}
            </div>
        </div>
    </main>

</x-layouts.app>
