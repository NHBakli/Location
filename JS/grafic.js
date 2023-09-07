const ctx = document.getElementById('myChart');

const jour = JSON.parse(myChart.dataset.jour);

new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                datasets: [{
                    label: "Nombre de visiteur ",
                    data: jour,
                    borderWidth: 5,
                    fill: false,
                    borderColor: 'blue',
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 15,
                                weight: 'bold',
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de Visites',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jour de la semaine',
                        },
                    },
                },
            },
        });