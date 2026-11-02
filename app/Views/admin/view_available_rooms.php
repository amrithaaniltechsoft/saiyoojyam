<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Available Rooms - Saiyoojyam</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>public/assets/admin/img/favicon/favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/css/demo.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <style>
      :root {
        --theme-primary: #ff561c;
        --theme-primary-hover: #e0440d;
        --theme-primary-light: #fff2ed;
        --theme-primary-border: #ffd8cb;
        --theme-primary-shadow: rgba(255, 86, 28, 0.35);
      }

      body {
        background: #f8fafc;
        font-family: 'Public Sans', sans-serif;
        color: #334155;
      }

      .page-header-card {
        background: linear-gradient(135deg, #ff561c 0%, #ff7033 50%, #e0440d 100%);
        border-radius: 20px;
        color: #fff;
        padding: 24px 30px;
        box-shadow: 0 10px 25px -5px rgba(255, 86, 28, 0.35);
      }

      .date-nav-group {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.18);
        padding: 6px 12px;
        border-radius: 14px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
      }

      .nav-arrow-btn {
        background: rgba(255, 255, 255, 0.22);
        border: none;
        color: #ffffff;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
      }
      .nav-arrow-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: scale(1.05);
      }

      .btn-today {
        background: #ffffff;
        color: #ff561c !important;
        font-weight: 700;
        font-size: 13px;
        padding: 6px 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
      .btn-today:hover {
        background: #fff5f0;
        color: #e0440d !important;
        transform: translateY(-1px);
      }

      /* Date Carousel Strip */
      .date-strip-wrapper {
        background: #ffffff;
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
      }

      .date-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 4px;
      }

      .date-tile {
        flex: 1;
        min-width: 72px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        color: #475569;
      }

      .date-tile:hover {
        transform: translateY(-3px);
        border-color: #ff9f7a;
        background: #ffffff;
        box-shadow: 0 6px 16px rgba(255, 86, 28, 0.18);
        color: #ff561c;
      }

      .date-tile.active {
        background: linear-gradient(135deg, #ff561c 0%, #e0440d 100%);
        color: #ffffff !important;
        border-color: #ff561c;
        box-shadow: 0 8px 20px rgba(255, 86, 28, 0.35);
        transform: scale(1.04);
      }

      .tile-day {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        opacity: 0.85;
        margin-bottom: 2px;
      }

      .tile-num {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
      }

      .tile-month {
        font-size: 11px;
        font-weight: 600;
        opacity: 0.85;
        margin-top: 2px;
      }

      .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      }

      .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
      }

      .stat-icon-theme {
        background: rgba(255, 86, 28, 0.12);
        color: #ff561c;
      }

      .room-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        user-select: none;
      }
      .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(255, 86, 28, 0.16);
        border-color: #ff9f7a;
      }
      .room-card .card-click-hint {
        transition: all 0.2s ease;
      }
      .room-card:hover .card-click-hint {
        color: #ff561c !important;
      }
      .room-card:hover .card-click-hint i {
        transform: scale(1.15);
      }
      
      .modal .modal-header .btn-modal-close {
        position: absolute !important;
        top: 16px !important;
        right: 18px !important;
        width: 34px !important;
        height: 34px !important;
        border-radius: 50% !important;
        background: rgba(255, 255, 255, 0.22) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
        color: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        font-size: 16px !important;
        padding: 0 !important;
        margin: 0 !important;
        z-index: 1070 !important;
      }
      .modal .modal-header .btn-modal-close:hover {
        background: #ffffff !important;
        color: #ff561c !important;
        border-color: #ffffff !important;
        transform: scale(1.08) !important;
      }

      .hover-primary:hover {
        color: #ff561c !important;
      }
      
      .room-card.status-available {
        border-top: 4px solid #10b981;
      }
      .room-card.status-full {
        border-top: 4px solid #ef4444;
        opacity: 0.85;
      }

      .badge-building {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
      }

      .badge-room-type {
        background: #fff2ed;
        color: #e0440d;
        border: 1px solid #ffd8cb;
        font-weight: 600;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
      }

      .progress-bar-custom {
        height: 8px;
        border-radius: 6px;
        background-color: #f1f5f9;
        overflow: hidden;
      }
      .progress-fill {
        height: 100%;
        border-radius: 6px;
        transition: width 0.4s ease;
      }

      .search-box {
        background: #ffffff;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        padding: 8px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
      }
      .search-box:focus-within {
        border-color: #ff561c;
        box-shadow: 0 0 0 3px rgba(255, 86, 28, 0.15);
      }
      .search-box input {
        border: none;
        outline: none;
        box-shadow: none;
      }

      .avail-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
      }
      .avail-pill-success {
        background: #d1fae5;
        color: #047857;
      }
      .avail-pill-danger {
        background: #fee2e2;
        color: #b91c1c;
      }

      .filter-btn-pill {
        border-radius: 50px;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 18px;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
      }
      .filter-btn-pill:hover {
        border-color: #ff561c;
        color: #ff561c;
      }
      .filter-btn-pill.active {
        background: #ff561c;
        border-color: #ff561c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(255, 86, 28, 0.3);
      }
      .filter-btn-pill.btn-avail.active {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      }
      .filter-btn-pill.btn-full.active {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      }
    </style>
  </head>

  <body>
    <?php 
      $total_rooms = count($pagedata);
      $total_capacity = 0;
      $total_occupied = 0;
      $total_available = 0;
      $available_rooms_count = 0;

      foreach($pagedata as $item){
        $total_capacity += $item['capacity'];
        $total_occupied += $item['occupied'];
        $total_available += $item['available'];
        if($item['available'] > 0){
          $available_rooms_count++;
        }
      }

      // Date calculations for date strip navigation
      $current_ts = strtotime($selected_date);
      $prev_date = date('Y-m-d', strtotime('-1 day', $current_ts));
      $next_date = date('Y-m-d', strtotime('+1 day', $current_ts));
      $today_date = date('Y-m-d');

      // Generate 7-day strip centered around selected date
      $date_strip = [];
      for ($i = -3; $i <= 3; $i++) {
        $ts = strtotime("$i days", $current_ts);
        $d_str = date('Y-m-d', $ts);
        $date_strip[] = [
          'formatted'   => $d_str,
          'day_name'    => date('D', $ts),
          'day_num'     => date('j', $ts),
          'month_name'  => date('M', $ts),
          'is_selected' => $d_str === $selected_date,
          'is_today'    => $d_str === $today_date,
        ];
      }
    ?>

    <div class="container-xxl py-4">

      <!-- Header Card -->
      <div class="page-header-card mb-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <h3 class="fw-bold mb-1 text-white"><i class="fa fa-calendar-check-o me-2"></i>Available Rooms Status</h3>
          <p class="mb-0 text-white-50">
            Selected Date: <strong><?php echo date('l, d F Y', strtotime($selected_date)); ?></strong>
          </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
          <a href="<?php echo base_url(); ?>Admin/Dashboard" class="btn btn-sm text-white fw-semibold rounded-pill px-3 py-2 me-1" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); text-decoration: none;">
            <i class="fa fa-th-large me-1"></i> Dashboard
          </a>

          <!-- Date Navigation Buttons -->
          <div class="date-nav-group">
            <button onclick="filterAvailableRooms('<?php echo $prev_date; ?>')" class="nav-arrow-btn" title="Previous Day">
              <i class="fa fa-chevron-left"></i>
            </button>
            <button onclick="filterAvailableRooms('<?php echo $today_date; ?>')" class="btn-today">
              Today
            </button>
            <button onclick="filterAvailableRooms('<?php echo $next_date; ?>')" class="nav-arrow-btn" title="Next Day">
              <i class="fa fa-chevron-right"></i>
            </button>
          </div>

          <!-- Calendar Input Picker -->
          <div class="p-2 rounded-3" style="background: rgba(255, 255, 255, 0.22); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
            <input type="date" id="date_filter" class="form-control form-control-sm border-0 fw-bold text-dark bg-white" 
                   value="<?php echo $selected_date; ?>" onchange="filterAvailableRooms(this.value)" style="width: 150px; border-radius: 8px;" />
          </div>
        </div>
      </div>

      <!-- 7-Day Interactive Date Carousel Strip -->
      <div class="date-strip-wrapper">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="fs-7 fw-bold text-uppercase" style="color: #ff561c;"><i class="fa fa-calendar me-1"></i> Interactive Date Calendar</span>
          <span class="fs-7 text-muted">Click any day to view room availability</span>
        </div>
        <div class="date-strip">
          <?php foreach($date_strip as $tile){ ?>
            <div class="date-tile <?php echo $tile['is_selected'] ? 'active' : ''; ?>" 
                 onclick="filterAvailableRooms('<?php echo $tile['formatted']; ?>')">
              <div class="tile-day"><?php echo $tile['day_name']; ?></div>
              <div class="tile-num"><?php echo $tile['day_num']; ?></div>
              <div class="tile-month"><?php echo $tile['month_name']; ?></div>
            </div>
          <?php } ?>
        </div>
      </div>

      <!-- Stat Cards Row -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 fw-semibold d-block">TOTAL ROOMS</span>
              <h3 class="fw-bold mb-0 mt-1" style="color: #ff561c;"><?php echo $total_rooms; ?></h3>
            </div>
            <div class="stat-icon stat-icon-theme">
              <i class="fa fa-building"></i>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 fw-semibold d-block">AVAILABLE ROOMS</span>
              <h3 class="fw-bold mb-0 mt-1 text-success"><?php echo $available_rooms_count; ?></h3>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
              <i class="fa fa-check-circle"></i>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 fw-semibold d-block">TOTAL CAPACITY</span>
              <h3 class="fw-bold mb-0 mt-1"><?php echo $total_capacity; ?> Beds</h3>
            </div>
            <div class="stat-icon bg-info bg-opacity-10 text-info">
              <i class="fa fa-users"></i>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 fw-semibold d-block">AVAILABLE BEDS</span>
              <h3 class="fw-bold mb-0 mt-1 text-emerald" style="color: #059669;"><?php echo $total_available; ?> Beds</h3>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
              <i class="fa fa-bed"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Search & Filter Bar -->
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="search-box d-flex align-items-center w-100" style="max-width: 380px;">
          <i class="fa fa-search me-2" style="color: #ff561c;"></i>
          <input type="text" id="room_search" class="w-100" placeholder="Search room name or building..." onkeyup="searchRooms()" />
        </div>
        <div class="d-flex gap-2">
          <button class="filter-btn-pill" onclick="filterStatus('all', this)">All</button>
          <button class="filter-btn-pill btn-avail active" id="btn_available" onclick="filterStatus('available', this)">Available Only</button>
          <button class="filter-btn-pill btn-full" onclick="filterStatus('full', this)">Full Only</button>
        </div>
      </div>

      <!-- Room Cards Grid -->
      <div class="row g-3" id="room_cards_container">
        <?php if(!empty($pagedata)){ foreach($pagedata as $page_data){ 
          $pct = $page_data['capacity'] > 0 ? round(($page_data['occupied'] / $page_data['capacity']) * 100) : 0;
          $is_avail = $page_data['available'] > 0;
        ?> 
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3 room-item-col" 
               data-status="<?php echo $is_avail ? 'available' : 'full'; ?>" 
               data-search="<?php echo strtolower($page_data['room_name'].' '.$page_data['building_name'].' '.$page_data['room_type_name']); ?>"
               <?php if(!$is_avail){ echo 'style="display: none;"'; } ?>>
            <div class="room-card p-3 <?php echo $is_avail ? 'status-available' : 'status-full'; ?>"
                 data-room-id="<?php echo $page_data['room_id']; ?>"
                 role="button"
                 title="Click to view details of Room <?php echo esc($page_data['room_name']); ?>">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge-building"><i class="fa fa-building-o me-1"></i><?php echo $page_data['building_name']; ?></span>
                <span class="badge-room-type"><?php echo $page_data['room_type_name']; ?></span>
              </div>

              <div class="my-2 text-center">
                <h4 class="fw-bold mb-1 text-dark"><?php echo $page_data['room_name']; ?></h4>
              </div>

              <div class="my-3">
                <div class="d-flex justify-content-between fs-7 mb-1 text-muted">
                  <span>Occupancy</span>
                  <span class="fw-semibold text-dark"><?php echo $page_data['occupied']; ?> / <?php echo $page_data['capacity']; ?> Beds</span>
                </div>
                <div class="progress-bar-custom">
                  <div class="progress-fill <?php echo $pct >= 100 ? 'bg-danger' : ($pct > 50 ? 'bg-warning' : 'bg-success'); ?>" 
                       style="width: <?php echo min($pct, 100); ?>%;"></div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                <span class="text-muted fs-7">Available:</span>
                <?php if($is_avail){ ?>
                  <span class="avail-pill avail-pill-success">
                    <i class="fa fa-check-circle"></i> <?php echo $page_data['available']; ?> Persons
                  </span>
                <?php } else { ?>
                  <span class="avail-pill avail-pill-danger">
                    <i class="fa fa-times-circle"></i> Full
                  </span>
                <?php } ?>
              </div>

              <div class="card-click-hint text-center mt-2 pt-2 border-top text-muted" style="font-size:11.5px;">
                <span class="fw-semibold"><i class="fa fa-eye me-1"></i> Click to view room details</span>
              </div>
            </div>
          </div>
        <?php } } else { ?>
          <div class="col-12 text-center py-5">
            <h5 class="text-muted">No rooms found.</h5>
          </div>
        <?php } ?>
      </div>

    </div>

    <!-- Room Details & Tariff Modal Start -->
    <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:18px;overflow:hidden;">
          <div class="modal-header text-white p-3 p-md-4 pe-5 position-relative" style="background: linear-gradient(135deg, #ff561c 0%, #e0440d 100%);">
            <div class="d-flex align-items-center gap-3">
              <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);flex-shrink:0;">
                <i class="fa fa-bed" style="font-size:22px;"></i>
              </div>
              <div>
                <h5 class="modal-title fw-bold text-white mb-0" id="roomDetailsModalLabel">
                  <span id="rdm_room_name">Room Details</span>
                </h5>
                <div class="d-flex align-items-center flex-wrap gap-2 mt-1" style="font-size:12.5px;color:rgba(255,255,255,0.95);">
                  <span><i class="fa fa-building-o me-1"></i><span id="rdm_building_name">Building</span></span>
                  <span>•</span>
                  <span><i class="fa fa-tag me-1"></i><span id="rdm_room_type">Type</span></span>
                  <span id="rdm_ac_container" class="d-none">
                    <span>•</span>
                    <span class="badge bg-white text-dark rounded-pill px-2 py-0.5" id="rdm_ac_badge" style="font-size:11px;font-weight:700;">AC</span>
                  </span>
                  <span>•</span>
                  <span class="badge rounded-pill px-2.5 py-1 fw-normal" style="background:#ffffff; color:#334155; font-size:12px; font-weight:500; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                    <i class="fa fa-calendar me-1" style="color:#ff561c;"></i><span id="rdm_date_label"><?php echo date('d M Y', strtotime($selected_date)); ?></span>
                  </span>
                </div>
              </div>
            </div>
            <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
              <i class="fa fa-times"></i>
            </button>
          </div>

          <div class="modal-body p-3 p-md-4" style="background:#f8fafc;">
            <!-- Loading Spinner -->
            <div id="rdm_loading" class="text-center py-5">
              <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;color:#ff561c !important;">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p class="text-muted mt-2 fw-semibold" style="font-size:13px;">Loading room &amp; tariff details...</p>
            </div>

            <!-- Content Area -->
            <div id="rdm_content" class="d-none">
              <!-- 1. Occupancy Breakdown Card -->
              <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;background:#ffffff;">
                <div class="card-body" style="padding:14px 18px;">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark" style="font-size:13px;">
                      <i class="fa fa-pie-chart text-primary me-1"></i> Bed Occupancy Status
                    </span>
                    <span class="badge rounded-pill" id="rdm_occupancy_badge" style="font-size:11px;">Available</span>
                  </div>
                  <div class="row g-2 text-center mb-2">
                    <div class="col-4">
                      <div class="rounded-3 p-2" style="background:#f1f5f9;border:1px solid #e2e8f0;">
                        <div class="text-muted fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;">Capacity</div>
                        <div class="d-flex align-items-baseline justify-content-center gap-1 mt-1">
                          <span class="fw-bold text-dark fs-5" id="rdm_cap_val">0</span>
                          <span class="text-muted fw-semibold" style="font-size:11px;">Beds</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="rounded-3 p-2" style="background:#fef2f2;border:1px solid #fee2e2;">
                        <div class="fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;color:#dc2626;">Occupied</div>
                        <div class="d-flex align-items-baseline justify-content-center gap-1 mt-1">
                          <span class="fw-bold text-danger fs-5" id="rdm_occ_val">0</span>
                          <span class="text-muted fw-semibold" style="font-size:11px;">Beds</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="rounded-3 p-2" style="background:#ecfdf5;border:1px solid #d1fae5;">
                        <div class="fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;color:#059669;">Available</div>
                        <div class="d-flex align-items-baseline justify-content-center gap-1 mt-1">
                          <span class="fw-bold text-success fs-5" id="rdm_avail_val">0</span>
                          <span class="text-muted fw-semibold" style="font-size:11px;">Beds</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="progress" style="height:6px;border-radius:10px;background:#e2e8f0;">
                    <div class="progress-bar" id="rdm_prog_bar" role="progressbar" style="width:0%;border-radius:10px;"></div>
                  </div>
                </div>
              </div>

              <!-- 2. Tariff Details Section -->
              <div class="card border-0 shadow-sm mb-3" style="border-radius:14px;background:#ffffff;">
                <div class="card-header p-3 d-flex align-items-center justify-content-between" style="background:#ffffff;border-bottom:1px solid #f1f5f9;">
                  <span class="fw-bold text-dark" style="font-size:13.5px;">
                    <i class="fa fa-money me-1" style="color:#ff561c;"></i> Room Tariff &amp; Pricing Details
                  </span>
                  <div class="d-flex align-items-center gap-2">
                    <span id="rdm_tariff_status_badge" class="badge rounded-pill" style="font-size:11px;">Tariff Configured</span>
                    <a href="#" id="rdm_edit_tariff_btn" target="_blank" class="btn btn-sm btn-outline-secondary py-0 px-2 d-none" style="font-size:11px;" title="Edit this tariff">
                      <i class="fa fa-pencil"></i> Edit
                    </a>
                  </div>
                </div>
                <div class="card-body p-3">
                  <!-- When Tariff is Added -->
                  <div id="rdm_tariff_exists">
                    <div class="row g-2">
                      <div class="col-sm-4 col-12">
                        <div class="p-3 rounded-3 h-100" style="background:#fff2ed;border:1.5px solid #ffd8cb;">
                          <div class="text-muted fw-semibold" style="font-size:11px;text-transform:uppercase;color:#ea4407 !important;">Monthly Rent / Fee</div>
                          <div class="fw-bold mt-1" style="font-size:22px;color:#ff561c;">
                            ₹<span id="rdm_tariff_price">0.00</span>
                          </div>
                          <small class="text-muted" style="font-size:11px;">per resident / month</small>
                        </div>
                      </div>
                      <div class="col-sm-4 col-6">
                        <div class="p-3 rounded-3 h-100" style="background:#f8fafc;border:1px solid #e2e8f0;">
                          <div class="text-muted fw-semibold" style="font-size:11px;text-transform:uppercase;">Admission Fees</div>
                          <div class="fw-bold text-dark mt-1" style="font-size:18px;">
                            ₹<span id="rdm_tariff_admission">0.00</span>
                          </div>
                          <small class="text-muted" style="font-size:11px;">One-time onboarding</small>
                        </div>
                      </div>
                      <div class="col-sm-4 col-6">
                        <div class="p-3 rounded-3 h-100" style="background:#f8fafc;border:1px solid #e2e8f0;">
                          <div class="text-muted fw-semibold" style="font-size:11px;text-transform:uppercase;">Caution Deposit</div>
                          <div class="fw-bold text-dark mt-1" style="font-size:18px;">
                            ₹<span id="rdm_tariff_deposit">0.00</span>
                          </div>
                          <small class="text-muted" style="font-size:11px;">Refundable security</small>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3 rounded-3 px-3 py-2" style="background:#f1f5f9;border:1px dashed #cbd5e1;font-size:12.5px;padding:10px 16px;">
                      <span class="text-secondary fw-semibold ms-2">Estimated Total Move-in Amount:</span>
                      <strong class="text-dark me-2" style="font-size:14px;">₹<span id="rdm_tariff_total">0.00</span></strong>
                    </div>
                  </div>

                  <!-- When NO Tariff is Added -->
                  <div id="rdm_tariff_none" class="d-none">
                    <div class="p-3 rounded-3 text-center" style="background:#fffbeb;border:1px solid #fde68a;">
                      <i class="fa fa-exclamation-triangle text-warning" style="font-size:26px;"></i>
                      <h6 class="fw-bold text-dark mt-2 mb-1" style="font-size:14px;">No Tariff Added For This Room</h6>
                      <p class="text-muted mb-2" style="font-size:12px;">This room does not currently have custom tariff pricing assigned.</p>
                      <a href="<?= base_url(); ?>Admin/Tariff/Add" id="rdm_add_tariff_btn" target="_blank" class="btn btn-sm btn-outline-warning fw-bold text-dark" style="font-size:12px;border-radius:6px;">
                        <i class="fa fa-plus me-1"></i> Add Tariff for this Room &rarr;
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- 3. Current Inmates in this Room -->
              <div class="card border-0 shadow-sm" style="border-radius:14px;background:#ffffff;">
                <div class="card-header p-3 d-flex align-items-center justify-content-between" style="background:#ffffff;border-bottom:1px solid #f1f5f9;">
                  <span class="fw-bold text-dark" style="font-size:13px;">
                    <i class="fa fa-users text-primary me-1"></i> Current Inmates in this Room (<span id="rdm_inmates_count">0</span>)
                  </span>
                  <small class="text-muted" style="font-size:11px;">Active residents occupying beds</small>
                </div>
                <div class="card-body p-0">
                  <div id="rdm_inmates_table_wrapper" class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:12px;">
                      <thead style="background:#f8fafc;">
                        <tr>
                          <th class="ps-3">Inmate Name</th>
                          <th>UID</th>
                          <th>Phone</th>
                          <th>Check-in</th>
                          <th>Check-out</th>
                          <th class="pe-3">Status</th>
                        </tr>
                      </thead>
                      <tbody id="rdm_inmates_tbody">
                        <!-- Populated via JS -->
                      </tbody>
                    </table>
                  </div>
                  <div id="rdm_no_inmates" class="text-center py-4 text-muted d-none" style="font-size:12.5px;">
                    <i class="fa fa-check-circle text-success" style="font-size:24px;display:block;margin-bottom:4px;"></i>
                    No inmates currently occupying beds in this room. Room is fully vacant.
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-between" style="background:#f8fafc;border-top:1px solid #edf2f7;padding:14px 20px;">
            <div class="d-flex gap-2">
              <a href="#" id="rdm_edit_room_btn" target="_blank" class="btn btn-sm btn-outline-warning text-dark fw-semibold" style="font-size:12px;border-radius:8px;">
                <i class="fa fa-pencil me-1"></i> Edit Room
              </a>
              <a href="<?= base_url(); ?>Admin/Inmates/RentalDetails" target="_blank" class="btn btn-sm btn-outline-primary fw-semibold" style="font-size:12px;border-radius:8px;">
                <i class="fa fa-calendar me-1"></i> Rental Calendar
              </a>
            </div>
            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" style="font-size:12.5px;border-radius:8px;">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Room Details & Tariff Modal End -->

    <!-- Core JS -->
    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>public/assets/admin/vendor/js/bootstrap.js"></script>

    <script>
      $(document).ready(function() {
        filterStatus('available', $('#btn_available'));

        // Click handler on room card to open room details modal
        $(document).on("click", ".room-card", function(e) {
          if ($(e.target).closest("a, button").length) return;
          var roomId = $(this).data("room-id");
          if (!roomId) return;
          var selectedDate = "<?php echo $selected_date; ?>";
          openRoomDetailsModal(roomId, selectedDate);
        });
      });

      function openRoomDetailsModal(roomId, selectedDate) {
        selectedDate = selectedDate || "<?php echo $selected_date; ?>";

        var modalEl = document.getElementById("roomDetailsModal");
        if (modalEl && modalEl.parentNode !== document.body) {
          document.body.appendChild(modalEl);
        }

        $("#rdm_loading").removeClass("d-none");
        $("#rdm_content").addClass("d-none");
        $("#rdm_room_name").text("Loading Room...");

        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        $.ajax({
          url: "<?php echo base_url('Admin/Ajax/RoomDetails'); ?>",
          type: "POST",
          data: {
            room_id: roomId,
            date: selectedDate
          },
          dataType: "json",
          success: function(res) {
            $("#rdm_loading").addClass("d-none");
            if (!res || res.status !== "success" || !res.room) {
              alert(res?.msg || "Failed to load room details.");
              return;
            }

            $("#rdm_content").removeClass("d-none");
            var r = res.room;

            $("#rdm_room_name").text(r.name);
            $("#rdm_building_name").text(r.building_name);
            $("#rdm_room_type").text(r.type_name);
            if (r.ac_type === "AC") {
              $("#rdm_ac_container").removeClass("d-none");
              $("#rdm_ac_badge").text("AC");
            } else {
              $("#rdm_ac_container").addClass("d-none");
            }
            $("#rdm_date_label").text(res.selected_date);

            $("#rdm_cap_val").text(r.capacity);
            $("#rdm_occ_val").text(r.occupied);
            $("#rdm_avail_val").text(r.available);

            var pct = r.occupancy_pct || 0;
            var $bar = $("#rdm_prog_bar");
            $bar.css("width", Math.min(pct, 100) + "%");
            if (pct >= 100) {
              $bar.attr("class", "progress-bar bg-danger");
              $("#rdm_occupancy_badge").attr("class", "badge bg-danger text-white").text("Fully Occupied");
            } else if (pct > 50) {
              $bar.attr("class", "progress-bar bg-warning");
              $("#rdm_occupancy_badge").attr("class", "badge bg-warning text-dark").text("Partially Occupied");
            } else {
              $bar.attr("class", "progress-bar bg-success");
              $("#rdm_occupancy_badge").attr("class", "badge bg-success text-white").text("Available (" + r.available + " Vacant)");
            }

            // Tariff Details Section
            if (res.tariff) {
              var t = res.tariff;
              $("#rdm_tariff_exists").removeClass("d-none");
              $("#rdm_tariff_none").addClass("d-none");
              $("#rdm_tariff_price").text(t.price);
              $("#rdm_tariff_admission").text(t.admission_fees);
              $("#rdm_tariff_deposit").text(t.caution_deposit);
              $("#rdm_tariff_total").text(t.total_initial);
              $("#rdm_tariff_status_badge").attr("class", "badge bg-success text-white").html('<i class="fa fa-check-circle me-1"></i> Tariff Configured');
              $("#rdm_edit_tariff_btn").attr("href", "<?php echo base_url('Admin/Tariff/Edit/'); ?>" + t.id).removeClass("d-none");
            } else {
              $("#rdm_tariff_exists").addClass("d-none");
              $("#rdm_tariff_none").removeClass("d-none");
              $("#rdm_tariff_status_badge").attr("class", "badge bg-warning text-dark").html('<i class="fa fa-exclamation-circle me-1"></i> No Tariff Set');
              $("#rdm_edit_tariff_btn").addClass("d-none");
              var addTariffUrl = "<?php echo base_url('Admin/Tariff/Add'); ?>?room_id=" + encodeURIComponent(r.id) + "&building_id=" + encodeURIComponent(r.building_id || '') + "&room_type_id=" + encodeURIComponent(r.type_id || '');
              $("#rdm_add_tariff_btn").attr("href", addTariffUrl);
            }

            // Inmates
            var inmates = res.inmates || [];
            $("#rdm_inmates_count").text(inmates.length);
            var $tbody = $("#rdm_inmates_tbody");
            $tbody.empty();

            if (inmates.length > 0) {
              $("#rdm_inmates_table_wrapper").removeClass("d-none");
              $("#rdm_no_inmates").addClass("d-none");
              $.each(inmates, function(idx, inm) {
                var inmateViewUrl = "<?php echo base_url('Admin/Inmates/View/'); ?>" + inm.id;
                var rowHtml = "<tr>" +
                  "<td class='ps-3'><a href='" + inmateViewUrl + "' target='_blank' class='fw-bold text-dark text-decoration-none hover-primary'>" + (inm.name || '-') + " <i class='fa fa-external-link text-muted' style='font-size:10px;'></i></a></td>" +
                  "<td><span class='badge bg-light text-dark border'>" + (inm.uid || '-') + "</span></td>" +
                  "<td>" + (inm.phone || '-') + "</td>" +
                  "<td>" + inm.check_in + "</td>" +
                  "<td>" + inm.check_out + "</td>" +
                  "<td class='pe-3'><span class='badge bg-success-subtle text-success border border-success-subtle'>" + inm.status + "</span></td>" +
                  "</tr>";
                $tbody.append(rowHtml);
              });
            } else {
              $("#rdm_inmates_table_wrapper").addClass("d-none");
              $("#rdm_no_inmates").removeClass("d-none");
            }

            // Footer Edit Room Link
            $("#rdm_edit_room_btn").attr("href", "<?php echo base_url('Admin/Rooms/Edit/'); ?>" + r.id);
          },
          error: function(xhr, status, err) {
            $("#rdm_loading").addClass("d-none");
            alert("Error loading room details. Please try again.");
          }
        });
      }

      function filterAvailableRooms(val){
        if(val){
          window.location.href = "<?php echo base_url(); ?>Admin/Rooms/Available?date=" + val;
        }
      }

      function searchRooms() {
        var query = $('#room_search').val().toLowerCase().trim();
        $('.room-item-col').each(function() {
          var searchData = $(this).attr('data-search');
          if (searchData.indexOf(query) !== -1) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }

      function filterStatus(type, btn) {
        $('.filter-btn-pill').removeClass('active');
        $(btn).addClass('active');

        $('.room-item-col').each(function() {
          var status = $(this).attr('data-status');
          if (type === 'all' || status === type) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }
    </script>
  </body>
</html>
