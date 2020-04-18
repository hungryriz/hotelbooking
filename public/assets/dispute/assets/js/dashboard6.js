(function($) {
    "use strict";


    $('.donut').peity('donut', {
        fill: ['#00bcd4', '#d7d7d7', '#ffffff']
    })

    // Flexible table
    var table = $('#proList').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false
    });
    //  external search bar
    $('#search-projects').on('keyup', function() {
        table.search(this.value).draw();
    });


  var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
            var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];

            var data1 = [
                { label: "Data 1", data: d1, color: '#3391ad'},
                { label: "Data 2", data: d2, color: '#0e83a5' }
            ];
            $.plot($("#flot-chart1"), data1, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        }
                    },
                    points: {
                        width: 0.1,
                        show: false
                    }
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false
                }
            });
            

    var data2 = [
        [gd(2012, 1, 1), 7],
        [gd(2012, 1, 2), 6],
        [gd(2012, 1, 3), 4],
        [gd(2012, 1, 4), 8],
        [gd(2012, 1, 5), 9],
        [gd(2012, 1, 6), 7],
        [gd(2012, 1, 7), 5],
        [gd(2012, 1, 8), 4],
        [gd(2012, 1, 9), 7],
        [gd(2012, 1, 10), 8],
        [gd(2012, 1, 11), 9],
        [gd(2012, 1, 12), 6],
        [gd(2012, 1, 13), 4],
        [gd(2012, 1, 14), 5],
        [gd(2012, 1, 15), 11],
        [gd(2012, 1, 16), 8],
        [gd(2012, 1, 17), 8],
        [gd(2012, 1, 18), 11],
        [gd(2012, 1, 19), 11],
        [gd(2012, 1, 20), 6],
        [gd(2012, 1, 21), 6],
        [gd(2012, 1, 22), 8],
        [gd(2012, 1, 23), 11],
        [gd(2012, 1, 24), 13],
        [gd(2012, 1, 25), 7],
        [gd(2012, 1, 26), 9],
        [gd(2012, 1, 27), 9],
        [gd(2012, 1, 28), 8],
        [gd(2012, 1, 29), 5],
        [gd(2012, 1, 30), 8],
        [gd(2012, 1, 31), 15]
    ];

    var data3 = [
        [gd(2012, 1, 1), 700],
        [gd(2012, 1, 2), 400],
        [gd(2012, 1, 3), 600],
        [gd(2012, 1, 4), 500],
        [gd(2012, 1, 5), 400],
        [gd(2012, 1, 6), 356],
        [gd(2012, 1, 7), 800],
        [gd(2012, 1, 8), 489],
        [gd(2012, 1, 9), 367],
        [gd(2012, 1, 10), 776],
        [gd(2012, 1, 11), 689],
        [gd(2012, 1, 12), 600],
        [gd(2012, 1, 13), 400],
        [gd(2012, 1, 14), 500],
        [gd(2012, 1, 15), 700],
        [gd(2012, 1, 16), 586],
        [gd(2012, 1, 17), 245],
        [gd(2012, 1, 18), 788],
        [gd(2012, 1, 19), 888],
        [gd(2012, 1, 20), 688],
        [gd(2012, 1, 21), 787],
        [gd(2012, 1, 22), 344],
        [gd(2012, 1, 23), 999],
        [gd(2012, 1, 24), 567],
        [gd(2012, 1, 25), 686],
        [gd(2012, 1, 26), 566],
        [gd(2012, 1, 27), 888],
        [gd(2012, 1, 28), 700],
        [gd(2012, 1, 29), 178],
        [gd(2012, 1, 30), 455],
        [gd(2012, 1, 31), 893]
    ];


    var dataset = [{
        label: "Number of orders",
        data: data3,
        color: "#00bcd4",
        bars: {
            show: true,
            align: "center",
            barWidth: 24 * 60 * 60 * 600,
            lineWidth: 0,
            fillColor: {
                colors: [{
                    opacity: 0.9
                }, {
                    opacity: 0.9
                }]
            }
        }

    }, {
        label: "Payments",
        data: data2,
        yaxis: 2,
        color: "#2a2a2a",
        lines: {
            lineWidth: 1,
            show: true,
            fill: true,
            fillColor: {
                colors: [{
                    opacity: 0.4
                }, {
                    opacity: 0.4
                }]
            }
        },
        splines: {
            show: false,
            tension: 0.6,
            lineWidth: 1,
            fill: 0.1
        },
    }];


    var options = {
        xaxis: {
            mode: "time",
            tickSize: [3, "day"],
            tickLength: 0,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 10,
            color: "#d5d5d5"
        },
        yaxes: [{
            position: "left",
            max: 1070,
            color: "#d5d5d5",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 3
        }, {
            position: "right",
            clolor: "#d5d5d5",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: ' Arial',
            axisLabelPadding: 67
        }],
        legend: {
            noColumns: 1,
            labelBoxBorderColor: "#000000",
            position: "nw"
        },
        grid: {
            hoverable: false,
            borderWidth: 0
        }
    };

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    var previousPoint = null,
        previousLabel = null;

    $.plot($("#flot-dashboard-chart"), dataset, options);




    var tax_data = [{
            y: '2008',
            a: 50,
            b: 0
        },
        {
            y: '2009',
            a: 75,
            b: 50
        },
        {
            y: '2010',
            a: 30,
            b: 80
        },
        {
            y: '2011',
            a: 50,
            b: 50
        },
        {
            y: '2012',
            a: 75,
            b: 10
        },
        {
            y: '2013',
            a: 50,
            b: 40
        },
        {
            y: '2014',
            a: 75,
            b: 50
        },
        {
            y: '2015',
            a: 100,
            b: 70
        }
    ];
    Morris.Line({
        element: 'hero-graph',
        data: tax_data,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Licensed', 'Off the road'],
        resize: true,
        lineColors: ['#00bcd4', '#ddd'],
    });

    Morris.Donut({
        element: 'hero-donut',
        data: [{
                label: "Download Sales",
                value: 50
            },
            {
                label: "In-Store Sales",
                value: 35
            },
            {
                label: "Mail-Order Sales",
                value: 15
            }
        ],
        resize: true,
        colors: ['#00bcd4', '#ff7588', '#ddd'],
        formatter: function(y) {
            return y + "%"
        }
    });




    Morris.Bar({
        element: 'hero-bar',
        data: [{
                y: '2010',
                a: 75
            },
            {
                y: '2012',
                a: 30
            },
            {
                y: '2013',
                a: 40
            },
            {
                y: '2014',
                a: 32
            },
            {
                y: '2015',
                a: 60
            },
            {
                y: '2016',
                a: 93
            },
            {
                y: '2017',
                a: 50
            }
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Statistics'],
        barRatio: 0.1,
        xLabelAngle: 0,
        hideHover: 'auto',
        resize: true,
        gridLineColor: '#eeeeee',
        barSizeRatio: 0.2,
        barColors: ['#00bcd4', '#cacaca'],
    });

    new Morris.Line({
        element: 'examplefirst',
        xkey: 'year',
        ykeys: ['value'],
        labels: ['Value'],
        data: [{
                year: '2008',
                value: 20
            },
            {
                year: '2009',
                value: 10
            },
            {
                year: '2010',
                value: 5
            },
            {
                year: '2011',
                value: 5
            },
            {
                year: '2012',
                value: 20
            }
        ]
    });

    $('.code-example').each(function(index, el) {
        eval($(el).text());
    });



    // ----------------------W--------
    var d1 = [
        [1262304000000, 6],
        [1264982400000, 3057],
        [1267401600000, 20434],
        [1270080000000, 31982],
        [1272672000000, 26602],
        [1275350400000, 27826],
        [1277942400000, 24302],
        [1280620800000, 24237],
        [1283299200000, 21004],
        [1285891200000, 12144],
        [1288569600000, 10577],
        [1291161600000, 10295]
    ];
    var d2 = [
        [1262304000000, 5],
        [1264982400000, 200],
        [1267401600000, 1605],
        [1270080000000, 6129],
        [1272672000000, 11643],
        [1275350400000, 19055],
        [1277942400000, 30062],
        [1280620800000, 39197],
        [1283299200000, 37000],
        [1285891200000, 27000],
        [1288569600000, 21000],
        [1291161600000, 17000]
    ];


    var data2 = [{
        label: "Data 1",
        data: d1,
        color: '#19a0a1'
    }];
    $.plot($("#flot-chart2"), data2, {
        xaxis: {
            tickDecimals: 0
        },
        series: {
            lines: {
                show: true,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 1
                    }, {
                        opacity: 1
                    }]
                }
            },
            points: {
                width: 0.1,
                show: false
            }
        },
        grid: {
            show: false,
            borderWidth: 0
        },
        legend: {
            show: false
        }
    });


})(jQuery);