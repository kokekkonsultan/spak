

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-12">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            KOREKSI DATA
                        </h3>

                        <a class="btn btn-primary btn-sm font-weight-bold"
                            href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/do' ?>"><i
                                class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-6">
                    <form id="form-filter-asli" class="">
                        <label for="is_total_skor" class="form-label font-weight-bold text-primary">Filter Total
                            Skor Data Asli</label>
                        <select id="is_total_skor_asli" class="form-control" onchange="updateUnitAsli();">
                            <option value="">Please Select</option>
                            <option value="asc">Terendah</option>
                            <option value="desc">Tertinggi</option>
                        </select>
                    </form>
                </div>
                <div class="col-md-6">
                    <form id="form-filter-koreksi" class="">
                        <label for="is_total_skor" class="form-label font-weight-bold text-primary">Filter Total
                            Skor Data Koreksi</label>
                        <select id="is_total_skor" class="form-control" onchange="updateUnitKoreksi();">
                            <option value="">Please Select</option>
                            <option value="asc">Terendah</option>
                            <option value="desc">Tertinggi</option>
                        </select>
                    </form>
                </div>
            </div>


            <div class="card-deck row mt-5">
                <div class="card col-md-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Data Asli</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <span class="btn btn-primary btn-sm font-weight-bold">
                                    <i class="fa fa-bookmark"></i> <strong><?php echo $jumlah_kuisioner; ?></strong>
                                    Kuesioner
                                    Valid
                                </span>
                            </div>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table id="table-default" class="table table-bordered table-hover" cellspacing="0"
                                width="100%" style="font-size: 12px;">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th width="5%">No.</th>
                                        <th>Total Skor</th>
                                        <?php $__currentLoopData = $unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo $row->nomor_unsur ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <?php echo $__env->make("koreksi_data/data_asli", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>
                </div>


                <div class="card col-md-6 <?php echo $manage_survey->is_koreksi == 1 ? 'bg-light-warning' : '' ?>"
                    id="mydiv">
                    <div class="card-body">

                        <form
                            action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/delete-by-checkbox' ?>"
                            class="form_hapus" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Data Koreksi</h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="btn btn-warning btn-sm font-weight-bold">
                                        <i class="fa fa-bookmark"></i>
                                        <strong><?php echo $koreksi_jumlah_kuisioner ?></strong>
                                        Kuesioner
                                        Valid
                                    </span>
                                </div>
                            </div>
                            <hr>


                            <div class="table-responsive">
                                <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                                    style="font-size: 12px;">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>Total Skor</th>
                                            <?php $__currentLoopData = $unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo $row->nomor_unsur ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <?php echo $__env->make("koreksi_data/data_koreksi", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php if($manage_survey->is_koreksi == ''): ?>
                            <div class="text-right mt-10">
                                <button type="submit"
                                    onclick="return confirm('Apakah anda yakin ingin mengoreksi data ?')"
                                    class="btn btn-light-dark btn-sm font-weight-bold btn-block tombolHapus"><i
                                        class="fa fa-check-square"></i> Koreksi Data
                                </button>
                            </div>
                            <?php endif; ?>
                        </form>


                        <?php if($manage_survey->is_koreksi == 1): ?>
                        <div class="row mt-5">
                            <div class="col-md-8">
                                <form
                                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/restore-data-koreksi' ?>"
                                    class="form_done">

                                    <button type="submit" class="btn btn-danger btn-sm font-weight-bold tombolRestore"
                                        onclick="return confirm('Apakah anda yakin ingin mengembalikan data ?')"><i
                                            class="fa fa-recycle"></i><br>Batalkan Koreksi &<br>Kembalikan ke Data
                                        Sebelumnya
                                    </button>
                                </form>

                            </div>
                            <div class="col-md-4 text-right">

                                <form
                                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/simpan-data-koreksi' ?>"
                                    class="form_done">

                                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolSimpan"
                                        onclick="return confirm('Apakah anda yakin ingin menyimpan data koreksi ?')"><i
                                            class="fa fa-upload"></i><br>Simpan Data
                                        Hasil Koreksi
                                    </button>
                                </form>

                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>

<script>
$(document).ready(function() {
    $("#checkAll").click(function() {
        $(".child").prop("checked", this.checked);
    });
});
</script>

<script>
$(document).ready(function() {
    table = $('#table-default').DataTable({

        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua data"]
        ],
        "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/ajax-list-data-asli' ?>",
            "type": "POST",
            "data": function(data) {
                data.is_total_skor_asli = $('#is_total_skor_asli').val();
            }
        },

        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],

    });
});

function updateUnitAsli() {
    $('#table-default').DataTable().ajax.reload(null, false);
}


$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,

        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua data"]
        ],
        "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/ajax-list-data-koreksi' ?>",
            "type": "POST",
            "data": function(data) {
                data.is_total_skor = $('#is_total_skor').val();
            }
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],

    });
});

function updateUnitKoreksi() {
    table.ajax.reload(null, false);
}
</script>


<script>
$('.form_hapus').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolHapus').attr('disabled', 'disabled');
            $('.tombolHapus').html(
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
            $('.tombolHapus').removeAttr('disabled');
            $('.tombolHapus').html('<i class="fa fa-trash"></i> Hapus Data di Pilih');
        },
        error: function(e) {
            alert('Error deleting data');
        },

        success: function(data) {
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                // $('#checkAll').prop('checked', false);
                toastr["success"]('Data berhasil di koreksi');
                window.setTimeout(function() {
                    $("#mydiv").load(location.reload());
                }, 2500);
            }
        }
    });
    return false;
});
</script>

<script>
$('.form_done').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolRestore').attr('disabled', 'disabled');
            $('.tombolRestore').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
            $('.tombolSimpan').attr('disabled', 'disabled');
            $('.tombolSimpan').html(
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
            $('.tombolRestore').removeAttr('disabled');
            $('.tombolRestore').html(
                '<i class="fa fa-recycle"></i><br>Batalkan Koreksi & Kembalikan ke Data Sebelumnya'
            );
            $('.tombolSimpan').removeAttr('disabled');
            $('.tombolSimpan').html('<i class="fa fa-upload"></i><br>Simpan Data Hasil Koreksi');
        },
        error: function(e) {
            alert('Error!');
        },

        success: function(data) {
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                // $('#checkAll').prop('checked', false);
                toastr["success"]('Data berhasil di proses');
                window.setTimeout(function() {
                    $("#mydiv").load(location.reload());
                }, 2500);
            }
        }
    });
    return false;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/koreksi_data/index.blade.php ENDPATH**/ ?>