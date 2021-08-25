<x-layouts.app>
    <x-slot name="title">Curadoria de notícias | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Curadoria de notícias</h1>
    </header>
    <main>
        <div class="card mb-3 p-4">
            <div>
                <h2 class="h4">Notícia</h2>
                <blockquote class="blockquote">
                    <p id="text_news">{{ $curatorshipDTO->newsText() }}</p>
                </blockquote>
                <p id="publication_date">
                    Data da publicação:
                    <span class="text-muted">{{ $curatorshipDTO->newsPublicationDate() }}</span>
                </p>
            </div>

            @if ($curatorshipDTO->hasSimilarCheckedNews())
            <div class="mt-3">
                <h2 class="h5">Notícia similar publicada pela agência de checagem</h2>
                <div class="my-2">
                    <p class="m-0">Agência: <span class="text-muted">{{ $curatorshipDTO->agencyNewsName() }}</span></p>
                    <a class="link-info" href="{{ $curatorshipDTO->agencyCheckedNewsUrl() }}">Link da publicação</a>
                </div>

                <label for="publication_title" class="text-bold">Texto da notícia:</label>
                <blockquote class="blockquote">
                    <p id="publication_title">{{ $curatorshipDTO->agencyCheckedNewsText() }}</p>
                </blockquote>
            </div>
            @endif
        </div>

        <div class="card mb-3 p-4">
            <form class="row g-3" action="{{route('curadoria.update', $curatorshipDTO->getId())}}" method="POST" novalidate>
                @csrf
                @method('PUT')

                @if ($curatorshipDTO->hasSimilarCheckedNews())
                    <div class="col-12">
                        <div>
                            <p>A notícia é similar a notícia publicada pela agência de checagem ?</p>
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="is_similar"
                                    id="is_similar_yes"
                                    value="1"
                                    {{ old('is_similar', 0) == 1 ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="is_similar_yes">
                                    Sim
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="is_similar" id="is_similar_no" value="0">
                                <label class="form-check-label" for="is_similar_no">
                                    Não
                                </label>
                            </div>
                        </div>
                        @error('is_similar')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror()
                    </div>
                @endif

                <div class="col-12">
                    <div>
                        <p>É uma notícia ?</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_news" id="is_news_yes" value="1">
                            <label class="form-check-label" for="is_news_yes">
                                Sim
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_news" id="is_news_no" value="0">
                            <label class="form-check-label" for="is_news_no">
                                Não
                            </label>
                        </div>
                    </div>
                    @error('is_news')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div id="is_fake_news_field_wrapper" class="col-12 d-none">
                    <div>
                        <p>É Fake News ?</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_fake_news" id="is_fake_news_yes" value="1">
                            <label class="form-check-label" for="is_fake_news_yes">
                                Sim
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_fake_news" id="is_fake_news_no" value="0">
                            <label class="form-check-label" for="is_fake_news_no">
                                Não
                            </label>
                        </div>
                    </div>
                    @error('is_fake_news')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="form-floating">
                    <textarea class="form-control" style="height: 100px" placeholder="Observações" id="text_note" name="text_note" rows="3"></textarea>
                    <label for="text_note">Observações</label>
                </div>

                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">
                        Enviar
                    </button>
                </div>

            </form>
        </div>
    </main>

    @push('scripts')
    <script defer>
        window.addEventListener('load', function () {
            CONFIA.pages.curatorship.curate();
        });
    </script>
    @endpush
</x-layouts.app>
