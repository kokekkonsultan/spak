

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card" data-aos="fade-down">
                <div class="card-header bg-secondary">
                    <h5><?php echo e($title); ?></h5>
                </div>
                <div class="card-body">
                    <?php echo form_open(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/profil-responden-survei/edit/' . $ci->uri->segment(5)); ?>

                    <span style="color: red; font-style: italic;"><?php echo validation_errors() ?></span>

                    <div class="form-group">
                        <?php
                        echo form_input($jenis_isian);
                        ?>
                    </div>

                    <div class="form-group row">
                        <?php
                        echo form_label('Nama Profil Responden <span style="color:red;">*</span>', '', ['class' =>
                        'col-sm-3 col-form-label
                        font-weight-bold']);
                        ?>
                        <div class="col-sm-9">
                            <?php
                            echo form_input($nama_profil_responden);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Wajib Diisi <span
                                style="color:red;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="is_required" id="is_required" required>
                                <option value="">Please Select</option>
                                <option value="1"<?php echo $profil_responden->is_required == '1' ? ' selected' : '' ?>>Ya</option>
                                <option value="2"<?php echo $profil_responden->is_required == '2' ? ' selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                    </div>

                    <?php if($profil_responden->type_data != ''): ?>
                    <br>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Type Data <span
                                style="color:red;">*</span></label>
                        <div class="col-sm-9">
                            <label>
                                <input type="radio" name="type_data" value="text"
                                    <?php echo $profil_responden->type_data == 'text' ? 'checked' : '' ?>>
                                TEXT
                            </label>
                            <hr>
                            <label>
                                <input type="radio" name="type_data" value="number"
                                    <?php echo $profil_responden->type_data == 'number' ? 'checked' : '' ?>>
                                NUMBER
                            </label>
                        </div>
                    </div>
                    <?php else: ?>
                    <input type="text" name="type_data" value="" hidden>

                    <br>
                    <h5 class="text-primary">Pilihan Jawaban</h5>
                    <hr class="mb-5">

                    <?php
                    $no = 1;
                    ?>
                    <?php $__currentLoopData = $kategori_profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="control-group row mb-7">
                        <div class="col-sm-11">
                            <input type="text" name="pilihan_jawaban[]" class="form-control"
                                value="<?php echo e($row->nama_kategori_profil_responden); ?>">
                        </div>

                        <div class="input-group-addon col-sm-1">
                            <button class="btn btn-danger remove" type="button">
                                <i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

                    <!-- class hide membuat form disembunyikan  -->
                    <!-- hide adalah fungsi bootstrap 3, klo bootstrap 4 pake invisible  -->
                    <div class="copy" style="display:none;">
                        <div class="control-group row mb-7">
                            <div class="col-sm-11">
                                <input type="text" name="pilihan_jawaban[]" class="form-control"
                                    placeholder="Masukkan Pilihan Jawaban . . .">
                            </div>

                            <div class="input-group-addon col-sm-1">
                                <button class="btn btn-danger remove" type="button">
                                    <i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>


                    <div class="control-group after-add-more">
                        <div class="form-group row">
                            <div class="col-sm-11">
                                <input type="text" name="pilihan_jawaban[]" class="form-control"
                                    placeholder="Masukkan Pilihan Jawaban . . .">
                            </div>
                            <div class="input-group-addon col-sm-1">
                                <button class="btn btn-success add-more" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if($profil_responden->is_lainnya == 1): ?>
                    <input class="form-control mb-7" name="pilihan_jawaban[]" value="Lainnya" hidden>
                    <?php endif; ?>



                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Dengan Isian Lainnya
                            <span style="color:red;">*</span></label>
                        <div class="col-9 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-md radio-disabled">
                                    <input type="radio" name="opsi_lainnya" class="opsi_lainnya" value="1"
                                        <?php echo $profil_responden->is_lainnya == 1 ? 'checked' : '' ?> disabled>
                                    <span></span>
                                    Ya
                                </label>
                                <label class="radio radio-md radio-disabled">
                                    <input type="radio" name="opsi_lainnya" class="opsi_lainnya" value=""
                                        <?php echo $profil_responden->is_lainnya != 1 ? 'checked' : '' ?> disabled>
                                    <span></span>
                                    Tidak
                                </label>
                            </div>
                            <span class="form-text text-muted">Jika profil yang anda tanyakan menggunakan
                                pilihan jawaban lainnya maka pilih <b>Ya</b> jika tidak maka pilih
                                <b>Tidak</b>.</span>
                        </div>
                    </div>
                    <?php endif; ?>


                    <br>
                    <div class="text-right">
                        <?php
                        echo
                        anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/profil-responden-survei',
                        'Batal', ['class' => 'btn btn-light-primary font-weight-bold'])
                        ?>
                        <?php echo form_submit('submit', 'Simpan', ['class' => 'btn btn-primary font-weight-bold']); ?>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var maxGroup = 50;

    $(".add-more").click(function() {
        if ($('body').find('.after-add-more').length < maxGroup) {
            var html = '<div class="control-group after-add-more">' + $(".copy").html() +
                '</div>';
            $('body').find('.after-add-more:last').after(html);
        } else {
            alert('Maximum ' + maxGroup + ' groups are allowed.');
        }
    });

    // saat tombol remove dklik control group akan dihapus 
    $("body").on("click", ".remove", function() {
        $(this).parents(".control-group").remove();
    });

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Htdocs MAMP\surveiku_spak\application\views/profil_responden_survei/form_edit.blade.php ENDPATH**/ ?>