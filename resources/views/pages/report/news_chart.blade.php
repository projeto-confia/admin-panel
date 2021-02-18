<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <h1>Notícias</h1>

    <div class="card card-search">
        <form action="/report/news_chart" method="get" class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="start_date" name="start_date" placeholder="dd/mm/yyyy">
                    <label for="start_date">Data Inicial</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="end_date" name="end_date" placeholder="dd/mm/yyyy">
                    <label for="end_date">Data Final</label>
                </div>
            </div>
            <!-- <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_all" value="all" checked>
                    <label class="form-check-label" for="classification_all">Todas</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_true" value="1">
                    <label class="form-check-label" for="classification_true">Verdadeira</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="classification" id="classification_false" value="0">
                    <label class="form-check-label" for="classification_false">Falsa</label>
                </div>
            </div> -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary float-end">Gerar</button>
            </div>
        </form>
    </div>

</x-layouts.app>
