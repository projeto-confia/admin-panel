<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <h1>Notícias</h1>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#Id</th>    
                    <th scope="col">Texto</th>
                    <th scope="col">Data de Publicação</th>
                    <th scope="col">Avaliação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $news_item)
                    <tr>
                        <th scope="row">{{ $news_item->id_news }}</th>
                        <td>{{ $news_item->text_news }}</td>
                        <td>{{ $news_item->datetime_publication }}</td>
                        <td>{{ $news_item->classification_outcome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>
