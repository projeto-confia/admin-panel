<x-layouts.app>
    <x-slot name="title">Curadoria | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Listagem de notícias para curadoria</h1>
    </header>
    <main>
        {{--    tabela    --}}
        <div class="card mb-3 p-4">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th scope="col">Notícia</th>
                        <th scope="col">Data de publicação</th>
                        <th scope="col">É similar a publicação por agência ?</th>
                        <th scope="col">Publicação da agência de checagem</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($curatorships as $curatorshipDTO)
                        <tr>
                            <td>{{ $curatorshipDTO->newsText() }}</td>
                            <td>{{ $curatorshipDTO->newsPublicationDate() }}</td>
                            <td>{{ $curatorshipDTO->hasSimilarCheckedNews() }}</td>
                            <td>
                                <a class="link-info" href="{{ $curatorshipDTO->agencyCheckedNewsUrl() }}" rel="noreferrer">
                                    {{ $curatorshipDTO->agencyCheckedNewsUrl() }}
                                </a>
                            </td>
                            <td>
                                <ul class="list-group list-group-horizontal">

                                    <li class="list-group-item border-0 bg-transparent">
                                        <a class="btn btn-outline-primary" href="{{ route('curadoria.edit', [$curatorshipDTO->getId()]) }}">
                                            Avaliar
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $curatorships->links() }}
            </div>
        </div>
    </main>

</x-layouts.app>
