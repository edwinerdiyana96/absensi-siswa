
    <body class="g-sidenav-show  bg-gray-200">
      <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
          <img src="<?= base_url('assets/img/logos/')?>logo atensi original.png" class="navbar-brand-img h-100" alt="main_logo">
          <span class="ms-1 font-weight-bold text-white">ATENS INDONESIA</span>
        </a>
      </div>
      <hr class="horizontal light mt-0 mb-2">
      <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height : 450px">
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php
            if ($hal=='1') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>

          <li class="nav-item">
            <?php
            if ($hal=='2') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin/karyawan') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
              </div>
              <span class="nav-link-text ms-1">Data Karyawan</span>
            </a>
          </li>


          <li class="nav-item">
            <?php
            if ($hal=='3') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin/interview') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">post_add</i>
              </div>
              <span class="nav-link-text ms-1">Data Reqruitment</span>
            </a>
          </li>

          <li class="nav-item">
            <?php
            if ($hal=='4') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin/interview') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">supervised_user_circle</i>
              </div>
              <span class="nav-link-text ms-1">Data Interview</span>
            </a>
          </li>

          <li class="nav-item">
            <?php
            if ($hal=='5') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin/psikotes') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">view_timeline</i>
              </div>
              <span class="nav-link-text ms-1">Data Psikotes</span>
            </a>
          </li>

          <li class="nav-item">
            <?php
            if ($hal=='6') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('admin/hasil') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">book</i>
              </div>
              <span class="nav-link-text ms-1">Data Hasil </span>
            </a>
          </li>


          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Navbar Laporan</h6>
          </li>
          <li class="nav-item">
            <?php
            if ($hal=='11') { ?>
              <a class="nav-link text-white active bg-gradient-primary"
            <?php }else{ ?>
              <a class="nav-link text-white "
            <?php } ?>
            href="<?= base_url('laporan/reqruitment') ?>">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
              </div>
              <span class="nav-link-text ms-1">Laporan Reqruitment</span>
            </a>
          </li>
          
          <!-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="< ?= base_url() ?>pages/profile.html">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
              </div>
              <span class="nav-link-text ms-1">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="< ?= base_url() ?>pages/sign-in.html">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">login</i>
              </div>
              <span class="nav-link-text ms-1">Sign In</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="< ?= base_url() ?>pages/sign-up.html">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">assignment</i>
              </div>
              <span class="nav-link-text ms-1">Sign Up</span>
            </a>
          </li> -->
        </ul>
      </div>
      <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
          <a class="btn bg-gradient-primary mt-4 w-100" href="<?= base_url('auth/logout') ?>" type="button">Logout</a>
        </div>
      </div>
    </aside>