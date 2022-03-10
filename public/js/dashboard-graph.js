var Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);
const axios = require('axios').default;

Highcharts.setOptions({
    lang: {
        months: [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre",
        ],
        weekdays: [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi",
        ],
        shortMonths: [
            "Jan",
            "Fev",
            "Mar",
            "Avr",
            "Mai",
            "Juin",
            "Juil",
            "Aout",
            "Sept",
            "Oct",
            "Nov",
            "Déc",
        ],
        decimalPoint: ",",
        resetZoom: "Réinitialiser le zoom",
        resetZoomTitle: "Réinitialiser le zoom au niveau 1:1",
        thousandsSep: " ",
        decimalPoint: ",",
        viewFullscreen: "Voir en plein écran",
        exitFullscreen: "Quitter le plein écran",
    },
});

let commentaires = []
let membres = []
let views = []
let categories = []

axios({
    method: "get",
    url: "/",
    params: {
        route: "commentAjax",
    },
}).then(function (response) {
    let data = response.data
    data.forEach((element) => commentaires.push(element))

    let sets = [];
    let sets_totaux = [];
    let total = 0;


    commentaires.forEach((element) => {
        total += parseInt(element['nb'])
        sets.push({
            x: new Date(element['created_at']).getTime(),
            y: parseInt(element['nb'])
        })
        sets_totaux.push({
            x: new Date(element['created_at']).getTime(),
            y: total
        })
    })


    myChart = Highcharts.chart("graphContainer", {
        chart: {
            zoomType: "xy",
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ["viewFullscreen"],
                },
            },
        },
        title: {
            text: "Commentaires",
        },
        xAxis: {
            type: "datetime",
        },
        yAxis: {
            title: {
                text: "Nombre commentaires",
            },
            tickInterval: 1
        },
        plotOptions: {
            spline: {
                marker: {
                    symbol: "circle",
                    radius: 2,
                },
                lineWidth: 3,
            },
        },
        series: [{
            name: 'Nouveaux Commentaires',
            type: 'spline',
            color: '#003459',
            data: sets
        },
            {
                name: 'Total Commentaires',
                type: 'spline',
                color: 'red',
                data: sets_totaux
            }],
    });

})

axios({
    method: "get",
    url: "/",
    params: {
        route: "membresAjax",
    },
}).then(function (response) {
    let data = response.data
    data.forEach((element) => membres.push(element))


    let set_membres = [];
    let membres_totaux = [];
    let total_membre = 0;


    membres.forEach((element) => {
        total_membre += parseInt(element['nb'])
        set_membres.push({
            x: new Date(element['created_at']).getTime(),
            y: parseInt(element['nb'])
        })
        membres_totaux.push({
            x: new Date(element['created_at']).getTime(),
            y: total_membre
        })
    })

    memberChart = Highcharts.chart("graphMembers", {
        chart: {
            zoomType: "xy",
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ["viewFullscreen"],
                },
            },
        },
        title: {
            text: "Membres",
        },
        xAxis: {
            type: "datetime",
        },
        yAxis: {
            title: {
                text: "Nombre de membres",
            },
            tickInterval: 1
        },
        plotOptions: {
            spline: {
                marker: {
                    symbol: "circle",
                    radius: 2,
                },
                lineWidth: 3,
            },
        },
        series: [{
            name: 'Nouveaux Membres',
            type: 'spline',
            color: '#003459',
            data: set_membres
        },
            {
                name: 'Total Membres',
                type: 'spline',
                color: 'red',
                data: membres_totaux,
            }],
    });

})

axios({
    method: "get",
    url: "/",
    params: {
        route: "nbViewsAjax",
    },
}).then(function (response) {
    let data = response.data
    data.forEach((element) => views.push(element))


    let set_views = [];
    let views_totaux = [];
    let total_views = 0;


    views.forEach((element) => {
        total_views += parseInt(element['nb'])
        set_views.push({
            x: new Date(element['date_vues']).getTime(),
            y: parseInt(element['nb'])
        })
        views_totaux.push({
            x: new Date(element['date_vues']).getTime(),
            y: total_views
        })
    })


    viewsChart = Highcharts.chart("graphViews", {
        chart: {
            zoomType: "xy",
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ["viewFullscreen"],
                },
            },
        },
        title: {
            text: "Vues sur les articles",
        },
        xAxis: {
            type: "datetime",
        },
        yAxis: {
            title: {
                text: "Nombre de vues",
            },
            tickInterval: 3
        },
        plotOptions: {
            spline: {
                marker: {
                    symbol: "circle",
                    radius: 2,
                },
                lineWidth: 3,
            },
        },
        series: [{
            name: 'Nouvelles Vues',
            type: 'spline',
            color: '#003459',
            data: set_views
        },
            {
                name: 'Total Vues',
                type: 'spline',
                color: 'red',
                data: views_totaux,
            }],
    });

})

axios({
    method: "get",
    url: "/",
    params: {
        route: "nbViewsCategories",
    },
}).then(function (response) {
    let data = response.data
    data.forEach((element) => categories.push(element))


    let set_categories = [];
    let valmax = 0

    categories.forEach((element) => {
        if (element['nb'] != null) {
            valmax += parseInt(element['nb'])
        }
    })

    categories.forEach((element) => {


        let pourcent = (100 * parseInt(element['nb'])) / valmax


        set_categories['name'] = 'test'
        set_categories['colorByPoint'] = true

        if (typeof set_categories[0] == "undefined") {
            set_categories[0] = {};
        }
        if (typeof set_categories[0]["data"] == "undefined") {
            set_categories[0]["data"] = [];
        }

        set_categories[0]['data'].push({
            name: element['nom_categorie'],
            y: pourcent,
            info: element['nb']
        })


    })

    console.log(set_categories)


    categoriesChart = Highcharts.chart("graphCategories", {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: ["viewFullscreen"],
                },
            },
        },
        title: {
            text: 'Catégories les plus vues'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b><br>' +
                'Vues : {point.info}'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: set_categories
    });

    console.log(categoriesChart.series)

})