

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
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
            <?php if($status_saran == 1): ?>
            <li id="payment"><strong>Saran</strong></li>
            <?php endif; ?>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-md-8 offset-md-2" style="font-size: 16px; font-family:arial, helvetica, sans-serif;">
            <div class="card shadow mb-4 mt-4" id="kt_blockui_content" data-aos="fade-up"
                style="border-left: 5px solid #FFA800;">

                <?php if($judul->img_benner == ''): ?>
                <img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg"
                    alt="new image" />
                <?php else: ?>
                <img class="card-img-top shadow"
                    src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
                <?php endif; ?>

                <div class="card-header text-center">
                    <h4><b>PERTANYAAN UNSUR</b> - <?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></h4>
                </div>

                <form action="<?php echo base_url() . 'survei/' . $ci->uri->segment(2) . '/add_pertanyaan/' .
                                    $ci->uri->segment(4) ?>" class="form_survei" method="POST">

                    <div class="card-body ml-5 mr-5">

                        <!-- Looping Pertanyaan Terbuka Paling Atas -->
                        <?php
                        $a = 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_terbuka_atas->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka_atas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="mt-10 mb-10">
                            <input type="hidden"
                                name="id_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                value="<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>">

                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row_terbuka_atas->nomor_pertanyaan_terbuka; ?>.
                                    </td>
                                    <td><?php echo $row_terbuka_atas->isi_pertanyaan_terbuka; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">

                                        <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka_atas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value_terbuka_atas->id_perincian_pertanyaan_terbuka ==
                                        $row_terbuka_atas->id_perincian_pertanyaan_terbuka): ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">
                                                <input type="radio"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                                    value="<?php echo e($value_terbuka_atas->pertanyaan_ganda); ?>"
                                                    <?php echo $value_terbuka_atas->pertanyaan_ganda == $row_terbuka_atas->jawaban ? 'checked' : '' ?>
                                                    <?php echo $row_terbuka_atas->stts_required ?>>
                                                <span></span> <?php echo e($value_terbuka_atas->pertanyaan_ganda); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                        <?php if($row_terbuka_atas->dengan_isian_lainnya == 1): ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">
                                                <input type="radio"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                                    value="Lainnya"
                                                    <?php echo $row_terbuka_atas->jawaban == 'Lainnya' ? 'checked' : '' ?>><span></span>Lainnya
                                            </label>
                                        </div>
                                        <br>
                                        <?php endif; ?>


                                        <?php if($row_terbuka_atas->id_jenis_pilihan_jawaban == 2): ?>
                                        <!-- <input class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."
                                            value="<?php echo e($row_terbuka_atas->jawaban); ?>"
                                            <?php echo e($row_terbuka_atas->stts_required); ?>> -->


                                        <textarea class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."
                                            <?php echo $row_terbuka_atas->stts_required ?>><?php echo e($row_terbuka_atas->jawaban); ?></textarea>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <hr>

                        <?php
                        $a++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        <!-- Looping Pertanyaan Unsur -->
                        <?php
                        $i = 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $is_required = $row->is_required == 1  ? 'required' : '';
                        $is_required_u = $row->is_required == 1 ? '<b class="text-danger">*</b>' : '';
                        ?>
                        <div class="mt-10 mb-10">
                            <input type="hidden" name="id_pertanyaan_unsur[<?php echo e($i); ?>]"
                                value="<?php echo e($row->id_pertanyaan_unsur); ?>">
                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row->nomor . '' . $is_required_u; ?>.</td>
                                    <td width="95%"><?php echo $row->isi_pertanyaan_unsur; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">


                                        
                                        <?php $__currentLoopData = $jawaban_pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->id_pertanyaan_unsur == $row->id_pertanyaan_unsur): ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">

                                                <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($i); ?>]"
                                                    value="<?php echo e($value->nomor_kategori_unsur_pelayanan); ?>"
                                                    class="<?php echo e($value->id_pertanyaan_unsur); ?>"
                                                    <?php echo $value->nomor_kategori_unsur_pelayanan == $row->skor_jawaban ? 'checked' : '' ?>
                                                    <?php echo e($is_required); ?>><span></span> <?php echo e($value->nama_kategori_unsur_pelayanan); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>

                                <?php
                                if($row->is_alasan == 1){
                                ?>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="95%">

                                        <textarea class="form-control form-alasan" type="text"
                                            name="alasan_pertanyaan_unsur[<?php echo e($i); ?>]" id="<?php echo e($row->id_pertanyaan_unsur); ?>"
                                            placeholder="Berikan alasan jawaban anda ..."
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$"
                                            <?php echo $row->skor_jawaban == 1 || $row->skor_jawaban == 2 ? 'required' : 'style="display:none"' ?>><?php echo e($row->alasan_jawaban); ?></textarea>

                                        <small id="text_alasan_<?php echo e($row->id_pertanyaan_unsur); ?>" class="text-danger"
                                            style="display:none">**Pengisian alasan hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                            </table>
                        </div>


                        <div id="display_terbuka_<?php echo e($row->id_pertanyaan_unsur); ?>">
                            <hr>
                            <!-- Looping Pertanyaan Terbuka -->
                            <?php
                            $n = $pertanyaan_terbuka_atas->num_rows() + 1;
                            ?>

                            <?php $__currentLoopData = $pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($row_terbuka->id_unsur_pelayanan == $row->id_unsur_pelayanan): ?>
                            <hr>
                            <div class=" mt-10 mb-10">
                                <input type="hidden"
                                    name="id_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                    value="<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>">
                                <table class="table table-borderless" width="100%" border="0">
                                    <tr>
                                        <td width="5%" valign="top"><?php echo $row_terbuka->nomor_pertanyaan_terbuka; ?>.</td>
                                        <td width="95%"><?php echo $row_terbuka->isi_pertanyaan_terbuka; ?></td>
                                    </tr>

                                    <tr>
                                        <td width="5%"></td>
                                        <td style="font-weight:bold;" width="95%">
                                            <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($value_terbuka->id_perincian_pertanyaan_terbuka ==
                                            $row_terbuka->id_perincian_pertanyaan_terbuka): ?>

                                            <div class="radio-inline mb-2">
                                                <label class="radio radio-outline radio-success radio-lg"
                                                    style="font-size: 16px;">
                                                    <input type="radio"
                                                        name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                        value="<?php echo e($value_terbuka->pertanyaan_ganda); ?>"
                                                        <?php echo $value_terbuka->pertanyaan_ganda == $row_terbuka->jawaban ? 'checked' : '' ?>
                                                        <?php echo $row_terbuka->stts_required ?>>
                                                    <span></span> <?php echo e($value_terbuka->pertanyaan_ganda); ?>

                                                </label>
                                            </div>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            <?php if($row_terbuka->dengan_isian_lainnya == 1): ?>
                                            <div class="radio-inline mb-2">
                                                <label class="radio radio-outline radio-success radio-lg"
                                                    style="font-size: 16px;">

                                                    <input type="radio"
                                                        name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                        value="Lainnya"
                                                        <?php echo $row_terbuka->jawaban == 'Lainnya' ? 'checked' : '' ?>>
                                                    <span></span> Lainnya
                                                </label>
                                            </div>
                                            <br>
                                            <?php endif; ?>



                                            <?php if($row_terbuka->id_jenis_pilihan_jawaban == 2): ?>
                                            <!-- <input class="form-control" type="text"
                                                name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                placeholder="Masukkan Jawaban Anda ..."
                                                value="<?php echo e($row_terbuka->jawaban); ?>"
                                                <?php echo $row_terbuka->stts_required ?>></input> -->

                                            <textarea class="form-control" type="text"
                                                name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                placeholder="Masukkan Jawaban Anda ..."
                                                <?php echo $row_terbuka->stts_required ?>><?php echo e($row_terbuka->jawaban); ?></textarea>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <?php endif; ?>

                            <?php
                            $n++;
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <hr>
                        </div>


                        <?php
                        $i++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <!-- Looping Pertanyaan Terbuka Paling Bawah -->
                        <?php
                        $b = $pertanyaan_terbuka_atas->num_rows() + $pertanyaan_terbuka->num_rows() + 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_terbuka_bawah->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka_bawah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mt-10 mb-10">
                            <input type="hidden"
                                name="id_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                value="<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>">

                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row_terbuka_bawah->nomor_pertanyaan_terbuka; ?>.
                                    </td>
                                    <td width="95%"><?php echo $row_terbuka_bawah->isi_pertanyaan_terbuka; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">
                                        <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka_bawah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value_terbuka_bawah->id_perincian_pertanyaan_terbuka ==
                                        $row_terbuka_bawah->id_perincian_pertanyaan_terbuka): ?>

                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">

                                                <input type="radio"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                                    value="<?php echo e($value_terbuka_bawah->pertanyaan_ganda); ?>"
                                                    <?php echo $value_terbuka_bawah->pertanyaan_ganda == $row_terbuka_bawah->jawaban ? 'checked' : '' ?>
                                                    <?php echo $row_terbuka_bawah->stts_required ?>>
                                                <span></span> <?php echo e($value_terbuka_bawah->pertanyaan_ganda); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($row_terbuka_bawah->dengan_isian_lainnya == 1): ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">

                                                <input type="radio"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                                    value="Lainnya"
                                                    <?php echo $row_terbuka_bawah->jawaban == 'Lainnya' ? 'checked' : '' ?>>
                                                <span></span> Lainnya
                                            </label>
                                        </div>
                                        <br>
                                        <?php endif; ?>


                                        <?php if($row_terbuka_bawah->id_jenis_pilihan_jawaban == 2): ?>
                                        <!-- <input class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."
                                            value="<?php echo e($row_terbuka_bawah->jawaban); ?>"
                                            <?php echo $row_terbuka_bawah->stts_required ?>></input> -->

                                        <textarea class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."
                                            <?php echo $row_terbuka_bawah->stts_required ?>><?php echo e($row_terbuka_bawah->jawaban); ?></textarea>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <hr>

                        <?php
                        $b++;
                        ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>


                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <?php if($ci->uri->segment(5) == 'edit'): ?>
                                <td class="text-left">
                                    <a class="btn btn-secondary btn-lg font-weight-bold shadow"
                                        href="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/edit'); ?>"><i
                                            class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                </td>
                                <?php endif; ?>

                                <td class="text-right">
                                    <button type="submit"
                                        class="btn btn-warning btn-lg font-weight-bold shadow-lg tombolSave">Selanjutnya
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('javascript'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


<?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="text/javascript">
$(function() {

    $(":radio.<?php echo $pr->id_pertanyaan_unsur; ?>").click(function() {
        $("#<?php echo $pr->id_pertanyaan_unsur; ?>").hide();
        $("#text_alasan_<?php echo $pr->id_pertanyaan_unsur ?>").hide();

        if ($(this).val() == 1 || $(this).val() == 2) {
            $("#<?php echo $pr->id_pertanyaan_unsur; ?>").prop('required', true).show();
            $("#text_alasan_<?php echo $pr->id_pertanyaan_unsur; ?>").show();

        } else {
            $("#<?php echo $pr->id_pertanyaan_unsur; ?>").removeAttr('required').hide();
            $("#text_alasan_<?php echo $pr->id_pertanyaan_unsur; ?>").hide();

        }

    });

});
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<script>
$('.form_survei').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSave').attr('disabled', 'disabled');
            $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#kt_blockui_content', {
                overlayColor: '#FFA800',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#kt_blockui_content');
            }, 1000);

        },
        complete: function() {
            $('.tombolSave').removeAttr('disabled');
            $('.tombolSave').html('Selanjutnya <i class="fa fa-arrow-right"></i>');
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
                // toastr["success"]('Data berhasil disimpan');

                setTimeout(function() {
                    window.location.href = "<?php echo $url_next ?>";
                }, 500);
            }
        }
    })
    return false;
});


// $('.form-alasan').keyup(validateTextarea);
// function validateTextarea() {
//     var errorMsg = "Mohon isi alasan dengan kalimat yang bisa dibaca.";
//     var textarea = this;
//     var pattern = new RegExp($(textarea).attr('pattern'));
//     // check each line of text
//     $.each($(this).val().split("\n"), function() {
//         // check if the line matches the pattern
//         var hasError = !this.match(pattern);
//         if (typeof textarea.setCustomValidity === 'function') {
//             textarea.setCustomValidity(hasError ? errorMsg : '');

//         } else {
//             // Not supported by the browser, fallback to manual error display...
//             $(textarea).toggleClass('error', !!hasError);
//             $(textarea).toggleClass('ok', !hasError);
//             if (hasError) {
//                 $(textarea).attr('title', errorMsg);
//             } else {
//                 $(textarea).removeAttr('title');
//             }
//         }
//         return !hasError;
//     });
// }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Htdocs MAMP\surveiku_spak\application\views/survei/form_pertanyaan.blade.php ENDPATH**/ ?>