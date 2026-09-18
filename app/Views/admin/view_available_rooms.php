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
      body {
        background: #f0f2f5;
        font-family: 'Public Sans', sans-serif;
        color: #334155;
      }

      .page-header-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 20px;
        color: #fff;
        padding: 24px 30px;
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
      }

      .date-nav-group {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 12px;
        border-radius: 14px;
        backdrop-filter: blur(10px);
      }

      .nav-arrow-btn {
        background: rgba(255, 255, 255, 0.2);
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
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.05);
      }

      .btn-today {
        background: #ffffff;
        color: #4f46e5 !important;
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
        background: #f8fafc;
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
        border-color: #818cf8;
        background: #ffffff;
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.12);
        color: #4f46e5;
      }

      .date-tile.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff !important;
        border-color: #4f46e5;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
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

      .room-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }
      .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
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
        background: #e0e7ff;
        color: #4338ca;
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
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
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
          <div class="bg-white bg-opacity-20 p-2 rounded-3" style="backdrop-filter: blur(10px);">
            <input type="date" id="date_filter" class="form-control form-control-sm border-0 fw-bold text-dark" 
                   value="<?php echo $selected_date; ?>" onchange="filterAvailableRooms(this.value)" style="width: 150px;" />
          </div>
        </div>
      </div>

      <!-- 7-Day Interactive Date Carousel Strip -->
      <div class="date-strip-wrapper">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="fs-7 fw-bold text-muted text-uppercase"><i class="fa fa-calendar me-1"></i> Interactive Date Calendar</span>
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
              <h3 class="fw-bold mb-0 mt-1"><?php echo $total_rooms; ?></h3>
            </div>
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
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
          <i class="fa fa-search text-muted me-2"></i>
          <input type="text" id="room_search" class="w-100" placeholder="Search room name or building..." onkeyup="searchRooms()" />
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="filterStatus('all', this)">All</button>
          <button class="btn btn-outline-success btn-sm rounded-pill active px-3" id="btn_available" onclick="filterStatus('available', this)">Available Only</button>
          <button class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="filterStatus('full', this)">Full Only</button>
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
            <div class="room-card p-3 <?php echo $is_avail ? 'status-available' : 'status-full'; ?>">
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
            </div>
          </div>
        <?php } } else { ?>
          <div class="col-12 text-center py-5">
            <h5 class="text-muted">No rooms found.</h5>
          </div>
        <?php } ?>
      </div>

    </div>

    <!-- Core JS -->
    <script src="<?php echo base_url();?>public/assets/admin/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>public/assets/admin/vendor/js/bootstrap.js"></script>

    <script>
      $(document).ready(function() {
        filterStatus('available', $('#btn_available'));
      });

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
        $('.d-flex.gap-2 button').removeClass('active');
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
