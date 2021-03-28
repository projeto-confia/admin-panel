<x-layouts.app>
    <x-slot name="title">Relatório de notícias | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Notícias</h1>
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
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-end">Gerar</button>
                </div>
            </form>
        </div>
    
        <div class="card">
            <div id="container" style="width: 100%; height:580px; margin: 0; padding: 0;"></div>
            <!-- <canvas id="myChart" width="770" height="385" style="display:block"></canvas> -->
        </div>
    </main>
    
    @push('scripts')
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
        <script>
            anychart.onDocumentReady(function() {
                var data = [
                    {"x": "Mandarin chinese", "value": 1090000000, category: "Sino-Tibetan"},
                    {"x": "English", "value": 983000000, category: "Indo-European"},
                    {"x": "Hindustani", "value": 544000000, category: "Indo-European"},
                    {"x": "Spanish", "value": 527000000, category: "Indo-European"},
                    {"x": "Arabic", "value": 422000000, category: "Afro-Asiatic"},
                    {"x": "Malay", "value": 281000000, category: "Austronesian"},
                    {"x": "Russian", "value": 267000000, category: "Indo-European"},
                    {"x": "Bengali", "value": 261000000, category: "Indo-European"},
                    {"x": "Portuguese", "value": 229000000, category: "Indo-European"},
                    {"x": "French", "value": 229000000, category: "Indo-European"},
                    {"x": "Hausa", "value": 150000000, category: "Afro-Asiatic"},
                    {"x": "Punjabi", "value": 148000000, category: "Indo-European"},
                    {"x": "Japanese", "value": 129000000, category: "Japonic"},
                    {"x": "German", "value": 129000000, category: "Indo-European"},
                    {"x": "Persian", "value": 121000000, category: "Indo-European"}
                ];
                // create a tag (word) cloud chart
                var chart = anychart.tagCloud(data);
                // set a chart title
                chart.title('15 most spoken languages');
                // set an array of angles at which the words will be laid out
                chart.angles([0]);
                // enable a color range
                chart.colorRange(true);
                // set the color range length
                chart.colorRange().length('80%');
                // display the word cloud chart
                chart.container("container");
                chart.draw();
            });
        </script>
    @endpush
</x-layouts.app>
