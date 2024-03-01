

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php echo $__env->make('data_survey_klien/menu_data_survey_klien', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <div class="col-md-9">
            <div class="card bg-light-success" data-aos="fade-down">
                <div class="card-body">
                    <div class="text-center">
                        <h3>Konfirmasi Pengembalian Data</h3>
                        <hr>
                        <span>Anda dapat mengembalikan data hasil survei dengan cara mengkonfirmasi tombol dibawah ini.
                        </span>
                        <br>
                        <span class="text-danger font-weight-bold">**Setelah dikonfirmasi maka data survei akan
                            dikembalikan seperti saat survei sebelum di tutup!</span>
                        <br>
                        <br>
                        <br>
                        <form
                            action="<?php echo base_url() . 'data-survey-klien/update-restore/' . $ci->uri->segment(3) ?>"
                            class="form_done">

                            <button type="submit"
                                class="btn btn-light font-weight-bold shadow btn-block tombolKonfirmasi"
                                onclick="return confirm('Apakah anda yakin ingin me-restore data survei ?')"><i
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
                Swal.fire(
                    'Informasi',
                    'Berhasil mengembalikan data!',
                    'success'
                );
                window.setTimeout(function() {
                    location.href =
                        "<?php echo base_url() . 'data-survey-klien/do/' . $ci->uri->segment(3) ?>"
                }, 2500);
            }
        }
    });
    return false;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/data_survey_klien/detail_restore.blade.php ENDPATH**/ ?>