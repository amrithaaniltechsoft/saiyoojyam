<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Monthly Rental Calendar</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" rel="stylesheet"/>
   <style>
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
  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f7fa;
    margin: 20px;
    color: #333;
  }

  h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 10px;
  }

  #legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 14px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    display: inline-block;
  }

  .legend-paid { background: #eafaf1; border: 1px solid #2e7d32; }
  .legend-unpaid { background: #fdecea; border: 1px solid #c0392b; }
  .legend-partial { background: #fff3cd; border: 1px solid #b57f00; }
  .legend-advance { background: #e6f7fb; border: 1px solid #03c3ec; }
  .legend-vacated { background: #eceff1; border: 1px solid #78909c; }

  #yearSelect, .month_clz, .build_clz, .status_clz {
    display: inline-block;
    width: auto;
    margin: 0 4px 15px 4px;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
    vertical-align: middle;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
  }

  th {
    background: cadetblue;
    color: #fff;
    padding: 10px;
    font-weight: 600;
    text-transform: uppercase;
  }

  td {
    border: 1px solid #eee;
    padding: 10px;
    text-align: center;
    transition: background 0.3s;
  }

  tr:nth-child(even) td {
    background: #f9fbfc;
  }

  td:hover {
    background: #f0f8ff;
  }

  .paid {
    background: #eafaf1;
    color: #2e7d32;
    font-weight: 500;
  }

  .unpaid {
    background: #fdecea;
    color: #c0392b;
    font-weight: 500;
  }

  .partial {
    background: #fff3cd;
    color: #b57f00;
    font-weight: 500;
  }

  .advance {
    background: #e6f7fb;
    color: #03c3ec;
    font-weight: 500;
  }

  .vacated {
    background: #e0e0e0;
    color: #555;
    font-style: italic;
    font-weight: 500;
  }

  tr.row-vacated td {
    background: #eceff1 !important;
    color: #78909c;
    font-style: italic;
  }

  tr.row-vacated td a {
    color: inherit;
    opacity: .8;
  }

  .paid a, .partial a, .unpaid a, .advance a {
    color: inherit;
    text-decoration: none;
    display: block;
  }

  .yearly_report {
    display: inline-block;
    vertical-align: middle;
    margin: 0 4px 15px 4px;
  }
  .yearly_report button {
    margin: 0;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
  }
  .yearly_report a {
    color: black;
    text-decoration: none;
  }
</style>
</head>
<body>

<h2>Saiyoojyam Rental Calendar</h2>

<!--- Color Legend -->
<div id="legend">
  <div class="legend-item"><span class="legend-color legend-paid"></span> Paid </div>
  <div class="legend-item"><span class="legend-color legend-partial"></span> Partial</div>
  <div class="legend-item"><span class="legend-color legend-advance"></span> Advance</div>
  <div class="legend-item"><span class="legend-color legend-unpaid"></span> Unpaid</div>
  <div class="legend-item"><span class="legend-color legend-vacated"></span> Checked Out</div>
</div>

<div style="text-align: center; margin-bottom: 20px;">

  <select id="yearSelect" class="form-control year_clz"></select>

  <select class="form-control month_clz">
    <option value="" selected disabled>Select Month</option>
    <?php foreach($month as $mon){ ?> 
      <option value="<?php echo $mon->month_id;?>"><?php echo $mon->month_short;?></option>
    <?php } ?>
  </select>

  <select class="form-control build_clz">
    <option value="" selected disabled>Select Building</option>
    <?php foreach($building as $build){ ?>
        <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
    <?php } ?>
  </select>

  <select class="form-control status_clz" style="display: none;">
    <option value="all">All Payment Statuses</option>
    <option value="unpaid" selected>Unpaid & Partial Only</option>
    <option value="unpaid_only">Strictly Unpaid Only</option>
    <option value="paid">Paid Only</option>
    <option value="partial">Partial Only</option>
    <option value="advance">Advance Only</option>
  </select>

  <div class="yearly_report"><button><a href="<?php echo base_url();?>Admin/Inmates/RentalDetails">Yearly Report</a></button></div>

</div>

<table id="calendarTable">
  <thead>
    <tr>
      <th>Inmates</th>
      
      <?php $year =0 ;foreach($month as $mon){ ?> 
      <th><?php echo $mon->month_short;?></th>
      <?php } ?>
    </tr>
  </thead>
 <tbody class="tbody_data">
  
<?php foreach($inmates as $inmate){ ?> 
  <tr <?php if($inmate->inmates_status == 'checked_out'){ echo 'class="row-vacated"'; } ?>>
    <td>
      <strong><?php echo htmlspecialchars($inmate->inmates_name); ?></strong>
      <br/><small class="text-muted"><?php echo htmlspecialchars($inmate->inmates_uid); ?></small>
      <?php
        $todayDate = date('Y-m-d');
        $hasCheckout = (!empty($inmate->inmates_check_out_date) && $inmate->inmates_check_out_date != '0000-00-00');
        $isFutureCheckout = ($hasCheckout && $inmate->inmates_check_out_date > $todayDate);
        $isCheckedOut = ($inmate->inmates_status === 'checked_out' || ($hasCheckout && $inmate->inmates_check_out_date <= $todayDate));
        $checkInDate = (!empty($inmate->inmates_check_in_date) && $inmate->inmates_check_in_date != '0000-00-00') ? $inmate->inmates_check_in_date : null;
        $oneMonthDate = $checkInDate ? date('Y-m-d', strtotime($checkInDate . ' + 1 month')) : null;
        $canCheckoutToday = empty($oneMonthDate) || ($todayDate >= $oneMonthDate);
        $roomName = !empty($inmate->rooms_name) ? $inmate->rooms_name : (!empty($inmate->inmates_rooms) ? 'Room ' . $inmate->inmates_rooms : 'Assigned Room');
      ?>
      <?php if($isCheckedOut) { ?>
        <br/><span style="font-size:11.5px;color:#dc2626;font-weight:600;">
          <i class="fa fa-sign-out"></i> Out: <?php echo date('d-M-Y', strtotime($inmate->inmates_check_out_date)); ?>
        </span>
      <?php } elseif($isFutureCheckout) { ?>
        <br/>
        <div style="display:inline-flex;align-items:center;gap:4px;margin-top:3px;">
          <span style="font-size:11px;background:#e0f2fe;color:#0369a1;padding:2px 6px;border-radius:4px;font-weight:600;" title="Scheduled Upcoming Check Out">
            <i class="fa fa-calendar-check-o"></i> <?php echo date('d-M-Y', strtotime($inmate->inmates_check_out_date)); ?> (Upcoming)
          </span>
          <button type="button" class="btn-checkout-trigger"
            data-inmate-id="<?php echo $inmate->inmates_id; ?>"
            data-inmate-name="<?php echo esc($inmate->inmates_name); ?>"
            data-inmate-uid="<?php echo esc($inmate->inmates_uid); ?>"
            data-inmate-room="<?php echo esc($roomName); ?>"
            data-checkin-date="<?php echo !empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-'; ?>"
            data-checkin-raw="<?php echo $inmate->inmates_check_in_date ?? ''; ?>"
            data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
            data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
            data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
            data-current-checkout="<?php echo $inmate->inmates_check_out_date; ?>"
            title="Reschedule departure date"
            style="border:1px solid #0284c7;background:#fff;color:#0284c7;border-radius:4px;padding:1px 5px;font-size:11px;cursor:pointer;">
            <i class="fa fa-pencil"></i>
          </button>
        </div>
      <?php } else { ?>
        <br/>
        <button type="button" class="btn-checkout-trigger"
          data-inmate-id="<?php echo $inmate->inmates_id; ?>"
          data-inmate-name="<?php echo esc($inmate->inmates_name); ?>"
          data-inmate-uid="<?php echo esc($inmate->inmates_uid); ?>"
          data-inmate-room="<?php echo esc($roomName); ?>"
          data-checkin-date="<?php echo !empty($inmate->inmates_check_in_date) ? date('d-M-Y', strtotime($inmate->inmates_check_in_date)) : '-'; ?>"
          data-checkin-raw="<?php echo $inmate->inmates_check_in_date ?? ''; ?>"
          data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
          data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
          data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
          data-current-checkout=""
          style="font-size:12px;color:#fff;background:#e74c3c;padding:3px 10px;border-radius:4px;border:none;cursor:pointer;display:inline-block;margin-top:3px;font-weight:500;">
          <i class="fa fa-sign-out"></i> Check Out
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
            if($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {
              echo '<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';
            } 
            else {
              echo '<td></td>'; 
            }
          }

        } 
        else {
          if ($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {
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


<!--table2 section start-->

<div id="summaryBanner" style="display:none; margin: 15px auto 25px auto; padding: 12px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); text-align: center;">
  <span style="margin: 0 15px; font-weight: 600;">Total Inmates: <span id="sumTotal" style="color:#2c3e50;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Unpaid: <span id="sumUnpaid" style="color:#c0392b;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Partial: <span id="sumPartial" style="color:#b57f00;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Paid: <span id="sumPaid" style="color:#2e7d32;">0</span></span>
</div>

<table id="buildingTable" style="display:none;">
  <thead>
    <tr>
      <th style="width: 5%; text-align: center;">#</th>
      <th style="width: 20%;">Inmate Name</th>
      <th style="width: 15%;">Room & Type</th>
      <th style="width: 15%;">Phone Number</th>
      <th style="width: 10%; text-align: right;">Rent (₹)</th>
      <th style="width: 10%; text-align: right;">Paid (₹)</th>
      <th style="width: 10%; text-align: right;">Balance (₹)</th>
      <th style="width: 10%; text-align: center;">Status</th>
      <th style="width: 10%; text-align: center;">Action</th>
    </tr>
  </thead>
 <tbody class="inmates_details">
  
</tbody>
</table>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!--table2 section end-->
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
              <span><i class="fa fa-calendar-check-o me-1 text-primary"></i>Check-in: <strong id="co_inmate_checkin" class="text-dark">-</strong></span>
              <span>•</span>
              <span><i class="fa fa-calendar-o me-1 text-success"></i>1-Mo Minimum Stay: <strong id="co_inmate_min_date" class="text-dark">-</strong></span>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>

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

      if (!oneMonth && checkinRaw) {
        var ciParts = checkinRaw.split('-');
        var ciD = new Date(parseInt(ciParts[0], 10), parseInt(ciParts[1], 10) - 1, parseInt(ciParts[2], 10));
        ciD.setMonth(ciD.getMonth() + 1);
        oneMonth = formatDateYMD(ciD);
        oneMonthFmt = String(ciD.getDate()).padStart(2, '0') + '-' + ciD.toLocaleString('en-US', {month: 'short'}) + '-' + ciD.getFullYear();
        canToday = (globalToday >= oneMonth);
      }

      $('#co_inmate_min_date').text(oneMonthFmt || '-');

      $('#checkoutForm').data('can-today', canToday ? '1' : '0');
      $('#checkoutForm').data('one-month', oneMonth);
      $('#checkoutForm').data('one-month-fmt', oneMonthFmt);
      $('#checkoutForm').data('checkin-fmt', checkin);
      $('#checkoutForm').data('checkin-raw', checkinRaw);

      var tomorrowD = new Date();
      tomorrowD.setDate(tomorrowD.getDate() + 1);
      var effectiveMinDate = canToday ? formatDateYMD(tomorrowD) : oneMonth;
      var initialSelectedDate = (currentCheckout && currentCheckout >= effectiveMinDate) ? currentCheckout : effectiveMinDate;

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

      if (!canToday) {
        $('#co_policy_warning').removeClass('d-none');
        $('#co_policy_warning_text').html('Inmates can check out only after 1 month from check-in date (' + checkin + '). Earliest eligible check-out date is <strong>' + oneMonthFmt + '</strong>.');

        $('#radio_co_today').prop('disabled', true).prop('checked', false);
        $('#card_co_today').addClass('disabled').removeClass('active');
        $('#co_today_badge').removeClass('bg-danger').addClass('bg-secondary').html('<i class="fa fa-lock me-1"></i>Locked (< 1 Mo)');
        $('#co_today_desc').html('<span class="text-danger fw-semibold">Not allowed. Must complete 1 month stay (eligible on or after ' + oneMonthFmt + ').</span>');

        $('#radio_co_upcoming').prop('disabled', false).prop('checked', true).trigger('change');
        $('#card_co_upcoming').addClass('active');

        $('#co_badge_quick_indicator').html('<i class="fa fa-lock me-1"></i>Min: ' + oneMonthFmt).removeClass('bg-success text-white').addClass('bg-danger text-white');
      } else {
        $('#co_policy_warning').addClass('d-none');

        $('#radio_co_today').prop('disabled', false);
        $('#card_co_today').removeClass('disabled');
        $('#co_today_badge').removeClass('bg-secondary').addClass('bg-danger').text(globalTodayFmt);
        $('#co_today_desc').text('Mark resident as departed immediately today and free up the bed.');

        $('#co_badge_quick_indicator').html('<i class="fa fa-check-circle me-1"></i>1-Mo Policy Satisfied').removeClass('bg-danger text-white').addClass('bg-success text-white');

        if (currentCheckout && currentCheckout > globalToday) {
          $('#radio_co_upcoming').prop('checked', true).trigger('change');
          $('#card_co_upcoming').addClass('active');
          $('#card_co_today').removeClass('active');
        } else {
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

      var canToday = $form.data('can-today') == '1';
      var oneMonth = $form.data('one-month');
      var oneMonthFmt = $form.data('one-month-fmt');
      var checkinFmt = $form.data('checkin-fmt');

      var type = $('input[name="checkout_type"]:checked').val();
      var upcomingDate = $('#co_upcoming_date').val();

      if (type === 'today') {
        if (!canToday) {
          $('#co_error_alert').removeClass('d-none').text('Check out is allowed only after one month from the check in date (' + checkinFmt + '). Earliest eligible check-out date is ' + oneMonthFmt + '.');
          return false;
        }
      } else if (type === 'upcoming') {
        if (!upcomingDate) {
          $('#co_error_alert').removeClass('d-none').text('Please select an upcoming check out date.');
          return false;
        }
        if (oneMonth && upcomingDate < oneMonth) {
          $('#co_error_alert').removeClass('d-none').text('Check out is allowed only after one month from the check in date (' + checkinFmt + '). Selected date cannot be earlier than ' + oneMonthFmt + '.');
          return false;
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

    function fetchBuildingInmates() {
        var build  = $(".build_clz").val();
        var month  = $(".month_clz").val();
        var year   = $(".year_clz").val();
        var status = $(".status_clz").val() || 'all';

        if (!build) {
            return;
        }

        if (!month) {
            $(".month_clz").val(currentMonth);
            month = currentMonth;
        }

        $('.status_clz').show();

        $.ajax({
            url: "<?php echo base_url(); ?>Admin/Ajax/inmatesDetails",
            type: "POST",
            data: { Build: build, Month: month, Year: year, Status: status },
            success: function(data) {
                var res = JSON.parse(data);
                $('.inmates_details').html(res.inmates_details);

                if (res.summary) {
                    $('#sumTotal').text(res.summary.total);
                    $('#sumUnpaid').text(res.summary.unpaid);
                    $('#sumPartial').text(res.summary.partial);
                    $('#sumPaid').text(res.summary.paid);
                    $('#summaryBanner').show();
                }

                $('#calendarTable').hide();
                $('#buildingTable').show();
            }
        });
    }

    $('.year_clz').on('change', function() {
        if ($(".build_clz").val()) {
            fetchBuildingInmates();
        } else {
            var year = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>Admin/Ajax/checkYear",
                type: "POST",
                data: { currentYear: year },
                success: function(data) {
                    var res = JSON.parse(data);
                    $('.tbody_data').html(res.year_html);
                }
            });
            $('.status_clz').hide();
            $('#summaryBanner').hide();
            $('#buildingTable').hide();
            $('#calendarTable').show();
        }
    });

    $('.month_clz, .build_clz, .status_clz').on('change', function() {
        fetchBuildingInmates();
    });
});
</script>

</body>
</html>
