export const precisionNews = (reportJson) => {
    const { labels, detected_fake, actual_fake } = reportJson;
    const ctx = document.getElementById('myChart');

    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Detectado como provável Fake News',
                    data: detected_fake,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Confirmado como Fake News',
                    data: actual_fake,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true
            },
        },
    });
}
