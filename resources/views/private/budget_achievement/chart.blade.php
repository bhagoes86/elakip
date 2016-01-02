<div id="{{$viewId}}-chart"></div>

<script>
    $('#{{$viewId}}-chart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Capaian Kinerja Kegiatan Fisik 2015-2019'
        },

        xAxis: {
            categories: [2015,2016,2017,2018,2019],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Pagu',
            data: [65,34,56,23,46]
        }, {
            name: 'Realisasi',
            data: [5,78,45,23,34]

        }],
        credits: {
            enabled: false
        }
    });
</script>