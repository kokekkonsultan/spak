<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $manage_survey->uuid ?></title>

    <style>
        
    /* @page {
        margin: 0.2in 0.5in 0.2in 0.5in;
    } */

    /* body {
        padding: .4in;
    } */

    @page {
        margin: 100px 20px;
    }

    .content-paragraph {
        text-indent: 5%;
        text-align: justify;
        text-justify: inter-word;
        line-height: 1.5;
        margin-left: 76px;
        margin-right: 76px;

    }

    .content-list {
        text-indent: 10%;
        text-align: justify;
        text-justify: inter-word;
        line-height: 1.5;

    }

    .page-session {
        page-break-after: always;
        font-family: Calibri, sans-serif;
        margin: 0.2in 0.5in 0.2in 0.5in;
    }

    .page-session:last-child {
        page-break-after: never;
    }

    .table-list {
        border-collapse: collapse;
        font-family: sans-serif;

        text-align: center;
    }

    table,
    th,
    td {
        font-size: 13px;
        padding: 3px;
    }

    li {
        padding: 4px;
        text-align: justify;
    }

    .td-th-list {
        border: 1px solid black;
        height: 20px;
    }

    header {
        position: fixed;
        top: -90px;
        left: 0px;
        right: 0px;
        /* background-color: lightblue; */
        height: 50px;
    }

    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        /* background-color: lightblue; */
        height: 50px;
    }

    footer .page:after {
        content: counter(page, decimal);
    }

    input[type=checkbox] {
            display: inline;
        }

        .th-td-draf{
            border: 1px solid black;
            font-size: 11px;
            /* text-align:left; */
            height: 15px;
        }
    </style>
</head>

<body>
    <!-- COVER -->
    <div class="page-session">
        <div style="text-align:center;">
            <br>

            <?php if ($profiles->foto_profile != '' || $profiles->foto_profile != null) { ?>
            <img src="<?php echo URL_AUTH . 'assets/klien/foto_profile/' . $profiles->foto_profile ?>" alt="Logo" width="250" class="center">
            <?php } else { ?>
            <img src="<?= URL_AUTH . 'assets/klien/foto_profile/200px.jpg' ?>" alt="Logo" width="250" class="center">
            <?php } ?>
 


            <br>
            <br>
            <br>
            <br>


            <div style="font-size:25px; font-weight:bold;">
            LAPORAN<br>SURVEI PERSEPSI ANTI KORUPSI<br>(SPAK)
            </div>
            <br>
            <br>
            <br>
            <div style="font-size:20px; font-weight:bold;">
                 <?php echo strtoupper($manage_survey->organisasi) ?>
                 <br>
                 <?php echo strtoupper($profiles->company) ?>
            </div>
            <br>
            <br>


            <?php
            $bulan = array(
                1 =>   'JANUARI',
                'FEBRUARI',
                'MARET',
                'APRIL',
                'MEI',
                'JUNI',
                'JULI',
                'AGUSTUS',
                'SEPTEMBER',
                'OKTOBER',
                'NOVENBER',
                'DESEMBER');
                $month_start = $bulan[(int)date("m", strtotime($manage_survey->survey_start))];
                $month_end = $bulan[(int)date("m", strtotime($manage_survey->survey_end))];
                $year_start = date("Y", strtotime($manage_survey->survey_end));
                $year_end = date("Y", strtotime($manage_survey->survey_end));

                if($month_start == $month_end){
                    $periode =  $month_end . ' ' . $year_end;
                }else{
                    $periode =  $month_start . ' - ' . $month_end . ' ' . $year_end;
                }
                ?>



            <div style="font-size:20px; font-weight:bold;">
            PERIODE <?php echo $periode ?>
            </div>

        </div>
    </div>

    <header>
        <table style="width: 90%; margin-left: auto; margin-right: auto;" class="table-list">
            <tr>
                <td style="width: 10%;">
                    <?php if ($profiles->foto_profile != '' || $profiles->foto_profile != null) { ?>
                    <img src="<?php echo URL_AUTH . 'assets/klien/foto_profile/' . $profiles->foto_profile ?>"
                        alt="Logo" width="70">
                    <?php } else { ?>
                    <img src="<?= URL_AUTH . '/assets/klien/foto_profile/200px.jpg' ?>" alt="Logo" width="70">
                    <?php } ?>
                </td>
                <td>
                    <div style="color:#DE2226; font-size:16px;">
                        <b>L A P O R A N</b>
                    </div>
                    SURVEI PERSEPSI ANTI KORUPSI
                    <br>
                    <?php echo strtoupper($manage_survey->organisasi) ?>
                </td>
            </tr>
        </table>
        <hr>
    </header>

    <footer>
    <footer>
        <div style="text-align:center;">
            <hr>
            <div style="font-family: sans-serif; font-size: 13px;">SPAK <?= date("Y") ?> - Generate by <a target="_blank" href="https://surveiku.com/" style="color:black;">SurveiKu.com</a></div>
            <p class="page"></p>
        </div>
    </footer>

    


    <main>



<!--============================================== BAB I =================================================== -->
<div class="page-session">
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; font-size:18px; font-weight: bold;">
                BAB I
                <br>
                KUESIONER SURVEI
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td><span style="font-weight: bold;">1. Variable Survei</span></td>
        </tr>
        <tr>
        <td style=" padding-left:1.5em;">Variabel Survei Persepsi Anti Korupsi (SPAK) meliputi :

<ol>
        <li>Diskriminasi pelayanan<br>
        Petugas memberikan pelayanan secara khusus atau membeda-bedakan pelayanan karena faktor suku, agama, kekerabatan, almamater, dan sejenisnya.
        </li>
        <li>Kecurangan pelayanan <br>
        Petugas memberikan pelayanan yang tidak sesuai dengan ketentuan sehingga mengindikasikan kecurangan, seperti penyerobotan antrian, mempersingkat waktu tunggu layanan diluar prosedur, pengurangan syarat/prosedur, pengurangan denda, dll.
        </li>
        <li>Menerima imbalan dan/atau gratifikasi<br>
        Petugas menerima/bahkan meminta imbalan uang untuk alasan administrasi, transportasi, rokok, kopi, dll diluar ketentuan, pemberian imbalan barang berupa makanan jadi, rokok, parsel, perhiasan, elektronik, pakaian, bahan pangan, dll diluar ketentuan, pemberian imbalan fasilitas berupa akomodasi (hotel, resort perjalanan/jasa transportasi, komunikasi, hiburan, voucher belanja, dll) diluar ketentuan.
        </li>
        <li>Pungutan liar<br>
        Petugas melakukan pungli, yaitu permintaan pembayaran atas pelayanan yang diterima pengguna layanan diluar tarif resmi (Pungli bisa dikamuflasekan melalui berbagai istilah seperti “uang administrasi”, “uang rokok”, “uang terima kasih”, dsb).
        </li>
        <li>Percaloan<br>
        Praktik percaloan (pihak yang melakukan percaloan dapat berasal dari oknum pegawai pada unit layanan ini, maupun pihak luar yang memiliki hubungan atau tidak memiliki hubungan dengan oknum pegawai).
        </li>
    </ol>

</td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td><span style="font-weight: bold;">2. Kuesioner Survei</span></td>
        </tr>
        <tr>
            <td style="padding-left:1.5em;">
            Kuesioner yang digunakan dalam pelaksanaan survei adalah sebagai berikut:
            <br>
                <br>
            </td>
        </tr>
    </table>

    <!-- LOAD DRAF KUESIONER -->
    <div style="padding-left:1.5em;">
                 <?php $this->view('laporan_survey/view_draf_kuesioner'); ?>
    </div>
</div>



<!--============================================== BAB II =================================================== -->
<div class="page-session">
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; font-size:18px; font-weight: bold;">
                BAB II
                <br>
                METODOLOGI SURVEI
                <br>
                <br>
            </td>
        </tr>
    </table>


    <table style="width: 100%;">
        <tr>
            <td><span style="font-weight: bold; ">A. Kriteria Responden</span></td>
        </tr>

        <?php if($manage_survey->id_sampling == 1) { ?>
        <tr>
            <td class="content-paragraph">
            Responden adalah seluruh pihak yang pernah mendapatkan pelayanan di unit ini. Jumlah responden yang digunakan dalam Survei Persepsi Anti Korupsi (SPAK) ini dihitung menggunakan rumus Krejchie sebagai berikut:
            </td>
        </tr>
        <tr>
            <td style="padding-left:1em;"><b>Rumus Krejcie</b>
            <div style="text-align:center;">
                <img src="<?php echo base_url() . 'assets/img/site/rumus_krejcie.png' ?>" alt="rumus krejcie" width="50%">
            </div>
        
            </td>
        </tr>

        <tr>
            <td style="padding-left:1em;">Keterangan :
            <div style="padding-left:4em;">
                <table style="width: 100%;">
                    <tr>
                        <td width="7%">&nbsp;S</td>
                        <td width="5%">:</td>
                        <td>Jumlah sampel</td>
                    </tr>
                    <tr>
                        <td width="7%"><img src="<?php echo base_url() . 'assets/img/site/lamda.png' ?>" alt="rumus krejcie" width="60%"></td>
                        <td width="5%">:</td>
                        <td>Lamda (faktor pengali) dengan dk = 1,<br>
                            (taraf kesalahan yang digunakan 5%, sehingga nilai lamba 3,841)
                        </td>
                    </tr>
                    <tr>
                        <td width="7%">&nbsp;N</td>
                        <td width="5%">:</td>
                        <td>Populasi sebanyak <?php echo $manage_survey->jumlah_populasi ?></td>
                    </tr>
                    <tr>
                        <td width="7%">&nbsp;P</td>
                        <td width="5%">:</td>
                        <td>Q = 0,5 (populasi menyebar normal)</td>
                    </tr>
                    <tr>
                        <td width="7%">&nbsp;d</td>
                        <td width="5%">:</td>
                        <td>0,05</td>
                    </tr>
                </table>
            </div>
            <div>Sehingga dari perhitungan di atas, jumlah responden minimal yang harus diperoleh adalah <?php echo $manage_survey->jumlah_sampling ?> responden.</div>

            <br>
            </td>
        </tr>
        
        <?php } else { ?>

        <tr>
            <td style="padding-left:1em;">
                Responden adalah seluruh pihak yang pernah mendapatkan pelayanan di unit ini.
                <br>
                <br>
            </td>
        </tr>

       <?php } ?>
        

    </table>



    <table style="width: 100%;">
        <tr>
            <td><span style="font-weight: bold; ">B. Metode Pencacahan</span></td>
        </tr>
        <tr>
            <td class="content-paragraph">
            Pengumpulan data dilakukan dengan menggunakan metode survei elektronik melalui sistem broadcast data. Broadcast data dilakukan melalui WhatsApp, SMS, Email, dan scan barcode.
            <br>
                <br>
            </td>
        </tr>

        <tr>
            <td><span style="font-weight: bold; ">C. Metode Pengolahan Data dan Analisis</span></td>
        </tr>
        <tr>
            <td class="content-paragraph">
            Metode yang digunakan dalam pengolahan data dan analisis Survei Persepsi Anti Korupsi (SPAK) ini menggunakan aplikasi survei yang akan menghasilkan analisis deskriptif kuantitatif.
            </td>
        </tr>
    </table>
</div>




<!--============================================== BAB III =================================================== -->
<div class="page-session">
<table style="width: 100%;" class="">
        <tr>
            <td style="text-align: center; font-size:18px; font-weight: bold;">
                BAB III
                <br>
                PENGOLAHAN SURVEI
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td><span style="font-weight: bold; ">A. Analisis Hasil Survei</span></td>
        </tr>
        <tr>
            <td style=" font-weight: bold; padding-left:1em;">1. Jenis Pelayanan</td>
        </tr>
        <tr>
            <td style="padding-left:1em;">Berikut merupakan jenis layanan yang diperoleh dari Survei Persepsi Anti Korupsi (SPAK):</td>
        </tr>

        <tr>
            <td>
            <table style="width: 90%; margin-left: auto; margin-right: auto;" class="table-list">
                        <tr style="background-color:#E4E6EF;">
                            <th class="td-th-list">No</th>
                            <th class="td-th-list">Jenis Pelayanan</th>
                            <th class="td-th-list">Jumlah</th>
                            <th class="td-th-list">Persentase</th>
                        </tr>


                        <?php
                       $responden = $this->db->query("SELECT * FROM responden_$table_identity
                       JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                       WHERE is_submit = 1");

                       $data = [];
                       foreach ($responden->result() as $key => $value) {
                           $id_layanan_survei = implode(", ", unserialize($value->id_layanan_survei));
                           $data[$key] = "UNION ALL SELECT *
                                       FROM layanan_survei_$table_identity
                                       WHERE id IN ($id_layanan_survei)";
                       }
                       $tabel_layanan = implode(" ", $data);

                       $layanan = $this->db->query("
                       SELECT id, nama_layanan, COUNT(id) - 1 AS perolehan,
                       SUM(Count(id)) OVER () - (SELECT COUNT(id) FROM layanan_survei_$table_identity WHERE is_active = 1) as total_survei
                       FROM (
                           SELECT * FROM layanan_survei_$table_identity
                           $tabel_layanan
                           ) ls
                       WHERE is_active = 1
                       GROUP BY id
                       ");

                        $no = 1;
                        foreach ($layanan->result() as $row) {
                            $perolehan[] = $row->perolehan;
                            $total_perolehan = array_sum($perolehan);

                            $persentase[] = ($row->perolehan/$row->total_survei) * 100;
                            $total_persentase  = array_sum($persentase);
                            ?>
                        <tr>

                            <td class="td-th-list"><?= $no++ ?></td>
                            <td class="td-th-list"><?= $row->nama_layanan ?></td>
                            <td class="td-th-list"><?= $row->perolehan ?></td>
                            <td class="td-th-list"><?= ROUND(($row->perolehan/$row->total_survei) * 100,2) ?> %</td>
                        </tr>
                        <?php } ?>


                        <tr>
                            <th class="td-th-list" colspan="2">TOTAL</th>
                            <th class="td-th-list"><?= $total_perolehan ?></th>
                            <th class="td-th-list"><?= ROUND($total_persentase) ?> %</th>
                        </tr>

                    </table>
            </td>
        </tr>
    </table>

    <br>


    <table style="width: 100%;" class="">
        <tr>
            <td style=" font-weight: bold; padding-left:1em;">2. Nilai Indeks Persepsi Anti Korupsi</td>
        </tr>
        <tr>
            <td class="content-paragraph" style="padding-left: 2em;">Hasil Survei Persepsi Anti Korupsi (SPAK)
                <?php echo $manage_survey->organisasi ?> mendapatkan nilai Indeks Persepsi Anti Korupsi sebesar
                <b><?php echo round($nilai_tertimbang, 3) ?></b>, dengan predikat <b><?php echo $ketegori ?></b>. Nilai
                Indeks Persepsi Anti Korupsi tersebut didapat dari nilai rata-rata seluruh
                unsur pada tabel berikut.</td>
        </tr>

        <tr>
            <td style="padding-left: 2em;">
                <br>
                <?php $table_next_1 = $this->db->get_where("profil_responden_$table_identity", array('is_lainnya' => 1))->num_rows() + 1; ?>
                <div style="text-align: center;">Tabel <?php echo $table_next_1 ?>. Nilai Unsur <?php echo $manage_survey->organisasi ?></div>

                <table style="width: 90%; margin-left: auto; margin-right: auto;" class="table-list">
                        <tr style="background-color:#E4E6EF;">
                            <th class="td-th-list">No</th>
                            <th class="td-th-list">Unsur</th>
                            <th class="td-th-list">Nilai Indeks</th>
                            <th class="td-th-list">Predikat</th>
                        </tr>


                        <?php
                        $no = 1;
                        foreach ($nilai_per_unsur->result() as $row) {
                            $indeks = ROUND($row->nilai_per_unsur * $skala_likert, 10);
                            foreach ($definisi_skala->result() as $obj) {
                                if ($indeks <= $obj->range_bawah && $indeks >= $obj->range_atas) {
                                    $ktg = $obj->kategori;
                                }
                            }
                            if ($indeks <= 0) {
                                $ktg = 'NULL';
                            }
                        ?>
                        <tr>
                            <td class="td-th-list">
                                <?php echo $no++ ?>
                            </td>
                            <td class="td-th-list" style="text-align: left;">
                                <?php echo $row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan ?>
                            </td>
                            <td class="td-th-list">
                                <?php echo ROUND($row->nilai_per_unsur, 3) ?>
                            </td>
                            <td class="td-th-list">
                                <?php echo $ktg ?>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                        <td class="td-th-list" colspan="2"><b>Nilai Indeks Persepsi Anti Korupsi</b></td>
                            <td class="td-th-list"><b><?php echo round($nilai_tertimbang, 3) ?></b></td>
                            <td class="td-th-list"><?php echo $ketegori ?></td>
                        </tr>
                        <tr>
                            <td class="td-th-list" colspan="2"><b>Nilai Konversi</b></td>
                            <td class="td-th-list"><b><?php echo round($nilai_skm, 2) ?></b></td>
                            <td class="td-th-list"><b><?php echo $ketegori ?></b></td>
                        </tr>
                        
                    </table>
            </td>
        </tr>

        <tr>
            <td class="content-paragraph" style="padding-left: 2em;">
            Nilai unsur Survei Persepsi Anti Korupsi (SPAK) pada <?php echo $manage_survey->organisasi ?> dapat dilihat pada  gambar di bawah ini.
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; padding-left: 2em;">
                <div style="outline: dashed 1px black;">
                    <img src="https://quickchart.io/chart?c={ type: 'horizontalBar', data: { labels: [<?php echo $nama_per_unsur ?>], datasets: [{ label: 'Dataset 1', backgroundColor: 'rgb(255, 159, 64)', stack: 'Stack 0', data: [<?php echo $bobot_per_unsur ?>], }, ], }, options: { title: { display: false, text: 'Chart.js Bar Chart - Stacked' }, legend: { display: false }, plugins: { roundedBars: true, datalabels: { anchor: 'center', align: 'center', color: 'white', font: { weight: 'normal', }, }, }, responsive: true, }, }"
                        alt="" width="70%">
                </div>
                <br>
                <?php $gambar_next_1 = $profil_responden->num_rows() + 1; ?>
                Gambar <?= $gambar_next_1 ?>. Grafik Unsur <?php echo $manage_survey->organisasi ?>
            </td>
        </tr>
    </table>




    <table style="width: 100%;" class="">
        <tr>
            <td style=" font-weight: bold; padding-left:1em;">3. Pembahasan Unsur</td>
        </tr>
        <tr>
            <td class="content-paragraph" style="padding-left: 2em;">Unsur yang dipakai dalam Survei Persepsi Anti Korupsi (SPAK) dapat dijadikan sebagai acuan untuk mengetahui predikat anti korupsi pada <?php echo $manage_survey->organisasi ?>. Berikut adalah pembahasan mengenai jumlah persentase persepsi responden di setiap unsur:</td>
        </tr>
    </table>

    <div><?php echo $get_html ?></div>
   


    <table style="width: 100%;" class="">
        <tr>
            <td style=" font-weight: bold; padding-left:1em;">4. Saran Responden</td>
        </tr>
        <tr>
            <td class="content-paragraph" style="padding-left: 2em;">Unsur yang dipakai dalam Survei Persepsi Anti Korupsi (SPAK) dapat Saran responden mengenai Survei Persepsi Anti Korupsi (SPAK) pada <?php echo $manage_survey->organisasi ?> sebagai berikut:</td>
        </tr>
    </table>



    <table style="width: 100%; margin-left: auto; margin-right: auto; padding-left: 2em;" class="table-list">
    
    <?php
    $table_next_2 = $this->db->get_where("unsur_pelayanan_$table_identity", array('id_parent' => 0))->num_rows() + $table_next_1 + 1;
    $saran = $this->db->query("SELECT * FROM survey_$table_identity WHERE is_submit = 1 && saran != '' && is_active = 1");
    ?>

    <!-- CEK APAKAH ADA SARAN YANG DIISIKAN -->
    <?php if($saran->num_rows() > 0) { ?>            
    <tr>
        <td colspan="2"><div style="text-align: center;">Tabel <?php echo $table_next_2 ?>. Saran Masukan Responden</div></td>
    </tr>

    <tr style="background-color:#E4E6EF;">
        <th class="td-th-list">No</th>
        <th class="td-th-list">Isi Saran</th>
    </tr>

    <?php
    //LOOPING SARAN
    $d = 1;
    foreach($saran->result() as $row) { ?>
    <tr>
        <td class="td-th-list" width="5%"><?php echo $d++ ?></td>
        <td class="td-th-list" style="text-align:left;"><?php echo $row->saran ?></td>
    </tr>
    <?php } ?>

     <!-- JIKA TIDAK ADA SARAN -->
    <?php } else { ?>

        <tr>
            <td colspan="2"><div style="text-align: center;"><i>Tidak ada saran dan masukan yang di dapan dalan survei.</i></div></td>
        </tr>
        
    <?php } ?>

    </table>
    <br>


    <table style="width: 100%;" class="">
        <tr>
            <td style="font-weight: bold; padding-top:1em;" colspan="2">B. Tindak Lanjut Hasil Survei</td>
        </tr>

        <tr>
            <td class="content-paragraph" colspan="2">Berdasarkan hasil dari Survei Persepsi Anti Korupsi (SPAK), maka rekomendasi yang dapat dilakukan sebagai berikut:</td>
        </tr>
    </table>

    <?php if($analisa->num_rows() > 0 ) { ?>
    <?php foreach($analisa->result() as $value) { ?>
    <div style="outline: dashed 1px black; padding-left:1em;" ">
    <table style="width: 100%; class="">
            <tr>
                <td style="font-weight: bold;" width="25%">Unsur</td>
                <td width="5%">:</td>
                <td><?= $value->nomor_unsur . '. ' . $value->nama_unsur_pelayanan ?></td>
            </tr>

            <tr>
                <td style="font-weight: bold;" width="25%">Faktor yang Mempengaruhi</td>
                <td width="5%">:</td>
                <td><?php echo $value->faktor_penyebab ?></td>
            </tr>

            <tr>
                <td style="font-weight: bold;" width="25%">Rencana Tindak Lanjut</td>
                <td width="5%">:</td>
                <td><?php echo $value->rencana_perbaikan ?></td>
            </tr>

            <tr>
                <td style="font-weight: bold;" width="25%">Waktu</td>
                <td width="5%">:</td>
                <td><?php echo $value->waktu ?></td>
            </tr>

            <tr>
                <td style="font-weight: bold;" width="25%">Penanggung Jawab</td>
                <td width="5%">:</td>
                <td><?php echo $value->penanggung_jawab?></td>
            </tr>
    </table>
    </div>
    <br>
    <?php } ?>

    <?php } else { ?>

    <div style="text-align:center; font-size:13px;"><i>Belum ada data tindak lanjut.</i></div>

    <?php } ?>


</div>


<!--============================================== BAB IV =================================================== -->
<div class="page-session">
    <table style="width: 100%;" class="">
        <tr>
            <td style="text-align: center; font-size:18px; font-weight: bold;">
                BAB IV
                <br>
                DATA SURVEI
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td><span style="font-weight: bold; ">A. Data Responden</span></td>
        </tr>
        <tr>
            <td style="padding-left:1em;">
                
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-left: auto; margin-right: auto; padding-left:2em;" class="table-list">
        <tr style="background-color:#E4E6EF;">
            <th class="td-th-list"></th>

            <?php
            $profil = $this->db->query("SELECT * FROM profil_responden_$manage_survey->table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

            $data_profil = [];
            foreach ($profil as $get) {
                if ($get->jenis_isian == 1) {

                    $data_profil[] = "(SELECT nama_kategori_profil_responden FROM kategori_profil_responden_$table_identity WHERE responden_$table_identity.$get->nama_alias = kategori_profil_responden_$table_identity.id) AS $get->nama_alias";
                } else {
                    $data_profil[] = $get->nama_alias;
                }
            }
            $query_profil = implode(", ", $data_profil);

            $data_responden = $this->db->query("SELECT *, responden_$table_identity.uuid AS uuid_responden, $query_profil
            FROM responden_$table_identity
            JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
            WHERE is_submit = 1");

            $array_profil = array('email', 'nomor_telepon', 'no_telepon', 'telepon', 'nomor', 'handphone', 'no_hp', 'whatsapp', 'nomor_whatsapp', 'no_wa', 'nama_lengkap');
            
            foreach ($profil as $row) {
                if(!in_array($row->nama_alias, $array_profil)) {
                ?>
                <th class="td-th-list"><?php echo $row->nama_profil_responden ?></th>
            <?php } } ?>
        
        </tr>

        <?php
        $e = 1;
        foreach($data_responden->result() as $value) { ?>
        <tr>
            <td class="td-th-list" style="text-align: left;">Responden <?= $e++ ?></td>

            <?php
            foreach ($profil as $get) {
                $nama_profil = $get->nama_alias;
                if(!in_array($get->nama_alias, $array_profil)) {
                ?>

                <td class="td-th-list"><?php echo $value->$nama_profil ?></td>    
            <?php } } ?>
        </tr>
        <?php } ?>

    </table>
                
                
    <table style="width: 100%;" class="">
        <tr>
            <td><i style="font-size: 12px;"><span style="color:red;">**</span> Data <b>Nama Lengkap</b>, <b>Email</b> dan <b>Nomor Telepon</b> tidak ditampilkan untuk menjaga kerahasiaan data responden.</i>
        </td>
        </tr>
    </table>


    <table style="width: 100%; padding-top:1em;">
        <tr>
            <td><span style="font-weight: bold; ">B. Capture Aplikasi Survei</span></td>
        </tr>
        <tr>
            <td style="padding-left:1em; padding-top:1em; text-align:center;">

                <?php if($manage_survey->img_form_opening != '') { ?>
                <div style="outline: dashed 1px black;">
                    <img src="<?php echo base_url() . 'assets/klien/form_opening/' . $table_identity . '.png' ?>" alt="" width="70%">
                </div>
                <?php } else { ?>

                    <i>Gambar form opening belum diambil.</i>

                <?php } ?>

            </td>
        </tr>
    </table>


    <table style="width: 100%; padding-top:1em;">
        <tr>
            <td><span style="font-weight: bold; ">C. Sertifikat Survei</span></td>
        </tr>
        <tr>
            <td style="padding-left:1em;">
                Link dan barcode untuk validasi hasil Survei:
            </td>
        </tr>

        <tr>
            <td style="padding-left:1em; text-align:center;">
                <img src="https://image-charts.com/chart?chs=150x150&cht=qr&chl=https://spak.surveiku.com/validasi-sertifikat/<?php echo $manage_survey->uuid ?>&choe=UTF-8" alt="" width="30%">
            </td>
        </tr>

        <tr>
            <td style="padding-left:1em;">
                <div style="outline: dashed 1px black; text-align:center; padding:1em;">
                    <span style="color: blue; "><?php echo base_url() . 'validasi-sertifikat/' . $manage_survey->uuid ?></span>
                    <br>
                </div>
            </td>
        </tr>
    </table>
</div>


</main>


</body>

</html>