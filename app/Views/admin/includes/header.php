  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Saiyoojyam</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>public/assets/admin/img/favicon/favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/libs/apex-charts/apex-charts.css" />

    <!--datatable cdn-->

    <link rel="stylesheet" href="https://datatables-cdn.com/2.3.1/css/dataTables.dataTables.css" />

    <!--alertify css-->
    <!--<link href="<?php echo base_url(); ?>public/assets/admin/css/alertify.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>


    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Page CSS -->
     

    <!-- Helpers -->
    <script src="<?php echo base_url();?>public/assets/admin/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="<?php echo base_url();?>public/assets/admin/js/config.js"></script>
  </head>

  <style>
    .dropdown-item {
      display: contents;
    }
    .dropdown-menu .dropdown-item {
      display: flex !important;
      align-items: center !important;
      white-space: nowrap !important;
      padding: 8px 16px;
      cursor: pointer;
    }
    .dropdown-menu .dropdown-item i {
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      line-height: 1;
      margin-right: 10px !important;
    }
    .dropdown-menu .dropdown-item span {
      display: inline-block;
      line-height: 1.2;
    }
    .edit_image {
      width: 300px;
      object-fit: contain;
    }

  </style>

   <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?= $this->include('admin/includes/sidebar') ?>

          <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base bx bx-menu icon-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- Quick Links Dropdown Launcher -->
                <li class="nav-item navbar-dropdown dropdown-shortcuts dropdown me-2">
                  <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" title="Quick Links & Shortcuts">
                    <i class="fa fa-th-large" style="font-size:18px;color:#697a8d;"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0" style="width:310px;border-radius:12px;overflow:hidden;border:1px solid #eaeaea;">
                    <li class="dropdown-menu-header" style="background:linear-gradient(135deg, #1e293b 0%, #334155 100%);color:#fff;padding:12px 16px;">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size:13.5px;"><i class="fa fa-bolt me-1 text-warning"></i> Quick Links</span>
                        <span class="badge bg-secondary text-white rounded-pill" style="font-size:11px;">Shortcuts</span>
                      </div>
                    </li>
                    <li class="p-2">
                      <div class="row g-2">
                        <div class="col-6">
                          <a href="<?= base_url(); ?>Admin/Inmates/RentalDetails" target="_blank" class="dropdown-item p-2.5 rounded-3 d-flex flex-column align-items-center text-center h-100" style="border:1px solid #e2e8f0;background:#f8fafc;transition:all 0.2s;">
                            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;display:flex;align-items:center;justify-content:center;margin-bottom:6px;">
                              <i class="fa fa-calendar" style="font-size:17px;"></i>
                            </div>
                            <span class="fw-bold text-dark" style="font-size:12px;">Rental Calendar</span>
                            <small class="text-muted" style="font-size:10.5px;">Monthly Rent</small>
                          </a>
                        </div>
                        <div class="col-6">
                          <a href="<?= base_url(); ?>Admin/Rooms/Available" target="_blank" class="dropdown-item p-2.5 rounded-3 d-flex flex-column align-items-center text-center h-100" style="border:1px solid #ffd8cb;background:#fff9f7;transition:all 0.2s;">
                            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#ff7033,#ff561c);color:#fff;display:flex;align-items:center;justify-content:center;margin-bottom:6px;">
                              <i class="fa fa-bed" style="font-size:17px;"></i>
                            </div>
                            <span class="fw-bold text-dark" style="font-size:12px;">Available Rooms</span>
                            <small class="text-muted" style="font-size:10.5px;">Live Vacancies</small>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-menu-footer text-center border-top" style="background:#f8f9fa;padding:8px;">
                      <a href="<?= base_url(); ?>Admin/Home" class="text-decoration-none fw-semibold" style="color:#64748b;font-size:11.5px;">
                        <i class="fa fa-home me-1"></i> Admin Dashboard
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- Notifications Bell -->
                <?php
                  $hdrModel = new \App\Models\CommonModel();
                  $hdrPendingCount = $hdrModel->checkWhereCount('saiyoojyam_inmates', ['inmates_status' => 'pending']);
                  $hdrPendingList = $hdrPendingCount > 0 ? $hdrModel->getPendingBookingRequests() : [];
                ?>
                <li class="nav-item navbar-dropdown dropdown-notifications dropdown me-3">
                  <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" title="Pending Booking Requests">
                    <i class="fa fa-bell" style="font-size:20px;color:<?php echo ($hdrPendingCount > 0) ? '#ff561c' : '#697a8d'; ?>;"></i>
                    <?php if ($hdrPendingCount > 0): ?>
                      <span class="badge rounded-pill bg-danger position-absolute" style="top:2px;right:-2px;font-size:10px;padding:3px 6px;box-shadow:0 0 0 2px #fff;">
                        <?php echo $hdrPendingCount; ?>
                      </span>
                    <?php endif; ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0" style="width:340px;border-radius:12px;overflow:hidden;border:1px solid #eaeaea;">
                    <li class="dropdown-menu-header" style="background:#ff561c;color:#fff;padding:12px 16px;">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size:14px;"><i class="fa fa-bell me-1"></i> Booking Requests</span>
                        <span class="badge bg-white text-dark rounded-pill fw-bold" style="font-size:11px;"><?php echo $hdrPendingCount; ?> Pending</span>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list" style="max-height:280px;overflow-y:auto;">
                      <?php if (empty($hdrPendingList)): ?>
                        <div class="text-center py-4 text-muted" style="font-size:13px;">
                          <i class="fa fa-check-circle text-success d-block mb-1" style="font-size:24px;"></i>
                          No pending requests
                        </div>
                      <?php else: ?>
                        <ul class="list-group list-group-flush mb-0" style="font-size:12px;">
                          <?php foreach (array_slice($hdrPendingList, 0, 5) as $hp): ?>
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-bottom">
                              <div style="max-width:210px;">
                                <div class="fw-bold text-dark text-truncate"><?php echo esc($hp->inmates_name); ?></div>
                                <div class="text-muted text-truncate" style="font-size:11px;">
                                  <?php echo esc($hp->rooms_name ? 'Room ' . $hp->rooms_name : 'Room #' . $hp->inmates_rooms); ?> · <?php echo esc($hp->building_name ?: 'Hostel'); ?>
                                </div>
                                <div class="text-success fw-bold" style="font-size:11px;">
                                  ₹<?php echo number_format((float)($hp->invoice_paid_amount ?: $hp->invoice_total), 2); ?> (Paid)
                                </div>
                              </div>
                              <a href="<?php echo base_url('Admin/Home#pending-bookings-section'); ?>" class="btn btn-sm text-white" style="background:#ff561c;font-size:11px;padding:4px 10px;border-radius:6px;font-weight:600;">
                                Review
                              </a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                    <li class="dropdown-menu-footer text-center border-top" style="background:#f8f9fa;padding:10px;">
                      <a href="<?php echo base_url('Admin/Home#pending-bookings-section'); ?>" class="text-decoration-none fw-bold" style="color:#ff561c;font-size:12px;">
                        View All Pending Bookings <i class="fa fa-arrow-right ms-1"></i>
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php echo base_url();?>public/assets/admin/img/avatars/user-dummy-img.jpg" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="padding: 10px 16px; min-width: 220px;">
                    <li>
                      <a class="dropdown-item" href="#" style="display: flex !important; align-items: center !important;">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo base_url();?>public/assets/admin/img/avatars/user-dummy-img.jpg" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0 current-user-name-display fw-semibold" style="margin-top: 0;"><?= esc(auth()->user()->username ?? 'Admin') ?></h6>
                            <!--<small class="text-body-secondary">Admin</small>-->
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-2"></div>
                    </li>
                    
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="<?=  base_url();?>Admin/ChangePassword" style="display: flex !important; align-items: center !important; white-space: nowrap !important;">
                        <i class="icon-base bx bx-lock-alt icon-md me-2" style="display: inline-flex !important; align-items: center;"></i><span>Change Password</span>
                      </a>
                    </li>
                    
                    <li>
                      <div class="dropdown-divider my-2"></div>
                    </li>
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="<?= site_url('logout') ?>" onclick="try{sessionStorage.removeItem('admin_pending_alert_shown');}catch(e){}" style="display: flex !important; align-items: center !important; white-space: nowrap !important;">
                        <i class="icon-base bx bx-power-off icon-md me-2 text-danger" style="display: inline-flex !important; align-items: center;"></i><span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->