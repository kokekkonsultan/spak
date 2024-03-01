@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp


@section('style')

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



@endsection

@section('javascript')

@endsection