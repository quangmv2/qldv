function fillPieChart(data, idDisplay, title, link, subtitle, idTagA) {
    var chartData = [];
    data.forEach(function(element){
        var ele = {name : element.name, y : parseFloat(element.y) };
        chartData.push(ele);
    });
    console.log(chartData);
    Highcharts.chart(idDisplay, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: title
        },
        subtitle: {
            text: 'Nguồn: <a href="'+ link +'" id="' + idTagA +'">' + subtitle + '</a>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
        series: [{
            name: 'Tỉ lệ',
            colorByPoint: true,
            data: chartData,
        }]
    }); 
}

function fillBarChart(data, location, title) {
    var listOfValue = [];
    var listOfYear = [];
    data.forEach(function(element){
        listOfYear.push(element.name);
        listOfValue.push(element.y);
    });
    console.log(listOfValue);
    
    var chart = Highcharts.chart(location, {

        title: {
            text: title
        },

        subtitle: {
            text: ''
        },

        xAxis: {
            categories: listOfYear,
        },

        series: [{
            type: 'column',
            colorByPoint: true,
            data: listOfValue,
            showInLegend: false
        }]
    });
    
    $('#plain').click(function () {
        chart.update({
            chart: {
                inverted: false,
                polar: false
            },
            subtitle: {
                text: 'Plain'
            }
        });
    });

    $('#inverted').click(function () {
        chart.update({
            chart: {
                inverted: true,
                polar: false
            },
            subtitle: {
                text: 'Inverted'
            }
        });
    });

    $('#polar').click(function () {
        chart.update({
            chart: {
                inverted: false,
                polar: true
            },
            subtitle: {
                text: 'Polar'
            }
        });
    });
    
}