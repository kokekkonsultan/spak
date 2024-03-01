@php
$ci = get_instance();
@endphp

<div class="card card-custom card-stretch card-stretch-half gutter-b overflow-hidden">
    <!-- style="background-color: #fff1e5;" -->

    <div class="card-body">
        <div class="text-center">
            <div id="chart"></div>
        </div>
    </div>
</div>



<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "column3d",
        renderAt: "chart",
        width: "100%",
        "height": "309",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Hasil Survei Persepsi Anti Korupsi",
                subcaption: "Sampai dengan Tahun <?php echo $tahun_awal ?>",
                // yaxisname: "Deforested Area{br}(in Hectares)",
                decimals: "1",
                theme: "gammel",
                "bgColor": "#ffffff"
            },
            data: [<?php echo $new_chart ?>]
        }
    });
    myChart.render();
});
</script>
