@php
$ci = get_instance();
$user_id = $ci->session->userdata('user_id');
$user_now = $ci->ion_auth->user($user_id)->row();
@endphp



@if ($ci->session->userdata('aside_minimize') == 2)
<div class="text-center mt-5">
    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center" id="photo_profile">
        <!-- <div class="text-center symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center"> -->
        @if ($user_now->foto_profile == NULL)
        <!-- <div class="symbol-label" style="background-image:url('{{ base_url() }}assets/klien/foto_profile/200px.jpg')"></div> -->

        <img class="" src="{{ base_url() }}assets/klien/foto_profile/200px.jpg" alt="">
        @else
        <img class="" src="{{ base_url() }}assets/klien/foto_profile/<?php echo $user_now->foto_profile ?>" alt="">
        @endif
        <i class="symbol-badge bg-success"></i>
    </div>
</div>
@endif


<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">

        <ul class="menu-nav">

            @php
            ($ci->uri->segment(1) == 'dashboard') ? $child_menu_active = 'menu-item-active' : $child_menu_active
            = ''
            @endphp

            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}dashboard" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>


            @php
            ($ci->uri->segment(1) == 'inbox') ? $child_menu_active = 'menu-item-active' : $child_menu_active =
            ''
            @endphp

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}inbox" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Kontak Masuk</span>
                </a>
            </li>
            @endif

            @php
            ($ci->uri->segment(1) == 'reseller-request') ? $child_menu_active = 'menu-item-active' :
            $child_menu_active
            = ''
            @endphp

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}reseller-request" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Permintaan Reseller</span>
                </a>
            </li>
            @endif

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['website-configuration', 'banner', 'article-post', 'article-category-post',
            'list-link-article', 'image-upload'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover" style="display: none; ">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Website</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        @php
                        ($ci->uri->segment(1) == 'website-configuration') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}website-configuration" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Konfigurasi Website</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'banner') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}banner" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Slide Banner</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'article-post') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}article-post" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Artikel</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'article-category-post') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}article-category-post" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kategori Artikel</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'list-link-article') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}list-link-article" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">List Link Artikel</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'image-upload') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}image-upload" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Upload Gambar/ Foto</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            @endif

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['klasifikasi-survei', 'jenis-pelayanan', 'unsur-pelayanan', 'pertanyaan-terbuka',
            'pertanyaan-unsur-pelayanan', 'perincian-pertanyaan-terbuka', 'review-pertanyaan-unsur',
            'pilihan-jawaban-pertanyaan',
            'pertanyaan-harapan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp



            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Master</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        @php
                        ($ci->uri->segment(1) == 'klasifikasi-survei') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}klasifikasi-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Klasifikasi Survei</span>
                            </a>
                        </li>

                        <!-- @php
                        ($ci->uri->segment(1) == 'jenis-pelayanan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}jenis-pelayanan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Jenis Pelayanan</span>
                            </a>
                        </li> -->

                        <!-- {{-- @php
                        ($ci->uri->segment(1) == 'unsur-pelayanan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}unsur-pelayanan" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Unsur Pelayanan</span>
                        </a>
                        </li> --}} -->

                        @php
                        ($ci->uri->segment(1) == 'pertanyaan-unsur-pelayanan') ? $child_menu_active =
                        'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pertanyaan-unsur-pelayanan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanyaan Survei</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'pilihan-jawaban-pertanyaan') ? $child_menu_active =
                        'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pilihan-jawaban-pertanyaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pilihan Jawaban Pertanyaan</span>
                            </a>
                        </li>

                        <!-- {{-- @php
                        ($ci->uri->segment(1) == 'pertanyaan-harapan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}pertanyaan-harapan" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Pertanyaan Harapan</span>
                        </a>
                        </li> --}} -->


                        <!-- {{-- @php
                        ($ci->uri->segment(1) == 'pertanyaan-terbuka') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}pertanyaan-terbuka" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Pertanyaan Tambahan</span>
                        </a>
                        </li> --}} -->


                        <!-- {{-- @php
                        ($ci->uri->segment(1) == 'perincian-pertanyaan-terbuka') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}perincian-pertanyaan-terbuka" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Perincian Pertanyaan Terbuka</span>
                        </a>
                        </li> --}} -->

                        <!-- {{-- @php
                        ($ci->uri->segment(1) == 'review-pertanyaan-unsur') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}review-pertanyaan-unsur" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Review Pertanyaan</span>
                        </a>
                        </li> --}} -->



                    </ul>
                </div>
            </li>
            @endif

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['unsur-skm', 'nilai-skm', 'profil-responden', 'profil-responden-kuesioner'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">SPAK</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <!-- {{-- @php
                                ($ci->uri->segment(1) == 'unsur-skm') ? $child_menu_active = 'menu-item-active' : $child_menu_active = '';
                            @endphp
                            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}unsur-skm" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Unsur SKM</span>
                        </a>
                        </li> --}} -->

                        @php
                        ($ci->uri->segment(1) == 'nilai-skm') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}nilai-skm" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Nilai SPAK</span>
                            </a>
                        </li>

                        <!-- {{--@php
            ($ci->uri->segment(1) == 'profil-responden') ? $child_menu_active = 'menu-item-active' : $child_menu_active
            = '';
            @endphp
            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}profil-responden" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Profil Responden</span>
                        </a>
            </li>

            @php
            ($ci->uri->segment(1) == 'profil-responden-kuesioner') ? $child_menu_active = 'menu-item-active' :
            $child_menu_active = '';
            @endphp
            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}profil-responden-kuesioner" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Profil Responden Kuesioner</span>
                </a>
            </li>--}} -->




                    </ul>
                </div>
            </li>
            @endif



            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['auth', 'pengguna-administrator', 'pengguna-klien', 'pengguna-surveyor',
            'pengguna-reseller', 'pengguna-klien-induk'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Pengguna</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        @php
                        ($ci->uri->segment(1) == 'pengguna-administrator') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pengguna-administrator" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Administrator</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'pengguna-klien-induk') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pengguna-klien-induk" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Klien Induk</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'pengguna-klien') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pengguna-klien" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Klien</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'pengguna-surveyor') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pengguna-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Surveyor</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'pengguna-reseller') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}pengguna-reseller" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengguna Reseller</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['paket', 'berlangganan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Berlangganan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        @php
                        ($ci->uri->segment(1) == 'paket') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active
                        = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}paket" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Paket</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'berlangganan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active
                        = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}berlangganan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Berlangganan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['data-survey-klien', 'all-data-survei'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Klien</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>



                        @php
                        ($ci->uri->segment(1) == 'data-survey-klien') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}data-survey-klien" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Survei Per Klien</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'all-data-survei') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}all-data-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Survei Semua Klien</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </li>
            @endif


            @php
            $group = array('admin')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            ($ci->uri->segment(1) == 'pengaturan') ? $child_menu_active = 'menu-item-active' :
            $child_menu_active = ''
            @endphp

            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}pengaturan" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Settings-1.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z"
                                    fill="#000000" />
                                <path
                                    d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Pengaturan</span>
                </a>
            </li>
            @endif

            <!-- {{-- @php
				$group = array('admin')
			@endphp
			@if ($ci->ion_auth->in_group($group))
				@php
				$menu_master = ['jenissurvey'];
			    $uri_selected = $ci->uri->segment(1);

			    $link_active = '';
			    if (in_array($uri_selected, $menu_master)) {

			        $main_menu_active = "menu-item-open menu-item-here";
			        $parent_menu_active = "menu-item-open menu-item-here";

			    } else {
			        $main_menu_active = "";
			        $parent_menu_active = "";
			    }
				@endphp

				<li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true" data-menu-toggle="hover">
            <a href="javascript:;" class="menu-link menu-toggle">
                <span class="svg-icon menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                                d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                fill="#000000" />
                            <rect fill="#000000" opacity="0.3"
                                transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                        </g>
                    </svg>
                </span>
                <span class="menu-text">Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <i class="menu-arrow"></i>
                <ul class="menu-subnav">
                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                        <span class="menu-link">
                            <span class="menu-text">Themes</span>
                        </span>
                    </li>

                    @php
                    ($ci->uri->segment(1) == 'jenissurvey') ? $child_menu_active = 'menu-item-active' :
                    $child_menu_active = '';
                    @endphp
                    <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                        <a href="{{ base_url() }}jenissurvey" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Pengaturan Web</span>
                        </a>
                    </li>


                </ul>
            </div>
            </li>
            @endif --}} -->


            @php
            $group = array('client')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['overview', 'manage-survey', 'penayang-survei'];
            $uri_selected = $ci->uri->segment(2);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Survei</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        <!-- @php
                        ($ci->uri->segment(2) == 'overview') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/overview'; ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Overview</span>
                            </a>
                        </li> -->

                        @php
                        ($ci->uri->segment(2) == 'manage-survey') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/manage-survey' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kelola Survei</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(2) == 'penayang-survei') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Penayang Survei</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            @php
            ($ci->uri->segment(2) == 'info-berlangganan') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            @endphp
            {{--<li class="menu-item {{ $menu_active }}" aria-haspopup="true">
                <a href="<?php echo base_url() . $ci->session->userdata('username') . '/info-berlangganan' ?>"
                    class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-receipt-cutoff" viewBox="0 0 20 20">
                            <path
                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                            <path
                                d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z" />
                        </svg>
                    </span>
                    <span class="menu-text">Info Berlangganan</span>
                </a>
            </li>--}}


            <!-- @php
            ($ci->uri->segment(2) == 'users-management') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            @endphp
            <li class="menu-item {{ $menu_active }}" aria-haspopup="true">
                <a href="<?php echo base_url() . $ci->session->userdata('username') . '/users-management' ?>"
                    class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-people-fill" viewBox="0 0 20 20">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            <path fill-rule="evenodd"
                                d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                        </svg>
                    </span>
                    <span class="menu-text">Kelola Pengguna</span>
                </a>
            </li> -->


            @php
            ($ci->uri->segment(1) == 'prosedur-penggunaan-aplikasi') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            @endphp
            {{--<li class="menu-item {{ $menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}prosedur-penggunaan-aplikasi" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path
                                    d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z"
                                    fill="#000000"></path>
                                <path
                                    d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z"
                                    fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Prosedur Penggunaan Aplikasi</span>
                </a>
            </li>--}}
            @endif











            @php
            $group = array('surveyor')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['link-survey-surveyor', 'data-perolehan-surveyor'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Surveyor</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'link-per-surveyor') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}link-per-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Link Survey Anda</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'data-perolehan-surveyor') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}data-perolehan-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Perolehan Surveyor</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'prospek-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}prospek-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Prospek</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif


            @php
            $group = array('supervisor')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['overview', 'manage-survey', 'prosedur-penggunaan-aplikasi'];
            $uri_selected = $ci->uri->segment(2);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Survei</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        ($ci->uri->segment(2) == 'overview') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/overview'; ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Overview</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(2) == 'manage-survey') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/manage-survey' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kelola Survei</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            @php
            ($ci->uri->segment(1) == 'prosedur-penggunaan-aplikasi') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            @endphp
            <li class="menu-item {{ $menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}prosedur-penggunaan-aplikasi" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path
                                    d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z"
                                    fill="#000000"></path>
                                <path
                                    d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z"
                                    fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Prosedur Penggunaan Aplikasi</span>
                </a>
            </li>
            @endif


            @php
            $group = array('reseller')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['list-klien'];
            $uri_selected = $ci->uri->segment(2);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            @php
            ($ci->uri->segment(1) == 'list-klien') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            @endphp
            <li class="menu-item {{ $menu_active }}" aria-haspopup="true">
                <a href="{{ base_url() }}list-klien" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-list-task" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z" />
                            <path
                                d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z" />
                            <path fill-rule="evenodd"
                                d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z" />
                        </svg>
                    </span>
                    <span class="menu-text">List Klien</span>
                </a>
            </li>
            @endif


            @php
            $group = array('client_induk')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['data-perolehan-keseluruhan', 'data-perolehan-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Data Perolehan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'data-perolehan-keseluruhan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}data-perolehan-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'data-perolehan-per-bagian') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}data-perolehan-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif


            @php
            $group = array('client_induk')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            <li class="menu-item {{ ($ci->uri->segment(1) == 'olah-data-per-bagian') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ base_url() }}olah-data-per-bagian" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Olah Data Per Bagian</span>
                </a>
            </li>


            <!-- <li class="menu-item {{ ($ci->uri->segment(1) == 'olah-data-keseluruhan') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ base_url() }}olah-data-keseluruhan" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Nilai Indeks</span>
                </a>
            </li>

            <li class="menu-item {{ ($ci->uri->segment(1) == 'olah-data-keseluruhan') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ base_url() }}olah-data-keseluruhan" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                    fill="#000000" fill-rule="nonzero" />
                                <path
                                    d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">History Nilai Per Periode</span>
                </a>
            </li> -->
            @endif


            @php
            $group = array('client_induk')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['olah-data-keseluruhan', 'history-nilai-per-periode'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Nilai Indeks</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'olah-data-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}olah-data-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'history-nilai-per-periode') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}history-nilai-per-periode" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">History Nilai Per Periode</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif



            @php
            $group = array('client_induk')
            @endphp
            @if ($ci->ion_auth->in_group($group))
            @php
            $menu_master = ['rekap-hasil-keseluruhan', 'rekap-hasil-per-bagian'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp
            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true"
                data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000" />
                                <rect fill="#000000" opacity="0.3"
                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Rekap Hasil</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'rekap-hasil-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}rekap-hasil-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        @php
                        ($ci->uri->segment(1) == 'rekap-hasil-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="{{ base_url() }}rekap-hasil-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif


        </ul>
    </div>
</div>