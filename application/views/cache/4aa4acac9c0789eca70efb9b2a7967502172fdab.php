

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
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            TABULASI DAN <?php echo e(strtoupper($title)); ?>

                        </h3>

                        <span class="btn btn-light btn-sm font-weight-bold">
                            <i class="fa fa-bookmark"></i> <strong><?php echo $jumlah_kuisioner; ?></strong> Kuesioner
                            Lengkap
                        </span>
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                            style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <!-- <th>Status</th>
                                    <th>Surveyor</th> -->
                                    <th>Nama Lengkap</th>

                                    <?php $__currentLoopData = $unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo $row->nomor_unsur ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-body mt-5" data-aos="fade-down">
                <h3>Persepsi</h3>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" style="font-size: 12px;">
                        <tr align="center">
                            <th></th>
                            <?php $__currentLoopData = $unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="bg-primary text-white"><?php echo e($row->nomor_unsur); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <tr>
                            <th class="bg-secondary">TOTAL</th>
                            <?php $__currentLoopData = $total->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center"><?php echo e(ROUND($total->sum_skor_jawaban, 3)); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-secondary">Rata-Rata</th>
                            <?php $__currentLoopData = $rata_rata->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rata_rata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="text-center"><?php echo e(ROUND($rata_rata->rata_rata, 3)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-secondary">Nilai per Unsur</th>
                            <?php $__currentLoopData = $nilai_per_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai_per_unsur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th colspan="<?php echo e($nilai_per_unsur->colspan); ?>" class="text-center">
                                <?php echo e(ROUND($nilai_per_unsur->nilai_per_unsur, 3)); ?>

                            </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-secondary">Rata-Rata * Bobot</th>
                            <?php

                            foreach ($rata_rata_bobot->result() as $rata_rata_bobot) {
                                $nilai_bobot[] = $rata_rata_bobot->rata_rata_bobot;
                                $nilai_tertimbang = array_sum($nilai_bobot);
                                $ikm = ROUND($nilai_tertimbang * $skala_likert, 10);
                                // $ikm = 80;
                            ?>
                            <td colspan="<?php echo e($rata_rata_bobot->colspan); ?>" class="text-center">
                                <?php echo e(ROUND($rata_rata_bobot->rata_rata_bobot, 3)); ?>

                            </td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <th class="bg-secondary">Indeks</th>
                            <th colspan="<?php echo e($tertimbang->colspan); ?>"><?php echo e(ROUND($nilai_tertimbang, 3)); ?></th>
                        </tr>


                        <tr>
                            <th class="bg-secondary">Nilai Konversi<!--Rata2 Tertimbang--></th>
                            <th colspan="<?php echo e($tertimbang->colspan); ?>"><?php echo e(ROUND($ikm, 2)); ?></th>
                        </tr>
                        

                        <!-- =IF(K510>4,5;"Pelayanan Prima";
                        IF(K510>4;"Sangat Baik";
                        IF(K510>3,5;"Baik";
                        IF(K510>3;"Baik (Dengan Catatan)";
                        IF(K510>2,5;"Cukup";
                        IF(K510>2;"Cukup (Dengan Catatan)";
                        IF(K510>1,5;"Buruk";
                        IF(K510>1;"Sangat Buruk";
                        IF(K510>0;"Terlalu Buruk"))))))))) -->


                        <?php
                        // if ($ikm <= 100 && 81 <= $ikm) {
                        //     $kategori = 'A';
                        //     $mutu = 'A';
                        // } elseif ($ikm <= 80 && 61 <= $ikm) {
                        //     $kategori = 'B';
                        //     $mutu = 'B';
                        // } elseif ($ikm <= 60 && 41 <= $ikm) {
                        //     $kategori = 'C';
                        //     $mutu = 'C';
                        // } elseif ($ikm <= 40 && 21 <= $ikm) {
                        //     $kategori = 'D';
                        //     $mutu = 'D';
                        // } elseif ($ikm <= 20 && 0 <= $ikm) {
                        //     $kategori = 'E';
                        //     $mutu = 'E';
                        // } else {
                        //     $kategori = 'NULL';
                        //     $mutu = 'NULL';
                        // }

                        foreach ($definisi_skala->result() as $obj) {
                            if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
                                $kategori = $obj->kategori;
                                $mutu = $obj->mutu;
                            }
                        }
                        if ($ikm <= 0) {
                            $kategori = 'NULL';
                            $mutu = 'NULL';
                        }
                        ?>

                        <tr>
                            <th class="bg-secondary">PREDIKAT</th>
                            <th colspan="<?php echo e($tertimbang->colspan); ?>"><?php echo e($mutu); ?></th>
                        </tr>

                        <tr>
                            <th class="bg-secondary">KATEGORI</th>
                            <th colspan="<?php echo e($tertimbang->colspan); ?>"><?php echo e($kategori); ?></th>
                        </tr>
                    </table>
                </div>
            </div>



            <?php if(in_array(1, $atribut_pertanyaan)): ?>
            <div class="card card-body mt-5" data-aos="fade-down">
                <h3>Harapan</h3>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" style="font-size: 12px;">
                        <tr align="center">
                            <th></th>
                            <?php $__currentLoopData = $unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="bg-primary text-white">H<?php echo e($row->nomor_harapan); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <td class="bg-secondary"><strong>TOTAL</strong></td>
                            <?php $__currentLoopData = $total_harapan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total_harapan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center"><?php echo e(ROUND($total_harapan->sum_skor_jawaban, 3)); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <th class="bg-secondary">Rata-Rata</th>
                            <?php $__currentLoopData = $rata_rata_harapan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rata_rata_harapan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center"><?php echo e(ROUND($rata_rata_harapan->rata_rata, 3)); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <td class="bg-secondary"><strong>Rata-Rata per Harapan</strong>
                            </td>
                            <?php $__currentLoopData = $nilai_per_unsur_harapan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai_per_unsur_harapan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="text-center" colspan="<?php echo e($nilai_per_unsur_harapan->colspan); ?>">
                                <?php echo e(ROUND($nilai_per_unsur_harapan->nilai_per_unsur, 3)); ?>

                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                    </table>
                </div>
            </div>
            <?php endif; ?>


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
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        // paging: true,
        //     dom: 'Blfrtip',
        //     "buttons": [
        //         {
        //             extend: 'collection',
        //             text: 'Export',
        //             buttons: [
        //                 'excel'
        //             ]
        //         }
        //     ],

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
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/olah-data/ajax-list' ?>",
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/olah_data/index.blade.php ENDPATH**/ ?>