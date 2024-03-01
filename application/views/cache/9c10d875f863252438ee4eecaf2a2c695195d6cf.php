<?php
$ci = get_instance();
$user_id = $ci->session->userdata('user_id');
$user_now = $ci->ion_auth->user($user_id)->row();
?>



<?php if($ci->session->userdata('aside_minimize') == 2): ?>
<div class="text-center mt-5">
    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center" id="photo_profile">
        <?php if($user_now->foto_profile == NULL): ?>

        <img class="" src="<?php echo e(URL_AUTH); ?>assets/klien/foto_profile/200px.jpg" alt="">
        <?php else: ?>
        <img class="" src="<?php echo e(URL_AUTH); ?>assets/klien/foto_profile/<?php echo $user_now->foto_profile ?>" alt="">
        <?php endif; ?>
        <i class="symbol-badge bg-success"></i>
    </div>
</div>
<?php endif; ?>


<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">

        <ul class="menu-nav">

            <?php
            ($ci->uri->segment(1) == 'dashboard') ? $child_menu_active = 'menu-item-active' : $child_menu_active
            = ''
            ?>

            <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>dashboard" class="menu-link">
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



            <?php
            $group = array('admin')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
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
            ?>



            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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



                        <!-- <?php
                        ($ci->uri->segment(1) == 'klasifikasi-survei') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>klasifikasi-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Klasifikasi Survei</span>
                            </a>
                        </li> -->

                        <?php
                        ($ci->uri->segment(1) == 'jenis-pelayanan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>jenis-pelayanan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Jenis Pelayanan</span>
                            </a>
                        </li>

                        <!--  -->

                        <?php
                        ($ci->uri->segment(1) == 'pertanyaan-unsur-pelayanan') ? $child_menu_active =
                        'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pertanyaan-unsur-pelayanan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanyaan Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'pilihan-jawaban-pertanyaan') ? $child_menu_active =
                        'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>pilihan-jawaban-pertanyaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pilihan Jawaban Pertanyaan</span>
                            </a>
                        </li>

                        <!--  -->


                        <!--  -->


                        <!--  -->

                        <!--  -->



                    </ul>
                </div>
            </li>



            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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



                        <?php
                        ($ci->uri->segment(1) == 'data-survey-klien') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-survey-klien" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Survei Per Klien</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'all-data-survei') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>all-data-survei" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Survei Semua Klien</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </li>
            <?php endif; ?>

            



            <!-- ==================================================== CLIEN ===================================================== -->
            <?php
            $group = array('client')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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

                        <!-- <?php
                        ($ci->uri->segment(2) == 'overview') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/overview'; ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Overview</span>
                            </a>
                        </li> -->

                        <?php
                        ($ci->uri->segment(2) == 'manage-survey') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo base_url() . $ci->session->userdata('username') . '/manage-survey' ?>"
                                class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kelola Survei</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(2) == 'penayang-survei') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
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



            <?php
            ($ci->uri->segment(2) == 'info-berlangganan') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            


            <!-- <?php
            ($ci->uri->segment(2) == 'users-management') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
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


            <?php
            ($ci->uri->segment(1) == 'prosedur-penggunaan-aplikasi') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            
            <?php endif; ?>











            <!-- ==================================================== SURVEYOR ===================================================== -->
            <?php
            $group = array('surveyor')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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

                        <?php
                        ($ci->uri->segment(1) == 'link-per-surveyor') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>link-per-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Link Survey Anda</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'data-perolehan-surveyor') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-perolehan-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Perolehan Surveyor</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'prospek-surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>prospek-surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Prospek</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>


            <?php
            $group = array('supervisor')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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


                        <?php
                        ($ci->uri->segment(2) == 'manage-survey') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
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


            <?php
            ($ci->uri->segment(1) == 'prosedur-penggunaan-aplikasi') ? $menu_active = 'menu-item-active' :
            $menu_active = '';
            ?>
            <li class="menu-item <?php echo e($menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>prosedur-penggunaan-aplikasi" class="menu-link">
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
            <?php endif; ?>




            
            <!-- ==================================================== CLIEN INDUK ===================================================== -->
            <?php
            $group = array('client_induk')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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

                        <?php
                        ($ci->uri->segment(1) == 'data-perolehan-keseluruhan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-perolehan-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'data-perolehan-per-bagian') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>data-perolehan-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            <li class="menu-item <?php echo e(($ci->uri->segment(1) == 'olah-data-per-bagian') ? 'menu-item-active' : ''); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>olah-data-per-bagian" class="menu-link">
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



            <?php
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
            ?>

            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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

                        <?php
                        ($ci->uri->segment(1) == 'olah-data-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>olah-data-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'history-nilai-per-periode') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>history-nilai-per-periode" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">History Nilai Per Periode</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>




            <?php
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
            ?>
            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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

                        <?php
                        ($ci->uri->segment(1) == 'rekap-hasil-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>rekap-hasil-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'rekap-hasil-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>rekap-hasil-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>



            <?php
            $group = array('client_induk');
            ($ci->uri->segment(1) == 'laporan-induk') ? $child_menu_active = 'menu-item-active' :
            $child_menu_active = '';
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                <a href="<?php echo e(base_url()); ?>laporan-induk" class="menu-link">
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
                    <span class="menu-text">Laporan</span>
                </a>
            </li>
            <?php endif; ?>




            


            <?php
            $group = array('client_induk')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
            $menu_master = ['e-sertifikat-per-bagian', 'e-sertifikat-keseluruhan'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>
            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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
                    <span class="menu-text">E-Sertifikat</span>
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

                        <?php
                        ($ci->uri->segment(1) == 'e-sertifikat-keseluruhan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>e-sertifikat-keseluruhan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Keseluruhan</span>
                            </a>
                        </li>

                        <?php
                        ($ci->uri->segment(1) == 'e-sertifikat-per-bagian') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>e-sertifikat-per-bagian" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Per Bagian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>


			<?php
            $group = array('client_induk')
            ?>
            <?php if($ci->ion_auth->in_group($group)): ?>
            <?php
            $menu_master = ['paket-berlangganan', 'kuota-jumlah-responden'];
            $uri_selected = $ci->uri->segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            ?>
            <li class="menu-item menu-item-submenu <?php echo e($main_menu_active); ?>" aria-haspopup="true"
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
                    <span class="menu-text">Status Berlangganan</span>
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

                        <?php
                        ($ci->uri->segment(1) == 'paket-berlangganan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>paket-berlangganan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Paket Berlangganan</span>
                            </a>
                        </li>
                        
						<?php
                        ($ci->uri->segment(1) == 'kuota-jumlah-responden') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        ?>
                        <li class="menu-item <?php echo e($child_menu_active); ?>" aria-haspopup="true">
                            <a href="<?php echo e(base_url()); ?>kuota-jumlah-responden" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kuota Jumlah Responden</span>
                            </a>
                        </li>

                        
                    </ul>
                </div>
            </li>
            <?php endif; ?>


        </ul>
    </div>
</div><?php /**PATH D:\Htdocs MAMP\surveiku_spak\application\views/include_backend/partials_backend/_aside_menu.blade.php ENDPATH**/ ?>