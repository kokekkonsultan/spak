

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
            <div class="card bg-light-success" data-aos="fade-down">
                <div class="card-body">
                    <div class="text-center">
                        <h3>Konfirmasi Penutupan Survei</h3>
                        <hr>
                        <span>Silahkan konfirmasi penutupan survei terlebih dahulu agar anda dapat mengelola menu
                            <b>Koreksi Data</b>.
                        </span>
                        <br>
                        <span class="text-danger font-weight-bold">**Setelah dikonfirmasi maka survei akan di tutup
                            secara permanen!</span>
                        <br>
                        <br>
                        <br>
                        <form
                            action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data/update-konfirmasi' ?>"
                            class="form_done">

                            <button type="submit"
                                class="btn btn-light font-weight-bold shadow btn-block tombolKonfirmasi"
                                onclick="return confirm('Apakah anda yakin ingin mengkonfirmasi penutupan survei ?')"><i
                                    class="fas fa-check-circle text-success"></i> Konfirmasi</button>
                        </form>

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
$('.form_done').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolKonfirmasi').attr('disabled', 'disabled');
            $('.tombolKonfirmasi').html(
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
            $('.tombolKonfirmasi').removeAttr('disabled');
            $('.tombolKonfirmasi').html(
                '<i class="fas fa-check-circle text-success"></i> Konfirmasi');
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
                toastr["success"]('Data berhasil di proses');
                location.href =
                    "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/koreksi-data' ?>";
            }
        }
    });
    return false;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/koreksi_data/form_konfirmasi.blade.php ENDPATH**/ ?>