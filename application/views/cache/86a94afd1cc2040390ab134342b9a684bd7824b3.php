

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container mt-5 mb-5" style="font-family: nunito;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            <?php if($status_saran == 1): ?>
            <li id="payment"><strong>Saran</strong></li>
            <?php endif; ?>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" data-aos="fade-up">

                <?php if($manage_survey->img_benner == ''): ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                <?php else: ?>
                <img class="card-img-top shadow"
                    src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                <?php endif; ?>

                <div class="card-body">
                    <div>
                        <?php
                        $slug = $ci->uri->segment(2);

                        $manage_survey = $ci->db->query("SELECT *
                        FROM manage_survey
                        JOIN u1489187_auth.users u ON manage_survey.id_user = u.id
                        WHERE slug = '$slug'")->row();
                        ?>

                        <?php echo $manage_survey->deskripsi_opening_survey; ?>

                    </div>
                    <br><br>
                    <a class="btn btn-warning btn-block font-weight-bold shadow"
                        href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/preview-form-survei/data-responden'); ?>">
                        IKUT SURVEI
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Htdocs MAMP\surveiku_spak\application\views/preview_form_survei/form_opening.blade.php ENDPATH**/ ?>