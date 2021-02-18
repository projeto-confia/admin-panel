<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <h1>Notícias</h1>

    <div class="card card-search">
        <form action="/report/news" method="get" class="row g-3">

            <div class="col-12">
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="text_news"
                           name="text_news"
                           placeholder="Digite um texto para pesquisar"
                           value="{{ optional($request)->text_news }}"
                    >
                    <label for="text_news">Texto da notícia</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="start_date" name="start_date" placeholder="dd/mm/yyyy" value="{{ optional($request)->start_date }}">
                    <label for="start_date">Data Inicial</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="end_date" name="end_date" placeholder="dd/mm/yyyy" value="{{ optional($request)->end_date }}">
                    <label for="end_date">Data Final</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="classification"
                        id="classification_all"
                        value="all"
                        {{ $request->get('classification', '') === 'all' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="classification_all">Todas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="classification"
                        id="classification_true"
                        value="1"
                        {{ $request->get('classification', '') === '1' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="classification_true">Verdadeira</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="classification"
                        id="classification_false"
                        value="0"
                        {{ $request->get('classification', '') === '0' ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="classification_false">Falsa</label>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary float-end">Pesquisar</button>
            </div>

        </form>
    </div>

    <div class="card">
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
                        <td>{{ Carbon\Carbon::parse($news_item->datetime_publication)->format('d M y') }}</td>
                        <td>{{ $news_item->classification_outcome ? 'Falsa' : 'Verdadeira' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $news->links() }}
    </div>

</x-layouts.app>
