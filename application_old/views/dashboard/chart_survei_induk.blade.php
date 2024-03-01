@php
$ci = get_instance();
@endphp

<div class="card card-custom card-stretch card-stretch-half gutter-b overflow-hidden">
    <!-- style="background-color: #fff1e5;" -->

    <div class="card-body">

        <div class="text-right">
            <a class="btn btn-light-info btn-sm font-weight-bold" href="{{base_url() . 'history-nilai-per-periode'}}">
                Kelola Nilai Indeks
            </a>

            <button type="button" class="btn btn-light-primary btn-sm font-weight-bold" data-toggle="modal"
                data-target="#exampleModal">
                Generate Indeks
            </button>
        </div>
        <div class="text-center">
            <div id="chart-index"></div>
        </div>
    </div>
</div>



<div class="card card-custom card-stretch card-stretch-half gutter-b overflow-hidden">
    <!-- style="background-color: #fff1e5;" -->

    <div class="card-body">
        <div class="text-center">
            <div id="chart"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border border-primary">
            <!-- <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div> -->
            <div class="modal-body">

            <form class="form_default" action="<?php echo base_url() . 'olah-data-keseluruhan/proses-index' ?>" method="POST">
                <div class="form-group">
                    <label class="form-label font-weight-bold">Masukkan Nama Label Indeks <span
                            class="text-danger">*</span></label>
                    <input class="form-control" name="label" placeholder="Survei Mahkamah Konstitusi Tahun 2023"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label font-weight-bold">Pilih survei yang dijadikan indeks <span
                            class="text-danger">*</span><hr></label>
                            {!! $checkbox !!}
                </div>

                <br>



                <div class="text-right mt-5">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolDefault">Simpan</button>
                </div>

            </form>

            </div>

        </div>
    </div>






    <script>
    FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            type: "column3d",
            renderAt: "chart-index",
            width: "100%",
            "height": "309",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Indeks Persepsi Anti Korupsi",
                    subcaption: "<?php echo $user->company ?>",
                    // yaxisname: "Deforested Area{br}(in Hectares)",
                    decimals: "1",
                    showvalues: "1",
                    theme: "fusion",
                    "bgColor": "#ffffff"
                },
                data: [

                    <?php foreach ($nilai_index_induk->result() as $row) { ?> {
                        "label": "<?= $row->label ?>",
                        value: <?= $row->nilai_indeks ?>
                    },
                    <?php } ?>
                ]
            }
        });
        myChart.render();
    });
    </script>


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
                    caption: "Hasil Survei Persepsi Anti Korupsi Per Bagian",
                    subcaption: "Sampai dengan Tahun <?php echo $tahun_awal ?>",
                    // yaxisname: "Deforested Area{br}(in Hectares)",
                    decimals: "1",
                    showvalues: "1",
                    theme: "gammel",
                    "bgColor": "#ffffff"
                },
                data: [<?php echo $new_chart ?>]
            }
        });
        myChart.render();
    });
    </script>



<script>
$('.form_default').submit(function(e) {
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolDefault').attr('disabled', 'disabled');
            $('.tombolDefault').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            Swal.fire({
                title: 'Memproses data',
                html: 'Mohon tunggu sebentar. Sistem sedang melakukan request anda.',
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading()
                }
            });

        },
        complete: function() {
            $('.tombolDefault').removeAttr('disabled');
            $('.tombolDefault').html('Simpan');
        },
        error: function(e) {
            Swal.fire(
                    'Informasi',
                    'Gagal memproses data!',
                    'error'
                );
                // window.setTimeout(function() {
                //     location.reload()
                // }, 2000);
        },

        success: function(data) {
            // if (data.gagal) {
            //     Swal.fire(
            //         'Informasi',
            //         'Gagal memproses data!',
            //         'error'
            //     );
            // }
            if (data.sukses) {
                $('#checkAll').prop('checked', false);
                Swal.fire(
                    'Informasi',
                    'Berhasil mendapatkan nilai indeks',
                    'success'
                );

                window.setTimeout(function() {
                    location.reload()
                }, 2000);
            }
        }
    });
    return false;
});
</script>