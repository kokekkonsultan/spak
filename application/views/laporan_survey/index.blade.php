@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp


@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css"
    rel="stylesheet" type="text/css" />
@endsection


@section('content')
<div class="container-fluid">
    @include('include_backend/partials_no_aside/_message')
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">


        <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>

                        
                    </div>
                </div>
            </div>

            <div class=" card mb-5 mt-5" data-aos="fade-down">
                <div class="card-body">

                {{-- @php
                $log_report = $ci->db->order_by('id', 'DESC')->get("log_report_$query->table_identity");
                @endphp

                 @if($log_report->num_rows() == 0)

                    <div class="card mt-5" data-aos="fade-down">
                        <div class="card-body">
                            <form class="form_submit" method="POST" action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/laporan-survey/generate'}}">

                                <input class="form-control" name="keterangan" hidden>

                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="card card-body border border-info text-info shadow wave wave-animate-slow wave-info tombolSubmit" onclick="return confirm('Apakah anda yakin ingin membuat laporan survei anda sekarang ?')">
                                            <div class="text-center font-weight-bold">
                                                <i class="fa fa-download text-info" style="font-size: 30px;"></i><br>
                                                <h6 class="mt-3">Generate Laporan Survei</h6>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                @else

                    <div class="card mt-5" data-aos="fade-down">
                        <div class="card-body">

                            


                            <div class="table-responsive">
                                <table class="table table-bordered table-hover example" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="4%">No.</th>
                                            <th width="22%">Tanggal Download</th>
                                            <th>Keterangan</th>
                                            <th width="19%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($log_report->result() as $row)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{date("d-m-Y H:i:s", strtotime($row->created_at))}}</td>
                                            <td>{{$row->keterangan}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-sm" href="{{base_url() . $ci->uri->segment(2) . '/laporan-survey/download-pdf/' . $row->file}}"><i class="fa fa-file-pdf"></i></a>
                                                <a class="btn btn-primary btn-sm" href="{{base_url() . $ci->uri->segment(2) . '/laporan-survey/download-word/' . $row->file}}"><i class="fa fa-file-word"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a class="btn btn-info btn-block font-weight-bold" href="" data-toggle="modal" data-target="#add">
                            <i class="fa fa-download"></i> Generate Laporan Baru
                        </a>
                    </div>

                @endif --}}

                    <p>
                        Setelah aktivitas survei selesai dan data sudah terkumpul maka Anda dapat mendownload
                        laporan survei. Gunakan tombol dibawah ini untuk mendownload laporan survei Anda.
                    </p>

                    <br>

                    <div class="card-deck">
                        <a href="{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/laporan-survey/download-docx"
                        target="_blank" class="card card-body border border-primary text-primary shadow wave wave-animate-slow wave-primary">
                            <div class="text-center font-weight-bold">
                                <i class="fa fa-file-word text-primary" style="font-size: 30px;"></i><br>
                                <h6 class="mt-3">Download Laporan Survei format .docx</h6>
                            </div>
                        </a>

                        <a href="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/laporan-survey/cetak'}}"
                            class="card card-body text-danger border border-danger shadow wave wave-animate-slow wave-danger"
                            target="_blank">
                            <div class="text-center font-weight-bold">
                                <i class="fa fa-file-pdf text-danger" style="font-size: 30px;"></i><br>
                                <h6 class="mt-3">Download Laporan Survei format .pdf</h5>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="example-modal">
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog border border-primary">
            <div class="modal-content">
                <!-- <div class="modal-header bg-secondary">
                    <h5 class="font-weight-bold">Buat Laporan</h5>
                </div> -->
                <div class="modal-body">

                    <form class="form_submit" method="POST" action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/laporan-survey/generate'}}">
                        <div class="form-group">
                            <label class="form-label font-weight-bold">Keterangan :</label>
                            <textarea class="form-control" name="keterangan" rows="5"></textarea>
                        </div>

                        <div class="text-right mt-5">
                            <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit"><i class="fa fa-download"></i> Generate Laporan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $(document).ready(function(e) {
        $('.form_submit').submit(function(e) {

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                cache: false,
                beforeSend: function() {
                    $('.tombolCancel').attr('disabled', 'disabled');
                    $('.tombolSubmit').attr('disabled', 'disabled');
                    $('.tombolSubmit').html(
                        '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                    Swal.fire({
                        title: 'Memproses data',
                        html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                        allowOutsideClick: false,
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });

                },
                complete: function() {
                    $('.tombolCancel').removeAttr('disabled');
                    $('.tombolSubmit').removeAttr('disabled');
                    $('.tombolSubmit').html('Simpan');
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

                        Swal.fire(
                            'Informasi',
                            'Berhasil Membuat Laporan!',
                            'success'
                        );
                        window.setTimeout(function() {
                            location.reload()
                        }, 1500);

                    }
                }
            })
            return false;
        });
    });
</script>

<script>
    $(document).ready(function() {
        table = $('.example').DataTable();
    });
</script>
@endsection