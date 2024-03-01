

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header bg-secondary font-weight-bold">
            <?php echo e($title); ?>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="">
                        <tr>
                            <th width="5"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
        "order": [],
        "ajax": {
            "url": "<?php echo base_url() . 'data-survey-klien/ajax-list-detail/' . $ci->uri->segment(3); ?>",
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
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/data_survey_klien/detail_survey_klien.blade.php ENDPATH**/ ?>