

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<style>
.header_card {
    color: #ffffff;
    background: linear-gradient(105deg, rgba(0 158 247) 0%, rgba(0, 247, 218) 100%);
    font-family: montserrat;
    font-size: 20px;
}
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">

    <div class="card shadow aos-init aos-animate" style="border-radius: 25px;">
        <div class="card-header fw-bold shadow text-center header_card" style="border-radius: 25px;">
            DETAIL SERTIFIKAT

        </div>

        <div class="card-body mt-3 mb-3" style="padding-left: 50px;">

            <div class="text-left mb-3" style="width: 175px;">
                <?php if ($user->foto_profile == NULL) : ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/klien/foto_profile/200px.jpg" alt="Card image">
                <?php else : ?>
                <img class="card-img-top"
                    src="<?php echo URL_AUTH; ?>assets/klien/foto_profile/<?php echo $user->foto_profile ?>"
                    alt="Card image">
                <?php endif; ?>
            </div>
            <br>

            <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Organisasi
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class="col-sm-8">
                    <?php echo  strtoupper($manage_survey->organisasi . ' ' . $user->company) ?>
                </div>
            </div>
            <!-- <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Nomor Sertifikat
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class="col-sm-8">
                    <?php echo $manage_survey->nomor_sertifikat ?>
                </div>
            </div> -->
            <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Nama Survei
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class="col-sm-8">
                    <?php echo $manage_survey->survey_name ?>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Tanggal Survei
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class="col-sm-8">
                    <?php echo $manage_survey->survey_mulai ?> s/d
                    <?php echo $manage_survey->survey_selesai ?>
                </div>
            </div>
           

            <?php if($manage_survey->id_sampling == 1): ?>
            <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Metode Sampling
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class=" col-sm-8">
                    <?php echo $manage_survey->nama_sampling ?>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-sm-3" style="font-weight:bold;">
                    Sample Minimal
                </div>
                <div class="col-sm-1">
                    :
                </div>
                <div class=" col-sm-8">
                    <?php echo $manage_survey->jumlah_sampling ?> Orang
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>


    <div class="row mt-5 mb-5">
        <div class="col-md-5">
            
            <div class="card shadow aos-init aos-animate mb-4" style="border-radius: 25px;">
                <div class="card-header fw-bold shadow text-center header_card" style="border-radius: 25px;">
                    JENIS PELAYANAN
                </div>
                <div class="card-body mt-3 mb-3" style="padding-left: 50px;">

                    <?php
                    foreach ($layanan->result() as $row) {
                        $perolehan[] = $row->perolehan;
                        $total_perolehan = array_sum($perolehan);
            
                        $persentase[] = ($row->perolehan/$row->total_survei) * 100;
                        $total_persentase  = array_sum($persentase);
                    ?>
                    <div class="mb-3"><b><?php echo strtoupper($row->nama_layanan); ?> :</b> <?php echo $row->perolehan ?> Orang</div>
                    <?php } ?>
                    
                </div>
            </div>
                
            <div class="card shadow aos-init aos-animate" style="border-radius: 25px;">
                <div class="card-header fw-bold shadow text-center header_card" style="border-radius: 25px;">
                    NILAI IPAK
                </div>
                <div class="card-body mt-3 mb-3">

                    <div class="text-center" style="font-weight: bold; font-size:50px;">
                        <?php echo ROUND($ikm/25, 3) ?></div>
                    <div class="text-center" style="font-size:16px;">Predikat : <br>
                        <b> <?php
                            foreach ($definisi_skala->result() as $obj) {
                                if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
                                    echo  $obj->kategori;
                                }
                            }
                            if ($ikm <= 0 || $ikm == NULL) {
                                echo  'NULL';
                            }

                            // if ($ikm <= 100 && $ikm >= 88.31) {
                            //     echo 'SANGAT BAIK';
                            // } elseif ($ikm <= 88.40 && $ikm >= 76.61) {
                            //     echo 'BAIK';
                            // } elseif ($ikm <= 76.60 && $ikm >= 65) {
                            //     echo 'KURANG BAIK';
                            // } elseif ($ikm <= 64.99 && $ikm >= 25) {
                            //     echo 'TIDAK BAIK';
                            // } else {
                            //     echo 'NULL';
                            // }
                            ?></b>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow aos-init aos-animate" style="border-radius: 25px;">
                <div class="card-header fw-bold shadow text-center header_card" style="border-radius: 25px;">
                    RESPONDEN
                </div>
                <div class="card-body mt-3 mb-3" style="padding-left: 50px;">

                    <div class="mb-3"><b>JUMLAH RESPONDEN :</b> <?php echo $jumlah_kuisioner ?> Orang</div>

                    <?php $__currentLoopData = $profil->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><b><?php echo e($row->nama_profil); ?></b>

                        <ul style="padding-left: 30px;">
                            <?php
                            $kategori_profil_responden = $ci->db->query("SELECT *, (SELECT COUNT(*) FROM responden_$manage_survey->table_identity JOIN survey_$manage_survey->table_identity ON responden_$manage_survey->table_identity.id = survey_$manage_survey->table_identity.id_responden WHERE kategori_profil_responden_$manage_survey->table_identity.id = responden_$manage_survey->table_identity.$row->nama_alias && is_submit = 1) AS perolehan FROM kategori_profil_responden_$manage_survey->table_identity");
                            ?>

                            <?php $__currentLoopData = $kategori_profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($value->id_profil_responden == $row->id): ?>

                            <li><?php echo e($value->nama_kategori_profil_responden); ?> : <?php echo e($value->perolehan); ?> Orang</li>

                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_frontend/template_frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/home/validasi_sertifikat.blade.php ENDPATH**/ ?>