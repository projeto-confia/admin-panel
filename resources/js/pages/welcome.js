const loadAutomataPerformanceDonut = (newsCorrectlyPredictedCount, totalNewsChecked) => {
    const canvasDrawingContextAutomataPerf = document.getElementById('performanceAutomata').getContext('2d');
    const data = [+newsCorrectlyPredictedCount, (+totalNewsChecked - +newsCorrectlyPredictedCount)];

    return new Chart(canvasDrawingContextAutomataPerf, {
        type: 'doughnut',
        data: {
            labels: ['Acertos', 'Erros'],
            datasets: [{
                data,
                backgroundColor: ['#20c997', '#dc3545'],
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            tooltips: {
                enabled: true,
                callbacks: {
                    afterLabel: function(tooltipItem) {
                        const count =  data[tooltipItem.index];
                        return ((count / (data[0] + data[1])) * 100).toFixed(2) + '%';
                    },
                    label: function(tooltipItem) {
                        return data[tooltipItem.index];
                    }
                }
            },
        },
    });
}

const fakeNewsByTurnLineChart = () => {
    const context = document.querySelector('#lineChart').getContext('2d');

    new Chart(context, {
        type: 'line',
        data: {
            labels: ['10/05/2019', '11/05/2019', '12/05/2019', '13/05/2019', '14/05/2019', '15/05/2019', '16/05/2019'],
            datasets: [{
                data: [106,107,111,133,221,783,2478],
                label: "Manhã",
                borderColor: "#3e95cd",
                fill: false
            }, {
                data: [502,635,809,947,1402,3700,5267],
                label: "Tarde",
                borderColor: "#8e5ea2",
                fill: false
            }, {
                data: [190,203,276,408,547,675,734],
                label: "Noite",
                borderColor: "#3cba9f",
                fill: false
            }, {
                data: [16,24,38,74,167,508,784],
                label: "Madrugada",
                borderColor: "#e8c3b9",
                fill: false
            }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Postagens de fake news por turno'
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Valor absoluto'
                    }
                }]
            },
        }
    });
}

const createDonutChartForNewsCount = (canvasId, totalNews, quantity, label) => {
    const canvasDrawingContextAutomataPerf = document.getElementById(canvasId).getContext('2d');
    const data = [+quantity, (+totalNews - +quantity)];

    return new Chart(canvasDrawingContextAutomataPerf, {
        type: 'doughnut',
        data: {
            labels: [label, 'Total'],
            datasets: [{
                data,
                backgroundColor: ['#61cac3', 'rgba(177,253,246,0.41)'],
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,

            tooltips: {
                enabled: true,
                callbacks: {
                    afterLabel: function(tooltipItem) {
                        const count =  data[tooltipItem.index];
                        return ((count / (data[0] + data[1])) * 100).toFixed(2) + '%';
                    },
                    label: function(tooltipItem) {
                        return data[tooltipItem.index];
                    }
                }
            },
        },
    });
}




export const welcome = {
    loadAutomataPerformanceDonut,
    fakeNewsByTurnLineChart,
    createDonutChartForNewsCount,
}


