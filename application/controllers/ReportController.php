<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('auth', 'refresh');
        }
    }

    

    public function download_docx($username, $slug)
    {

        $manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
        $table_identity = $manage_survey->table_identity;

        $atribut_pertanyaan = unserialize($manage_survey->atribut_pertanyaan_survey);

        $user = $this->ion_auth->user()->row();
        $data_user = [
            'foto_profile' => ($user->foto_profile != '') ? $user->foto_profile : '200px.jpg',
        ];

        $data_survei = [
            'nama_survei' => $manage_survey->survey_name,
            'tahun_survei' => $manage_survey->survey_year,
            'survei_dimulai' => date("d-m-Y", strtotime($manage_survey->survey_start)),
            'survei_selesai' => date("d-m-Y", strtotime($manage_survey->survey_end)),
            'nama_organisasi' => $manage_survey->organisasi,
            'alamat_organisasi' => $manage_survey->alamat,
            'telp_organisasi' => $manage_survey->no_tlpn,
            'email_organisasi' => $manage_survey->email,
            'executive_summary' => $manage_survey->executive_summary,
            'visi' => strip_tags($manage_survey->visi),
            'misi' => strip_tags($manage_survey->misi)
        ];

        //PENDEFINISIAN SKALA LIKERT
        $skala_likert = 100 / ($manage_survey->skala_likert == 5 ? 5 : 4);
        $definisi_skala = $this->db->query("SELECT * FROM definisi_skala_$table_identity ORDER BY id DESC");




        $this->db->select("nama_unsur_pelayanan, IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub, (SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden)) AS rata_rata,  (COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden)) AS colspan, ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden))) AS nilai, (((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden)))/(SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE id_parent = 0)) AS rata_rata_bobot");
        $this->db->from('jawaban_pertanyaan_unsur_' . $table_identity);
        $this->db->join("pertanyaan_unsur_pelayanan_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id");
        $this->db->join("unsur_pelayanan_$table_identity", "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id");
        $this->db->join("survey_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden");
        $this->db->where("survey_$table_identity.is_submit = 1");
        $this->db->group_by('id_sub');
        $rata_rata_bobot = $this->db->get();

        foreach ($rata_rata_bobot->result() as $rata_rata_bobot) {
            $nilai_bobot[] = $rata_rata_bobot->rata_rata_bobot;
            $ikm_nilai_tertimbang = array_sum($nilai_bobot);
            $ikm = ROUND($ikm_nilai_tertimbang * $skala_likert, 10);
        }

        foreach ($definisi_skala->result() as $obj) {
            if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
                $index  = $obj->kategori;
                $mutu_pelayanan = $obj->mutu;
            }
        }
        if ($ikm <= 0) {
            $index = 'NULL';
            $mutu_pelayanan = 'NULL';
        }


        // if ($ikm <= 100 && $ikm >= 88.31) {
        //     $index = 'Sangat Baik';
        //     $mutu_pelayanan = 'A';
        // } elseif ($ikm <= 88.40 && $ikm >= 76.61) {
        //     $index = 'Baik';
        //     $mutu_pelayanan = 'B';
        // } elseif ($ikm <= 76.60 && $ikm >= 65) {
        //     $index = 'Kurang Baik';
        //     $mutu_pelayanan = 'C';
        // } elseif ($ikm <= 64.99 && $ikm >= 25) {
        //     $index = 'Tidak Baik';
        //     $mutu_pelayanan = 'D';
        // } else {
        //     $index = 'NULL';
        //     $mutu_pelayanan = 'NULL';
        // }
        $nilai_tertimbang = $ikm_nilai_tertimbang;
        $nilai_skm = $ikm;


        // UNSUR TERENDAH DAN TERTINGGI
        $nilai_per_unsur_desc = $this->db->query("SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub, (SUM(skor_jawaban)/COUNT(DISTINCT id_responden)) AS rata_rata,  (COUNT(id_parent)/COUNT(DISTINCT id_responden)) AS colspan, ((SUM(skor_jawaban)/COUNT(DISTINCT id_responden))/(COUNT(id_parent)/COUNT(DISTINCT id_responden))) AS nilai_per_unsur, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nomor_unsur, (SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nama_unsur_pelayanan
        FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
        JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
        GROUP BY id_sub
        ORDER BY nilai_per_unsur DESC
        LIMIT 3");

        $nilai_per_unsur_asc = $this->db->query("SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub, (SUM(skor_jawaban)/COUNT(DISTINCT id_responden)) AS rata_rata,  (COUNT(id_parent)/COUNT(DISTINCT id_responden)) AS colspan, ((SUM(skor_jawaban)/COUNT(DISTINCT id_responden))/(COUNT(id_parent)/COUNT(DISTINCT id_responden))) AS nilai_per_unsur, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nomor_unsur, (SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nama_unsur_pelayanan
        FROM jawaban_pertanyaan_unsur_$table_identity
        JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
        JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
        GROUP BY id_sub
        ORDER BY nilai_per_unsur ASC
        LIMIT 3");

        $asc = [];
        foreach ($nilai_per_unsur_asc->result() as $value) {
            $asc[] = $value->nomor_unsur . '. ' . $value->nama_unsur_pelayanan;
        }
        $unsur_terendah = implode(", ", $asc);

        $desc = [];
        foreach ($nilai_per_unsur_desc->result() as $get) {
            $desc[] = $get->nomor_unsur . '. ' . $get->nama_unsur_pelayanan;
        }
        $unsur_tertinggi = implode(", ", $desc);

        $total_survey = $this->db->get_where("survey_$table_identity", array('is_submit' => 1))->num_rows();








    $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split1 = explode('-', $manage_survey->survey_start);
    $split2 = explode('-', $manage_survey->survey_end);
    if((int)$split1[0] != (int)$split2[0]){
        $periode =  strtoupper($bulan[ (int)$split1[1] ] . ' ' . $split1[0] . ' - ' . $bulan[ (int)$split2[1] ] . ' ' . $split2[0]);
    }else{
        if($bulan[ (int)$split1[1] ] == $bulan[ (int)$split2[1] ]){
            $periode =  strtoupper($bulan[ (int)$split2[1] ] . ' ' . $split1[0]);
        }else{
            $periode =  strtoupper($bulan[ (int)$split1[1] ] . ' - ' . $bulan[ (int)$split2[1] ] . ' ' . $split1[0]);
        }
    }

    $no_pl=1;
    $no_p=1;
    $no_p1=2;
    $no_p2=1;







        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        PhpOffice\PhpWord\Settings::setDefaultFontSize(11);

        $phpWord->addParagraphStyle('Heading2', array('alignment' => 'center'));

        $fontStyleName = 'rStyle';
        $phpWord->addFontStyle($fontStyleName, array('name' => 'Arial', 'size' => 11, 'allCaps' => true));

        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));


        $section = $phpWord->addSection();

        // Add first page header
        $header = $section->addHeader();
        $header->firstPage();

        // Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addImage(
            URL_AUTH . 'assets/klien/foto_profile/' . $data_user['foto_profile'],
            array(
                'positioning'        => 'relative',
                'marginTop'          => -5,
                'marginLeft'         => 0,
                'width'              => 55,
                'height'             => 55,
                'wrappingStyle'      => 'behind',
                'wrapDistanceRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToPoint(),
                'wrapDistanceBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToPoint(),
            )
        );
        $subsequent->addText('L A P O R A N', array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'DE2226'), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $subsequent->addText('SURVEI PERSEPSI ANTI KORUPSI (SPAK)', array('name' => 'Arial', 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $subsequent->addText(strtoupper($manage_survey->organisasi), array('name' => 'Arial', 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $subsequent->addLine(['weight' => 1, 'width' => 450, 'height' => 0]);

        // Add footer
        $footer = $section->addFooter();
        $footer->addLine(['weight' => 1, 'width' => 450, 'height' => 0]);
        //$footer->addText($data_survei['nama_organisasi'] . ' - ' . $data_survei['tahun_survei'], array('name' => 'Arial', 'size' => 10), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $footer->addText('SPAK ' . $data_survei['tahun_survei'] . ' - Generate by SurveiKu.com', array('name' => 'Arial', 'size' => 10), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $footer->addPreserveText('{PAGE}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        // HALAMAN COVER LAPORAN
        $section->addTextBreak(3);

        $section->addImage(URL_AUTH . 'assets/klien/foto_profile/' . $data_user['foto_profile'], array('width' => 140, 'height' => 140, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        $section->addTextBreak(3);

        $section->addText('LAPORAN', array('bold' => true, 'size' => 20), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        //$section->addTextBreak();
        $section->addText('SURVEI PERSEPSI ANTI KORUPSI (SPAK)', array('name' => 'Arial', 'size' => 20, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $section->addTextBreak();
        $section->addText(strtoupper($data_survei['nama_organisasi']), array('name' => 'Arial', 'size' => 14, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $section->addText(strtoupper($user->company), array('name' => 'Arial', 'size' => 14, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $section->addTextBreak();
        //$section->addText('PERIODE ' . $data_survei['survei_dimulai'] . ' - ' . $data_survei['survei_selesai'], array('name' => 'Arial', 'size' => 14, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $section->addText('PERIODE ' . $periode, array('name' => 'Arial', 'size' => 14, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        // $section->addTextBreak(5);

        // $section->addText($data_survei['nama_organisasi'], array('name' => 'Arial', 'size' => 10, 'allCaps' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        // $section->addText($data_survei['alamat_organisasi'], array('name' => 'Arial', 'size' => 10), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        // $section->addText($data_survei['telp_organisasi'], array('name' => 'Arial', 'size' => 10), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        // $section->addText($data_survei['email_organisasi'], array('name' => 'Arial', 'size' => 10), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));



        $section->addPageBreak();



        // HALAMAN PROFIL ORGANISASI

        $section->addText('BAB I', array('bold' => true, 'size' => 16), $paragraphStyleName);
        //$section->addTextBreak();
        $section->addText('KUESIONER SURVEI', array('bold' => true, 'size' => 16), $paragraphStyleName);
        $section->addTextBreak();

        $texthtmlbab1 = '<table>
        <tr>
            <td width="5%"><b>1.</b></td>
            <td width="95%"><b>Variabel Survei</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%">Variabel Survei Persepsi Anti Korupsi (SPAK) meliputi:

            <table>
            <tr>
                <td width="5%">1.</td>
                <td width="95%">Diskriminasi pelayanan</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Petugas memberikan pelayanan secara khusus atau membeda-bedakan pelayanan karena faktor suku, agama, kekerabatan, almamater, dan sejenisnya.</p></td>
            </tr>
            <tr>
                <td width="5%">2.</td>
                <td width="95%">Kecurangan pelayanan</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Petugas memberikan pelayanan yang tidak sesuai dengan ketentuan sehingga mengindikasikan kecurangan, seperti penyerobotan antrian, mempersingkat waktu tunggu layanan diluar prosedur, pengurangan syarat/prosedur, pengurangan denda, dll.</p></td>
            </tr>
            <tr>
                <td width="5%">3.</td>
                <td width="95%">Menerima imbalan dan/atau gratifikasi</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Petugas menerima/bahkan meminta imbalan uang untuk alasan administrasi, transportasi, rokok, kopi, dll diluar ketentuan, pemberian imbalan barang berupa makanan jadi, rokok, parsel, perhiasan, elektronik, pakaian, bahan pangan, dll diluar ketentuan, pemberian imbalan fasilitas berupa akomodasi (hotel, resort perjalanan/jasa transportasi, komunikasi, hiburan, voucher belanja, dll) diluar ketentuan.</p></td>
            </tr>
            <tr>
                <td width="5%">4.</td>
                <td width="95%">Pungutan liar</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Petugas melakukan pungli, yaitu permintaan pembayaran atas pelayanan yang diterima pengguna layanan diluar tarif resmi (Pungli bisa dikamuflasekan melalui berbagai istilah seperti “uang administrasi”, “uang rokok”, “uang terima kasih”, dsb)</p></td>
            </tr>
            <tr>
                <td width="5%">5.</td>
                <td width="95%">Percaloan</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Praktik percaloan (pihak yang melakukan percaloan dapat berasal dari oknum pegawai pada unit layanan ini, maupun pihak luar yang memiliki hubungan atau tidak memiliki hubungan dengan oknum pegawai)</p></td>
            </tr>
            </table>

            </td>
        </tr>
        </table>';

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab1, false, false);

        $texthtmlbab12 = '<table>
            <tr>
                <td width="5%"><b>2.</b></td>
                <td width="95%"><b>Kuesioner Survei</b></td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify">Kuesioner yang digunakan dalam pelaksanaan survei adalah sebagai berikut:</p></td>
            </tr>
            </table>';

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab12, false, false);
        $section->addTextBreak();








        //========================================  USER PROFIL =============================================
        if ($user->foto_profile == NULL) {
            $profil_img = '<img src="' . URL_AUTH . 'assets/klien/foto_profile/200px.jpg" height="75" alt="" />';
        } else {
            $profil_img = '<img src="' . URL_AUTH . 'assets/klien/foto_profile/' . $user->foto_profile . '" height="75" alt="" />';
        };

        $title_header = unserialize($manage_survey->title_header_survey);
        $title_1 = $title_header[0];
        $title_2 = $title_header[1];



        //========================================  PROFIL RESPONDEN =============================================
        $profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();
        $nama_profil = [];
        foreach ($profil_responden as $get_profil) {

            if ($get_profil->jenis_isian == 1) {
                $kategori = [];
                foreach ($this->db->get_where("kategori_profil_responden_$table_identity", array('id_profil_responden' => $get_profil->id))->result() as $value) {
                    $kategori[] = '<img src="' . base_url() . 'assets/img/site/vector/check.png" height="10" alt="" /> ' . $value->nama_kategori_profil_responden . '<br/>';
                }
                $get_kategori = implode("", $kategori);
            } else {
                $get_kategori = '';
            };

            $nama_profil[] = '<tr style="font-size: 11px;"><td style="width: 30%; height:15px;" valign="top">' . $get_profil->nama_profil_responden . ' </td><td style="width: 70%;">' . $get_kategori . '</td></tr>';
        }
        $get_nama = implode("", $nama_profil);


        $nama_layanan = [];
        foreach($this->db->get_where("layanan_survei_$table_identity", array('is_active' => 1))->result() as $row){
            $nama_layanan[] = '<img src="' . base_url() . 'assets/img/site/vector/check.png" height="10" alt="" /> ' . $row->nama_layanan . '<br/>';
        }
        $get_layanan = '' . implode("", $nama_layanan) . '';



        //CEK SKALA TERLEBIH DAHULU SEBELUM MEMBUAT JUDUL TABEL
        if ($skala_likert == 5) {
            $thead_tabel_unsur = '<table style="width: 100%; font-size: 11px; text-align:center; background-color:#C7C6C1; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td rowspan="2" style="width: 5%; ">No</td>
                <td rowspan="2" style="width: 32%; ">PERTANYAAN</td>
                <td colspan="5" style="width: 40%; ">PILIHAN JAWABAN</td>
                <td rowspan="2" style="width: 23%; ">Berikan alasan jika pilihan jawaban: 1 atau 2</td>
            </tr>
            <tr>
                <td style="width: 8%; ">1</td>
                <td style="width: 8%; ">2</td>
                <td style="width: 8%; ">3</td>
                <td style="width: 8%; ">4</td>
                <td style="width: 8%; ">5</td>
            </tr>
        </table>';

            $thead_tabel_harapan = '<table style="width: 100%; font-size: 11px; text-align:center; background-color:#C7C6C1; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="5" width="63%">PILIHAN JAWABAN</td>
            </tr>
            <tr>
                <td width="12.6%">1</td>
                <td width="12.6%">2</td>
                <td width="12.6%">3</td>
                <td width="12.6%">4</td>
                <td width="12.6%">5</td>
            </tr>
        </table>';
        } else {

        $thead_tabel_unsur1 = '<table style="width: 100%; font-size: 11px; text-align:center; background-color:#C7C6C1; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td rowspan="2" style="width: 5%; text-align:center; ">No</td>
                <td rowspan="2" style="width: 32%; text-align:center; ">PERTANYAAN</td>
                <td colspan="4" style="width: 40%; text-align:center; ">PILIHAN JAWABAN</td>
                <td rowspan="2" style="width: 23%; text-align:center; ">Berikan alasan jika pilihan jawaban: 1 atau 2</td>
            </tr>
            <tr>
                <td style="width: 10%; ">1</td>
                <td style="width: 10%; ">2</td>
                <td style="width: 10%; ">3</td>
                <td style="width: 10%; ">4</td>
            </tr>
        </table>';

        $thead_tabel_unsur = '<br/><table style="width: 100%; font-size: 11px; text-align:center; background-color:#C7C6C1; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td style="width: 5%; text-align:center; ">No</td>
                <td style="width: 32%; text-align:center; ">PERTANYAAN</td>
                <td style="width: 40%; "><table style="width: 100%; font-size: 11px; text-align:center; background-color:#C7C6C1; " cellpadding="3">
            <tr>
                <td colspan="4" style="width: 100%; text-align:center; border-bottom: 2px #000 solid; ">PILIHAN JAWABAN</td>
            </tr>
            <tr>
                <td style="width: 25%; text-align:center; border-right: 2px #000 solid; ">1</td>
                <td style="width: 25%; text-align:center; border-right: 2px #000 solid; ">2</td>
                <td style="width: 25%; text-align:center; border-right: 2px #000 solid; ">3</td>
                <td style="width: 25%; text-align:center; ">4</td>
            </tr>
        </table></td>
                <td style="width: 23%; text-align:center; ">Berikan alasan jika pilihan jawaban: 1 atau 2
                </td>
            </tr>
        </table><br/>';

            $thead_tabel_harapan = '<table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="4" width="63%">PILIHAN JAWABAN</td>
            </tr>
            <tr>
                <td width="15.75%">1</td>
                <td width="15.75%">2</td>
                <td width="15.75%">3</td>
                <td width="15.75%">4</td>
            </tr>
        </table>';
        }





        //=================================== PERTANYAAN TERBUKA ATAS ==========================================
        if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_terbuka_atas = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
        FROM pertanyaan_terbuka_$table_identity
        JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
        WHERE pertanyaan_terbuka_$table_identity.is_letak_pertanyaan = 1");

            if ($pertanyaan_terbuka_atas->num_rows() > 0) {

                $per_terbuka_atas = [];
                foreach ($pertanyaan_terbuka_atas->result() as $value) {

                    if ($value->id_jenis_pilihan_jawaban == 2) {

                        $per_terbuka_atas[] = '
                    <table style="width: 100%; font-size: 11px; border: 2px #000 solid;" cellpadding="3">
                        <tr>
                            <td style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                            <td style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>
                            <td colspan="2" style="width: 63%; "></td>
                            <!--<td style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                        </tr>
                    </table>';
                    } else {

                        $pilihan_terbuka_atas = [];
                        foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                            $pilihan_terbuka_atas[] = '<tr>
                        <td style="width: 4%; border-bottom: 2px #000 solid; "></td>
                        <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; border-bottom: 2px #000 solid;">' . $get->pertanyaan_ganda . '</td>
                        </tr>';
                        }



                        if ($value->dengan_isian_lainnya == 1) {
                            $get_pilihan_terbuka_atas = implode("", $pilihan_terbuka_atas) . '<tr>
                            <td style="width: 4%; "></td>
                            <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; ">Lainnya</td>
                            </tr>';

                            $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 2;
                        } else {
                            $get_pilihan_terbuka_atas = implode("", $pilihan_terbuka_atas);

                            $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;
                        }

                        $per_terbuka_atas[] = '
                        <table style="width: 100%; font-size: 11px; border: 2px #000 solid;" cellpadding="3">
                            <tr>
                                <td rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                                <td rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>

                                <td colspan="2" style="width: 63%; "><table style="width: 100%; font-size: 11px; border: 0px #000 solid;" cellpadding="0"><tr><td colspan="2" style="width: 40%; border-bottom: 2px #000 solid; ">&nbsp;</td></tr>' . $get_pilihan_terbuka_atas . '</table></td>
                                        
                                <!--<td rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                            </tr>
                    </table>';
                    }
                }
                $get_pertanyaan_terbuka_atas = implode("", $per_terbuka_atas);
            } else {
                $get_pertanyaan_terbuka_atas = '';
            }
        } else {
            $get_pertanyaan_terbuka_atas = '';
        };




        //============================================= PERTANYAAN UNSUR =============================================
        $pertanyaan_unsur = $this->db->query("SELECT *, (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 1 ) AS pilihan_1,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 2 ) AS pilihan_2,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 3 ) AS pilihan_3,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 4 ) AS pilihan_4,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 5 ) AS pilihan_5
        FROM pertanyaan_unsur_pelayanan_$table_identity
        JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id");

        $per_unsur = [];
        foreach ($pertanyaan_unsur->result() as $row) {


            if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

                $pertanyaan_terbuka = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
            FROM pertanyaan_terbuka_$table_identity
            JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
            WHERE  id_unsur_pelayanan = $row->id_unsur_pelayanan");

                $per_terbuka = [];
                foreach ($pertanyaan_terbuka->result() as $value) {


                    if ($value->id_jenis_pilihan_jawaban == 2) {

                        $per_terbuka[] = '
                        <table style="width: 100%; font-size: 11px; border: 2px #000 solid;" cellpadding="3">
                            <tr>
                                <td style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                                <td style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>
                                <td colspan="2" style="width: 63%; "></td>
                                <!--<td style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                            </tr>
                        </table>
                    ';
                    } else {

                        $pilihan_terbuka = [];
                        foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                            $pilihan_terbuka[] = '<tr>
                            <td style="width: 4%; border-bottom: 2px #000 solid; "></td>
                            <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; border-bottom: 2px #000 solid;">' . $get->pertanyaan_ganda . '</td>
                            </tr>';
                        }

                        if ($value->dengan_isian_lainnya == 1) {
                            $get_pilihan_terbuka = implode("", $pilihan_terbuka) . '<tr>
                            <td style="width: 4%; "></td>
                            <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; ">Lainnya</td>
                            </tr>';

                            $isi[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 2;
                        } else {
                            $get_pilihan_terbuka = implode("", $pilihan_terbuka);

                            $isi[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;
                        }


                        $per_terbuka[] = '
                        <table style="width: 100%; font-size: 11px; border: 2px #000 solid;" cellpadding="3">
                            <tr>
                                <td rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                                <td rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>

                                <td colspan="2" style="width: 63%; "><table style="width: 100%; font-size: 11px; border: 0px #000 solid;" cellpadding="0"><tr><td colspan="2" style="width: 40%; border-bottom: 2px #000 solid; ">&nbsp;</td></tr>' . $get_pilihan_terbuka . '</table></td>
                                
                                <!--<td rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                            </tr>
                        </table>
                    ';
                    }
                }
                $get_pertanyaan_terbuka = implode("", $per_terbuka);
            } else {
                $get_pertanyaan_terbuka = '';
            }



            //CEK SKALA TERLEBIH DAHULU
            if ($skala_likert == 5) {
                $pilihan_ke_2 = $row->pilihan_5;
                $width = 8;
                $pilihan_ke_5 = '<td style="width: 8%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_5 . '</td>';
                $ke_5 = '<th></th>';
            } else {
                $pilihan_ke_2 = $row->pilihan_4;
                $width = 10;
                $pilihan_ke_5 = '';
                $ke_5 = '';
            }


            if ($row->jenis_pilihan_jawaban == 1) {

                $per_unsur[] = '
                <table style="width: 100%; border: 2px #000 solid; " cellpadding="4">
                    <tr>
                        <td rowspan="2" style="width: 5%; text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                        <td rowspan="2" style="width: 32%; text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                        <td style="width: 20%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                        <td style="width: 20%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $pilihan_ke_2 . '</td>
                        <td rowspan="2" style="width: 23%; text-align:left; font-size: 11px;"></td>
                    </tr>

                    <!--<tr>
                        <th></th>
                        <th></th>
                    </tr>-->
                </table>
            ' . $get_pertanyaan_terbuka;
            } else {


                $per_unsur[] = '
            <table style="width: 100%; border: 2px #000 solid; " cellpadding="4">
                <tr>
                    <td rowspan="2" style="width: 5%; text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                    <td rowspan="2" style="width: 32%; text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_2 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_3 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_4 . '</td>' . $pilihan_ke_5 . '
                    <td rowspan="2" style="width: 23%; text-align:left; font-size: 11px;"></td>
                </tr>

                <!--<tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>'
                    . $ke_5 .
                    '</tr>-->
            </table>
            ' . $get_pertanyaan_terbuka;
            }
        }
        $get_pertanyaan_unsur = implode("", $per_unsur);





        //============================================= PERTANYAAN TERBUKA BAWAH =========================================
        if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_terbuka_bawah = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
            FROM pertanyaan_terbuka_$table_identity
            JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
            WHERE pertanyaan_terbuka_$table_identity.is_letak_pertanyaan = 2");

            if ($pertanyaan_terbuka_bawah->num_rows() > 0) {

                $per_terbuka_bawah = [];
                foreach ($pertanyaan_terbuka_bawah->result() as $value) {

                    if ($value->id_jenis_pilihan_jawaban == 2) {

                        $per_terbuka_bawah[] = '
                <table style="width: 100%; font-size: 11px; border: 2px #000 solid; " cellpadding="3">
                    <tr>
                        <td style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                        <td style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>
                        <td colspan="2" style="width: 63%; "></td>
                        <!--<td style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                    </tr>
                </table>';
                    } else {

                        $pilihan_terbuka_bawah = [];
                        foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                            $pilihan_terbuka_bawah[] = '<tr>
                    <td style="width: 4%; border-bottom: 2px #000 solid; "></td>
                    <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; border-bottom: 2px #000 solid;">' . $get->pertanyaan_ganda . '</td>
                    </tr>';
                        }



                        if ($value->dengan_isian_lainnya == 1) {
                            $get_pilihan_terbuka_bawah = implode("", $pilihan_terbuka_bawah) . '<tr>
                    <td style="width: 4%; "></td>
                    <td style="width: 36%; background-color:#C7C6C1; border-left: 2px #000 solid; ">Lainnya</td>
                    </tr>';

                            $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 2;
                        } else {
                            $get_pilihan_terbuka_bawah = implode("", $pilihan_terbuka_bawah);

                            $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;
                        }

                        $per_terbuka_bawah[] = '
                    <table style="width: 100%; font-size: 11px; border: 2px #000 solid; " cellpadding="3">
                        <tr>
                            <td rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" style="width: 5%; text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                            <td rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" style="width: 32%; text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>

                            <td colspan="2" style="width: 63%; "><table style="width: 100%; font-size: 11px; border: 0px #000 solid;" cellpadding="0"><tr><td colspan="2" style="width: 40%; border-bottom: 2px #000 solid; ">&nbsp;</td></tr>' . $get_pilihan_terbuka_bawah . '</table></td>
                                    
                            <!--<td rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" style="width: 23%; text-align:left; font-size: 11px;"></td>-->
                        </tr>
                </table>';
                    }
                }
                $get_pertanyaan_terbuka_bawah = implode("", $per_terbuka_bawah);
            } else {
                $get_pertanyaan_terbuka_bawah = '';
            }
        } else {
            $get_pertanyaan_terbuka_bawah = '';
        };







        //PERTANYAAN HARAPAN
        if (in_array(1, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_harapan = $this->db->query("SELECT *, (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 1 ) AS pilihan_1,
         (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 2 ) AS pilihan_2,
         (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 3 ) AS pilihan_3,
         (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 4 ) AS pilihan_4, 
         (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 5 ) AS pilihan_5, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_unsur_pelayanan = unsur_pelayanan_$table_identity.id) AS nomor_unsur
         FROM pertanyaan_unsur_pelayanan_$table_identity");

            $per_harapan = [];
            foreach ($pertanyaan_harapan->result() as $row) {


                if ($skala_likert == 5) {
                    $width = 12.6;
                    $pilihan_ke_5 = '<td style="width: 12.6%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_5 . '</td>';
                    $ke_5 = '<th></th>';
                } else {
                    $width = 15.75;
                    $pilihan_ke_5 = '';
                    $ke_5 = '';
                }

                $per_harapan[] = '
            <table style="width: 100%; border: 2px #000 solid; " cellpadding="4">
                <tr>
                    <td rowspan="2" style="width: 5%; text-align:center; font-size: 11px;">H' . substr($row->nomor_unsur, 1) . '</td>
                    <td rowspan="2" style="width: 32%; text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_2 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_3 . '</td>
                    <td style="width: ' . $width . '%; background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_4 . '</td>' . $pilihan_ke_5 . '
                </tr>

                <!--<tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>'
                    . $ke_5 .
                    '</tr>-->
            </table>
            ';
            }
            $get_pertanyaan_harapan = '<table style="width: 100%; border: 2px #000 solid; " cellpadding="3">
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN HARAPAN TERHADAP UNSUR PELAYANAN BERDASARKAN TINGKAT KEPENTINGAN</b></td>
            </tr>
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;">Berilah tanda silang (x) sesuai jawaban Saudara dan berikan alasan jika jawaban Saudara negatif(Tidak
                    atau Kurang Penting)</td>
            </tr>
        </table>' . $thead_tabel_harapan . implode("", $per_harapan);
        } else {
            $get_pertanyaan_harapan = '';
        }






        // ======================================== PERTANYAAN KUALITATIF ======================================
        if (in_array(3, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_kualitatif = $this->db->get_where("pertanyaan_kualitatif_$table_identity", array('is_active' => 1));
            $per_kualitatif = [];
            $no = 1;
            foreach ($pertanyaan_kualitatif->result() as $row) {
                $per_kualitatif[] = '
                <tr>
                    <td style="width: 5%; ">' . $no++ . '</td>
                    <td style="width: 32%; ">' . $row->isi_pertanyaan . '</td>
                    <td style="width: 63%; "></td>
                </tr>
            ';
            }
            $get_pertanyaan_kualitatif = '<table style="width: 100%; border: 2px #000 solid; " cellpadding="3">
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN KUALITATIF PERSEPSI ANTI KORUPSI</b></td>
            </tr>
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;">Berikan jawaban sesuai dengan pendapat dan pengetahuan Saudara.</td>
            </tr>
        </table>
    
        <table style="width: 100%; font-size: 11px; background-color:#C7C6C1; border: 2px #000 solid; " cellpadding="3">
            <tr>
                <td style="width: 5%; text-align:center; ">No</td>
                <td style="width: 32%; text-align:center; ">PERTANYAAN</td>
                <td style="width: 63%; text-align:center; ">JAWABAN</td>
            </tr>
        </table>
        
        <table style="width: 100%; font-size: 11px; border: 2px #000 solid; " cellpadding="10">
            ' . implode("", $per_kualitatif) . '
        </table>';
        } else {
            $get_pertanyaan_kualitatif = '';
        }



        // =============================================== STATUS SARAN ================================================
        if ($manage_survey->is_saran == 1) {
            $is_saran = '<tr>
            <td style="width: 100%; text-align:left; font-size: 11px;"><b>SARAN :</b>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
            </td>
        </tr>';
        } else {
            $is_saran = '';
        }







        // ============================================= GET HTML VIEW =============================================
        $texthtmlbab13 = '
        <table style="width: 100%; border: 2px #000 solid;">
            <tr>
                <td style="width: 100%; ">
                    <table border="0" cellspacing="2" cellpadding="1" style="width: 100%;">
                        <tr>
                            <td style="width: 15%; ">' . $profil_img . '</td>
                            <td style="width: 85%; font-size:12px; font-weight:bold;">' . strtoupper($title_1) . '<br/>' . strtoupper($title_2) . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        

        <table style="width: 100%; border: 2px #000 solid;" cellpadding="7">
            <tr>
                <td style="width: 100%; text-align:center; font-size: 11px; font-family:Arial, Helvetica, sans-serif; height:35px; ">Dalam rangka mengukur indeks persepsi anti korupsi, Saudara dipercaya menjadi responden pada kegiatan survei ini.<br/>Atas kesediaan Saudara kami sampaikan terima kasih dan penghargaan sedalam-dalamnya.</td>
            </tr>
        </table>


        <table style="width: 100%; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td style="width: 100%; font-size: 11px; background-color: black; color:white; height:15px;"><b>DATA RESPONDEN</b> (Berilah tanda silang (x) sesuai jawaban Saudara pada kolom yang tersedia)</td>
            </tr>
        </table>

        <table style="width: 100%; border: 2px #000 solid;" cellpadding="4">
            <tr style="font-size: 11px;">
                <td style="width: 30%; height:15px;">Jenis Pelayanan yang diterima</td>
                <td style="width: 70%; ">' . $get_layanan .'</td>
            </tr>'
            . $get_nama . '
        </table>
        
        
        <table style="width: 100%; border: 2px #000 solid;" cellpadding="3">
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN TERHADAP UNSUR-UNSUR PERSEPSI ANTI KORUPSI</b></td>
            </tr>
            <tr>
                <td style="width: 100%; text-align:left; font-size: 11px; background-color: black; color:white;">Berilah tanda silang (x) sesuai jawaban Saudara dan berikan alasan jika jawaban Saudara negatif(Tidak atau Kurang Baik)</td>
            </tr>
        </table>' .

            $thead_tabel_unsur . $get_pertanyaan_terbuka_atas . $get_pertanyaan_unsur . $get_pertanyaan_terbuka_bawah .   $get_pertanyaan_harapan . $get_pertanyaan_kualitatif . '

        <table style="width: 100%; border: 2px #000 solid;" cellpadding="5">' . $is_saran . '
            <tr>
                <td style="width: 100%; text-align:center; font-size: 11px;">Terima kasih atas kesediaan Saudara mengisi kuesioner tersebut di atas.<br/>Saran dan penilaian Saudara memberikan konstribusi yang sangat berarti bagi instansi ini.</td>
            </tr>
        </table>
    ';
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab13, false, false);














        $section->addPageBreak();


        $this->db->select('COUNT(id) AS id');
        $this->db->from('survey_' . $table_identity);
        $this->db->where("is_submit = 1");
        $jumlah_kuisioner = $this->db->get()->row()->id;

        if ($manage_survey->id_sampling == 0) {
            $texthtmlbab21 = '<table>
            <tr>
                <td width="5%"><b>A.</b></td>
                <td width="95%"><b>Kriteria Responden</b></td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify" style="text-indent: 50pt; ">Responden adalah seluruh pihak yang pernah mendapatkan pelayanan di unit ini.<!--Responden adalah masyarakat yang telah mendapatkan pelayanan penanganan perkara di Mahkamah Konstitusi yaitu para pihak berperkara di Mahkamah Konstitusi. Hasil survei yang telah dilakukan, diperoleh responden sebanyak '.$jumlah_kuisioner.' responden.--></p></td>
            </tr>
            </table>';
        }else{
            $texthtmlbab21 = '<table>
            <tr>
                <td width="5%"><b>A.</b></td>
                <td width="95%"><b>Kriteria Responden</b></td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%"><p align="justify" style="text-indent: 50pt; ">Responden adalah seluruh pihak yang pernah mendapatkan pelayanan di unit ini. Jumlah responden yang digunakan dalam Survei Persepsi Anti Korupsi (SPAK) ini dihitung menggunakan rumus Krejcie sebagai berikut:</p>
                <b>Rumus Krejcie:</b>
                </td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%">
                    <table width="50%" align="center" style="border: 1px #000 solid;">
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S = {λ². N. P. Q}/ {d² (N-1) + λ². P. Q</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="5%">&nbsp;</td>
                <td width="95%">&nbsp;</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%">
                    <table>
                        <tr>
                            <td width="25%">Keterangan</td>
                            <td width="75%">
                            <p>S = Jumlah sampel</p>
                            <p>λ² = Lamda (faktor pengali) dengan dk = 1, (taraf kesalahan yang digunakan 5%, sehingga nilai lamba 3,841)</p>
                            <p>N = Populasi sebanyak '.$manage_survey->jumlah_populasi.'</p>
                            <p>P = Q = 0,5 (populasi menyebar normal)</p>
                            <p>d = 0,05</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="95%">Sehingga dari perhitungan di atas, jumlah responden minimal yang harus diperoleh adalah '.$manage_survey->jumlah_sampling.' responden.</td>
            </tr>
            </table>';
        }

        $texthtmlbab22 = '<table>
        <tr>
            <td width="5%">&nbsp;</td>
            <td width="95%">&nbsp;</td>
        </tr>
        <tr>
            <td width="5%"><b>B.</b></td>
            <td width="95%"><b>Metode Pencacahan</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Pengumpulan data dilakukan dengan menggunakan metode survei elektronik melalui sistem broadcast data. Broadcast data dilakukan melalui WhatsApp, SMS, Email, dan scan barcode.</p></td>
        </tr>
        <tr>
            <td width="5%">&nbsp;</td>
            <td width="95%">&nbsp;</td>
        </tr>
        <tr>
            <td width="5%"><b>C.</b></td>
            <td width="95%"><b>Metode Pengolahan Data dan Analisis</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Metode yang digunakan dalam pengolahan data dan analisis Survei Persepsi Anti Korupsi (SPAK) ini menggunakan aplikasi survei yang akan menghasilkan analisis deskriptif kuantitatif.</p></td>
        </tr>
        </table>';

        
        $section->addText('BAB II', array('bold' => true, 'size' => 16), $paragraphStyleName);
        //$section->addTextBreak();
        $section->addText('METODOLOGI SURVEI', array('bold' => true, 'size' => 16), $paragraphStyleName);
        $section->addTextBreak();
        
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab21, false, false);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab22, false, false);


        $section->addPageBreak();

        // HALAMAN EXECUTIVE SUMMARY
        // $section->addText('Executive Summary', array('bold' => true, 'size' => 18), $paragraphStyleName);
        // $section->addTextBreak();
        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $data_survei['executive_summary'], false, false);
        // $section->addPageBreak();

        // HALAMAN HASIL SURVEI KEPUASAN MASYARAKAT

        

        // HALAMAN Karakteristik Responden
        // $section->addText('Karakteristik Responden', array('bold' => true, 'size' => 18), $paragraphStyleName);
        // $section->addTextBreak();
        $section->addText('BAB III', array('bold' => true, 'size' => 16), $paragraphStyleName);
        //$section->addTextBreak();
        $section->addText('PENGOLAHAN SURVEI', array('bold' => true, 'size' => 16), $paragraphStyleName);
        $section->addTextBreak();

        $texthtmlbab3 = 'A.	Analisis Hasil Survei
        1.	Profil Responden
        Berikut merupakan karakterstik responden yang diperoleh dari Survei Persepsi Anti Korupsi (SPAK):';
        $texthtmlbab3 = '<table>
        <tr>
            <td width="5%"><b>A.</b></td>
            <td width="95%"><b>Analisis Hasil Survei</b></td>
        </tr>
        <tr>
            <td width="5%"><b>1.</b></td>
            <td width="95%"><b>Jenis Layanan</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%">Berikut merupakan jenis layanan yang diperoleh dari Survei Persepsi Anti Korupsi (SPAK):</td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab3, false, false);

        $fancyTableStyleName = 'Tabel Jenis Layanan SPAK';
        $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

        $table->addRow();
        $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
        $table->addCell(5000, $fancyTableCellStyle)->addText('Jenis Pelayanan', $fancyTableFontStyle);
        $table->addCell(1000, $fancyTableCellStyle)->addText('Jumlah', $fancyTableFontStyle);
        $table->addCell(1000, $fancyTableCellStyle)->addText('Persentase Responden', $fancyTableFontStyle);


        
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

            $table->addRow();
            $table->addCell(150)->addText($no++, $cellTableFontStyle);
            $table->addCell(5000)->addText($row->nama_layanan, $cellTableFontStyle);
            $table->addCell(1000)->addText($row->perolehan, $cellTableFontStyle);
            $table->addCell(1000)->addText(ROUND(($row->perolehan/$row->total_survei) * 100, 2).'%', $cellTableFontStyle);
        }

        $table->addRow();
        $table->addCell(150)->addText('', $cellTableFontStyle);
        $table->addCell(5000)->addText('Total', array('bold' => true), $cellTableFontStyle);
        $table->addCell(1000)->addText($total_perolehan, array('bold' => true), $cellTableFontStyle);
        $table->addCell(1000)->addText(ROUND($total_persentase).'%', array('bold' => true), $cellTableFontStyle);

        $section->addTextBreak();
        
        $texthtmlbab31 = '<table>
        <tr>
            <td width="5%"><b>2.</b></td>
            <td width="95%"><b>Profil Responden</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%">Berikut merupakan karakterstik responden yang diperoleh dari Survei Persepsi Anti Korupsi (SPAK):</td>
        </tr>
        </table>';
        //\PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab31, false, false);


        // Karakteristik Responden
        $profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity WHERE jenis_isian = 111");

        $arr_profil_responden = [];
        foreach ($profil_responden->result() as $get) {
            $arr_profil_responden[] = $get->nama_profil_responden;
        }
        $arr_profil_responden = implode(", ", $arr_profil_responden);

        // $section->addText('Responden merupakan pihak yang dipakai sebagai sampel dalam sebuah penelitian. Karakteristik responden akan mempengaruhi teknik sampling yang digunakan dalam penelitian. Responden dipilih secara acak yang ditentukan sesuai dengan karakteristik di ' . $data_survei['nama_organisasi'] . ' dan diambil jumlah minimal responden yang telah ditetapkan. Peran responden ialah memberikan tanggapan dan informasi terkait data yang dibutuhkan oleh peneliti, serta memberikan masukan kepada peneliti, baik secara langsung maupun tidak langsung.', array('name' => 'Arial', 'size' => 11), array('keepNext' => true, 'indentation' => array('firstLine' => 500), 'align' => 'both'));
        // $section->addText('Secara umum responden dibagi dalam karakteristik ' . $arr_profil_responden . '. Secara rinci dapat dilihat pada pie chart dan tabel dibawah ini.', array('name' => 'Arial', 'size' => 11), array('keepNext' => true, 'indentation' => array('firstLine' => 500), 'align' => 'both'));

        $section->addTextBreak();

        if ($profil_responden->num_rows() > 0) {
            $no_p = 1;
            $no_p1 = 1;
            foreach ($profil_responden->result() as $get) {

                $kategori_profil_responden = $this->db->query("SELECT *, (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE kategori_profil_responden_$table_identity.id = responden_$table_identity.$get->nama_alias && is_submit = 1) AS perolehan, ROUND((((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE kategori_profil_responden_$table_identity.id = responden_$table_identity.$get->nama_alias && is_submit = 1) / (SELECT COUNT(*) FROM survey_$table_identity WHERE is_submit = 1)) * 100), 2) AS persentase
                FROM kategori_profil_responden_$table_identity
                WHERE id_profil_responden = $get->id");

                $jumlah = [];
                $nama_kelompok = [];
                $jumlah_persentase = [];
                foreach ($kategori_profil_responden->result() as $kpr) {
                    $jumlah[] = $kpr->perolehan;
                    $nama_kelompok[] = str_replace(' ', '+', $kpr->nama_kategori_profil_responden) . '+=+' . $kpr->persentase . '%';  //'%27' . str_replace(' ', '+', $kpr->nama_kategori_profil_responden) . '%27';
                    //$nama_kelompok[] = "'" . str_replace(' ', '+', $kpr->nama_kategori_profil_responden) . "+=+" . $kpr->persentase . "%25'";
                    $jumlah_persentase[] = $kpr->persentase;
                }
                $total_rekap_responden = implode(",", $jumlah);
                $kelompok_rekap_responden = implode("|", $nama_kelompok);
                $persentase_kelompok = implode(",", $jumlah_persentase);

                $kategori_profil_responden2 = $this->db->query("SELECT *, (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE kategori_profil_responden_$table_identity.id = responden_$table_identity.$get->nama_alias && is_submit = 1) AS perolehan, ROUND((((SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE kategori_profil_responden_$table_identity.id = responden_$table_identity.$get->nama_alias && is_submit = 1) / (SELECT COUNT(*) FROM survey_$table_identity WHERE is_submit = 1)) * 100), 2) AS persentase
                FROM kategori_profil_responden_$table_identity
                WHERE id_profil_responden = $get->id ORDER BY id DESC");

                $nama_kelompok2 = [];
                foreach ($kategori_profil_responden2->result() as $kpr) {
                    $nama_kelompok2[] = str_replace(' ', '+', $kpr->nama_kategori_profil_responden) . '+=+' . $kpr->persentase . '%';  //'%27' . str_replace(' ', '+', $kpr->nama_kategori_profil_responden) . '%27';
                }
                $kelompok_rekap_responden2 = implode("|", $nama_kelompok2);

                // var_dump($persentase_kelompok);

                $section->addText('2.'.$no_p++.'. '.$get->nama_profil_responden, array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));

                $section->addTextBreak(1);


                // if ($kategori_profil_responden->num_rows() < 7) {
                //     $section->addImage('https://image-charts.com/chart?chd=t:' . $persentase_kelompok . '&chdlp=b&chdl=' . $kelompok_rekap_responden . '&chf=ps0-0%2Clg%2C45%2Cfc3dd6%2C0.2%2Cfc3d3d7C%2C1%7Cps0-1%2Clg%2C45%2C2b4fc4%2C0.2%2C32c9c47C%2C1%7Cps0-2%2Clg%2C45%2CEA469E%2C0.2%2C03A9F47C%2C1%7Cps0-3%2Clg%2C45%2Cfacc00%2C0.2%2Cffca477C%2C1%7Cps0-4%2Clg%2C45%2Cf2fa05%2C0.2%2C2fa36f7C%2C1%7Cps0-4%2Clg%2C45%2C098d9c%2C0.2%2C840ccf7C%2C1&chs=500x200&cht=pc&chxt=x%2Cy', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
                // } else {
                //     $section->addImage('https://image-charts.com/chart?chbh=20&chbr=10&chd=t:' . $total_rekap_responden . '&chs=600x300&cht=bhs&chxr=1,0,100&chxt=y,x&chxl=0%3A|' . $kelompok_rekap_responden . '&chco=57a8e6', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
                // }
                       $section->addImage('https://image-charts.com/chart?chbh=20&chbr=10&chd=t:' . $persentase_kelompok . '&chs=600x300&cht=bhs&chxr=1,0,100&chxt=y,x&chxl=0%3A|' . $kelompok_rekap_responden2 . '&chco=ff9f40', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));


                // $section->addImage("https://quickchart.io/chart?width=500&height=500&bkg=white&c={%27type%27:%27outlabeledPie%27,%27data%27:{%27labels%27:[" . $kelompok_rekap_responden ."],%27datasets%27:[{%27backgroundColor%27:[%27rgb(255,55,132)%27,%27rgb(54,%20162,%20235)%27,%27rgb(75,192,192)%27,%27rgb(255,221,0)%27,%27rgb(247,120,37)%27,%27rgb(153,102,255)%27],%27data%27:[" . $total_rekap_responden . "]}]},%27options%27:{%27plugins%27:{%27legend%27:false,%27outlabels%27:{%27color%27:%27white%27,%27stretch%27:35,%27font%27:{%27resizable%27:true,%27minSize%27:12,%27maxSize%27:18}}}}}", array('width' => 300, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                $section->addText('Gambar '.$no_p1++.'. Persentase Responden Berdasarkan '.$get->nama_profil_responden, array('size' => 11), $paragraphStyleName);
                //$section->addTextBreak();

                $fancyTableStyleName = 'Profil Responden ' . $no_p;
                $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                $fancyTableCellStyle = array('valign' => 'center');
                $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                $table = $section->addTable($fancyTableStyleName);
                $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                // $table->addRow();
                // $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                // $table->addCell(4000, $fancyTableCellStyle)->addText('Kelompok', $fancyTableFontStyle);
                // $table->addCell(1000, $fancyTableCellStyle)->addText('Jumlah', $fancyTableFontStyle);
                // $table->addCell(1000, $fancyTableCellStyle)->addText('Persentase', $fancyTableFontStyle);


                // $no_pr = 1;
                // foreach ($kategori_profil_responden->result() as $key) {
                //     if ($key->id_profil_responden == $get->id) {

                //         $table->addRow();
                //         $table->addCell(150)->addText($no_pr++, $cellTableFontStyle);
                //         $table->addCell(4000)->addText($key->nama_kategori_profil_responden, $cellTableFontStyle);
                //         $table->addCell(1000)->addText($key->perolehan, $cellTableFontStyle);
                //         $table->addCell(1000)->addText(str_replace('.', ',', $key->persentase) . ' %', $cellTableFontStyle);
                //     }
                // }

                $section->addTextBreak(1);


                $no_pl = 1;
                if($get->is_lainnya == 1) {
                    $lainnya = $get->nama_alias . '_lainnya';
                    $cek_lainnya = $this->db->query("SELECT *
                    FROM responden_$table_identity
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                    WHERE is_submit = 1 && responden_$table_identity.$lainnya != ''");

                    if($cek_lainnya->num_rows() > 0){

                        $section->addText('Tabel '.$no_pl++.'. Persentase Responden pada '.$get->nama_profil_responden . ' Lainnya', array('size' => 11), $paragraphStyleName);

                        $fancyTableStyleName = 'Profil Responden Lainnya ' . $no_p;
                        $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                        $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                        $fancyTableCellStyle = array('valign' => 'center');
                        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                        $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                        $table = $section->addTable($fancyTableStyleName);
                        $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                        $table->addRow();
                        $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                        $table->addCell(5000, $fancyTableCellStyle)->addText($get->nama_profil_responden. ' Lainnya', $fancyTableFontStyle);

                        $no_pr2 = 1;
                        $profil_lainnya = $this->db->query("SELECT *
                                        FROM responden_$table_identity
                                        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                                        WHERE is_submit = 1");

                        foreach ($profil_lainnya->result() as $value) {
                            if($value->$lainnya != ''){
                                $table->addRow();
                                $table->addCell(150)->addText($no_pr2++, $cellTableFontStyle);
                                $table->addCell(5000)->addText($value->$lainnya, $cellTableFontStyle);
                            }
                        }
                    }

                }

                $section->addTextBreak(1);


            }
        }
        
        //$section->addPageBreak();





        // $section->addText('Hasil Survei Kepuasan Masyarakat', array('bold' => true, 'size' => 18), $paragraphStyleName);
        // $section->addTextBreak();
        // $section->addText('Hasil Survei Kepuasan Masyarakat ' . $data_survei['nama_organisasi'] . ' Periode ' . $data_survei['survei_dimulai'] . ' s/d ' . $data_survei['survei_selesai'] . ' dengan total ' . $total_survey . ' responden seperti pada tabel 1 menghasilkan Indeks Kepuasan Masyarakat (IKM) sebesar ' . ROUND($nilai_tertimbang, 2) . '. Dengan demikian pelayanan publik pada ' . $data_survei['nama_organisasi'] . ' berada pada kategori ' . $index . ' atau dengan nilai konversi IKM sebesar ' . ROUND($nilai_skm, 2) . '.', array('name' => 'Arial', 'size' => 11), array('keepNext' => true, 'indentation' => array('firstLine' => 500), 'align' => 'both'));
        // $section->addTextBreak(1);


        $texthtmlbab32 = '2.	Nilai Indeks Persepsi Anti Korupsi
        Hasil Survei Persepsi Anti Korupsi (SPAK) '.$data_survei['nama_organisasi'].' mendapatkan nilai Indeks Persepsi Anti Korupsi sebesar ' . ROUND($nilai_skm, 3) . ', dengan predikat ' . $index . '. Nilai Indeks Persepsi Anti Korupsi tersebut didapat dari nilai rata-rata seluruh unsur pada tabel berikut.';
        $texthtmlbab32 = '<table>
        <tr>
            <td width="5%"><b>2.</b></td>
            <td width="95%"><b>Nilai Indeks Persepsi Anti Korupsi</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Hasil Survei Persepsi Anti Korupsi (SPAK) '.$data_survei['nama_organisasi'].' mendapatkan nilai Indeks Persepsi Anti Korupsi sebesar <b>' . ROUND($nilai_tertimbang, 3) . '</b>, dengan predikat <b>' . $index . '</b>. Nilai Indeks Persepsi Anti Korupsi tersebut didapat dari nilai rata-rata seluruh unsur pada tabel berikut.</p></td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab32, false, false);


	
  







        /*$section->addText('Tabel '.($no_pl).'. Nilai IPAK', array('size' => 11), $paragraphStyleName);

        $fancyTableStyleName = 'Unsur Survei';
        $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

        $table->addRow();
        $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
        $table->addCell(4000, $fancyTableCellStyle)->addText('Unit Pelayanan', $fancyTableFontStyle);
        $table->addCell(1200, $fancyTableCellStyle)->addText('Nilai IPAK', $fancyTableFontStyle);
        $table->addCell(1200, $fancyTableCellStyle)->addText('Nilai Konversi', $fancyTableFontStyle);
        $table->addCell(1200, $fancyTableCellStyle)->addText('Predikat', $fancyTableFontStyle);
        $table->addRow();
        $table->addCell(150)->addText('1.', $cellTableFontStyle);
        $table->addCell(4000)->addText($data_survei['nama_organisasi'], $cellTableFontStyle);
        $table->addCell(1200)->addText(str_replace('.', ',', ROUND($nilai_tertimbang, 3)), $cellTableFontStyle);
        $table->addCell(1200)->addText(str_replace('.', ',', ROUND($nilai_skm, 2)), $cellTableFontStyle);
        $table->addCell(1200)->addText($mutu_pelayanan, $cellTableFontStyle);

        $section->addTextBreak(1);*/

        //$section->addText('Hasil SKM tersebut di atas, terdiri dari 16 unsur pelayanan, sebagaimana tersebut dalam tabel 2 di bawah ini.', array('name' => 'Arial', 'size' => 11), array('keepNext' => true, 'indentation' => array('firstLine' => 500), 'align' => 'both'));
        //$section->addTextBreak(1);
        

        $section->addText('Tabel '.($no_pl).'. Nilai Unsur '.$data_survei['nama_organisasi'], array('size' => 11), $paragraphStyleName);
       

        $this->db->select("IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub, ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden))) AS nilai_per_unsur, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nomor_unsur, (SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nama_unsur_pelayanan");
        $this->db->from('jawaban_pertanyaan_unsur_' . $table_identity);
        $this->db->join("pertanyaan_unsur_pelayanan_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id");
        $this->db->join("unsur_pelayanan_$table_identity", "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id");
        $this->db->join("survey_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden");
        $this->db->where("survey_$table_identity.is_submit = 1");
        $this->db->group_by('id_sub');
        $nilai_per_unsur = $this->db->get();
        // var_dump($nilai_per_unsur->result());


        $grafik_nama_per_unsur = $this->db->query("SELECT GROUP_CONCAT(nomor_unsur ORDER BY unsur_pelayanan_$table_identity.id DESC SEPARATOR '|') AS nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_parent = 0")->row()->nomor_unsur;

        // $nama_per_unsur = [];
        $bobot_per_unsur = [];
        foreach ($nilai_per_unsur->result() as $value) {
            // $nama_per_unsur[] = $value->nomor_unsur; //. '. ' . $value->nama_unsur_pelayanan;
            $bobot_per_unsur[] = $value->nilai_per_unsur;
        }
        // $grafik_nama_per_unsur = implode("|", $nama_per_unsur);
        $grafik_bobot_per_unsur = implode(",", $bobot_per_unsur);


        $fancyTableStyleName = 'Nilai Per Unsur Pelayanan';
        $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

        $table->addRow();
        $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
        $table->addCell(5000, $fancyTableCellStyle)->addText('Unsur', $fancyTableFontStyle);
        $table->addCell(1200, $fancyTableCellStyle)->addText('Indeks', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Kategori', $fancyTableFontStyle);

        $no = 1;
        foreach ($nilai_per_unsur->result() as $row) {

            $nilai_unsur = ROUND($row->nilai_per_unsur * $skala_likert, 10);
            foreach ($definisi_skala->result() as $obj) {
                if ($nilai_unsur <= $obj->range_bawah && $nilai_unsur >= $obj->range_atas) {
                    $ktg = $obj->kategori;
                }
            }
            if ($nilai_unsur <= 0) {
                $ktg = 'NULL';
            }

            // if (($row->nilai_per_unsur * 25) <= 100 &&  ($row->nilai_per_unsur * 25) >= 88.31) {
            //     $ktg = 'Sangat Baik';
            // } elseif (($row->nilai_per_unsur * 25) <= 88.40 &&  ($row->nilai_per_unsur * 25) >= 76.61) {
            //     $ktg = 'Baik';
            // } elseif (($row->nilai_per_unsur * 25) <= 76.60 &&  ($row->nilai_per_unsur * 25) >= 65) {
            //     $ktg = 'Kurang Baik';
            // } elseif (($row->nilai_per_unsur * 25) <= 64.99 &&  ($row->nilai_per_unsur * 25) >= 25) {
            //     $ktg = 'Tidak Baik';
            // } else {
            //     $ktg = 'NULL';
            // }


            $table->addRow();
            $table->addCell(150)->addText($no++, $cellTableFontStyle);
            $table->addCell(5000)->addText($row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan, $cellTableFontStyle);
            $table->addCell(1200)->addText(str_replace('.', ',', ROUND($row->nilai_per_unsur, 3)), $cellTableFontStyle);
            $table->addCell(2000)->addText($ktg, $cellTableFontStyle);
        }

        $table->addRow();
        $table->addCell(150)->addText('', $cellTableFontStyle);
        $table->addCell(5000)->addText('Nilai Indeks Persepsi Anti Korupsi', array('bold' => true), $cellTableFontStyle);
        $table->addCell(1200)->addText(str_replace('.', ',', ROUND($nilai_tertimbang, 3)), array('bold' => true), $cellTableFontStyle);
        $table->addCell(2000)->addText($index, array('bold' => true), $cellTableFontStyle);

        $table->addRow();
        $table->addCell(150)->addText('', $cellTableFontStyle);
        $table->addCell(5000)->addText('Nilai Konversi', array('bold' => true), $cellTableFontStyle);
        $table->addCell(1200)->addText(str_replace('.', ',', ROUND($nilai_skm, 2)), array('bold' => true), $cellTableFontStyle);
        $table->addCell(2000)->addText($index, array('bold' => true), $cellTableFontStyle);




        $section->addTextBreak(1);

        $texthtmlbab33 = 'Nilai unsur Survei Persepsi Anti Korupsi (SPAK) pada '.$data_survei['nama_organisasi'].' apabila diurutkan berdasarkan nilai tertinggi sampai terendah dapat dilihat pada gambar di bawah ini.';
        $texthtmlbab33 = '<table>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Nilai unsur Survei Persepsi Anti Korupsi (SPAK) pada '.$data_survei['nama_organisasi'].' dapat dilihat pada gambar di bawah ini.</p></td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab33, false, false);

        $section->addImage('https://image-charts.com/chart?chbh=20&chbr=10&chd=t:' . $grafik_bobot_per_unsur . '&chs=600x300&cht=bhs&chxr=1,0,5&chxt=y,x&chxl=0%3A|' . $grafik_nama_per_unsur . '&chco=ff9f40', array('width' => 450, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        $section->addText('Gambar '.$no_p.'. Grafik Unsur '.$data_survei['nama_organisasi'], array('size' => 11), $paragraphStyleName);

        $section->addTextBreak(1);


        $texthtmlbab34 = '3.	Pembahasan Unsur
        Unsur yang dipakai dalam Survei Persepsi Anti Korupsi (SPAK) dapat dijadikan sebagai acuan untuk mengetahui predikat anti korupsi pada '.$data_survei['nama_organisasi'].'. Berikut adalah pembahasan mengenai jumlah persentase persepsi responden di setiap unsur:';
        $texthtmlbab34 = '<table>
        <tr>
            <td width="5%"><b>3.</b></td>
            <td width="95%"><b>Pembahasan Unsur</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Unsur yang dipakai dalam Survei Persepsi Anti Korupsi (SPAK) dapat dijadikan sebagai acuan untuk mengetahui predikat anti korupsi pada '.$data_survei['nama_organisasi'].'. Berikut adalah pembahasan mengenai jumlah persentase persepsi responden di setiap unsur:</p></td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab34, false, false);
        

        // $section->addText('Tabel 3. Ringkasan Hasil Survei Kepuasan Masyarakat', array('size' => 11), $paragraphStyleName);

        // $fancyTableStyleName = 'SKM Unsur Tertinggi Terendah';
        // $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        // $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
        // $fancyTableCellStyle = array('valign' => 'center');
        // $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        // $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
        // $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        // $table = $section->addTable($fancyTableStyleName);
        // $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

        // $table->addRow();
        // $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
        // $table->addCell(3000, $fancyTableCellStyle)->addText('Kesimpulan', $fancyTableFontStyle);
        // $table->addCell(5000, $fancyTableCellStyle)->addText('Keterangan', $fancyTableFontStyle);
        // $table->addRow();
        // $table->addCell(150)->addText('1', $cellTableFontStyle);
        // $table->addCell(3000)->addText('Nilai IKM', $cellTableFontStyle);
        // $table->addCell(5000)->addText(str_replace('.', ',', ROUND($nilai_tertimbang, 3)), $cellTableFontStyle);
        // $table->addRow();
        // $table->addCell(150)->addText('2', $cellTableFontStyle);
        // $table->addCell(3000)->addText('Nilai IKM Konversi', $cellTableFontStyle);
        // $table->addCell(5000)->addText(str_replace('.', ',', ROUND($nilai_skm, 2)), $cellTableFontStyle);
        // $table->addRow();
        // $table->addCell(150)->addText('3', $cellTableFontStyle);
        // $table->addCell(3000)->addText('Kategori', $cellTableFontStyle);
        // $table->addCell(5000)->addText($index, $cellTableFontStyle);
        // $table->addRow();
        // $table->addCell(150)->addText('4', $cellTableFontStyle);
        // $table->addCell(3000)->addText('Unsur Tertinggi', $cellTableFontStyle);
        // $table->addCell(5000)->addText($unsur_tertinggi, $cellTableFontStyle);
        // $table->addRow();
        // $table->addCell(150)->addText('5', $cellTableFontStyle);
        // $table->addCell(3000)->addText('Unsur Terendah', $cellTableFontStyle);
        // $table->addCell(5000)->addText($unsur_terendah, $cellTableFontStyle);

        //$section->addPageBreak();
        $section->addTextBreak();



        // HALAMAN CHART UNSUR SKM
        // $section->addText('Chart Unsur SKM', array('bold' => true, 'size' => 18), $paragraphStyleName);
        // $section->addTextBreak();

        $this->db->select("*, unsur_pelayanan_$table_identity.id AS id_unsur_pelayanan");
        $this->db->from("unsur_pelayanan_$table_identity");
        $this->db->where(['id_parent' => 0]);
        $unsur_pelayanan = $this->db->get();
        $no_up = 1;
        $no_p2 = $no_p1;
        $no_p3 = $no_pl+1;

        foreach ($unsur_pelayanan->result() as $value) {

            $section->addText('3.'.$no_up++.'.  '.$value->nomor_unsur . '. ' . $value->nama_unsur_pelayanan, array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));

            $sub_unsur = $this->db->get_where("unsur_pelayanan_$table_identity", ['id_parent' => $value->id_unsur_pelayanan]);

            //JIKA MEMPUNYAI TURUNAN
            if ($sub_unsur->num_rows() > 0) {

                $this->db->select("(SELECT id FROM pertanyaan_unsur_pelayanan_$table_identity WHERE pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id) AS id_pertanyaan_unsur");
                $this->db->from("unsur_pelayanan_$table_identity");
                $this->db->where('id_parent', $value->id_unsur_pelayanan);
                $this->db->order_by('id', 'desc');
                $get_opsi = $this->db->get()->row();

                $this->db->select('nama_kategori_unsur_pelayanan');
                $this->db->from("kategori_unsur_pelayanan_$table_identity");
                $this->db->where('id_pertanyaan_unsur', $get_opsi->id_pertanyaan_unsur);
                $get_data_opsi = $this->db->get()->result_array();

                $rel_data = $this->db->query(" SELECT *, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan,
                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id AND skor_jawaban = 1) AS jumlah_1,
                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id AND skor_jawaban = 2) AS jumlah_2,
                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id AND skor_jawaban = 3) AS jumlah_3,
                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id AND skor_jawaban = 4) AS jumlah_4,

                    ( SELECT ROUND(COUNT(skor_jawaban) / ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id) * 100, 2) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id AND
                    skor_jawaban = 1 ) AS persentase_1,
                    ( SELECT ROUND(COUNT(skor_jawaban) / ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 &&
                    id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id) * 100, 2) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id AND
                    skor_jawaban = 2 ) AS persentase_2,
                    ( SELECT ROUND(COUNT(skor_jawaban) / ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 &&
                    id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id) * 100, 2) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id AND
                    skor_jawaban = 3 ) AS persentase_3,
                    ( SELECT ROUND(COUNT(skor_jawaban) / ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 &&
                    id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id) * 100, 2) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id AND
                    skor_jawaban = 4 ) AS persentase_4,

                    ( SELECT ROUND(COUNT(skor_jawaban) / ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 &&
                    id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id) * 100, 2) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id AND
                    skor_jawaban = 5 ) AS persentase_5,

                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id) AS jumlah_pengisi,
                    ( SELECT AVG(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
                    JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
                    WHERE is_submit = 1 && id_pertanyaan_unsur =
                    pertanyaan_unsur_pelayanan_$table_identity.id) AS rata_rata

                    FROM unsur_pelayanan_$table_identity
                    JOIN pertanyaan_unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan =
                    unsur_pelayanan_$table_identity.id
                    WHERE unsur_pelayanan_$table_identity.id_parent = $value->id_unsur_pelayanan
                    ");



                $ij = 0;
                $jumlah_persentase_1 = 0;
                $jumlah_persentase_2 = 0;
                $jumlah_persentase_3 = 0;
                $jumlah_persentase_4 = 0;
                $jumlah_persentase_5 = 0;
                foreach ($rel_data->result() as $elements) {
                    $jumlah_persentase_1 += $elements->persentase_1;
                    $jumlah_persentase_2 += $elements->persentase_2;
                    $jumlah_persentase_3 += $elements->persentase_3;
                    $jumlah_persentase_4 += $elements->persentase_4;
                    $jumlah_persentase_5 += $elements->persentase_5;
                    $ij++;

                    $f_persentase_1 = round(($jumlah_persentase_1 / $ij), 2);
                    $f_persentase_2 = round(($jumlah_persentase_2 / $ij), 2);
                    $f_persentase_3 = round(($jumlah_persentase_3 / $ij), 2);
                    $f_persentase_4 = round(($jumlah_persentase_4 / $ij), 2);
                    $f_persentase_5 = round(($jumlah_persentase_5 / $ij), 2);
                }

                $get_data_opsi_1 = str_replace(' ', '%20', $get_data_opsi[0]['nama_kategori_unsur_pelayanan']);
                $get_data_opsi_2 = str_replace(' ', '%20', $get_data_opsi[1]['nama_kategori_unsur_pelayanan']);
                $get_data_opsi_3 = str_replace(' ', '%20', $get_data_opsi[2]['nama_kategori_unsur_pelayanan']);
                $get_data_opsi_4 = str_replace(' ', '%20', $get_data_opsi[3]['nama_kategori_unsur_pelayanan']);


                if ($manage_survey->skala_likert == 5) {
                    $get_data_opsi_5 = str_replace(' ', '%20', $get_data_opsi[4]['nama_kategori_unsur_pelayanan']);

                    $series = [$f_persentase_1, $f_persentase_2, $f_persentase_3, $f_persentase_4, $f_persentase_5];
                    // $labels = [$get_data_opsi_1 . '%20=%20' . $f_persentase_1 . '%', $get_data_opsi_2 . '%20=%20' . $f_persentase_2 . '%',  $get_data_opsi_3 . '%20=%20' . $f_persentase_3 . '%', $get_data_opsi_4 . '%20=%20' . $f_persentase_4 . '%', $get_data_opsi_5 . '%20=%20' . $f_persentase_5 . '%'];
                    $labels = [$get_data_opsi_5 . '%20=%20' . $f_persentase_5 . '%', $get_data_opsi_4 . '%20=%20' . $f_persentase_4 . '%', $get_data_opsi_3 . '%20=%20' . $f_persentase_3 . '%',  $get_data_opsi_2 . '%20=%20' . $f_persentase_2 . '%', $get_data_opsi_1 . '%20=%20' . $f_persentase_1 . '%'];
                    $identitas = [$f_persentase_1 . '%', $f_persentase_2 . '%', $f_persentase_3 . '%', $f_persentase_4 . '%', $f_persentase_5 . '%'];
                } else {

                    $series = [$f_persentase_1, $f_persentase_2, $f_persentase_3, $f_persentase_4];
                    // $labels = [$get_data_opsi_1 . '%20=%20' . $f_persentase_1 . '%', $get_data_opsi_2 . '%20=%20' . $f_persentase_2 . '%',  $get_data_opsi_3 . '%20=%20' . $f_persentase_3 . '%', $get_data_opsi_4 . '%20=%20' . $f_persentase_4 . '%'];
                    $labels = [$get_data_opsi_4 . '%20=%20' . $f_persentase_4 . '%', $get_data_opsi_3 . '%20=%20' . $f_persentase_3 . '%',  $get_data_opsi_2 . '%20=%20' . $f_persentase_2 . '%', $get_data_opsi_1 . '%20=%20' . $f_persentase_1 . '%'];
                    $identitas = [$f_persentase_1 . '%', $f_persentase_2 . '%', $f_persentase_3 . '%', $f_persentase_4 . '%'];
                }



                $get_series = implode(",", $series);
                $get_nama_opsi = implode("|", $labels);
                $get_identitas = implode("|", $identitas);
                // var_dump($get_series);


                // JIKA UNSUR MEMILIKI TURUNAN
                // $section->addImage('https://image-charts.com/chart?chd=t:' . $get_series . '&chdlp=b&chdl=' . $get_nama_opsi . '&chf=ps0-0%2Clg%2C45%2Cfc3dd6%2C0.2%2Cfc3d3d7C%2C1%7Cps0-1%2Clg%2C45%2C2b4fc4%2C0.2%2C32c9c47C%2C1%7Cps0-2%2Clg%2C45%2CEA469E%2C0.2%2C03A9F47C%2C1%7Cps0-3%2Clg%2C45%2Cfacc00%2C0.2%2Cffca477C%2C1%7Cps0-4%2Clg%2C45%2Cf2fa05%2C0.2%2C2fa36f7C%2C1%7Cps0-4%2Clg%2C45%2C098d9c%2C0.2%2C840ccf7C%2C1&chl=' . $get_identitas . '&chs=500x200&cht=pc&chxt=x%2Cy', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                // ok$section->addImage('https://image-charts.com/chart?chd=t:' . $get_series . '&chdlp=b&chdl=' . $get_nama_opsi . '&chf=ps0-0%2Clg%2C45%2Cfc3dd6%2C0.2%2Cfc3d3d7C%2C1%7Cps0-1%2Clg%2C45%2C2b4fc4%2C0.2%2C32c9c47C%2C1%7Cps0-2%2Clg%2C45%2CEA469E%2C0.2%2C03A9F47C%2C1%7Cps0-3%2Clg%2C45%2Cfacc00%2C0.2%2Cffca477C%2C1%7Cps0-4%2Clg%2C45%2Cf2fa05%2C0.2%2C2fa36f7C%2C1%7Cps0-4%2Clg%2C45%2C098d9c%2C0.2%2C840ccf7C%2C1&chs=500x200&cht=pc&chxt=x%2Cy', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                $total_rekap_responden = implode(",", $series);
                $kelompok_rekap_responden = implode("|", $labels);
                $section->addImage('https://image-charts.com/chart?chbh=20&chbr=10&chd=t:' . $total_rekap_responden . '&chs=600x300&cht=bhs&chxr=1,0,100&chxt=y,x&chxl=0%3A|' . $kelompok_rekap_responden . '&chco=ff9f40', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                $section->addText('Gambar '.$no_p2++.'. Grafik Unsur '.$value->nama_unsur_pelayanan, array('size' => 11), $paragraphStyleName);

                $section->addTextBreak(1);

                $fancyTableStyleName = 'Chart Unsur';
                $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 100, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                $fancyTableCellStyle = array('valign' => 'center');
                $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                $table = $section->addTable($fancyTableStyleName);
                $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                $table->addRow();
                $table->addCell(2000, $fancyTableCellStyle)->addText('Unsur', $fancyTableFontStyle);
                $table->addCell(800, $fancyTableCellStyle)->addText($get_data_opsi[0]['nama_kategori_unsur_pelayanan'], $fancyTableFontStyle);
                $table->addCell(800, $fancyTableCellStyle)->addText($get_data_opsi[1]['nama_kategori_unsur_pelayanan'], $fancyTableFontStyle);
                $table->addCell(800, $fancyTableCellStyle)->addText($get_data_opsi[2]['nama_kategori_unsur_pelayanan'], $fancyTableFontStyle);
                $table->addCell(800, $fancyTableCellStyle)->addText($get_data_opsi[3]['nama_kategori_unsur_pelayanan'], $fancyTableFontStyle);

                if ($manage_survey->skala_likert == 5) {
                    $table->addCell(800, $fancyTableCellStyle)->addText($get_data_opsi[4]['nama_kategori_unsur_pelayanan'], $fancyTableFontStyle);
                }

                $table->addCell(525, $fancyTableCellStyle)->addText('Indeks', $fancyTableFontStyle);
                $table->addCell(525, $fancyTableCellStyle)->addText('Predikat', $fancyTableFontStyle);


                $no = 0;
                $jum_persentase_1 = 0;
                $jum_persentase_2 = 0;
                $jum_persentase_3 = 0;
                $jum_persentase_4 = 0;
                $jum_persentase_5 = 0;
                $jum_indeks = 0;
                $nama_sub_unsur = [];

                foreach ($rel_data->result() as $elements) {

                    foreach ($definisi_skala->result() as $obj) {
                        if (($elements->rata_rata * $skala_likert) <= $obj->range_bawah && ($elements->rata_rata * $skala_likert) >= $obj->range_atas) {
                            $predikat = $obj->kategori;
                        }
                    }
                    if (($elements->rata_rata * $skala_likert) <= 0) {
                        $predikat = 'NULL';
                    }

                    $table->addRow();
                    $table->addCell(2000)->addText($elements->nama_unsur_pelayanan, $cellTableFontStyle);
                    $table->addCell(800)->addText(str_replace('.', ',', round($elements->persentase_1, 2)) . ' %', $cellTableFontStyle);
                    $table->addCell(800)->addText(str_replace('.', ',', round($elements->persentase_2, 2)) . ' %', $cellTableFontStyle);
                    $table->addCell(800)->addText(str_replace('.', ',', round($elements->persentase_3, 2)) . ' %', $cellTableFontStyle);
                    $table->addCell(800)->addText(str_replace('.', ',', round($elements->persentase_4, 2)) . ' %', $cellTableFontStyle);

                    if ($manage_survey->skala_likert == 5) {
                        $table->addCell(800)->addText(str_replace('.', ',', round($elements->persentase_5, 2)) . ' %', $cellTableFontStyle);
                    }

                    $table->addCell(525)->addText(str_replace('.', ',', round($elements->rata_rata, 2)), $cellTableFontStyle);
                    $table->addCell(525)->addText($predikat, $cellTableFontStyle);


                    $nama_sub_unsur[] = $elements->nama_unsur_pelayanan;
                    $jum_persentase_1 += $elements->persentase_1;
                    $jum_persentase_2 += $elements->persentase_2;
                    $jum_persentase_3 += $elements->persentase_3;
                    $jum_persentase_4 += $elements->persentase_4;
                    $jum_persentase_5 += $elements->persentase_5;
                    $jum_indeks += $elements->rata_rata;
                    $no++;

                    $f_indeks = round(($jum_indeks / $no), 2);


                    foreach ($definisi_skala->result() as $obj) {
                        if (($f_indeks * $skala_likert) <= $obj->range_bawah && ($f_indeks * $skala_likert) >= $obj->range_atas) {
                            $h_indeks = $obj->kategori;
                        }
                    }
                    if (($f_indeks * $skala_likert) <= 0) {
                        $h_indeks = 'NULL';
                    }

                    // if (($f_indeks * 25) <= 100 &&  ($f_indeks * 25) >= 88.31) {
                    //     $h_indeks = 'Sangat Baik';
                    // } elseif (($f_indeks * 25) <= 88.40 &&  ($f_indeks * 25) >= 76.61) {
                    //     $h_indeks = 'Baik';
                    // } elseif (($f_indeks * 25) <= 76.60 &&  ($f_indeks * 25) >= 65) {
                    //     $h_indeks = 'Kurang Baik';
                    // } elseif (($f_indeks * 25) <= 64.99 &&  ($f_indeks * 25) >= 25) {
                    //     $h_indeks = 'Tidak Baik';
                    // } else {
                    //     $h_indeks = 'NULL';
                    // }
                }

                $table->addRow();
                $table->addCell(2000)->addText('Rata-rata', $cellTableFontStyle);
                $table->addCell(800)->addText(str_replace('.', ',', round(($jum_persentase_1 / $no), 2)) . ' %', $cellTableFontStyle);
                $table->addCell(800)->addText(str_replace('.', ',', round(($jum_persentase_2 / $no), 2)) . ' %', $cellTableFontStyle);
                $table->addCell(800)->addText(str_replace('.', ',', round(($jum_persentase_3 / $no), 2)) . ' %', $cellTableFontStyle);
                $table->addCell(800)->addText(str_replace('.', ',', round(($jum_persentase_4 / $no), 2)) . ' %', $cellTableFontStyle);

                if ($manage_survey->skala_likert == 5) {
                    $table->addCell(800)->addText(str_replace('.', ',', round(($jum_persentase_5 / $no), 2)) . ' %', $cellTableFontStyle);
                }

                $table->addCell(525)->addText(str_replace('.', ',', $f_indeks), $cellTableFontStyle);
                $table->addCell(525)->addText($h_indeks, $cellTableFontStyle);

                $section->addTextBreak(1);



                //TURUNAN
                $this->db->select("*, unsur_pelayanan_$table_identity.id AS id_unsur_pelayanan, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan");
                $this->db->from("unsur_pelayanan_$table_identity");
                $this->db->join("pertanyaan_unsur_pelayanan_$table_identity", "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id");
                $this->db->where(['id_parent' => $value->id_unsur_pelayanan]);
                $unsur_pelayanan_a = $this->db->get();

                foreach ($unsur_pelayanan_a->result() as $element_a) {

                    $this->db->select("*, unsur_pelayanan_$table_identity.id AS id_unsur_pelayanan, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan");
                    $this->db->from("unsur_pelayanan_$table_identity");
                    $this->db->join(
                        "pertanyaan_unsur_pelayanan_$table_identity",
                        "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id"
                    );
                    $this->db->where(["unsur_pelayanan_$table_identity.id" => $element_a->id_unsur_pelayanan]);
                    $unsur_pelayanan_aa = $this->db->get()->row();


                    $id_pertanyaan_unsur_pelayanan = $unsur_pelayanan_aa->id_pertanyaan_unsur_pelayanan;
                    $persentase_detail = $this->db->query(" SELECT id AS id_kup, nama_kategori_unsur_pelayanan,
                        ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                        $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) AS jumlah,
                        ( SELECT ROUND(( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                        $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) / ( SELECT COUNT(*) FROM
                        jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan ) * 100,2) ) AS
                        persentase
                        FROM kategori_unsur_pelayanan_$table_identity
                        WHERE id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan
                        ");

                    $section->addText($element_a->nomor_unsur . '. ' . $element_a->nama_unsur_pelayanan, array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));

                    $section->addText('Tabel '.$no_p3++.'. Persentase Responden pada Unsur '.$value->nama_unsur_pelayanan, array('size' => 11), $paragraphStyleName);

                    $fancyTableStyleName = 'Chart Unsur 1';
                    $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                    $fancyTableCellStyle = array('valign' => 'center');
                    $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                    $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                    $table = $section->addTable($fancyTableStyleName);
                    $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                    $table->addRow();
                    $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                    $table->addCell(4000, $fancyTableCellStyle)->addText('Kelompok', $fancyTableFontStyle);
                    $table->addCell(1000, $fancyTableCellStyle)->addText('Jumlah', $fancyTableFontStyle);
                    $table->addCell(1000, $fancyTableCellStyle)->addText('Persentase', $fancyTableFontStyle);


                    $no = 1;
                    $t_jum = 0;
                    $t_persen = 0;

                    foreach ($persentase_detail->result() as $val_p) {

                        $table->addRow();
                        $table->addCell(150)->addText($no++, $cellTableFontStyle);
                        $table->addCell(4000)->addText($val_p->nama_kategori_unsur_pelayanan, $cellTableFontStyle);
                        $table->addCell(1000)->addText($val_p->jumlah, $cellTableFontStyle);
                        $table->addCell(1000)->addText(str_replace('.', ',', $val_p->persentase) . ' %', $cellTableFontStyle);

                        $t_jum += $val_p->jumlah;
                        $t_persen += $val_p->persentase;
                    }
                    $table->addRow();
                    $table->addCell(150)->addText('', $cellTableFontStyle);
                    $table->addCell(4000)->addText('TOTAL', $cellTableFontStyle);
                    $table->addCell(1000)->addText($t_jum, $cellTableFontStyle);
                    $table->addCell(1000)->addText(str_replace('.', ',', $t_persen) . ' %', $cellTableFontStyle);
                    $section->addTextBreak(1);



                    $alasan = $this->db->query("SELECT *
                    FROM jawaban_pertanyaan_unsur_$table_identity
                    JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
                    JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
                    WHERE is_submit = 1 && id_unsur_pelayanan = $element_a->id_unsur_pelayanan && alasan_pilih_jawaban != '' && jawaban_pertanyaan_unsur_$table_identity.is_active = 1
                    ");


                    if($alasan->num_rows() > 0){
                        $val_alasan = [];
                        foreach($alasan->result() as $val){
                            $val_alasan[] = '<li>' . $val->alasan_pilih_jawaban . '</li>';
                        }
                        $data_alasan = '
                            <br/>
                            Alasan yang diberikan responden pada unsur ' . $element_a->nama_unsur_pelayanan . ':
                            <ul>' . implode(" ", $val_alasan).'</ul>';
                    } else {
                        $data_alasan = '';
                    }

                    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $data_alasan, false, false);
                    //$section->addTextBreak(1);



                }
            } else {

                //JIKA TIDAK MEMPUNYAI TURUNAN
                $this->db->select("*, unsur_pelayanan_$table_identity.id AS id_unsur_pelayanan, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan");
                $this->db->from("unsur_pelayanan_$table_identity");
                $this->db->join(
                    "pertanyaan_unsur_pelayanan_$table_identity",
                    "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id"
                );
                $this->db->where(["unsur_pelayanan_$table_identity.id" => $value->id_unsur_pelayanan]);
                $unsur_pelayanan_b = $this->db->get()->row();

                $id_pertanyaan_unsur_pelayanan = $unsur_pelayanan_b->id_pertanyaan_unsur_pelayanan;
                $persentase_detail = $this->db->query(" SELECT nama_kategori_unsur_pelayanan,
                    ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                    $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) AS jumlah,
                    ( SELECT ROUND(( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                    $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) / ( SELECT COUNT(*) FROM
                    jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan ) * 100,2) ) AS
                    persentase
                    FROM kategori_unsur_pelayanan_$table_identity
                    WHERE id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan
                    ")->result_array();

                $nama_kategori_unsur_pelayanan = [];
                $persentase = [];
                $nama_identitas = [];
                foreach ($persentase_detail as $element) {
                    // if($element['persentase']){
                    //     $element_persentase = $element['persentase'];
                    // }else{
                    //     $element_persentase = 1;
                    // }
                    $nama_kategori_unsur_pelayanan[] = str_replace(' ', '%20', $element['nama_kategori_unsur_pelayanan']) . '%20=%20' . $element['persentase'] . '%';
                    $persentase[] = $element['persentase'];
                    $nama_identitas[] = $element['persentase'] . '%';
                    // $nama_kategori_unsur_pelayanan[] = str_replace(' ', '%20', $element['nama_kategori_unsur_pelayanan']) . '%20=%20' . $element_persentase . '%';
                    // $persentase[] = $element_persentase;
                    // $nama_identitas[] = $element_persentase . '%';
                }
                $get_persentase = implode(",", $persentase);
                $get_nama_kategori = implode("|", $nama_kategori_unsur_pelayanan);
                $get_nama_identitas = implode("|", $nama_identitas);


                $persentase_detail2 = $this->db->query(" SELECT nama_kategori_unsur_pelayanan,
                ( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) AS jumlah,
                ( SELECT ROUND(( SELECT COUNT(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur =
                $id_pertanyaan_unsur_pelayanan AND skor_jawaban = nomor_kategori_unsur_pelayanan) / ( SELECT COUNT(*) FROM
                jawaban_pertanyaan_unsur_$table_identity JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
WHERE is_submit = 1 && id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan ) * 100,2) ) AS
                persentase
                FROM kategori_unsur_pelayanan_$table_identity
                WHERE id_pertanyaan_unsur = $id_pertanyaan_unsur_pelayanan ORDER BY ID DESC
                ")->result_array();

                $nama_kategori_unsur_pelayanan2 = [];
                foreach ($persentase_detail2 as $element) {
                    $nama_kategori_unsur_pelayanan2[] = str_replace(' ', '%20', $element['nama_kategori_unsur_pelayanan']) . '%20=%20' . $element['persentase'] . '%';
                }

                //JIKA UNSUR TIDAK MEMILIKI TURUNAN
                // $section->addImage('https://image-charts.com/chart?chd=t:' . $get_persentase . '&chdlp=b&chdl=' . $get_nama_kategori . '&chf=ps0-0%2Clg%2C45%2Cfc3dd6%2C0.2%2Cfc3d3d7C%2C1%7Cps0-1%2Clg%2C45%2C2b4fc4%2C0.2%2C32c9c47C%2C1%7Cps0-2%2Clg%2C45%2CEA469E%2C0.2%2C03A9F47C%2C1%7Cps0-3%2Clg%2C45%2Cfacc00%2C0.2%2Cffca477C%2C1%7Cps0-4%2Clg%2C45%2Cf2fa05%2C0.2%2C2fa36f7C%2C1%7Cps0-4%2Clg%2C45%2C098d9c%2C0.2%2C840ccf7C%2C1&chl=' . $get_nama_identitas . '&chs=500x200&cht=pc&chxt=x%2Cy', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                // ok$section->addImage('https://image-charts.com/chart?chd=t:' . $get_persentase . '&chdlp=b&chdl=' . $get_nama_kategori . '&chf=ps0-0%2Clg%2C45%2Cfc3dd6%2C0.2%2Cfc3d3d7C%2C1%7Cps0-1%2Clg%2C45%2C2b4fc4%2C0.2%2C32c9c47C%2C1%7Cps0-2%2Clg%2C45%2CEA469E%2C0.2%2C03A9F47C%2C1%7Cps0-3%2Clg%2C45%2Cfacc00%2C0.2%2Cffca477C%2C1%7Cps0-4%2Clg%2C45%2Cf2fa05%2C0.2%2C2fa36f7C%2C1%7Cps0-4%2Clg%2C45%2C098d9c%2C0.2%2C840ccf7C%2C1&chs=500x200&cht=pc&chxt=x%2Cy', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                $total_rekap_responden = implode(",", $persentase);
                $kelompok_rekap_responden = implode("|", $nama_kategori_unsur_pelayanan2);
                $section->addImage('https://image-charts.com/chart?chbh=20&chbr=10&chd=t:' . $total_rekap_responden . '&chs=600x300&cht=bhs&chxr=1,0,100&chxt=y,x&chxl=0%3A|' . $kelompok_rekap_responden . '&chco=ff9f40', array('width' => 350, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

                $section->addText('Gambar '.$no_p2++.'. Grafik Unsur '.$value->nama_unsur_pelayanan, array('size' => 11), $paragraphStyleName);

                $section->addTextBreak();


                $section->addText('Tabel '.$no_p3++.'. Persentase Responden pada Unsur '.$value->nama_unsur_pelayanan, array('size' => 11), $paragraphStyleName);

                $fancyTableStyleName = 'Chart Unsur tidak memiliki turunan';
                $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                $fancyTableCellStyle = array('valign' => 'center');
                $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                $table = $section->addTable($fancyTableStyleName);
                $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                $table->addRow();
                $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                $table->addCell(4000, $fancyTableCellStyle)->addText('Kategori', $fancyTableFontStyle);
                $table->addCell(1000, $fancyTableCellStyle)->addText('Jumlah', $fancyTableFontStyle);
                $table->addCell(1000, $fancyTableCellStyle)->addText('Persentase', $fancyTableFontStyle);

                $t = 1;
                $t_jum = 0;
                $t_persen = 0;
                foreach ($persentase_detail as $element) {
                    $table->addRow();
                    $table->addCell(150)->addText($t++, $cellTableFontStyle);
                    $table->addCell(4000)->addText($element['nama_kategori_unsur_pelayanan'], $cellTableFontStyle);
                    $table->addCell(1000)->addText($element['jumlah'], $cellTableFontStyle);
                    $table->addCell(1000)->addText(str_replace('.', ',', $element['persentase']) . ' %', $cellTableFontStyle);

                    $t_jum += $element['jumlah'];
                    $t_persen += $element['persentase'];
                }
                $table->addRow();
                $table->addCell(150)->addText('', $cellTableFontStyle);
                $table->addCell(4000)->addText('TOTAL', $cellTableFontStyle);
                $table->addCell(1000)->addText($t_jum, $cellTableFontStyle);
                $table->addCell(1000)->addText(str_replace('.', ',', $t_persen) . ' %', $cellTableFontStyle);
            };
            $section->addTextBreak(1);


            $alasan = $this->db->query("SELECT * FROM jawaban_pertanyaan_unsur_$table_identity
            JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
            WHERE is_submit = 1 && id_pertanyaan_unsur = $value->id_unsur_pelayanan && alasan_pilih_jawaban != '' && jawaban_pertanyaan_unsur_$table_identity.is_active = 1
            ");

            if($alasan->num_rows() > 0){
                $val_alasan = [];
                foreach($alasan->result() as $get){
                    $val_alasan[] = '<li>' . $get->alasan_pilih_jawaban . '</li>';
                }
                $data_alasan = '
                    <br/>
                    Alasan yang diberikan responden pada unsur ' . $value->nama_unsur_pelayanan . ':
                    <ul>' . implode(" ", $val_alasan).'</ul>';
            } else {
                $data_alasan = '';
            }
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $data_alasan, false, false);
            $section->addTextBreak(1);


        }



        // HALAMAN REKAP SARAN/ OPINI RESPONDEN
        if ($manage_survey->is_saran == 1) {
            // $section->addText('Rekapitulasi Saran/ Opini Responden', array('bold' => true, 'size' => 18), $paragraphStyleName);
            // $section->addTextBreak(1);
            // $section->addText('Saran atau opini responden mengenai survei kepuasan masyarakat ' . $data_survei['nama_organisasi'] . '.', array('size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));
            // $section->addTextBreak();
            $texthtmlbab35 = '<table>
        <tr>
            <td width="5%"><b>4.</b></td>
            <td width="95%"><b>Saran Responden</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Saran responden mengenai Survei Persepsi Anti Korupsi (SPAK) pada '.$data_survei['nama_organisasi'].' sebagai berikut:</p></td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab35, false, false);

            $fancyTableStyleName = 'Jawaban Saran 1';
            $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
            $fancyTableCellStyle = array('valign' => 'center');
            $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
            $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
            $table = $section->addTable($fancyTableStyleName);
            $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

            $this->db->select("*");
            $this->db->from("survey_$table_identity");
            $this->db->join("responden_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
            $this->db->where("survey_$table_identity.is_active", 1);
            $this->db->where("survey_$table_identity.is_submit", 1);
            $this->db->where("survey_$table_identity.saran != ''");
            $rekap_saran = $this->db->get();


            if($rekap_saran->num_rows() > 0 ) {
                $table->addRow();
                $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                // $table->addCell(4000, $fancyTableCellStyle)->addText('Nama Responden', $fancyTableFontStyle);
                $table->addCell(8200, $fancyTableCellStyle)->addText('Saran', $fancyTableFontStyle);
    
                $no = 1;
                foreach ($rekap_saran->result() as $value) {
    
                    $table->addRow();
                    $table->addCell(150)->addText($no++, $cellTableFontStyle);
                    // $table->addCell(4000)->addText($value->nama_lengkap, $cellTableFontStyle);
                    $table->addCell(200)->addText($value->saran, $cellTableFontStyle);
                }
            }else{
                $section->addText('Tidak ada saran dan masukan yang di dapan dalan survei.', array('italic'=>true, 'size' => 11), $paragraphStyleName);
            }
            //$section->addPageBreak();
            $section->addTextBreak(1);

        }


        $this->db->select("*");
        $this->db->from("analisa_$table_identity");
        $this->db->join("unsur_pelayanan_$table_identity", "unsur_pelayanan_$table_identity.id = analisa_$table_identity.id_unsur_pelayanan");
        $data_analisa = $this->db->get();

        $texthtmlbab36 = '<table>
        <tr>
            <td width="5%"><b>B.</b></td>
            <td width="95%"><b>Tindak Lanjut Hasil Survei</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"><p align="justify" style="text-indent: 50pt; ">Berdasarkan hasil dari Survei Persepsi Anti Korupsi (SPAK), maka rekomendasi yang dapat dilakukan sebagai berikut:</p></td>
        </tr>
        </table>';
        
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab36, false, false);

        if($data_analisa->num_rows() > 0 ) {

            // $fancyTableStyleName = 'Tabel Analisa SPAK';
            // $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            // $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
            // $fancyTableCellStyle = array('valign' => 'center');
            // $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
            // $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
            // $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
            // $table = $section->addTable($fancyTableStyleName);
            // $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');
    
            // $table->addRow();
            // $table->addCell(150, $fancyTableCellStyle)->addText('Unsur', $fancyTableFontStyle);
            // $table->addCell(2000, $fancyTableCellStyle)->addText('Saran dan Masukan', $fancyTableFontStyle);
            // $table->addCell(1000, $fancyTableCellStyle)->addText('Rencana Perbaikan', $fancyTableFontStyle);
            // $table->addCell(1000, $fancyTableCellStyle)->addText('Waktu', $fancyTableFontStyle);
            // $table->addCell(1000, $fancyTableCellStyle)->addText('Faktor Penyebab', $fancyTableFontStyle);
            // $table->addCell(1000, $fancyTableCellStyle)->addText('Kegiatan', $fancyTableFontStyle);
            // $table->addCell(1000, $fancyTableCellStyle)->addText('Penanggung Jawab', $fancyTableFontStyle);
    
            $texthtmlbab37 = '<table>';
            foreach ($data_analisa->result() as $value) {

               
                 $texthtmlbab37 .= '<tr>
                    <td width="25%"><b>Unsur</b></td>
                    <td width="5%">:</td>
                    <td width="70%">'.$value->nomor_unsur.'. '.$value->nama_unsur_pelayanan.'</td>
                </tr>
                <tr>
                    <td width="25%"><b>Faktor-faktor yang mempengaruhi</b></td>
                    <td width="5%">:</td>
                    <td width="70%">'.$value->faktor_penyebab.'</td>
                </tr>
                <tr>
                    <td width="25%"><b>Rencana tindak lanjut</b></td>
                    <td width="5%">:</td>
                    <td width="70%">'.$value->rencana_perbaikan.'</td>
                </tr>
                <tr>
                    <td width="25%"><b>Waktu</b></td>
                    <td width="5%">:</td>
                    <td width="70%">'.$value->waktu.'</td>
                </tr>
                <tr>
                    <td width="25%"><b>Penanggung jawab</b></td>
                    <td width="5%">:</td>
                    <td width="70%">'.$value->penanggung_jawab.'</td>
                </tr>
                <tr>
                    <td width="25%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="70%">&nbsp;</td>
                </tr>';

                
            }
            $texthtmlbab37 .= '</table>';
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab37, false, false);

        }else{
            
            // $texthtmlbab37 = '<table>
            // <tr>
            //     <td width="10%"></td>
            //     <td width="90%">Belum ada data tindak lanjut.</td>
            // </tr>
            // </table>';
            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab37, false, false);
            $section->addText('Belum ada data tindak lanjut.', array('italic'=>true, 'size' => 11), $paragraphStyleName);

        }
            

        


       

        

        $section->addPageBreak();








        // HALAMAN REKAPITULASI ALASAN JAWABAN PERTANYAAN UNSUR
        // $section->addText('Rekapitulasi Alasan Jawaban Pertanyaan Unsur', array('bold' => true, 'size' => 18), $paragraphStyleName);

        // $section->addTextBreak(2);

        $this->db->select("*, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_unsur_pelayanan = unsur_pelayanan_$table_identity.id) AS nomor_unsur");
        $this->db->from("pertanyaan_unsur_pelayanan_$table_identity");
        $unsur = $this->db->get();

        /*foreach ($unsur->result() as $value) {

            // CEK DATA RESPONDEN UNSUR
            $this->db->select("*");
            $this->db->from("jawaban_pertanyaan_unsur_$table_identity");
            $this->db->join("responden_$table_identity", "responden_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_responden");
            $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
            $this->db->where("survey_$table_identity.is_submit", 1);
            $this->db->where("jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur", $value->id_pertanyaan_unsur);
            $this->db->where("jawaban_pertanyaan_unsur_$table_identity.is_active", 1);
            $this->db->where("jawaban_pertanyaan_unsur_$table_identity.alasan_pilih_jawaban !=", "");
            $jawaban_p_unsur = $this->db->get();


            $table = $section->addTable('Alasan Jawaban U1');
            $table->addRow();
            $table->addCell(500)->addText($value->nomor_unsur . '.', array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));
            $table->addCell(9000)->addText(strip_tags($value->isi_pertanyaan_unsur), array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));


            $fancyTableStyleName = 'Rekapitulasi Alasan 1';
            $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
            $fancyTableCellStyle = array('valign' => 'center');
            $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
            $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
            $table = $section->addTable($fancyTableStyleName);
            $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

            $table->addRow();
            $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
            // $table->addCell(4000, $fancyTableCellStyle)->addText('Nama Responden', $fancyTableFontStyle);
            $table->addCell(8200, $fancyTableCellStyle)->addText('Alasan Jawaban', $fancyTableFontStyle);


            if ($jawaban_p_unsur->num_rows() > 0) {

                $no = 1;
                foreach ($jawaban_p_unsur->result() as $values) {
                    $table->addRow();
                    $table->addCell(150)->addText($no++, $cellTableFontStyle);
                    // $table->addCell(4000)->addText($values->nama_lengkap, $cellTableFontStyle);
                    $table->addCell(8200)->addText($values->alasan_pilih_jawaban, $cellTableFontStyle);
                }
            } else {
                // echo '<span style="color: red;">Tidak ada alasan jawaban yang diisi</span>';
            }
            $section->addTextBreak();
        }*/
        //$section->addPageBreak();







        // HALAMAN REKAPITULASI PERTANYAAN TAMBAHAN
        if (in_array(2, $atribut_pertanyaan)) {
            $section->addText('Rekapitulasi Pertanyaan Tambahan', array('bold' => true, 'size' => 18), $paragraphStyleName);
            $section->addTextBreak(2);

            $pertanyaan_tambahan = $this->db->query("SELECT *, (SELECT DISTINCT dengan_isian_lainnya FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS is_lainnya,
		(SELECT COUNT(*) FROM responden_$table_identity
		JOIN jawaban_pertanyaan_terbuka_$table_identity ON responden_$table_identity.id =
		jawaban_pertanyaan_terbuka_$table_identity.id_responden
		JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 && jawaban_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka =
		perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka && jawaban_pertanyaan_terbuka_$table_identity.jawaban =
		'Lainnya') AS perolehan,
		(((SELECT COUNT(*) FROM responden_$table_identity
		JOIN jawaban_pertanyaan_terbuka_$table_identity ON responden_$table_identity.id =
		jawaban_pertanyaan_terbuka_$table_identity.id_responden
		JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 && jawaban_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka =
		perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka && jawaban_pertanyaan_terbuka_$table_identity.jawaban =
		'Lainnya') / (SELECT COUNT(*) FROM survey_$table_identity WHERE is_submit =
		1)) * 100) AS persentase

		FROM pertanyaan_terbuka_$table_identity
		JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka");

            $jawaban_ganda = $this->db->query("SELECT *, (SELECT COUNT(*) FROM responden_$table_identity
        JOIN jawaban_pertanyaan_terbuka_$table_identity ON responden_$table_identity.id =
        jawaban_pertanyaan_terbuka_$table_identity.id_responden
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE survey_$table_identity.is_submit = 1 && jawaban_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka =
        perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka && jawaban_pertanyaan_terbuka_$table_identity.jawaban =
        isi_pertanyaan_ganda_$table_identity.pertanyaan_ganda) AS perolehan,
        (((SELECT COUNT(*) FROM responden_$table_identity
        JOIN jawaban_pertanyaan_terbuka_$table_identity ON responden_$table_identity.id =
        jawaban_pertanyaan_terbuka_$table_identity.id_responden
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE survey_$table_identity.is_submit = 1 && jawaban_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka =
        perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka && jawaban_pertanyaan_terbuka_$table_identity.jawaban =
        isi_pertanyaan_ganda_$table_identity.pertanyaan_ganda) / (SELECT COUNT(*) FROM survey_$table_identity WHERE is_submit =
        1)) * 100) AS persentase
        FROM isi_pertanyaan_ganda_$table_identity
        JOIN perincian_pertanyaan_terbuka_$table_identity ON isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka
        = perincian_pertanyaan_terbuka_$table_identity.id
        WHERE perincian_pertanyaan_terbuka_$table_identity.id_jenis_pilihan_jawaban = 1");

            $jawaban_isian = $this->db->query("SELECT *
        FROM jawaban_pertanyaan_terbuka_$table_identity
        JOIN pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = jawaban_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
        JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
        JOIN responden_$table_identity ON jawaban_pertanyaan_terbuka_$table_identity.id_responden = responden_$table_identity.id
        JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
        WHERE id_jenis_pilihan_jawaban = 2 && survey_$table_identity.is_submit = 1");


            foreach ($pertanyaan_tambahan->result() as $row) {
                $table = $section->addTable('Judul Pertanyaan Tambahan');
                $table->addRow();
                $table->addCell(500)->addText($row->nomor_pertanyaan_terbuka . '.', array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));
                $table->addCell(9000)->addText(strip_tags($row->isi_pertanyaan_terbuka), array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));



                if ($row->id_jenis_pilihan_jawaban == 1) {

                    $fancyTableStyleName = 'Pertanyaan Tambahan 1';
                    $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                    $fancyTableCellStyle = array('valign' => 'center');
                    $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                    $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                    $table = $section->addTable($fancyTableStyleName);
                    $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                    $table->addRow();
                    $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                    $table->addCell(3000, $fancyTableCellStyle)->addText('Kelompok', $fancyTableFontStyle);
                    $table->addCell(2500, $fancyTableCellStyle)->addText('Jumlah', $fancyTableFontStyle);
                    $table->addCell(2500, $fancyTableCellStyle)->addText('Persentase', $fancyTableFontStyle);

                    $nt = 1;
                    foreach ($jawaban_ganda->result() as $value) {
                        if ($value->id_pertanyaan_terbuka == $row->id_pertanyaan_terbuka) {
                            $table->addRow();
                            $table->addCell(150)->addText($nt++, $cellTableFontStyle);
                            $table->addCell(3000)->addText($value->pertanyaan_ganda, $cellTableFontStyle);
                            $table->addCell(2500)->addText($value->perolehan, $cellTableFontStyle);
                            $table->addCell(2500)->addText(str_replace('.', ',', ROUND($value->persentase, 2)) . '%', $cellTableFontStyle);
                        }
                    }
                    if ($row->is_lainnya == 1) {
                        $table->addRow();
                        $table->addCell(150)->addText($nt++, $cellTableFontStyle);
                        $table->addCell(3000)->addText('Lainnya', $cellTableFontStyle);
                        $table->addCell(2500)->addText($row->perolehan, $cellTableFontStyle);
                        $table->addCell(2500)->addText(str_replace('.', ',', ROUND($row->persentase, 2)) . '%', $cellTableFontStyle);
                    }
                } else {
                    $fancyTableStyleName = 'Pertanyaan Tambahan 2';
                    $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                    $fancyTableCellStyle = array('valign' => 'center');
                    $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                    $table = $section->addTable($fancyTableStyleName);
                    $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                    $table->addRow();
                    $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                    $table->addCell(8200, $fancyTableCellStyle)->addText('Jawaban', $fancyTableFontStyle);


                    $i = 1;
                    foreach ($jawaban_isian->result() as $get) {
                        if ($get->id_pertanyaan_terbuka == $row->id_pertanyaan_terbuka) {
                            $table->addRow();
                            $table->addCell(150)->addText($i++, $cellTableFontStyle);
                            $table->addCell(8200)->addText($get->jawaban, $cellTableFontStyle);
                        }
                    }
                }
                $section->addTextBreak();
            }
            $section->addPageBreak();
        }








        // HALAMAN REKAPITULASI JAWABAN PERTANYAAN KUALITATIF\
        if (in_array(3, $atribut_pertanyaan)) {
            $section->addText('Rekapitulasi Jawaban Pertanyaan Kualitatif', array('bold' => true, 'size' => 18), $paragraphStyleName);

            $section->addTextBreak(2);


            $this->db->select("*");
            $this->db->from("pertanyaan_kualitatif_$table_identity");
            $this->db->where("pertanyaan_kualitatif_$table_identity.is_active", 1);
            $rekap_kualitatif = $this->db->get();


            $no = 1;
            foreach ($rekap_kualitatif->result() as $value) {

                $table = $section->addTable('Pertanyaan Kualitatif 1');
                $table->addRow();
                $table->addCell(500)->addText($no++, array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));
                $table->addCell(9000)->addText(strip_tags($value->isi_pertanyaan), array('name' => 'Arial', 'size' => 11, 'valign' => 'center'));

                $this->db->select("*");
                $this->db->from("jawaban_pertanyaan_kualitatif_$table_identity");
                $this->db->join("responden_$table_identity", "responden_$table_identity.id = jawaban_pertanyaan_kualitatif_$table_identity.id_responden");
                $this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
                $this->db->where("survey_$table_identity.is_submit", 1);
                $this->db->where("jawaban_pertanyaan_kualitatif_$table_identity.id_pertanyaan_kualitatif", $value->id);
                $this->db->where("jawaban_pertanyaan_kualitatif_$table_identity.is_active", 1);
                $rekap_jawaban_kualitatif = $this->db->get();

                $fancyTableStyleName = 'Jawaban Pertanyaan Kualitatif 1';
                $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
                $fancyTableCellStyle = array('valign' => 'center');
                $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
                $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
                $table = $section->addTable($fancyTableStyleName);
                $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

                $table->addRow();
                $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
                // $table->addCell(4000, $fancyTableCellStyle)->addText('Nama Responden', $fancyTableFontStyle);
                $table->addCell(8200, $fancyTableCellStyle)->addText('Jawaban', $fancyTableFontStyle);

                $no_sub = 1;
                foreach ($rekap_jawaban_kualitatif->result() as $values) {

                    $table->addRow();
                    $table->addCell(150)->addText($no_sub++, $cellTableFontStyle);
                    // $table->addCell(4000)->addText($values->nama_lengkap, $cellTableFontStyle);
                    $table->addCell(8200)->addText($values->isi_jawaban_kualitatif, $cellTableFontStyle);
                }

                $section->addTextBreak();
            }
            $section->addPageBreak();
        }




        





        // HALAMAN KUADRAN UNSUR SKM
        if (in_array(1, $atribut_pertanyaan)) {
            $section->addText('Kuadran Unsur SKM', array('bold' => true, 'size' => 18), $paragraphStyleName);

            $section->addTextBreak(1);

            $section->addImage('assets/klien/img_kuadran/kuadran-' . $table_identity . '.png', array('width' => 450, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

            $section->addTextBreak();


            $fancyTableStyleName = 'Tabel Kuadran Unsur SKM';
            $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
            $fancyTableCellStyle = array('valign' => 'center');
            $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
            $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
            $table = $section->addTable($fancyTableStyleName);
            $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');






            $this->db->select('COUNT(id) AS jumlah_unsur');
            $this->db->from('unsur_pelayanan_' . $manage_survey->table_identity);
            $this->db->where('id_parent = 0');
            $jumlah_unsur = $this->db->get()->row()->jumlah_unsur;

            //NILAI PER UNSUR
            $this->db->select("IF(id_parent = 0,unsur_pelayanan_$manage_survey->table_identity.id, unsur_pelayanan_$manage_survey->table_identity.id_parent) AS id_sub, ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))) AS nilai_per_unsur");
            $this->db->from('jawaban_pertanyaan_unsur_' . $manage_survey->table_identity);
            $this->db->join("pertanyaan_unsur_pelayanan_$manage_survey->table_identity", "jawaban_pertanyaan_unsur_$manage_survey->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("unsur_pelayanan_$manage_survey->table_identity", "pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id_unsur_pelayanan = unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("survey_$manage_survey->table_identity", "jawaban_pertanyaan_unsur_$manage_survey->table_identity.id_responden = survey_$manage_survey->table_identity.id_responden");
            $this->db->where("survey_$manage_survey->table_identity.is_submit = 1");
            $this->db->group_by('id_sub');
            $object_unsur = $this->db->get();
            $this->data['nilai_per_unsur'] = $object_unsur;

            $nilai_unsur = 0;
            foreach ($object_unsur->result() as $values) {
                $nilai_unsur += $values->nilai_per_unsur;
            }

            //NILAI PER HARAPAN
            $this->db->select("((SUM(skor_jawaban)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))) AS nilai_per_unsur");
            $this->db->from("jawaban_pertanyaan_harapan_$manage_survey->table_identity");
            $this->db->join("pertanyaan_unsur_pelayanan_$manage_survey->table_identity", "jawaban_pertanyaan_harapan_$manage_survey->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("unsur_pelayanan_$manage_survey->table_identity", "pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id_unsur_pelayanan = unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("survey_$manage_survey->table_identity", "jawaban_pertanyaan_harapan_$manage_survey->table_identity.id_responden = survey_$manage_survey->table_identity.id_responden");
            $this->db->where("survey_$manage_survey->table_identity.is_submit = 1");
            $this->db->group_by("IF(id_parent = 0,unsur_pelayanan_$manage_survey->table_identity.id, unsur_pelayanan_$manage_survey->table_identity.id_parent)");
            $object_harapan = $this->db->get();
            $this->data['nilai_per_unsur_harapan'] = $object_harapan;

            $nilai_harapan = 0;
            foreach ($object_harapan->result() as $rows) {
                $nilai_harapan += $rows->nilai_per_unsur;
            }

            $total_rata_unsur = $nilai_unsur / $jumlah_unsur;
            $total_rata_harapan = $nilai_harapan / $jumlah_unsur;


            // $section->addText('PENENTUAN KUADRAN', array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));

            $data_kuadran_unsur =  $this->db->query("SELECT *,
            (CASE
                WHEN kup.skor_unsur <= $total_rata_unsur && kup.skor_harapan >= $total_rata_harapan
                        THEN 1
                WHEN kup.skor_unsur >= $total_rata_unsur && kup.skor_harapan >= $total_rata_harapan
                        THEN 2
                    WHEN kup.skor_unsur <= $total_rata_unsur && kup.skor_harapan <= $total_rata_harapan
                        THEN 3
                    WHEN kup.skor_unsur >= $total_rata_unsur && kup.skor_harapan <= $total_rata_harapan
                        THEN 4
                ELSE 0
            END) AS kuadran

            FROM (SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) AS nomor_unsur, (SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) AS nama_unsur_pelayanan, 

            (SUM((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_unsur_$table_identity JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden WHERE is_submit = 1 && pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur))/(SELECT COUNT(survey_$table_identity.id_responden) FROM jawaban_pertanyaan_unsur_$table_identity 
            JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
            WHERE pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur && survey_$table_identity.is_submit = 1)/COUNT(id_parent)) AS skor_unsur,

            (SUM((SELECT SUM(skor_jawaban) FROM jawaban_pertanyaan_harapan_$table_identity JOIN survey_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_responden = survey_$table_identity.id_responden WHERE is_submit = 1 && pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_harapan_$table_identity.id_pertanyaan_unsur))/(SELECT COUNT(survey_$table_identity.id_responden) FROM jawaban_pertanyaan_unsur_$table_identity 
            JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
            WHERE pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur && survey_$table_identity.is_submit = 1)/COUNT(id_parent)) AS skor_harapan

            FROM pertanyaan_unsur_pelayanan_$table_identity
            JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
            GROUP BY id_sub) AS kup");

            foreach ($data_kuadran_unsur->result() as $row) {
                if ($row->kuadran == 1) {
                    $kuadran_1[] = '<li>' . $row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan . '</li>';
                }
            }
            $set_kuadran_1 = implode("", $kuadran_1);


            foreach ($data_kuadran_unsur->result() as $row) {
                if ($row->kuadran == 2) {
                    $kuadran_2[] = '<li>' . $row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan . '</li>';
                }
            }
            $set_kuadran_2 = implode("", $kuadran_2);


            foreach ($data_kuadran_unsur->result() as $row) {
                if ($row->kuadran == 3) {
                    $kuadran_3[] = '<li>' . $row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan . '</li>';
                }
            }
            $set_kuadran_3 = implode("", $kuadran_3);


            foreach ($data_kuadran_unsur->result() as $row) {
                if ($row->kuadran == 4) {
                    $kuadran_4[] = '<li>' . $row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan . '</li>';
                }
            }
            $set_kuadran_4 = implode("", $kuadran_4);


            $html = '
            <table align="left" style="width: 100%; border: 1px #A5A5A5 solid;">
               
                    <tr>
                        <th width="30%" style="background-color: #F3F6F9; font-weight: bold; ">KUADRAN I</th>
                        <td><ul>' .  $set_kuadran_1 . '</ul></td>
                    </tr>
                     <tr>
                        <th width="30%" style="background-color: #F3F6F9; font-weight: bold; ">KUADRAN II</th>
                        <td><ul>' .  $set_kuadran_2 . '</ul></td>
                    </tr>
                     <tr>
                        <th width="30%" style="background-color: #F3F6F9; font-weight: bold; ">KUADRAN III</th>
                        <td><ul>' .  $set_kuadran_3 . '</ul></td>
                    </tr>
                     <tr>
                        <th width="30%" style="background-color: #F3F6F9; font-weight: bold; ">KUADRAN IV</th>
                        <td><ul>' .  $set_kuadran_4 . '</ul></td>
                    </tr>
            </table>
            ';
            // var_dump($html);
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $section->addTextBreak();





            $section->addText('Nilai Persepsi.', array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));

            $persepsi = $this->db->query("SELECT *, SUBSTR(nomor_unsur,2) AS nomor_harapan
            FROM unsur_pelayanan_$table_identity
            WHERE id_parent = 0");
            $jumlah_unsur = $persepsi->num_rows();
            $colspan_unsur = ($jumlah_unsur + 1);

            $nomor_unsur = [];
            $nomor_harapan = [];
            foreach ($persepsi->result() as $row_unsur) {
                $nomor_unsur[] = '<th>' . $row_unsur->nomor_unsur . '</th>';
                $nomor_harapan[] = '<th>H' . $row_unsur->nomor_harapan . '</th>';
            }
            $no_unsur = implode("", $nomor_unsur);
            $no_harapan = implode("", $nomor_harapan);


            //NILAI PER UNSUR
            $this->db->select("IF(id_parent = 0,unsur_pelayanan_$manage_survey->table_identity.id, unsur_pelayanan_$manage_survey->table_identity.id_parent) AS id_sub, ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))) AS nilai_per_unsur");
            $this->db->from('jawaban_pertanyaan_unsur_' . $manage_survey->table_identity);
            $this->db->join("pertanyaan_unsur_pelayanan_$manage_survey->table_identity", "jawaban_pertanyaan_unsur_$manage_survey->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("unsur_pelayanan_$manage_survey->table_identity", "pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id_unsur_pelayanan = unsur_pelayanan_$manage_survey->table_identity.id");
            $this->db->join("survey_$manage_survey->table_identity", "jawaban_pertanyaan_unsur_$manage_survey->table_identity.id_responden = survey_$manage_survey->table_identity.id_responden");
            $this->db->where("survey_$manage_survey->table_identity.is_submit = 1");
            $this->db->group_by('id_sub');
            $object_unsur = $this->db->get();

            $nilai_unsur = 0;
            $rata_unsur = [];
            foreach ($object_unsur->result() as $values) {
                $rata_unsur[] = '<td style="text-align: center;">' . ROUND($values->nilai_per_unsur, 3) . '</td>';
                $nilai_unsur += $values->nilai_per_unsur;
            }
            $get_rata_unsur = implode("", $rata_unsur);
            $total_rata_unsur = $nilai_unsur / $jumlah_unsur;

            $html = '
            
            <table align="left" style="width: 100%; border: 1px #A5A5A5 solid;">
                <thead>
                    <tr style="background-color: #A5A5A5; text-align: center; color: #FFFFFF; font-weight: bold; ">
                        <th></th>' . $no_unsur . '</tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Rata-Rata per Unsur</th>' . $get_rata_unsur . '</tr>
                    <tr>
                        <th>Rata-Rata Akhir</th>
                        <td colspan="' . $colspan_unsur . '">' . ROUND($total_rata_unsur, 3) . '</td>
                    </tr>
                </tbody>
            </table>
            ';
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
















            // $section->addText('Nilai Harapan.', array('bold' => true, 'size' => 11), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100));


            // //NILAI PER HARAPAN
            // $this->db->select("((SUM(skor_jawaban)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$manage_survey->table_identity.id_responden))) AS nilai_per_unsur");
            // $this->db->from("jawaban_pertanyaan_harapan_$manage_survey->table_identity");
            // $this->db->join("pertanyaan_unsur_pelayanan_$manage_survey->table_identity", "jawaban_pertanyaan_harapan_$manage_survey->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id");
            // $this->db->join("unsur_pelayanan_$manage_survey->table_identity", "pertanyaan_unsur_pelayanan_$manage_survey->table_identity.id_unsur_pelayanan = unsur_pelayanan_$manage_survey->table_identity.id");
            // $this->db->join("survey_$manage_survey->table_identity", "jawaban_pertanyaan_harapan_$manage_survey->table_identity.id_responden = survey_$manage_survey->table_identity.id_responden");
            // $this->db->where("survey_$manage_survey->table_identity.is_submit = 1");
            // $this->db->group_by("IF(id_parent = 0,unsur_pelayanan_$manage_survey->table_identity.id, unsur_pelayanan_$manage_survey->table_identity.id_parent)");
            // $object_harapan = $this->db->get();

            // $nilai_harapan = 0;
            // $rata_harapan = [];
            // foreach ($object_harapan->result() as $rows) {
            //     $rata_harapan[] = '<td style="text-align: center;">' . ROUND($rows->nilai_per_unsur, 3) . '</td>';
            //     $nilai_harapan += $rows->nilai_per_unsur;
            // }
            // $get_rata_harapan = implode("", $rata_harapan);
            // $total_rata_rata_harapan = $nilai_harapan / $jumlah_unsur;


            // $html = '
            // <table align="left" style="width: 100%; border: 1px #A5A5A5 solid;">
            //     <thead>
            //         <tr style="background-color: #A5A5A5; text-align: center; color: #FFFFFF; font-weight: bold; ">
            //             <th></th>' . $no_harapan . '</tr>
            //     </thead>
            //     <tbody>
            //         <tr>
            //             <th>Rata-Rata per Unsur</th>' . $get_rata_harapan . '</tr>
            //         <tr>
            //             <th>Rata-Rata Akhir</th>
            //             <td colspan="' . $colspan_unsur . '">' . ROUND($total_rata_rata_harapan, 3) . '</td>
            //         </tr>
            //     </tbody>
            // </table>
            // ';
            // // var_dump($html);
            // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

            $section->addPageBreak();
        }


        




        // HALAMAN ANALISA
        /*$section->addText('Analisa', array('bold' => true, 'size' => 18), $paragraphStyleName);

        $section->addTextBreak();

        */

        //$section->addPageBreak();


        $section->addText('BAB IV', array('bold' => true, 'size' => 16), $paragraphStyleName);
        //$section->addTextBreak();
        $section->addText('DATA SURVEI', array('bold' => true, 'size' => 16), $paragraphStyleName);
        $section->addTextBreak();
        $texthtmlbab4 = '<table>
        <tr>
            <td width="20%"><b>A.</b></td>
            <td width="80%"><b>Data Responden</b></td>
        </tr>
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab4, false, false);


        $fancyTableStyleName = 'Profil Responden';
        $fancyTableStyle = array('borderSize' => 5, 'borderColor' => '4472C4', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('bgColor' => '4472C4');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('name' => 'Arial', 'size' => 11, 'bold' => true, 'color' => 'FFFFFF');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $cellTableFontStyle = array('name' => 'Arial', 'size' => 11, 'valign' => 'center');

        $profil_responden_bab4 = $this->db->query("SELECT * FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();

        $data_profil = [];
        foreach ($profil_responden_bab4 as $get) {
            if ($get->jenis_isian == 1) {
                $data_profil[] = "(SELECT nama_kategori_profil_responden FROM kategori_profil_responden_$table_identity WHERE responden_$table_identity.$get->nama_alias = kategori_profil_responden_$table_identity.id) AS $get->nama_alias";
            } else {
                $data_profil[] = $get->nama_alias;
            }
        }
        $query_profil = implode(",", $data_profil);

        /*$this->db->select("*, responden_$table_identity.uuid AS uuid_responden, (SELECT first_name FROM users WHERE users.id = surveyor.id_user) AS first_name, (SELECT last_name FROM users WHERE users.id = surveyor.id_user) AS last_name, $query_profil");
		$this->db->from("responden_$table_identity");
		$this->db->join("survey_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden");
		$this->db->join("surveyor", "survey_$table_identity.id_surveyor = surveyor.id", "left");
		$this->db->where('is_submit', 1);
        $list_responden = $this->db->get();*/
        
        $list_responden = $this->db->query("SELECT *, responden_$table_identity.uuid AS uuid_responden, $query_profil
                                FROM responden_$table_identity
                                JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                                WHERE is_submit = 1");
        $array_profil = array('email', 'nomor_telepon', 'no_telepon', 'telepon', 'nomor', 'handphone', 'no_hp', 'whatsapp', 'nomor_whatsapp', 'no_wa', 'nama_lengkap');

        $table->addRow();
        // $table->addCell(150, $fancyTableCellStyle)->addText('No', $fancyTableFontStyle);
        // $table->addCell(1000, $fancyTableCellStyle)->addText('Status', $fancyTableFontStyle);
        // $table->addCell(1000, $fancyTableCellStyle)->addText('Surveyor', $fancyTableFontStyle);
        $table->addCell(200, $fancyTableCellStyle)->addText('', $fancyTableFontStyle);
        foreach ($profil_responden_bab4 as $row) {
            if(!in_array($row->nama_alias, $array_profil)) {
            $table->addCell(2000, $fancyTableCellStyle)->addText($row->nama_profil_responden, $fancyTableFontStyle);
            }
        }
        $table->addCell(2000, $fancyTableCellStyle)->addText("Waktu Isi", $fancyTableFontStyle);

        $no = 1;
        foreach ($list_responden->result() as $value) {

            if ($value->is_submit == 1) {
				$status = 'Valid';
			} else {
				$status = 'Tidak Valid';
			}

            $table->addRow();
            $table->addCell(2000)->addText('Responden ' .$no++, $cellTableFontStyle);
            // $table->addCell(150)->addText($no++, $cellTableFontStyle);
            // $table->addCell(1000)->addText($status, $cellTableFontStyle);
            // $table->addCell(1000)->addText('<b>' . $value->kode_surveyor . '</b>--' . $value->first_name . ' ' . $value->last_name, $cellTableFontStyle);
            // $table->addCell(1000)->addText('--', $cellTableFontStyle);
            foreach ($profil_responden_bab4 as $get) {
                $profil = $get->nama_alias;
                /*if($profil=='nama_lengkap'){
                    $data_profil_responden = 'Responden ' .$no++;
                }else{*/
                    $data_profil_responden = $value->$profil;
                //}
                if(!in_array($get->nama_alias, $array_profil)) {
                $table->addCell(2000)->addText($data_profil_responden, $cellTableFontStyle);
                }
            }
            $table->addCell(2000)->addText(date("d-m-Y", strtotime($value->waktu_isi)), $cellTableFontStyle);
        }
        $section->addText('** Data Nama Lengkap, Email dan Nomor Telepon tidak ditampilkan untuk menjaga kerahasiaan data responden.', array('italic'=>true, 'size' => 11));

        if($manage_survey->img_form_opening != '') {
            $capture = '<img src="' . base_url() . 'assets/klien/form_opening/' . $table_identity . '.png" alt="" width="500"/>';
        } else {
            $capture = 'Gambar form opening belum diambil.';
        }

        $texthtmlbab42 = '<table>
        <tr>
            <td width="5%"></td>
            <td width="95%"><br/></td>
        </tr>
        <tr>
            <td width="5%"><b>B.</b></td>
            <td width="95%"><b>Capture Aplikasi Survei</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%"></td>
        </tr>
        <tr>
            <td width="5%"><b>C.</b></td>
            <td width="95%"><b>Link Akses Hasil Survei</b></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%">Link dan barcode untuk validasi hasil Survei:
            <br/>https://spak.surveiku.com/validasi-sertifikat/'.$manage_survey->uuid.'</td>
        </tr>
        <!--<tr>
            <td width="5%"></td>
            <td width="95%"></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="95%">Sertifikat publikasi:</td>
        </tr>-->
        </table>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $texthtmlbab42, false, false);

        
        $section->addImage('https://image-charts.com/chart?chl='. base_url() . 'validasi-sertifikat/' . $manage_survey->uuid . '&choe=UTF-8&chs=300x300&cht=qr', array('width' => 130, 'ratio' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));



        $filename = 'Laporan ' .  $data_survei['nama_survei'] . '.docx';
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $phpWord->save('php://output');

        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $filename = 'Laporan ' .  $data_survei['nama_survei'] . '.docx';
        // $somePathToUpload = 'upload/';
        // $objWriter->save($somePathToUpload.$filename);
    }
}

/* End of file ReportController.php */
