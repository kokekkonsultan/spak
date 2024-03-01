<br>
<hr>
<div class="table-responsive mt-10">
    <table width="100%" class="table table-bordered" id='myolahdata' style="font-size: 12px;">
        <tr align="center">
            <th></th>
            <?php foreach ($unsur->result() as $row) { ?>
            <th class="bg-primary text-white"><?php echo $row->nomor_unsur ?></th>
            <?php } ?>
        </tr>
        <tr>
            <td class="bg-secondary"><strong>TOTAL</strong></td>
            <?php $__currentLoopData = $total->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td>
                <div align="center">
                    <strong><?php echo ROUND($total->sum_skor_jawaban, 3) ?></strong>
                </div>
            </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>

        <tr>
            <td class="bg-secondary"><strong>Rata-Rata</strong></td>
            <?php $__currentLoopData = $rata_rata->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rata_rata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td>
                <div align="center"><?php echo ROUND($rata_rata->rata_rata, 3) ?></div>
            </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>

        <tr>
            <td class="bg-secondary"><strong>Nilai per Unsur</strong></td>
            <?php $__currentLoopData = $nilai_per_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai_per_unsur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td colspan="<?php echo $nilai_per_unsur->colspan ?>">
                <div align="center">
                    <strong><?php echo ROUND($nilai_per_unsur->nilai_per_unsur, 3) ?></strong>
                </div>
            </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>

        <tr>
            <td class="bg-secondary"><strong>Rata-Rata * Bobot</strong></td>
            <?php
            foreach ($rata_rata_bobot->result() as $rata_rata_bobot) {
                $nilai_bobot[] = $rata_rata_bobot->rata_rata_bobot;
                $nilai_tertimbang = array_sum($nilai_bobot);
                $ikm = ROUND($nilai_tertimbang * $skala_likert, 10);
            ?>
            <td colspan="<?php echo $rata_rata_bobot->colspan ?>">
                <div align="center">
                    <?php echo ROUND($rata_rata_bobot->rata_rata_bobot, 3) ?></div>
            </td>
            <?php
            } ?>
        </tr>

        <tr>
            <td class="bg-secondary"><strong>Nilai Rata2 Tertimbang</strong></td>
            <td colspan="<?php echo e($jumlah_pertanyaan); ?>">
                <div><?php echo ROUND($nilai_tertimbang, 3) ?></div>
            </td>
        </tr>
        <tr>
            <td class="bg-secondary"><strong>IKM</strong></td>
            <td colspan="<?php echo e($jumlah_pertanyaan); ?>">
                <div> <strong><?php echo ROUND($ikm, 3) ?></strong></div>
            </td>
        </tr>


        <?php
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


        // if ($ikm <= 100 && $ikm >= 88.31) {
        //     $kategori = 'Sangat Baik';
        //     $mutu = 'A';
        // } elseif ($ikm <= 88.40 && $ikm >= 76.61) {
        //     $kategori = 'Baik';
        //     $mutu = 'B';
        // } elseif ($ikm <= 76.60 && $ikm >= 65) {
        //     $kategori = 'Kurang Baik';
        //     $mutu = 'C';
        // } elseif ($ikm <= 64.99 && $ikm >= 25) {
        //     $kategori = 'Tidak Baik';
        //     $mutu = 'D';
        // } else {
        //     $kategori = 'NULL';
        //     $mutu = 'NULL';
        // }
        ?>

        <tr>
            <td class="bg-secondary"><strong>MUTU PELAYANAN</strong></td>
            <td colspan="<?php echo e($jumlah_pertanyaan); ?>">
                <div><strong><?php echo e($mutu); ?></strong></div>
            </td>
        </tr>

        <tr>
            <td class="bg-secondary"><strong>KATEGORI</strong></td>
            <td colspan="<?php echo e($jumlah_pertanyaan); ?>">
                <div><strong><?php echo e($kategori); ?></strong></div>
            </td>
        </tr>
    </table>
</div><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\surveiku_spak\application\views/koreksi_data/data_asli.blade.php ENDPATH**/ ?>