

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-body" data-aos="fade-down">
                <h4 class="text-center text-primary"><b>Nilai IPAK : <?php echo e(ROUND($nilai_tertimbang, 3)); ?>

                        <?php foreach ($definisi_skala->result() as $obj) {
                            if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
                                echo '(' . $obj->kategori . ')';
                            }
                        }
                        if ($ikm <= 0) {
                            echo  'NULL';
                        }
                        ?>
                    </b>
                </h4>
                <hr>
                <br>



                <h4 class="text-primary"><b>Unsur</b></h4>
                <div class="table-responsive">
                    <table class="table table-hover example" style="width:100%">
                        <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Unsur</th>
                                <th>Indeks</th>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($nilai_per_unsur->result() as $value) { ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td><?php echo e($value->nomor_unsur); ?>. <?php echo e($value->nama_unsur_pelayanan); ?></td>
                                    <td><?php echo e(ROUND($value->nilai_per_unsur,2)); ?></td>
                                    <td>
                                        <?php
                                        $nilai_konversi = $value->nilai_per_unsur * $skala_likert;
                                        foreach ($definisi_skala->result() as $obj) {
                                            if ($nilai_konversi <= $obj->range_bawah && $nilai_konversi >= $obj->range_atas) {
                                                echo $obj->kategori;
                                            }
                                        }
                                        if ($nilai_konversi <= 0) {
                                            echo  'NULL';
                                        }

                                        // if ($nilai_konversi >= 25 && $nilai_konversi <= 64.99) {
                                        //     echo "Tidak Baik";
                                        // } elseif ($nilai_konversi >= 65 && $nilai_konversi <= 76.60) {
                                        //     echo "Kurang Baik";
                                        // } elseif ($nilai_konversi >= 76.61 && $nilai_konversi <= 88.30) {
                                        //     echo "Baik";
                                        // } elseif ($nilai_konversi >= 88.31 && $nilai_konversi <= 100) {
                                        //     echo "Sangat Baik";
                                        // } else {
                                        //     echo "NULL";
                                        // };
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/analisa-survei/detail-unsur/<?php echo e($value->id_sub); ?>" class="btn btn-light-primary btn-sm font-weight-bold"><i class="fa fa-book"></i>
                                            Lakukan Analisa</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>


                <?php if($nilai_per_sub_unsur->num_rows > 0): ?>
                <br>
                <h4 class="text-primary"><b>Sub Unsur</b></h4>
                <div class="table-responsive">
                    <table class="table table-hover example" style="width:100%">
                        <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Unsur</th>
                                <th>Indeks</th>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($nilai_per_sub_unsur->result() as $value) { ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td><?php echo e($value->nomor_unsur); ?>. <?php echo e($value->nama_unsur_pelayanan); ?></td>
                                    <td><?php echo e(ROUND($value->rata_skor,2)); ?></td>
                                    <td>
                                        <?php $nilai_konversi_sub = $value->rata_skor * $skala_likert;
                                        foreach ($definisi_skala->result() as $obj) {
                                            if ($nilai_konversi_sub <= $obj->range_bawah && $nilai_konversi_sub >= $obj->range_atas) {
                                                echo $obj->kategori;
                                            }
                                        }
                                        if ($ikm <= 0) {
                                            echo  'NULL';
                                        }

                                        // if ($nilai_konversi_sub >= 25 && $nilai_konversi_sub <= 64.99) {
                                        //     echo "Tidak Baik";
                                        // } elseif ($nilai_konversi_sub >= 65 && $nilai_konversi_sub <= 76.60) {
                                        //     echo "Kurang Baik";
                                        // } elseif ($nilai_konversi_sub >= 76.61 && $nilai_konversi_sub <= 88.30) {
                                        //     echo "Baik";
                                        // } elseif ($nilai_konversi_sub >= 88.31 && $nilai_konversi_sub <= 100) {
                                        //     echo "Sangat Baik";
                                        // } else {
                                        //     echo "NULL";
                                        // };
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/analisa-survei/detail-unsur/<?php echo e($value->id_unsur_pelayanan); ?>" class="btn btn-light-primary btn-sm font-weight-bold"><i class="fa fa-book"></i>
                                            Lakukan Analisa</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>



            <!-- <div class="card card-body mt-5" id="content_1" data-aos="fade-down">
                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/update-executive-summary' ?>"
                    class="form_executive_summary" method="POST">
                    <div class="form-group">
                        <label class="form-label font-weight-bold">Executive Summary <span
                                style="color: red;">*</span></label>

                        <?php
                        echo form_textarea($executive_summary);
                        ?>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-light-primary font-weight-bold tombolSimpan"
                            onclick="tinyMCE.triggerSave();">Update
                            Executive Summary</button>
                    </div>
                </form>
            </div> -->

            <div class="card card-custom card-sticky mt-5" data-aos="fade-down">
                <?php echo $__env->make('include_backend/partials_backend/_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-header">
                    <div class="card-title">
                        <?php echo e($title); ?>

                    </div>
                    <!-- <div class="card-toolbar">
                        <?php
                        echo
                        anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/analisa-survei/add',
                        '<i class="fas fa-plus"></i> Tambah Analisa Survei', ['class' => 'btn btn-primary btn-sm
                        font-weight-bold shadow-lg']);
                        ?>
                    </div> -->
                </div>



                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%" style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Unsur</th>
                                    <!-- <th>Saran & Masukkan</th> -->
                                    <th>Faktor Yang Mempengaruhi</th>
                                    <th>Rencana Tindak Lanjut</th>
                                    <!-- <th>Kegiatan / Program</th> -->
                                    <th>Waktu</th>
                                    <th>Penanggung Jawab</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>
            </div>



        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });
</script>

<script>
    var KTTinymce = function() {
        var demos = function() {
            tinymce.init({
                selector: '#executive_summary'
            });
        }
        return {
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
</script>

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#executive_summary'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script> -->

<script>
    $('.form_executive_summary').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpan').attr('disabled', 'disabled');
                $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
            },
            complete: function() {
                $('.tombolSimpan').removeAttr('disabled');
                $('.tombolSimpan').html('Update Executive Summary');
            },
            error: function(e) {
                Swal.fire(
                    'Error !',
                    e,
                    'error'
                )
            },
            success: function(data) {
                if (data.validasi) {
                    $('.pesan').fadeIn();
                    $('.pesan').html(data.validasi);
                }
                if (data.sukses) {
                    toastr["success"]('Data berhasil disimpan');
                }
            }
        })
        return false;
    });
</script>


<script>
    $(document).ready(function() {
        table = $('#table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            },
            "ajax": {
                "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/ajax-list' ?>",
                "type": "POST",
                "data": function(data) {}
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            }, ],

        });
    });

    $('#btn-filter').click(function() {
        table.ajax.reload();
    });
    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });

    function delete_analisa_survei(id) {
        if (confirm('Are you sure delete this data?')) {
            $.ajax({
                url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/delete/' ?>" +
                    id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.status) {

                        table.ajax.reload();

                        Swal.fire(
                            'Informasi',
                            'Berhasil menghapus data',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Informasi',
                            'Hak akses terbatasi. Bukan akun administrator.',
                            'warning'
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });

        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/analisa_survei/index.blade.php ENDPATH**/ ?>