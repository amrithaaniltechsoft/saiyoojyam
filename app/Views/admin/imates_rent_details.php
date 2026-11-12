<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Monthly Rental Calendar - Saiyoojyam</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>public/assets/admin/img/favicon/favicon.png" />

  <!-- Google Fonts: Public Sans (Dashboard Typography) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Core Dashboard CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/vendor/css/core.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>public/assets/admin/css/demo.css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- jQuery & Vendors -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" rel="stylesheet"/>

  <style>
  :root {
    --theme-primary: #ff561c;
    --theme-primary-hover: #e0440d;
    --theme-primary-light: #fff2ed;
    --theme-primary-border: #ffd8cb;
    --theme-primary-shadow: rgba(255, 86, 28, 0.35);
    --theme-dark: #1e293b;
    --theme-slate: #334155;
    --theme-bg: #f8fafc;
  }

  body {
    font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8fafc;
    color: #334155;
    margin: 0;
    padding: 0;
  }

  /* Dashboard Header Banner */
  .page-header-card {
    background: linear-gradient(135deg, #ff561c 0%, #ff7033 50%, #e0440d 100%);
    border-radius: 20px;
    color: #fff;
    padding: 22px 28px;
    box-shadow: 0 10px 25px -5px rgba(255, 86, 28, 0.35);
  }
  .header-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #ffffff;
    flex-shrink: 0;
  }
  .btn-dashboard-nav {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff !important;
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
  }
  .btn-dashboard-nav:hover {
    background: rgba(255, 255, 255, 0.35);
    transform: translateY(-1px);
    color: #ffffff !important;
  }

  /* Status Legend Card */
  .legend-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 10px 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  }
  .legend-pill {
    display: inline-flex;
    align-items: center;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
  }
  .pill-paid { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
  .pill-partial { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
  .pill-advance { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
  .pill-unpaid { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
  .pill-vacated { background: #e2e8f0; color: #334155; border: 1px solid #94a3b8; font-weight: 700; }

  /* Filter Toolbar Card */
  .filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 14px 18px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
  }
  .search-input-wrapper {
    position: relative;
    width: 290px;
    max-width: 100%;
  }
  .search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
    pointer-events: none;
  }
  .rental-search-control {
    padding: 7px 32px 7px 36px !important;
    font-size: 13.5px !important;
    border-radius: 10px !important;
    border: 1.5px solid #cbd5e1 !important;
    background: #ffffff !important;
    color: #1e293b !important;
    transition: all 0.2s ease !important;
  }
  .rental-search-control:focus {
    border-color: #ff561c !important;
    box-shadow: 0 0 0 3px rgba(255, 86, 28, 0.18) !important;
    outline: none !important;
  }
  .clear-search-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #94a3b8;
    font-size: 15px;
    display: none;
    cursor: pointer;
    padding: 2px 4px;
  }
  .clear-search-btn:hover {
    color: #dc2626;
  }
  .rental-select {
    height: auto;
    padding: 7px 34px 7px 12px !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    border-radius: 10px !important;
    border: 1.5px solid #cbd5e1 !important;
    background-color: #ffffff !important;
    color: #1e293b !important;
    cursor: pointer;
    transition: all 0.2s ease !important;
  }
  .rental-select:focus {
    border-color: #ff561c !important;
    box-shadow: 0 0 0 3px rgba(255, 86, 28, 0.18) !important;
    outline: none !important;
  }
  .btn-theme-primary {
    background: linear-gradient(135deg, #ff561c 0%, #e0440d 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 10px;
    padding: 7px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(255, 86, 28, 0.25);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none !important;
  }
  .btn-theme-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(255, 86, 28, 0.35);
    color: #ffffff !important;
  }
  .btn-theme-reset {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 7px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none !important;
  }
  .btn-theme-reset:hover {
    background: #e2e8f0;
    color: #1e293b !important;
    border-color: #94a3b8;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  /* Metric Stat Cards for Monthly View */
  .stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
  }
  .stat-card .stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .stat-total .stat-icon { background: #f1f5f9; color: #334155; }
  .stat-paid .stat-icon { background: #dcfce7; color: #16a34a; }
  .stat-partial .stat-icon { background: #fef9c3; color: #b45309; }
  .stat-unpaid .stat-icon { background: #fee2e2; color: #dc2626; }
  .stat-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 2px;
  }
  .stat-value {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
  }

  /* Table Card Wrappers */
  .table-card-wrapper {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    overflow: hidden;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    font-size: 13px;
    margin: 0;
  }
  #calendarTable th:first-child,
  #calendarTable td:first-child {
    width: 18.4%;
    min-width: 220px;
  }
  #calendarTable th:not(:first-child),
  #calendarTable td:not(:first-child) {
    width: 6.8%;
    min-width: 72px;
  }
  th {
    background: #1e293b;
    color: #ffffff;
    padding: 12px 14px;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    text-align: center;
  }
  th:first-child {
    text-align: left;
    padding-left: 18px;
  }
  td {
    border: 1px solid #f1f5f9;
    padding: 10px 12px;
    text-align: center;
    vertical-align: middle;
    transition: background 0.15s ease;
  }
  td:first-child {
    text-align: left;
    padding-left: 18px;
  }
  tr:nth-child(even) td {
    background: #fbfcfe;
  }
  tr:hover td {
    background: #f1f5f9 !important;
  }

  /* Month Status Cell Highlights */
  .paid {
    background: #dcfce7 !important;
    color: #15803d !important;
    font-weight: 600;
  }
  .paid:hover {
    background: #bbf7d0 !important;
  }
  .unpaid {
    background: #fee2e2 !important;
    color: #b91c1c !important;
    font-weight: 600;
  }
  .unpaid:hover {
    background: #fecaca !important;
  }
  .partial {
    background: #fef9c3 !important;
    color: #a16207 !important;
    font-weight: 600;
  }
  .partial:hover {
    background: #fef08a !important;
  }
  .advance {
    background: #e0f2fe !important;
    color: #0369a1 !important;
    font-weight: 600;
  }
  .advance:hover {
    background: #bae6fd !important;
  }
  .vacated, td.vacated {
    background: #e2e8f0 !important;
    color: #475569 !important;
    font-weight: 600;
  }
  .vacated:hover, td.vacated:hover {
    background: #cbd5e1 !important;
  }
  .vacated a, td.vacated a {
    color: inherit;
    text-decoration: none;
    display: block;
    font-weight: 700;
  }
  tr.row-vacated td {
    background: #f1f5f9;
    color: #475569;
  }
  tr.row-vacated td:first-child {
    background: #e2e8f0 !important;
    border-right: 2px solid #cbd5e1;
  }
  tr.row-vacated td.vacated {
    background: #e2e8f0 !important;
    color: #64748b !important;
  }
  tr.row-vacated:hover td {
    background: #e2e8f0;
  }
  tr.row-vacated:hover td.vacated {
    background: #cbd5e1 !important;
  }
  tr.row-vacated td a {
    color: inherit;
    opacity: .85;
  }
  .paid a, .partial a, .unpaid a, .advance a, .vacated a {
    color: inherit;
    text-decoration: none;
    display: block;
    font-weight: 700;
  }

  /* Inmate Action Buttons */
  .btn-receipt-action {
    background: #ff561c;
    color: #ffffff !important;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 6px;
    text-decoration: none !important;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
  }
  .btn-receipt-action:hover {
    background: #e0440d;
    transform: translateY(-1px);
    color: #ffffff !important;
  }
  .btn-checkout-theme {
    background: #dc2626;
    color: #ffffff;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
  }
  .btn-checkout-theme:hover {
    background: #b91c1c;
    transform: translateY(-1px);
  }

  /* Checkout Modal Styling */
  .checkout-option-card {
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .checkout-option-card:hover:not(.disabled) {
    border-color: #cbd5e1;
    background: #f8fafc;
  }
  .checkout-option-card.active {
    border-color: #dc2626 !important;
    background: #fff5f5 !important;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.08);
  }
  .checkout-option-card.disabled {
    opacity: 0.65 !important;
    background: #f8fafc !important;
    border: 1.5px dashed #cbd5e1 !important;
    cursor: not-allowed !important;
  }
  .checkout-option-card.disabled * {
    cursor: not-allowed !important;
  }
  .modal .modal-header .btn-modal-close {
    position: absolute !important;
    top: 16px !important;
    right: 18px !important;
    transform: none !important;
    margin: 0 !important;
    z-index: 10700 !important;
    opacity: 1 !important;
    width: 34px !important;
    height: 34px !important;
    padding: 0 !important;
    border-radius: 50% !important;
    background: rgba(255, 255, 255, 0.22) !important;
    border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
    color: #ffffff !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
  }
  .modal .modal-header .btn-modal-close:hover {
    background: #ffffff !important;
    color: #dc2626 !important;
    border-color: #ffffff !important;
    transform: scale(1.08) !important;
  }
  .modal .modal-header .btn-modal-close::before {
    display: none !important;
  }

  /* Fancy Flatpickr Popup Calendar Styling */
  .flatpickr-calendar {
    z-index: 10650 !important;
    border-radius: 16px !important;
    border: 1.5px solid #fed7aa !important;
    box-shadow: 0 14px 38px rgba(0, 0, 0, 0.16), 0 4px 14px rgba(220, 38, 38, 0.12) !important;
    overflow: hidden !important;
    background: #ffffff !important;
    width: 320px !important;
    animation: fpFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
  }
  @keyframes fpFadeIn {
    from { opacity: 0; transform: translateY(-8px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
  }
  .flatpickr-calendar .flatpickr-months {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    padding: 10px 8px !important;
  }
  .flatpickr-calendar .flatpickr-month {
    color: #ffffff !important;
    fill: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-current-month {
    font-size: 15px !important;
    font-weight: 700 !important;
  }
  .flatpickr-calendar .flatpickr-current-month .cur-month {
    font-weight: 700 !important;
    color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-current-month input.cur-year {
    font-weight: 700 !important;
    color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-day.selected,
  .flatpickr-calendar .flatpickr-day.selected:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    color: #ffffff !important;
  }
  .input-group > .flatpickr-wrapper {
    flex: 1 1 auto;
    width: 1%;
  }
  .input-group > .flatpickr-wrapper > input {
    width: 100% !important;
    border-radius: 0 !important;
  }
</style>
</head>
<body>

<div class="container-fluid px-3 px-xl-4 py-3">

  <!-- 1. Header Card (Matches Saiyoojyam Dashboard Theme) -->
  <div class="page-header-card mb-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div class="header-icon-box">
        <i class="fa fa-calendar-check-o"></i>
      </div>
      <div>
        <h3 class="fw-bold mb-1 text-white">Saiyoojyam Rental Calendar</h3>
        <p class="mb-0 text-white-50" style="font-size:13.5px;">Resident monthly rental collection, invoices & checkout management</p>
      </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      <button type="button" id="toggleFullscreenBtn" class="btn-dashboard-nav" title="Toggle Full Screen View (F11)">
        <i class="fa fa-arrows-alt me-1.5" id="fullscreenIcon"></i> <span id="fullscreenText">Full Screen</span>
      </button>
      <a href="<?php echo base_url(); ?>Admin/Home" class="btn-dashboard-nav">
        <i class="fa fa-th-large me-1.5"></i> Dashboard
      </a>
      <a href="<?php echo base_url(); ?>Admin/Inmates" class="btn-dashboard-nav">
        <i class="fa fa-users me-1.5"></i> Inmates
      </a>
      <a href="<?php echo base_url(); ?>Admin/Rooms/Available" class="btn-dashboard-nav">
        <i class="fa fa-bed me-1.5"></i> Available Rooms
      </a>
    </div>
  </div>

  <!-- 2. Status Legend Pill Strip -->
  <div class="legend-card mb-3">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
      <span class="text-uppercase fw-bold text-muted" style="font-size:11px;letter-spacing:0.5px;">
        <i class="fa fa-tag me-1 text-primary"></i> Payment Legend:
      </span>
      <div class="d-flex align-items-center flex-wrap gap-2">
        <span class="legend-pill pill-paid"><i class="fa fa-check-circle me-1"></i> Paid</span>
        <span class="legend-pill pill-partial"><i class="fa fa-clock-o me-1"></i> Partial</span>
        <span class="legend-pill pill-advance"><i class="fa fa-rocket me-1"></i> Advance</span>
        <span class="legend-pill pill-unpaid"><i class="fa fa-exclamation-circle me-1"></i> Unpaid</span>
        <span class="legend-pill pill-vacated"><i class="fa fa-sign-out me-1"></i> Checked Out</span>
      </div>
    </div>
  </div>

  <!-- 3. Filter Toolbar Card -->
  <div class="filter-card mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2.5">
      <!-- Search Input -->
      <div class="search-input-wrapper">
        <i class="fa fa-search search-icon"></i>
        <input type="text" id="rentalSearchInput" class="form-control rental-search-control" placeholder="Search inmate, UID, room, phone...">
        <button type="button" id="clearSearchBtn" class="clear-search-btn" title="Clear search">
          <i class="fa fa-times-circle"></i>
        </button>
      </div>

      <div class="d-flex align-items-center flex-wrap gap-2">
        <!-- Year Select -->
        <select id="yearSelect" class="form-select rental-select year_clz" title="Select Calendar Year" style="width: auto;"></select>

        <!-- Month Select -->
        <select class="form-select rental-select month_clz" title="Select Month View" style="width: auto;">
          <option value="" selected>Yearly Calendar (All Months)</option>
          <?php foreach($month as $mon){ ?> 
            <option value="<?php echo $mon->month_id;?>"><?php echo $mon->month_short;?> (<?php echo $mon->month_name ?? $mon->month_short;?>)</option>
          <?php } ?>
        </select>

        <!-- Building Select -->
        <select class="form-select rental-select build_clz" title="Select Building" style="width: auto;">
          <option value="all" selected>All Buildings</option>
          <?php foreach($building as $build){ ?>
            <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
          <?php } ?>
        </select>

        <!-- Status Select (Shown in monthly view) -->
        <select class="form-select rental-select status_clz" style="display: none; width: auto;" title="Filter by Payment Status">
          <option value="all" selected>All Payment Statuses</option>
          <option value="unpaid">Unpaid & Partial Only</option>
          <option value="unpaid_only">Strictly Unpaid Only</option>
          <option value="paid">Paid Only</option>
          <option value="partial">Partial Only</option>
          <option value="advance">Advance Only</option>
        </select>

        <!-- Reset Button -->
        <a href="<?php echo base_url();?>Admin/Inmates/RentalDetails" id="btnResetFilters" class="btn-theme-reset" title="Reset all filters and view to default">
          <i class="fa fa-refresh me-1.5"></i> Reset
        </a>

        <!-- Yearly Report Button -->
        <a href="<?php echo base_url();?>Admin/Inmates/RentalDetails" id="btnYearlyReport" class="btn-theme-primary" title="View full 12-month calendar">
          <i class="fa fa-calendar me-1.5"></i> Yearly Report
        </a>
      </div>
    </div>
  </div>

  <!-- 4. Monthly Summary Stat Cards (Displayed when a month is selected) -->
  <div id="summaryBanner" style="display:none;" class="mb-4">
    <div class="row g-3 justify-content-center">
      <div class="col-6 col-md-3">
        <div class="stat-card stat-total">
          <div class="stat-icon"><i class="fa fa-users"></i></div>
          <div>
            <div class="stat-label">Total Inmates</div>
            <div class="stat-value" id="sumTotal">0</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card stat-paid">
          <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
          <div>
            <div class="stat-label">Paid</div>
            <div class="stat-value text-success" id="sumPaid">0</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card stat-partial">
          <div class="stat-icon"><i class="fa fa-clock-o"></i></div>
          <div>
            <div class="stat-label">Partial</div>
            <div class="stat-value text-warning" id="sumPartial">0</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card stat-unpaid">
          <div class="stat-icon"><i class="fa fa-exclamation-circle"></i></div>
          <div>
            <div class="stat-label">Unpaid</div>
            <div class="stat-value text-danger" id="sumUnpaid">0</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 5. Table 1: 12-Month Yearly Calendar Table -->
  <div id="calendarCard" class="table-card-wrapper mb-4">
    <div class="table-responsive">
      <table id="calendarTable">
        <thead>
          <tr>
            <th style="min-width: 220px;">Inmate Details</th>
            <?php foreach($month as $mon){ ?> 
              <th style="min-width: 78px;"><?php echo $mon->month_short;?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody class="tbody_data">
          <?php foreach($inmates as $inmate){ 
            $todayDate = date('Y-m-d');
            $hasCheckout = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date != '0000-00-00');
            $isFutureCheckout = ($hasCheckout && $inmate->inmates_check_out_date > $todayDate);
            $isCheckedOut = ($inmate->inmates_status === 'checked_out' || ($hasCheckout && $inmate->inmates_check_out_date <= $todayDate));
            $checkInDate = (!empty($inmate->inmates_check_in_date) && $inmate->inmates_check_in_date != '0000-00-00') ? $inmate->inmates_check_in_date : null;
            $isShortTerm = ((int)($inmate->inmates_duration_of_stay ?? 0) === 1);
            $oneMonthDate = (!$isShortTerm && $checkInDate) ? date('Y-m-d', strtotime($checkInDate . ' + 1 month')) : null;
            $canCheckoutToday = $isShortTerm ? (empty($checkInDate) || $todayDate >= $checkInDate) : (empty($oneMonthDate) || ($todayDate >= $oneMonthDate));
            $roomName = !empty($inmate->rooms_name) ? $inmate->rooms_name : (!empty($inmate->inmates_rooms) ? 'Room ' . $inmate->inmates_rooms : 'Assigned Room');
            $coDate = $hasCheckout ? strtotime($inmate->inmates_check_out_date) : 0;
            $coYear = $hasCheckout ? (int)date('Y', $coDate) : 0;
            $coMonth = $hasCheckout ? (int)date('m', $coDate) : 0;
          ?> 
            <tr <?php if($isCheckedOut){ echo 'class="row-vacated"'; } ?>>
              <td>
                <div class="fw-bold text-dark" style="font-size:13.5px;"><?php echo htmlspecialchars($inmate->inmates_name); ?></div>
                <small class="text-muted font-monospace"><?php echo htmlspecialchars($inmate->inmates_uid); ?></small>
                <?php if($isCheckedOut) { ?>
                  <br/><span style="font-size:11px;color:#dc2626;font-weight:600;">
                    <i class="fa fa-sign-out"></i> Out: <?php echo date('d-M-Y', $coDate); ?>
                  </span>
                <?php } elseif($isFutureCheckout) { ?>
                  <br/>
                  <div style="display:inline-flex;align-items:center;gap:4px;margin-top:3px;">
                    <span style="font-size:11px;background:#e0f2fe;color:#0369a1;padding:2px 7px;border-radius:6px;font-weight:600;border:1px solid #bae6fd;" title="Scheduled Upcoming Check Out">
                      <i class="fa fa-calendar-check-o"></i> <?php echo date('d-M-Y', strtotime($inmate->inmates_check_out_date)); ?>
                    </span>
                    <button type="button" class="btn-checkout-trigger"
                      data-inmate-id="<?php echo $inmate->inmates_id; ?>"
                      data-inmate-name="<?php echo esc($inmate->inmates_name); ?>"
                      data-inmate-uid="<?php echo esc($inmate->inmates_uid); ?>"
                      data-inmate-room="<?php echo esc($roomName); ?>"
                      data-is-short-term="<?php echo $isShortTerm ? '1' : '0'; ?>"
                      data-checkin-date="<?php echo !empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-'; ?>"
                      data-checkin-raw="<?php echo $inmate->inmates_check_in_date ?? ''; ?>"
                      data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
                      data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
                      data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
                      data-current-checkout="<?php echo $inmate->inmates_check_out_date; ?>"
                      title="Reschedule departure date"
                      style="border:1px solid #0284c7;background:#fff;color:#0284c7;border-radius:5px;padding:1px 6px;font-size:11px;cursor:pointer;">
                      <i class="fa fa-pencil"></i>
                    </button>
                  </div>
                <?php } else { ?>
                  <br/>
                  <button type="button" class="btn-checkout-theme btn-checkout-trigger"
                    data-inmate-id="<?php echo $inmate->inmates_id; ?>"
                    data-inmate-name="<?php echo esc($inmate->inmates_name); ?>"
                    data-inmate-uid="<?php echo esc($inmate->inmates_uid); ?>"
                    data-inmate-room="<?php echo esc($roomName); ?>"
                    data-is-short-term="<?php echo $isShortTerm ? '1' : '0'; ?>"
                    data-checkin-date="<?php echo !empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-'; ?>"
                    data-checkin-raw="<?php echo $inmate->inmates_check_in_date ?? ''; ?>"
                    data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
                    data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
                    data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
                    data-current-checkout=""
                    style="margin-top:4px;">
                    <i class="fa fa-sign-out me-1"></i> Check Out
                  </button>
                <?php } ?>
              </td>

              <?php  
                $invoiceMonths = [];
                foreach($inmate->invoice as $inv){  
                    $parts = explode('-', $inv->invoice_payment_month);
                    $month = (int)$parts[1];
                    $year  = (int)$parts[0];  
                    $invoiceMonths[$month] = [
                        'month'         => $inv->invoice_payment_month,
                        'amount'        => (float)$inv->invoice_paid_amount,
                        'rent'          => (float)$inv->invoice_rent,
                        'status'        => (int)$inv->invoice_status, 
                    ];
                }
               
                $currentMonth = (int)date('m');
                $currentYear  = (int)date('Y');
                $yearToShow = $currentYear;
                $ciDate = strtotime($inmate->inmates_check_in_date);
                $ciYear = (int)date('Y', $ciDate);
                $ciMonth = (int)date('m', $ciDate);
                $ciDay = (int)date('j', $ciDate);

                $stayRent = 0.0;
                if ($ciDay >= 21) {
                  $daysInCiMonth = cal_days_in_month(CAL_GREGORIAN, $ciMonth, $ciYear);
                  $stayDays = $daysInCiMonth - $ciDay + 1;
                  $tariffPrice = !empty($inmate->tariffs_price) ? (float)$inmate->tariffs_price : 0.0;
                  if ($tariffPrice <= 0 && isset($invoiceMonths[$ciMonth + 1])) {
                    $invRent = (float)$invoiceMonths[$ciMonth + 1]['rent'];
                    $tariffPrice = $invRent / (1 + ($stayDays / $daysInCiMonth));
                  }
                  $stayRent = round($stayDays * ($tariffPrice / $daysInCiMonth), 2);
                }

                for ($m = 1; $m <= 12; $m++) {

                  if(($yearToShow > $currentYear) || (($yearToShow < $ciYear) || ($yearToShow == $ciYear && $m < $ciMonth))){
                    echo '<td></td>';
                    continue;
                  }

                  $invData = null;
                  $cellTitle = '';

                  if ($ciDay >= 21 && $yearToShow == $ciYear && $m == $ciMonth) {
                    $nextM = ($ciMonth == 12) ? 1 : ($ciMonth + 1);
                    if (isset($invoiceMonths[$nextM])) {
                      $invData = [
                        'amount' => number_format($stayRent, 2, '.', ''),
                        'status' => $invoiceMonths[$nextM]['status']
                      ];
                      $cellTitle = 'title="Stay Rent: ₹' . number_format($stayRent, 2) . ' (Paid with next month)"';
                    }
                  } elseif ($ciDay >= 21 && $yearToShow == $ciYear && $m == ($ciMonth + 1) && isset($invoiceMonths[$m])) {
                    $inv = $invoiceMonths[$m];
                    $remAmount = max(0, $inv['amount'] - $stayRent);
                    $invData = [
                      'amount' => number_format($remAmount, 2, '.', ''),
                      'status' => $inv['status']
                    ];
                    $cellTitle = 'title="Monthly Rent & Fees: ₹' . number_format($remAmount, 2) . '"';
                  } elseif (isset($invoiceMonths[$m])) {
                    $invData = $invoiceMonths[$m];
                  }

                  $isAfterCheckout = false;
                  if ($hasCheckout && $isCheckedOut) {
                    if ($yearToShow > $coYear || ($yearToShow == $coYear && $m > $coMonth)) {
                      $isAfterCheckout = true;
                    }
                  }

                  if (!empty($invData)) {

                    if ($invData['status'] == 1) {
                      echo '<td class="paid"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';
                    } 
                    elseif($invData['status'] == 2) {
                      echo '<td class="partial"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';
                    }
                    elseif($invData['status'] == 3) {
                      echo '<td class="advance"><a ' . $cellTitle . ' href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';
                    }
                    else{
                      if ($isAfterCheckout) {
                        echo '<td class="vacated" title="Checked Out on ' . date('d-M-Y', $coDate) . '">---</td>';
                      } elseif($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {
                        echo '<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';
                      } 
                      else {
                        echo '<td></td>'; 
                      }
                    }

                  } 
                  else {
                    if ($isAfterCheckout) {
                      echo '<td class="vacated" title="Checked Out on ' . date('d-M-Y', $coDate) . '">---</td>';
                    } elseif ($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {
                      echo '<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>'; 
                    } 
                    else {
                      echo '<td></td>'; 
                    }
                  }
                  
                }

              ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 6. Table 2: Monthly Building Table (Displayed when Month or Building is selected) -->
  <div id="buildingCard" class="table-card-wrapper mb-4" style="display:none;">
    <div class="table-responsive">
      <table id="buildingTable">
        <thead>
          <tr>
            <th style="width: 4%; text-align: center;">#</th>
            <th style="width: 20%;">Inmate Name</th>
            <th style="width: 17%;">Room & Type</th>
            <th style="width: 13%;">Phone Number</th>
            <th style="width: 10%; text-align: right;">Rent (₹)</th>
            <th style="width: 10%; text-align: right;">Paid (₹)</th>
            <th style="width: 10%; text-align: right;">Balance (₹)</th>
            <th style="width: 9%; text-align: center;">Status</th>
            <th style="width: 7%; text-align: center;">Action</th>
          </tr>
        </thead>
        <tbody class="inmates_details">
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
  alertify.set('notifier','position', 'top-center');
</script>

<!-- Inmate Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;max-height:92vh;display:flex;flex-direction:column;">
      <div class="modal-header text-white pe-5 position-relative" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);padding:18px 22px;">
        <div class="d-flex align-items-center gap-2.5">
          <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);flex-shrink:0;">
            <i class="fa fa-sign-out" style="font-size:18px;color:#fff;"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-white mb-0" id="checkoutModalLabel">Check Out Inmate</h5>
            <small style="font-size:11.5px;color:rgba(255,255,255,0.9);">Select departure date for resident</small>
          </div>
        </div>
        <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <form id="checkoutForm" method="POST" action="<?php echo base_url('Admin/Inmates/CheckOut'); ?>">
        <input type="hidden" name="inmates_id" id="co_inmate_id" value="">
        <input type="hidden" name="is_ajax" value="1">
        
        <div class="modal-body p-4" style="overflow-y:auto;max-height:calc(92vh - 130px);">
          <!-- Inmate Info Banner -->
          <div class="p-3 mb-3 rounded-3" style="background:#f8faff;border:1.5px solid #e0e7ff;">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="fw-bold text-dark" id="co_inmate_name" style="font-size:15px;">Inmate Name</span>
              <span class="badge bg-danger font-monospace" id="co_inmate_uid">IN000000</span>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 text-muted" style="font-size:12px;">
              <span><i class="fa fa-bed me-1 text-danger"></i><span id="co_inmate_room">Room</span></span>
              <span>•</span>
              <span id="co_inmate_duration" class="badge bg-light text-dark border">Long Term</span>
              <span>•</span>
              <span><i class="fa fa-calendar-check-o me-1 text-primary"></i>Check-in: <strong id="co_inmate_checkin" class="text-dark">-</strong></span>
              <span id="co_min_stay_wrap">
                <span>•</span>
                <span><i class="fa fa-calendar-o me-1 text-success"></i>1-Mo Minimum Stay: <strong id="co_inmate_min_date" class="text-dark">-</strong></span>
              </span>
            </div>
          </div>

          <!-- 1-Month Policy Warning (shown when today < 1 month) -->
          <div id="co_policy_warning" class="alert alert-warning py-2.5 px-3 mb-3 d-none" style="font-size:12px;border-radius:8px;">
            <div class="d-flex align-items-start gap-2">
              <i class="fa fa-exclamation-triangle text-warning mt-0.5" style="font-size:15px;"></i>
              <div>
                <strong>1-Month Minimum Stay Policy:</strong>
                <div id="co_policy_warning_text">Inmates can check out only after 1 month from check-in date.</div>
              </div>
            </div>
          </div>

          <!-- Checkout Question -->
          <label class="form-label fw-bold text-dark mb-2" style="font-size:13px;">When would you like to process check out?</label>
          
          <div class="d-flex flex-column gap-2.5 mb-3">
            <!-- Option 1: Checkout Today -->
            <label class="checkout-option-card d-flex align-items-start gap-3 p-3 rounded-3 cursor-pointer" id="card_co_today">
              <input type="radio" name="checkout_type" value="today" id="radio_co_today" class="form-check-input mt-1" checked style="accent-color:#dc2626;">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between">
                  <span class="fw-bold text-dark" style="font-size:13.5px;">Check Out Today</span>
                  <span id="co_today_badge" class="badge bg-danger rounded-pill px-2.5 py-1" style="font-size:11px;"><?php echo date('d-M-Y'); ?></span>
                </div>
                <small class="text-muted d-block mt-0.5" id="co_today_desc" style="font-size:11.5px;">Mark resident as departed immediately today and free up the bed.</small>
              </div>
            </label>

            <!-- Option 2: Select Upcoming Date -->
            <label class="checkout-option-card d-flex align-items-start gap-3 p-3 rounded-3 cursor-pointer" id="card_co_upcoming">
              <input type="radio" name="checkout_type" value="upcoming" id="radio_co_upcoming" class="form-check-input mt-1" style="accent-color:#dc2626;">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between">
                  <span class="fw-bold text-dark" style="font-size:13.5px;">Select Upcoming Date</span>
                  <span class="badge rounded-pill px-2.5 py-1" style="font-size:11px;background:#e0f2fe;color:#0369a1;">Scheduled Departure</span>
                </div>
                <small class="text-muted d-block mt-0.5" style="font-size:11.5px;">Set a future departure date. The resident remains active in their room until this date.</small>
                
                <!-- Upcoming Date Input Container -->
                <div id="upcoming_date_container" class="mt-2.5 d-none">
                  <label class="form-label text-muted fw-semibold mb-1" style="font-size:11.5px;">Choose Upcoming Check-Out Date</label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-danger ps-3 pe-2" id="co_input_icon" style="border-radius:10px 0 0 10px;border-color:#fca5a5;cursor:pointer;">
                      <i class="fa fa-calendar-check-o" style="font-size:16px;"></i>
                    </span>
                    <input type="text" name="upcoming_checkout_date" id="co_upcoming_date" class="form-control" placeholder="Click to choose departure date" readonly>
                    <button type="button" class="btn btn-danger px-3" id="btn_open_calendar" title="Choose Date" style="border-radius:0 10px 10px 0;font-size:12.5px;">
                      <i class="fa fa-calendar me-1"></i> Pick Date
                    </button>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-1 px-0.5">
                    <small id="upcoming_date_help" class="text-muted" style="font-size:11px;">
                      <i class="fa fa-info-circle me-1 text-primary"></i>Click input or button to choose date.
                    </small>
                    <span id="co_badge_quick_indicator" class="badge rounded-pill" style="font-size:10.5px;background:#fee2e2;color:#dc2626;">
                      Min 1-Month Stay
                    </span>
                  </div>
                </div>
              </div>
            </label>
          </div>

          <!-- Error Alert -->
          <div id="co_error_alert" class="alert alert-danger py-2 px-3 mt-2 mb-0 d-none" style="font-size:12px;border-radius:8px;"></div>
        </div>

        <div class="modal-footer p-3 bg-light d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:8px;font-size:13px;">Cancel</button>
          <button type="submit" id="btn_submit_checkout" class="btn btn-danger fw-bold px-4" style="border-radius:8px;font-size:13px;">
            <i class="fa fa-check me-1"></i> Confirm Check Out
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
$(document).ready(function () {
    var globalToday = '<?php echo date('Y-m-d'); ?>';
    var globalTodayFmt = '<?php echo date('d-M-Y'); ?>';
    var checkoutPicker = null;

    function formatDateYMD(d) {
      return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    function updateHelperInfo(dateStr, checkinRaw) {
      if (!dateStr) return;
      if (checkinRaw) {
        var cParts = checkinRaw.split('-');
        var cDate = new Date(parseInt(cParts[0], 10), parseInt(cParts[1], 10) - 1, parseInt(cParts[2], 10));
        var pParts = dateStr.split('-');
        var pDate = new Date(parseInt(pParts[0], 10), parseInt(pParts[1], 10) - 1, parseInt(pParts[2], 10));
        var diffDays = Math.round((pDate.getTime() - cDate.getTime()) / (1000 * 3600 * 24));
        if (diffDays > 0) {
          $('#upcoming_date_help').html('<i class="fa fa-calendar-check-o text-success me-1"></i>Scheduled stay duration: <strong>' + diffDays + ' days</strong>');
        } else {
          $('#upcoming_date_help').html('<i class="fa fa-info-circle text-primary me-1"></i>Departure date selected.');
        }
      } else {
        $('#upcoming_date_help').html('<i class="fa fa-info-circle text-primary me-1"></i>Departure date selected.');
      }
    }

    // Open checkout modal when clicking Check Out trigger button
    $(document).on('click', '.btn-checkout-trigger', function(e) {
      e.preventDefault();
      var id = $(this).data('inmate-id');
      var name = $(this).data('inmate-name');
      var uid = $(this).data('inmate-uid');
      var room = $(this).data('inmate-room');
      var checkin = $(this).data('checkin-date');
      var checkinRaw = $(this).data('checkin-raw');
      var isShortTerm = $(this).data('is-short-term') == '1';
      var oneMonth = $(this).data('one-month');
      var oneMonthFmt = $(this).data('one-month-fmt');
      var canToday = $(this).data('can-today') == '1';
      var currentCheckout = $(this).data('current-checkout');

      $('#co_inmate_id').val(id);
      $('#co_inmate_name').text(name || 'Inmate');
      $('#co_inmate_uid').text(uid || 'ID');
      $('#co_inmate_room').text(room ? 'Room ' + room : 'Assigned Room');
      $('#co_inmate_checkin').text(checkin || '-');
      $('#co_error_alert').addClass('d-none').text('');

      if (isShortTerm) {
        $('#co_inmate_duration').removeClass('bg-secondary bg-primary').addClass('bg-info text-dark').html('<i class="fa fa-clock-o me-1"></i>Short Term Stay');
        $('#co_min_stay_wrap').addClass('d-none');
        canToday = (!checkinRaw || globalToday >= checkinRaw);
      } else {
        $('#co_inmate_duration').removeClass('bg-info text-dark').addClass('bg-primary text-white').html('<i class="fa fa-calendar me-1"></i>Long Term Stay');
        $('#co_min_stay_wrap').removeClass('d-none');
        if (!oneMonth && checkinRaw) {
          var ciParts = checkinRaw.split('-');
          var ciD = new Date(parseInt(ciParts[0], 10), parseInt(ciParts[1], 10) - 1, parseInt(ciParts[2], 10));
          ciD.setMonth(ciD.getMonth() + 1);
          oneMonth = formatDateYMD(ciD);
          oneMonthFmt = String(ciD.getDate()).padStart(2, '0') + '-' + ciD.toLocaleString('en-US', {month: 'short'}) + '-' + ciD.getFullYear();
          canToday = (globalToday >= oneMonth);
        }
        $('#co_inmate_min_date').text(oneMonthFmt || '-');
      }

      $('#checkoutForm').data('can-today', canToday ? '1' : '0');
      $('#checkoutForm').data('one-month', oneMonth);
      $('#checkoutForm').data('one-month-fmt', oneMonthFmt);
      $('#checkoutForm').data('checkin-fmt', checkin);
      $('#checkoutForm').data('checkin-raw', checkinRaw);
      $('#checkoutForm').data('is-short-term', isShortTerm ? '1' : '0');
      $('#checkoutForm').data('current-checkout', currentCheckout);

      var tomorrowD = new Date();
      tomorrowD.setDate(tomorrowD.getDate() + 1);
      var tomorrowStr = formatDateYMD(tomorrowD);
      var hasFutureCheckout = (currentCheckout && currentCheckout > globalToday);
      var effectiveMinDate;
      if (isShortTerm) {
        effectiveMinDate = (checkinRaw && checkinRaw > globalToday) ? checkinRaw : globalToday;
      } else {
        if (hasFutureCheckout) {
          effectiveMinDate = (oneMonth && oneMonth > currentCheckout) ? oneMonth : currentCheckout;
        } else {
          effectiveMinDate = canToday ? tomorrowStr : oneMonth;
        }
      }
      var initialSelectedDate = (currentCheckout && currentCheckout >= effectiveMinDate) ? currentCheckout : (canToday ? (isShortTerm ? globalToday : tomorrowStr) : effectiveMinDate);

      if (checkoutPicker) {
        checkoutPicker.destroy();
      }

      checkoutPicker = flatpickr('#co_upcoming_date', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd-M-Y (l)',
        altInputClass: 'form-control border-start-0 border-end-0 fw-bold text-dark fancy-datepicker-input',
        minDate: effectiveMinDate,
        defaultDate: initialSelectedDate,
        static: true,
        monthSelectorType: 'static',
        prevArrow: '<i class="fa fa-chevron-left" style="font-size:12px;color:#ffffff;"></i>',
        nextArrow: '<i class="fa fa-chevron-right" style="font-size:12px;color:#ffffff;"></i>',
        onChange: function(selectedDates, dateStr) {
          updateHelperInfo(dateStr, checkinRaw);
        }
      });

      updateHelperInfo(initialSelectedDate, checkinRaw);

      if (!isShortTerm && hasFutureCheckout) {
        // LONG TERM INMATE ALREADY HAS SCHEDULED UPCOMING DEPARTURE
        var curParts = currentCheckout.split('-');
        var curD = new Date(parseInt(curParts[0], 10), parseInt(curParts[1], 10) - 1, parseInt(curParts[2], 10));
        var currentCheckoutFmt = String(curD.getDate()).padStart(2, '0') + '-' + curD.toLocaleString('en-US', {month: 'short'}) + '-' + curD.getFullYear();

        $('#co_policy_warning').removeClass('d-none');
        $('#co_policy_warning_text').html('Scheduled departure date is <strong>' + currentCheckoutFmt + '</strong>. Dates before ' + currentCheckoutFmt + ' are disabled.');

        // Disable "Check Out Today" option
        $('#radio_co_today').prop('disabled', true).prop('checked', false);
        $('#card_co_today').addClass('disabled').removeClass('active');
        $('#co_today_badge').removeClass('bg-danger').addClass('bg-secondary').html('<i class="fa fa-lock me-1"></i>Scheduled: ' + currentCheckoutFmt);
        $('#co_today_desc').html('<span class="text-danger fw-semibold">Departure already scheduled for ' + currentCheckoutFmt + '. Check out today is disabled.</span>');

        // Auto-select "Select Upcoming Date"
        $('#radio_co_upcoming').prop('disabled', false).prop('checked', true).trigger('change');
        $('#card_co_upcoming').addClass('active');

        $('#co_badge_quick_indicator').html('<i class="fa fa-calendar-check-o me-1"></i>Scheduled: ' + currentCheckoutFmt).removeClass('bg-success bg-danger text-white').addClass('bg-info text-white');
      } else if (!canToday) {
        $('#co_policy_warning').removeClass('d-none');
        if (isShortTerm) {
          $('#co_policy_warning_text').html('Check out is allowed on or after the check-in date (<strong>' + checkin + '</strong>).');
        } else {
          $('#co_policy_warning_text').html('Inmates can check out only after 1 month from check-in date (' + checkin + '). Earliest eligible check-out date is <strong>' + oneMonthFmt + '</strong>.');
        }

        $('#radio_co_today').prop('disabled', true).prop('checked', false);
        $('#card_co_today').addClass('disabled').removeClass('active');
        $('#co_today_badge').removeClass('bg-danger').addClass('bg-secondary').html('<i class="fa fa-lock me-1"></i>Locked');
        $('#co_today_desc').html(isShortTerm ? '<span class="text-danger fw-semibold">Check-in date is in future (' + checkin + ').</span>' : '<span class="text-danger fw-semibold">Not allowed. Must complete 1 month stay (eligible on or after ' + oneMonthFmt + ').</span>');

        $('#radio_co_upcoming').prop('disabled', false).prop('checked', true).trigger('change');
        $('#card_co_upcoming').addClass('active');

        $('#co_badge_quick_indicator').html(isShortTerm ? '<i class="fa fa-calendar me-1"></i>Check-in: ' + checkin : '<i class="fa fa-lock me-1"></i>Min: ' + oneMonthFmt).removeClass('bg-success text-white').addClass('bg-danger text-white');
      } else {
        $('#co_policy_warning').addClass('d-none');

        $('#radio_co_today').prop('disabled', false);
        $('#card_co_today').removeClass('disabled');
        $('#co_today_badge').removeClass('bg-secondary').addClass('bg-danger').text(globalTodayFmt);
        $('#co_today_desc').text('Mark resident as departed immediately today and free up the bed.');

        if (isShortTerm) {
          var curCheckoutFmt = '';
          if (hasFutureCheckout) {
            var curParts = currentCheckout.split('-');
            var curD = new Date(parseInt(curParts[0], 10), parseInt(curParts[1], 10) - 1, parseInt(curParts[2], 10));
            curCheckoutFmt = ' (Current: ' + String(curD.getDate()).padStart(2, '0') + '-' + curD.toLocaleString('en-US', {month: 'short'}) + '-' + curD.getFullYear() + ')';
          }
          $('#co_badge_quick_indicator').html('<i class="fa fa-clock-o me-1"></i>Short Term Stay' + curCheckoutFmt).removeClass('bg-danger bg-success text-white').addClass('bg-info text-white');

          if (hasFutureCheckout) {
            $('#radio_co_upcoming').prop('disabled', false).prop('checked', true).trigger('change');
            $('#card_co_upcoming').addClass('active');
            $('#card_co_today').removeClass('active');
          } else {
            $('#radio_co_today').prop('checked', true).trigger('change');
            $('#card_co_today').addClass('active');
            $('#card_co_upcoming').removeClass('active');
          }
        } else {
          $('#co_badge_quick_indicator').html('<i class="fa fa-check-circle me-1"></i>1-Mo Policy Satisfied').removeClass('bg-danger bg-info text-white').addClass('bg-success text-white');
          $('#radio_co_today').prop('checked', true).trigger('change');
          $('#card_co_today').addClass('active');
          $('#card_co_upcoming').removeClass('active');
        }
      }

      var modalEl = document.getElementById('checkoutModal');
      if (modalEl && modalEl.parentNode !== document.body) {
        document.body.appendChild(modalEl);
      }
      var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
    });

    $(document).on('click', '#btn_open_calendar, #co_input_icon', function(e) {
      e.preventDefault();
      if (checkoutPicker) {
        checkoutPicker.open();
      }
    });

    $(document).on('change', 'input[name="checkout_type"]', function() {
      if ($(this).is(':disabled')) return;
      var val = $(this).val();
      $('.checkout-option-card').removeClass('active');
      $(this).closest('.checkout-option-card').addClass('active');

      if (val === 'upcoming') {
        $('#upcoming_date_container').removeClass('d-none');
        if (checkoutPicker) {
          checkoutPicker.redraw();
        }
      } else {
        $('#upcoming_date_container').addClass('d-none');
      }
    });

    $(document).on('click', '.checkout-option-card', function(e) {
      if ($(this).hasClass('disabled') || $(this).find('input[type="radio"]').is(':disabled')) {
        e.preventDefault();
        return false;
      }
      if (e.target.tagName !== 'INPUT') {
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
      }
    });

    $('#checkoutForm').on('submit', function(e) {
      e.preventDefault();
      var $form = $(this);
      var $btn = $('#btn_submit_checkout');
      var origText = $btn.html();

      var isShortTerm = $form.data('is-short-term') == '1';
      var canToday = $form.data('can-today') == '1';
      var oneMonth = $form.data('one-month');
      var oneMonthFmt = $form.data('one-month-fmt');
      var checkinFmt = $form.data('checkin-fmt');
      var checkinRaw = $form.data('checkin-raw');
      var currentCheckout = $form.data('current-checkout');

      var type = $('input[name="checkout_type"]:checked').val();
      var upcomingDate = $('#co_upcoming_date').val();

      if (type === 'today') {
        if (currentCheckout && currentCheckout > globalToday) {
          var curParts = currentCheckout.split('-');
          var curD = new Date(parseInt(curParts[0], 10), parseInt(curParts[1], 10) - 1, parseInt(curParts[2], 10));
          var curFmt = String(curD.getDate()).padStart(2, '0') + '-' + curD.toLocaleString('en-US', {month: 'short'}) + '-' + curD.getFullYear();
          $('#co_error_alert').removeClass('d-none').text('Departure is already scheduled for ' + curFmt + '. Check out today is not allowed.');
          return false;
        }
        if (!canToday) {
          if (isShortTerm) {
            $('#co_error_alert').removeClass('d-none').text('Check out is allowed on or after the check in date (' + checkinFmt + ').');
          } else {
            $('#co_error_alert').removeClass('d-none').text('Check out is allowed only after one month from the check in date (' + checkinFmt + '). Earliest eligible check-out date is ' + oneMonthFmt + '.');
          }
          return false;
        }
      } else if (type === 'upcoming') {
        if (!upcomingDate) {
          $('#co_error_alert').removeClass('d-none').text('Please select an upcoming check out date.');
          return false;
        }
        if (currentCheckout && currentCheckout > globalToday && upcomingDate < currentCheckout) {
          var curParts = currentCheckout.split('-');
          var curD = new Date(parseInt(curParts[0], 10), parseInt(curParts[1], 10) - 1, parseInt(curParts[2], 10));
          var curFmt = String(curD.getDate()).padStart(2, '0') + '-' + curD.toLocaleString('en-US', {month: 'short'}) + '-' + curD.getFullYear();
          $('#co_error_alert').removeClass('d-none').text('Check out date cannot be earlier than currently scheduled date (' + curFmt + ').');
          return false;
        }
        if (isShortTerm) {
          if (checkinRaw && upcomingDate < checkinRaw) {
            $('#co_error_alert').removeClass('d-none').text('Check out date cannot be earlier than check in date (' + checkinFmt + ').');
            return false;
          }
        } else {
          if (oneMonth && upcomingDate < oneMonth) {
            $('#co_error_alert').removeClass('d-none').text('Check out is allowed only after one month from the check in date (' + checkinFmt + '). Selected date cannot be earlier than ' + oneMonthFmt + '.');
            return false;
          }
        }
      }

      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
      $('#co_error_alert').addClass('d-none').text('');

      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        dataType: 'json',
        success: function(res) {
          $btn.prop('disabled', false).html(origText);
          if (res && res.status) {
            alert(res.message);
            location.reload();
          } else {
            $('#co_error_alert').removeClass('d-none').text(res?.message || 'Error processing check out.');
          }
        },
        error: function(xhr) {
          $btn.prop('disabled', false).html(origText);
          var err = 'Server error. Please try again.';
          try {
            var parsed = JSON.parse(xhr.responseText);
            if (parsed && parsed.message) err = parsed.message;
          } catch(e) {}
          $('#co_error_alert').removeClass('d-none').text(err);
        }
      });
    });

    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;

    for (let y = currentYear - 1; y <= currentYear + 2; y++) {
        $('#yearSelect').append(`<option value="${y}">${y}</option>`);
    }
    $('#yearSelect').val(currentYear);

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function applySearchFilter() {
        var query = $('#rentalSearchInput').val().toLowerCase().trim();

        if (query.length > 0) {
            $('#clearSearchBtn').show();
        } else {
            $('#clearSearchBtn').hide();
        }

        // 1. Filter Calendar Table (when visible)
        if ($('#calendarCard').is(':visible')) {
            var calMatches = 0;
            var calTotal = 0;
            $('#calendarTable tbody tr:not(.no-search-row)').each(function() {
                calTotal++;
                var text = $(this).find('td:first-child').text().toLowerCase();
                if (query === '' || text.indexOf(query) !== -1) {
                    $(this).show();
                    calMatches++;
                } else {
                    $(this).hide();
                }
            });
            $('#calendarTable tbody .no-search-row').remove();
            if (calTotal > 0 && calMatches === 0 && query !== '') {
                $('#calendarTable tbody').append('<tr class="no-search-row"><td colspan="13" class="text-center text-muted py-4"><i class="fa fa-search me-2"></i>No inmates matching "<strong>' + escapeHtml(query) + '</strong>" found in the ' + $('.year_clz').val() + ' calendar.</td></tr>');
            }
        }

        // 2. Filter Building Table (when visible)
        if ($('#buildingCard').is(':visible')) {
            var bldMatches = 0;
            var bldTotal = 0;
            $('#buildingTable tbody tr:not(.no-search-row)').each(function() {
                if ($(this).find('td').length === 1 && $(this).text().indexOf('No inmates found') !== -1) {
                    return;
                }
                bldTotal++;
                var text = $(this).text().toLowerCase();
                if (query === '' || text.indexOf(query) !== -1) {
                    $(this).show();
                    bldMatches++;
                } else {
                    $(this).hide();
                }
            });
            $('#buildingTable tbody .no-search-row').remove();
            if (bldTotal > 0 && bldMatches === 0 && query !== '') {
                $('#buildingTable tbody').append('<tr class="no-search-row"><td colspan="9" class="text-center text-muted py-4"><i class="fa fa-search me-2"></i>No inmates matching "<strong>' + escapeHtml(query) + '</strong>" found.</td></tr>');
            }
        }
    }

    $('#rentalSearchInput').on('keyup input', function() {
        applySearchFilter();
    });

    $('#clearSearchBtn').on('click', function() {
        $('#rentalSearchInput').val('');
        applySearchFilter();
        $('#rentalSearchInput').focus();
    });

    $('#rentalSearchInput').on('keydown', function(e) {
        if (e.key === 'Escape') {
            $(this).val('');
            applySearchFilter();
        }
    });

    function fetchBuildingInmates() {
        var build  = $(".build_clz").val() || 'all';
        var month  = $(".month_clz").val();
        var year   = $(".year_clz").val();
        var status = $(".status_clz").val() || 'all';

        if (!month) {
            $(".month_clz").val(currentMonth);
            month = currentMonth;
        }

        $('.status_clz').show();
        $('.inmates_details').html('<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin me-2"></i>Loading rental details...</td></tr>');
        $('#calendarCard').hide();
        $('#buildingCard').show();

        $.ajax({
            url: "<?php echo base_url(); ?>Admin/Ajax/inmatesDetails",
            type: "POST",
            data: { Build: build, Month: month, Year: year, Status: status },
            dataType: "json",
            success: function(data) {
                var res = (typeof data === 'object') ? data : JSON.parse(data);
                $('.inmates_details').html(res.inmates_details);

                if (res.summary) {
                    $('#sumTotal').text(res.summary.total);
                    $('#sumUnpaid').text(res.summary.unpaid);
                    $('#sumPartial').text(res.summary.partial);
                    $('#sumPaid').text(res.summary.paid);
                    $('#summaryBanner').show();
                }

                applySearchFilter();
            },
            error: function(xhr, status, error) {
                console.error("Rental AJAX Error:", status, error);
                $('.inmates_details').html('<tr><td colspan="9" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Failed to load rental details. Please try again.</td></tr>');
            }
        });
    }

    $('.year_clz').on('change', function() {
        if ($(".month_clz").val()) {
            fetchBuildingInmates();
        } else {
            var year = $(this).val();
            $('.tbody_data').html('<tr><td colspan="13" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin me-2"></i>Loading calendar for ' + year + '...</td></tr>');
            $.ajax({
                url: "<?php echo base_url(); ?>Admin/Ajax/checkYear",
                type: "POST",
                data: { currentYear: year },
                dataType: "json",
                success: function(data) {
                    var res = (typeof data === 'object') ? data : JSON.parse(data);
                    $('.tbody_data').html(res.year_html);
                    applySearchFilter();
                },
                error: function(xhr, status, error) {
                    console.error("Year check AJAX Error:", status, error);
                    $('.tbody_data').html('<tr><td colspan="13" class="text-center py-4 text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Failed to load calendar. Please try again.</td></tr>');
                }
            });
            $('.status_clz').hide();
            $('#summaryBanner').hide();
            $('#buildingCard').hide();
            $('#calendarCard').show();
        }
    });

    $('.month_clz').on('change', function() {
        var mVal = $(this).val();
        if (!mVal) {
            $('.status_clz').hide();
            $('#summaryBanner').hide();
            $('#buildingCard').hide();
            $('#calendarCard').show();
            applySearchFilter();
        } else {
            fetchBuildingInmates();
        }
    });

    $('.build_clz, .status_clz').on('change', function() {
        fetchBuildingInmates();
    });

    // Reset Filters Handler
    $('#btnResetFilters').on('click', function(e) {
        var currYear = new Date().getFullYear();
        var currentSelectedYear = $('.year_clz').val();

        // If year was changed from current year, navigate to base URL to cleanly reload current year data
        if (currentSelectedYear && currentSelectedYear != currYear) {
            return true;
        }

        e.preventDefault();

        // 1. Clear search input and hide clear button
        $('#rentalSearchInput').val('');

        // 2. Reset dropdown selects
        $('.month_clz').val('');
        $('.build_clz').val('all');
        $('.status_clz').val('all').hide();

        // 3. Reset view cards
        $('#summaryBanner').hide();
        $('#buildingCard').hide();
        $('#calendarCard').show();

        // 4. Reset table filter rows (shows all rows and hides clearSearchBtn)
        applySearchFilter();

        if (typeof alertify !== 'undefined') {
            alertify.success('Filters reset to default');
        }
    });

    // Full Screen Toggle Handler
    function isFullScreen() {
        return !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
    }

    function toggleFullScreen() {
        if (!isFullScreen()) {
            var elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    }

    $('#toggleFullscreenBtn').on('click', function(e) {
        e.preventDefault();
        toggleFullScreen();
    });

    function updateFsBtn() {
        if (isFullScreen()) {
            $('#fullscreenIcon').removeClass('fa-arrows-alt').addClass('fa-compress');
            $('#fullscreenText').text('Exit Full Screen');
            $('#toggleFullscreenBtn').attr('title', 'Exit Full Screen View');
        } else {
            $('#fullscreenIcon').removeClass('fa-compress').addClass('fa-arrows-alt');
            $('#fullscreenText').text('Full Screen');
            $('#toggleFullscreenBtn').attr('title', 'Toggle Full Screen View (F11)');
        }
    }

    document.addEventListener('fullscreenchange', updateFsBtn);
    document.addEventListener('webkitfullscreenchange', updateFsBtn);
    document.addEventListener('mozfullscreenchange', updateFsBtn);
    document.addEventListener('MSFullscreenChange', updateFsBtn);
});
</script>

</body>
</html>
