// ↓ Variable ↓

const ctx = document.getElementById('myChart');

const ctx_two = document.getElementById("myChart2")

const ctx_three = document.getElementById("myChart3")

// Variable qui récupère les informations
const jour = JSON.parse(myChart.dataset.jour);

// ↓ 1er graphique qui contient le nombre de visiteurs dans une semaine ↓

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


// ↓ 2ème graphique qui contient le nombre de visiteurs dans un mois ↓

const months = JSON.parse(myChart2.dataset.months);

new Chart(ctx_two, {
    type: 'line',
    data: {
        labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        datasets: [{
            label: "Nombre de visiteur ",
            data: months,
            borderWidth: 5,
            fill: false,
            borderColor: 'white',
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
                    text: "Mois",
                },
            },
        },
    },
});

// ↓ 3ème graphique qui contient le nombre de visiteurs dans une année ↓

const years = JSON.parse(myChart3.dataset.years);

new Chart(ctx_three, {
    type: 'line',
    data: {
        labels: ['2022', '2023', '2024', '2025', '2026'],
        datasets: [{
            label: "Nombre de visiteur ",
            data: years,
            borderWidth: 5,
            fill: false,
            borderColor: 'red',
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
                    text: "Année",
                },
            },
        },
    },
});