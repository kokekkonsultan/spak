@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
</link>


<style type="text/css">
    [pointer-events="bounding-box"] {
        display: none
    }

    .dataTables_length {
        display: none
    }

    .dataTables_filter {
        display: none
    }
</style>

@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5" data-aos="fade-down">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <div class="card card-custom card-sticky mb-5">
                <div class="card-body">

                    <div class="d-flex justify-content-center" id="chart"></div>
                    <br>

                    <table class="table table-bordered table-striped example" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kelompok</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($layanan->result() as $value)

                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$value->nama_layanan}}</td>
                                <td>{{$value->perolehan}}</th>


                                <td>{{ ROUND(($value->perolehan / $value->total_survei) * 100, 2)}} %</td>
                               
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>

<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.accessibility.js">
</script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.gammel.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.umber.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });
</script>



<script>
    FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            "type": "bar3d",
            "renderAt": "chart",
            "width": "100%",
            "height": "350",
            "dataFormat": "json",
            dataSource: {
                "chart": {
                    caption: "Layanan Survei",
                    subcaption: "Jenis Pelayanan yang di Survei",
                    "enableSmartLabels": "1",
                    "startingAngle": "0",
                    "showPercentValues": "1",
                    "decimals": "2",
                    "useDataPlotColorForLabels": "1",
                    // "theme": "umber",
                    // "bgColor": "#ffffff",

                    theme: "fusion"
                },
                "data": [
                    <?php foreach ($layanan->result() as $value) { ?> {
                            "label": "<?= $value->nama_layanan ?>",
                            "value": "<?= $value->perolehan ?>"
                        },
                    <?php } ?>
                ]
            }

        });
        myChart.render();
    });
</script>


@endsection