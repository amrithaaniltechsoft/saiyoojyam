<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" rel="stylesheet"/>

  <style>
  #myTable th.col-sl,
  #myTable td.col-sl,
  #myTable th:first-child,
  #myTable td:first-child {
    width: 50px !important;
    max-width: 55px !important;
    min-width: 45px !important;
    text-align: center !important;
    padding-left: 6px !important;
    padding-right: 6px !important;
    white-space: nowrap !important;
  }
  #myTable th.col-ref,
  #myTable td.col-ref,
  #myTable th:nth-child(2),
  #myTable td:nth-child(2) {
    width: 100px !important;
    max-width: 110px !important;
    min-width: 90px !important;
    white-space: nowrap !important;
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
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
    position: relative !important;
  }
  .flatpickr-calendar .flatpickr-month {
    color: #ffffff !important;
    fill: #ffffff !important;
    height: 36px !important;
  }
  .flatpickr-calendar .flatpickr-current-month {
    font-size: 15px !important;
    font-weight: 700 !important;
    color: #ffffff !important;
    padding-top: 3px !important;
  }
  .flatpickr-calendar .flatpickr-current-month .cur-month {
    font-weight: 700 !important;
    color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months {
    color: #ffffff !important;
    background: transparent !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    outline: none !important;
    border: none !important;
    border-radius: 4px !important;
    cursor: pointer !important;
    padding: 2px 4px !important;
  }
  .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
    background: rgba(255, 255, 255, 0.2) !important;
  }
  .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months option,
  .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
    color: #1e293b !important;
    background-color: #ffffff !important;
    font-size: 14px !important;
    font-weight: 600 !important;
  }
  .flatpickr-calendar .flatpickr-current-month input.cur-year {
    font-weight: 700 !important;
    color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-current-month .numInputWrapper span.arrowUp:after {
    border-bottom-color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-current-month .numInputWrapper span.arrowDown:after {
    border-top-color: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-prev-month,
  .flatpickr-calendar .flatpickr-next-month {
    color: #ffffff !important;
    fill: #ffffff !important;
    padding: 6px 10px !important;
    border-radius: 8px !important;
    transition: all 0.2s ease !important;
    top: 10px !important;
  }
  .flatpickr-calendar .flatpickr-prev-month:hover,
  .flatpickr-calendar .flatpickr-next-month:hover {
    background: rgba(255, 255, 255, 0.25) !important;
    transform: scale(1.1) !important;
  }
  .flatpickr-calendar .flatpickr-prev-month svg,
  .flatpickr-calendar .flatpickr-next-month svg {
    fill: #ffffff !important;
  }
  .flatpickr-calendar .flatpickr-weekdays {
    background: #f8fafc !important;
    border-bottom: 1px solid #f1f5f9 !important;
    padding: 6px 0 !important;
  }
  .flatpickr-calendar .flatpickr-weekday {
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #64748b !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
  }
  .flatpickr-calendar .flatpickr-days {
    padding: 6px 8px 10px 8px !important;
    width: 100% !important;
  }
  .flatpickr-calendar .dayContainer {
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
    justify-content: space-around !important;
  }
  .flatpickr-calendar .flatpickr-day {
    border-radius: 10px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    height: 36px !important;
    line-height: 36px !important;
    max-width: 38px !important;
    margin: 2px 0 !important;
    transition: all 0.15s ease !important;
  }
  .flatpickr-calendar .flatpickr-day:hover:not(.flatpickr-disabled) {
    background: #fee2e2 !important;
    color: #dc2626 !important;
    border-color: #fca5a5 !important;
    transform: translateY(-2px) scale(1.06) !important;
    box-shadow: 0 4px 10px rgba(220, 38, 38, 0.15) !important;
  }
  .flatpickr-calendar .flatpickr-day.today {
    border: 2px solid #dc2626 !important;
    color: #dc2626 !important;
    font-weight: 700 !important;
    background: #fff5f5 !important;
  }
  .flatpickr-calendar .flatpickr-day.selected,
  .flatpickr-calendar .flatpickr-day.selected:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    color: #ffffff !important;
    border-color: #dc2626 !important;
    font-weight: 700 !important;
    box-shadow: 0 6px 14px rgba(220, 38, 38, 0.4) !important;
    transform: scale(1.05) !important;
  }
  .flatpickr-calendar .flatpickr-day.flatpickr-disabled,
  .flatpickr-calendar .flatpickr-day.flatpickr-disabled:hover {
    color: #cbd5e1 !important;
    background: transparent !important;
    cursor: not-allowed !important;
    text-decoration: line-through !important;
    opacity: 0.45 !important;
    transform: none !important;
    box-shadow: none !important;
  }
  .input-group > .flatpickr-wrapper {
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
    display: flex;
  }
  .input-group > .flatpickr-wrapper > input {
    width: 100% !important;
    border-radius: 0 !important;
    border-left: 0 !important;
    border-right: 0 !important;
    border-color: #fca5a5 !important;
    background: #ffffff !important;
    font-weight: 700 !important;
    font-size: 13.5px !important;
    color: #1e293b !important;
    cursor: pointer !important;
  }
  .input-group > .flatpickr-wrapper > input:focus {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15) !important;
  }
  </style>



          
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
               
              <div class="card">
                <h5 class="card-header">View Inmates</h5>

                <?php
                  $href_base = base_url().'Admin/Inmates';
                  $fq = array();
                  if(!empty($active_status)){ $fq['status'] = $active_status; }
                  if(!empty($active_pay)){ $fq['pay'] = $active_pay; }
                  $href = function($extra) use ($fq){
                    return base_url().'Admin/Inmates?'.http_build_query(array_merge($fq, $extra));
                  };
                  $cls_ab = $active_status == 'active' ? 'btn-success' : 'btn-outline-success';
                  $cls_na = $active_status == 'checked_out' ? 'btn-success' : 'btn-outline-success';
                  $cls_ud = $active_pay == 'unpaid' ? 'btn-warning' : 'btn-outline-warning';
                  $cls_pd = $active_pay == 'paid' ? 'btn-success' : 'btn-outline-success';
                  $cls_pt = $active_pay == 'partial' ? 'btn-primary' : 'btn-outline-primary';
                  $cls_av = $active_pay == 'advance' ? 'btn-info' : 'btn-outline-info';
                ?>

                <div class="card-header d-flex flex-wrap gap-2 align-items-center">
                  <select id="ref_filter" class="form-select form-select-sm" style="width:200px;" onchange="var u='<?php echo base_url();?>Admin/Inmates';if(this.value){u+='?ref='+this.value+'<?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>';}goNav(u);">
                    <option value="">Filter by Reffer ID</option>
                    <?php foreach($reffers as $ref){ ?>
                    <option value="<?php echo $ref->inmates_uid;?>" <?php if(!empty($active_ref) && $active_ref == $ref->inmates_uid){ echo 'selected';} ?>><?php echo $ref->inmates_uid; ?> - <?php echo $ref->inmates_name;?></option>
                    <?php } ?>
                  </select>
                  <a href="<?php echo $href_base;?>" class="btn btn-sm btn-outline-secondary filter-link">All</a>
                  <a href="<?php echo $href(array('status' => 'active'));?>" class="btn btn-sm filter-link <?php echo $cls_ab;?>">Active</a>
                  <a href="<?php echo $href(array('status' => 'checked_out'));?>" class="btn btn-sm filter-link <?php echo $cls_na;?>">Inactive</a>
                  <span class="mx-1 text-muted">Payment:</span>
                  <a href="<?php echo $href(array('pay' => 'unpaid'));?>" class="btn btn-sm filter-link <?php echo $cls_ud;?>">Unpaid</a>
                  <a href="<?php echo $href(array('pay' => 'paid'));?>" class="btn btn-sm filter-link <?php echo $cls_pd;?>">Paid</a>
                  <a href="<?php echo $href(array('pay' => 'partial'));?>" class="btn btn-sm filter-link <?php echo $cls_pt;?>">Partially Paid</a>
                  <a href="<?php echo $href(array('pay' => 'advance'));?>" class="btn btn-sm filter-link <?php echo $cls_av;?>">Advance</a>
                  <a href="<?php echo $href_base;?>" class="btn btn-sm btn-outline-danger filter-link">Reset</a>
                </div>

                <div class="card-header d-flex flex-wrap gap-2 align-items-center border-top">
                  <label class="text-muted mb-0">Check In:</label>
                  <input type="date" class="form-control form-control-sm check_in_filter" style="width:150px;" value="<?php echo $active_check_in; ?>" onchange="goNav('<?php echo base_url();?>Admin/Inmates?check_in='+this.value+'<?php echo !empty($active_check_out)?'&check_out='.$active_check_out:''; ?><?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>');"/>
                  <label class="text-muted mb-0 ms-2">Check Out:</label>
                  <input type="date" class="form-control form-control-sm check_out_filter" style="width:150px;" value="<?php echo $active_check_out; ?>" onchange="goNav('<?php echo base_url();?>Admin/Inmates?check_out='+this.value+'<?php echo !empty($active_check_in)?'&check_in='.$active_check_in:''; ?><?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>');"/>
                  <a href="<?php echo $href_base.(!empty($fq) ? '?'.http_build_query($fq) : '');?>" class="btn btn-sm btn-outline-secondary filter-link">Reset Dates</a>
                </div>
               
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th class="text-center col-sl" style="width: 50px !important; max-width: 55px !important;">Sl no</th>
                        <th class="col-ref" style="width: 100px !important; max-width: 110px !important;">Reffer ID</th>
                        <th>Name</th>
                        <th>Rooms</th>
                        
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th>Status</th>
                        
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $val){ ?> 
                      <tr>
                        <td class="text-center col-sl"><?php echo $i; ?></td>
                        <td class="col-ref"><?php echo $val->inmates_uid; ?></td>
                         <td><?php echo $val->inmates_name;?></td>
                        
                        <?php 
                          $inmate_room_name = '';
                          foreach($rooms_data as $rooms){
                            if($rooms->rooms_id  == $val->inmates_rooms){ 
                              $inmate_room_name = $rooms->rooms_name;
                        ?>

                          <td>
                            <?php echo $rooms->rooms_name;?>
                            <?php foreach($room_types as $rtype){
                              if($rtype->room_type_id == $val->inmates_room_type){
                            ?>
                            <br/><small class="text-muted"><?php echo $rtype->room_type_name; ?></small>
                            <?php } } ?>
                            <?php foreach($buildings as $build){
                              if($build->building_id == $val->inmates_building){
                            ?>
                            <br/><small class="text-muted"><?php echo $build->building_name; ?></small>
                            <?php } } ?>
                          </td>

                        <?php } }  ?>
                       
                        <td><?php echo date('d-M-Y',strtotime($val->inmates_check_in_date)); ?></td>
                        <td>
                          <?php 
                            $todayDate = date('Y-m-d');
                            $hasCheckout = (!empty($val->inmates_check_out_date) && $val->inmates_check_out_date != "0000-00-00");
                            $isFutureCheckout = ($hasCheckout && $val->inmates_check_out_date > $todayDate);
                            $isCheckedOut = ($val->inmates_status === 'checked_out' || ($hasCheckout && $val->inmates_check_out_date <= $todayDate));
                            $checkInDate = (!empty($val->inmates_check_in_date) && $val->inmates_check_in_date != '0000-00-00') ? $val->inmates_check_in_date : null;
                            $isShortTerm = ((int)($val->inmates_duration_of_stay ?? 0) === 1);
                            $oneMonthDate = (!$isShortTerm && $checkInDate) ? date('Y-m-d', strtotime($checkInDate . ' + 1 month')) : null;
                            $canCheckoutToday = $isShortTerm ? (empty($checkInDate) || $todayDate >= $checkInDate) : (empty($oneMonthDate) || ($todayDate >= $oneMonthDate));
                          ?>

                          <?php if($isCheckedOut) { ?>
                            <span class="text-danger fw-semibold" style="font-size:12.5px;">
                              <i class="fa fa-sign-out me-1"></i><?php echo date('d-M-Y', strtotime($val->inmates_check_out_date)); ?>
                            </span>
                          <?php } elseif($isFutureCheckout) { ?>
                            <div class="d-inline-flex align-items-center gap-1">
                              <span class="badge bg-label-info fw-bold py-1 px-2" style="font-size:11px;" title="Scheduled Upcoming Check Out">
                                <i class="fa fa-calendar-check-o me-1"></i><?php echo date('d-M-Y', strtotime($val->inmates_check_out_date)); ?> <small class="fw-normal">(Upcoming)</small>
                              </span>
                              <button type="button" class="btn btn-xs btn-outline-primary btn-checkout-trigger py-0 px-1"
                                data-inmate-id="<?php echo $val->inmates_id; ?>"
                                data-inmate-name="<?php echo esc($val->inmates_name); ?>"
                                data-inmate-uid="<?php echo esc($val->inmates_uid); ?>"
                                data-inmate-room="<?php echo esc($inmate_room_name); ?>"
                                data-checkin-date="<?php echo date('d-M-Y', strtotime($val->inmates_check_in_date)); ?>"
                                data-checkin-raw="<?php echo $val->inmates_check_in_date; ?>"
                                data-is-short-term="<?php echo $isShortTerm ? '1' : '0'; ?>"
                                data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
                                data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
                                data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
                                data-current-checkout="<?php echo $val->inmates_check_out_date; ?>"
                                title="Reschedule departure date">
                                <i class="icon-base bx bx-edit-alt"></i>
                              </button>
                            </div>
                          <?php } else { ?>
                            <div class="d-inline-block">
                              <button type="button" class="btn btn-danger btn-sm btn-checkout-trigger"
                                data-inmate-id="<?php echo $val->inmates_id; ?>"
                                data-inmate-name="<?php echo esc($val->inmates_name); ?>"
                                data-inmate-uid="<?php echo esc($val->inmates_uid); ?>"
                                data-inmate-room="<?php echo esc($inmate_room_name); ?>"
                                data-checkin-date="<?php echo date('d-M-Y', strtotime($val->inmates_check_in_date)); ?>"
                                data-checkin-raw="<?php echo $val->inmates_check_in_date; ?>"
                                data-is-short-term="<?php echo $isShortTerm ? '1' : '0'; ?>"
                                data-one-month="<?php echo $oneMonthDate ?: ''; ?>"
                                data-one-month-fmt="<?php echo $oneMonthDate ? date('d-M-Y', strtotime($oneMonthDate)) : ''; ?>"
                                data-can-today="<?php echo $canCheckoutToday ? '1' : '0'; ?>"
                                data-current-checkout="">
                                <i class="icon-base bx bx-log-out-circle me-1"></i> Check Out
                              </button>
                              <?php if(!$isShortTerm && !$canCheckoutToday && $oneMonthDate) { ?>
                                <small class="text-muted d-block mt-0.5" style="font-size:10.5px;" title="Minimum 1 month stay required before check out">
                                  <i class="fa fa-lock text-warning me-0.5"></i>Min 1-mo: <?php echo date('d-M', strtotime($oneMonthDate)); ?>
                                </small>
                              <?php } ?>
                            </div>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if(!empty($val->inmates_status) && $val->inmates_status == 'checked_out'){ ?>
                            <span class="badge bg-label-danger">Inactive</span>
                          <?php } elseif(!empty($val->inmates_status) && $val->inmates_status == 'pending'){ ?>
                            <span class="badge bg-label-warning">Pending Approval</span>
                          <?php } elseif(!empty($val->inmates_status) && ($val->inmates_status == 'rejected' || $val->inmates_status == 'cancelled')){ ?>
                            <span class="badge bg-label-secondary"><?php echo ucfirst($val->inmates_status); ?></span>
                          <?php } elseif($isFutureCheckout) { ?>
                            <span class="badge bg-label-success">Active</span>
                            <small class="text-info d-block fw-semibold" style="font-size:10.5px;"><i class="fa fa-clock-o me-0.5"></i>Leaving <?php echo date('d-M', strtotime($val->inmates_check_out_date)); ?></small>
                          <?php } else { ?>
                            <span class="badge bg-label-success">Active</span>
                          <?php } ?>
                        </td>
                        
                        <td>
                          <div class="d-flex align-items-center gap-1">
                            <a class="btn btn-sm btn-icon btn-outline-info p-1" href="<?php echo base_url();?>Admin/Inmates/View/<?php echo $val->inmates_id;?>" title="View Inmate Profile"><i class="icon-base bx bx-show" style="font-size:17px;"></i></a>
                            <a class="btn btn-sm btn-icon btn-outline-primary p-1" href="<?php echo base_url();?>Admin/Inmates/Edit/<?php echo $val->inmates_id;?>" title="Edit Inmate"><i class="icon-base bx bx-edit-alt" style="font-size:17px;"></i></a>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-warning p-1 btn-regen-pwd" 
                              data-id="<?php echo $val->inmates_id; ?>" 
                              data-name="<?php echo htmlspecialchars($val->inmates_name, ENT_QUOTES); ?>" 
                              data-uid="<?php echo htmlspecialchars($val->inmates_uid, ENT_QUOTES); ?>" 
                              data-email="<?php echo htmlspecialchars($val->inmates_email ?? '', ENT_QUOTES); ?>" 
                              data-phone="<?php echo htmlspecialchars($val->inmates_phone_no ?? '', ENT_QUOTES); ?>"
                              title="Regenerate Password">
                              <i class="icon-base bx bx-key" style="font-size:17px;"></i>
                            </button>
                            <a class="btn btn-sm btn-icon btn-outline-secondary p-1" href="<?php echo base_url();?>Admin/Inmates/Receipt/<?php echo $val->inmates_id;?>" title="Print Invoice"><i class="icon-base bx bx-bxs-printer" style="font-size:17px;"></i></a>
                            <a class="btn btn-sm btn-icon btn-outline-danger p-1" href="<?php echo base_url();?>Admin/Inmates/Delete/<?php echo $val->inmates_id;?>" onclick="return confirm('Are you sure you want to delete this inmate?');" title="Delete Inmate"><i class="icon-base bx bx-trash" style="font-size:17px;"></i></a>
                          </div>
                        </td>
                       
                      </tr>

                      <?php $i++; } ?>
                      
                     
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              

             

              

              
              

            <!-- Contextual Classes -->

              
              
            </div>
            <!-- / Content -->

            <div id="filterLoader" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:99999;text-align:center;">
  <div style="margin-top:20%;"><div class="spinner-border text-light" style="width:3rem;height:3rem;" role="status"><span class="visually-hidden">Loading...</span></div><br/><span style="color:#fff;font-weight:600;">Filtering...</span></div>
</div>

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
                          <span><i class="fa fa-clock-o me-1 text-info"></i><span id="co_inmate_duration" class="fw-semibold">Long Term</span></span>
                          <span id="co_min_stay_wrap"><span>•</span> <span><i class="fa fa-calendar-o me-1 text-success"></i>1-Mo Minimum Stay: <strong id="co_inmate_min_date" class="text-dark">-</strong></span></span>
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
                              <span class="badge bg-label-primary rounded-pill px-2.5 py-1" style="font-size:11px;">Scheduled Departure</span>
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

            <!-- Inmate Regenerate Password Modal -->
            <div class="modal fade" id="regenPwdModal" tabindex="-1" aria-labelledby="regenPwdModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                  <div class="modal-header text-white pe-5 position-relative" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);padding:18px 22px;">
                    <div class="d-flex align-items-center gap-2.5">
                      <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.22);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);flex-shrink:0;">
                        <i class="fa fa-key" style="font-size:18px;color:#fff;"></i>
                      </div>
                      <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="regenPwdModalLabel">Regenerate Inmate Password</h5>
                        <small style="font-size:11.5px;color:rgba(255,255,255,0.92);">Reset resident login credentials</small>
                      </div>
                    </div>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>

                  <div class="modal-body p-4">
                    <!-- Inmate Info Banner -->
                    <div class="p-3 mb-3 rounded-3" style="background:#fffbeb;border:1.5px solid #fde68a;">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark" id="rgp_inmate_name" style="font-size:15px;">Inmate Name</span>
                        <span class="badge bg-warning text-dark font-monospace" id="rgp_inmate_uid">IN000000</span>
                      </div>
                      <div class="d-flex flex-wrap align-items-center gap-2 text-muted" style="font-size:12px;">
                        <span id="rgp_email_wrapper"><i class="fa fa-envelope-o me-1 text-primary"></i><span id="rgp_inmate_email">No Email</span></span>
                        <span id="rgp_sep_dot">•</span>
                        <span><i class="fa fa-phone me-1 text-success"></i><span id="rgp_inmate_phone">-</span></span>
                      </div>
                    </div>

                    <!-- Form Step (Visible initially) -->
                    <div id="rgp_step_form">
                      <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size:13px;">New Password</label>
                        <div class="input-group">
                          <input type="text" class="form-control font-monospace" id="rgp_password_input" placeholder="Type custom or click suggest..." style="font-size:14px;letter-spacing:0.5px;">
                          <button class="btn btn-outline-secondary" type="button" id="rgp_btn_suggest" title="Generate New Password Suggestion">
                            <i class="fa fa-random me-1"></i> Suggest
                          </button>
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size:11px;">Min 6 characters. Click <strong>Suggest</strong> to generate a secure random password.</small>
                      </div>

                      <div class="mb-3" id="rgp_send_email_container">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="rgp_send_email" checked style="cursor:pointer;">
                          <label class="form-check-label text-dark fw-semibold" for="rgp_send_email" style="font-size:12.5px;cursor:pointer;">
                            Send updated credentials to inmate's email (<span id="rgp_email_badge" class="text-primary font-monospace">email</span>)
                          </label>
                        </div>
                      </div>

                      <div id="rgp_no_email_notice" class="alert alert-secondary py-2 px-3 mb-3 d-none" style="font-size:11.5px;border-radius:8px;">
                        <i class="fa fa-info-circle me-1 text-muted"></i> This inmate has no email address. The generated password will be shown on screen so you can copy and share it via WhatsApp/SMS.
                      </div>

                      <div id="rgp_error_alert" class="alert alert-danger py-2 px-3 mb-0 d-none" style="font-size:12px;border-radius:8px;"></div>
                    </div>

                    <!-- Success Step (Visible after successful regeneration) -->
                    <div id="rgp_step_success" class="d-none">
                      <div class="text-center py-4 px-2">
                        <div class="mb-3">
                          <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 58px; height: 58px; background-color: #d1e7dd; color: #0f5132;">
                            <i class="fa fa-envelope-o" style="font-size: 26px;"></i>
                          </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Password Updated Successfully</h5>
                        
                        <div id="rgp_email_success_box" class="alert alert-success py-3 px-3 mb-0" style="font-size:14.5px; border-radius:8px;">
                          <i class="fa fa-check-circle me-1.5 text-success"></i> New password sent to mail (<strong id="rgp_success_email"></strong>)
                        </div>

                        <div id="rgp_no_email_box" class="alert alert-warning py-3 px-3 mb-0 d-none text-start" style="font-size:13px; border-radius:8px;">
                          <i class="fa fa-info-circle me-1 text-warning"></i> Inmate has no email address. Updated password: <strong id="rgp_fallback_pwd" class="font-monospace text-dark"></strong>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer px-4 py-3" style="background:#f8fafc;border-top:1px solid #edf2f7;">
                    <div id="rgp_footer_form" class="w-100 d-flex justify-content-between align-items-center">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-warning fw-bold text-dark px-4" id="rgp_btn_submit">
                        <i class="fa fa-key me-1"></i> Update Password
                      </button>
                    </div>
                    <div id="rgp_footer_success" class="w-100 d-none text-end">
                      <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer section start-->
            
<?= $this->include('admin/includes/footer') ?>

            <!--Footer section end-->

            <script>
              function goNav(url){
                document.getElementById('filterLoader').style.display = 'block';
                window.location = url;
              }
              $(document).ready(function () {
                $('.filter-link').on('click', function (e) {
                  e.preventDefault();
                  var href = $(this).attr('href');
                  $(this).addClass('active');
                  goNav(href);
                });
              });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
            <script>
              $(document).ready(function () {
                $('#ref_filter').select2({
                  theme: 'bootstrap-5',
                  placeholder: 'Filter by Reffer ID',
                  allowClear: true,
                  width: '200px'
                });

                flatpickr('.check_in_filter', { dateFormat: 'Y-m-d', allowInput: true });
                flatpickr('.check_out_filter', { dateFormat: 'Y-m-d', allowInput: true });
              });
            </script>

            <script>
              $(document).ready(function() {
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

                // Open checkout modal when clicking Check Out or Edit Checkout
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

                  // Duration of stay & minimum stay policy
                  if (isShortTerm) {
                    $('#co_inmate_duration').text('Short Term').removeClass('text-info').addClass('text-warning');
                    $('#co_min_stay_wrap').hide();
                    oneMonth = '';
                    oneMonthFmt = '';
                    canToday = (!checkinRaw || globalToday >= checkinRaw);
                  } else {
                    $('#co_inmate_duration').text('Long Term').removeClass('text-warning').addClass('text-info');
                    $('#co_min_stay_wrap').show();
                    // If oneMonth not passed from PHP, calculate it
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

                  // Store parameters on form
                  $('#checkoutForm').data('is-short-term', isShortTerm ? '1' : '0');
                  $('#checkoutForm').data('can-today', canToday ? '1' : '0');
                  $('#checkoutForm').data('one-month', oneMonth);
                  $('#checkoutForm').data('one-month-fmt', oneMonthFmt);
                  $('#checkoutForm').data('checkin-fmt', checkin);
                  $('#checkoutForm').data('checkin-raw', checkinRaw);
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

                  // Initialize Fancy Flatpickr on the input field
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
                    // INMATE CANNOT CHECK OUT TODAY
                    $('#co_policy_warning').removeClass('d-none');
                    if (isShortTerm) {
                      $('#co_policy_warning_text').html('Check out is allowed on or after the check-in date (<strong>' + checkin + '</strong>).');
                    } else {
                      $('#co_policy_warning_text').html('Inmates can check out only after 1 month from check-in date (' + checkin + '). Earliest eligible check-out date is <strong>' + oneMonthFmt + '</strong>.');
                    }

                    // Disable "Check Out Today" option
                    $('#radio_co_today').prop('disabled', true).prop('checked', false);
                    $('#card_co_today').addClass('disabled').removeClass('active');
                    $('#co_today_badge').removeClass('bg-danger').addClass('bg-secondary').html('<i class="fa fa-lock me-1"></i>Locked');
                    $('#co_today_desc').html(isShortTerm ? '<span class="text-danger fw-semibold">Check-in date is in future (' + checkin + ').</span>' : '<span class="text-danger fw-semibold">Not allowed. Must complete 1 month stay (eligible on or after ' + oneMonthFmt + ').</span>');

                    // Auto-select "Select Upcoming Date"
                    $('#radio_co_upcoming').prop('disabled', false).prop('checked', true).trigger('change');
                    $('#card_co_upcoming').addClass('active');

                    $('#co_badge_quick_indicator').html(isShortTerm ? '<i class="fa fa-calendar me-1"></i>Check-in: ' + checkin : '<i class="fa fa-lock me-1"></i>Min: ' + oneMonthFmt).removeClass('bg-success text-white').addClass('bg-danger text-white');
                  } else {
                    // INMATE CAN CHECK OUT TODAY
                    $('#co_policy_warning').addClass('d-none');

                    // Enable "Check Out Today" option
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

                  // Move modal to body if needed to avoid z-index or stacking clipping
                  var modalEl = document.getElementById('checkoutModal');
                  if (modalEl && modalEl.parentNode !== document.body) {
                    document.body.appendChild(modalEl);
                  }
                  var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                  modal.show();
                });

                // Clicking the "Pick Date" button or calendar icon opens the Flatpickr popup
                $(document).on('click', '#btn_open_calendar, #co_input_icon', function(e) {
                  e.preventDefault();
                  if (checkoutPicker) {
                    checkoutPicker.open();
                  }
                });

                // Toggle between Check Out Today and Select Upcoming Date
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

                // Clicking card triggers radio
                $(document).on('click', '.checkout-option-card', function(e) {
                  if ($(this).hasClass('disabled') || $(this).find('input[type="radio"]').is(':disabled')) {
                    e.preventDefault();
                    return false;
                  }
                  if (e.target.tagName !== 'INPUT') {
                    $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
                  }
                });

                // Submit checkout form via AJAX
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

                // --- Inmate Regenerate Password Modal Script ---
                function generateRandomPassword() {
                  var randNum = Math.floor(100 + Math.random() * 900);
                  var chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
                  var syms = ["@", "#", "$", "!", "&"];
                  var sym = syms[Math.floor(Math.random() * syms.length)];
                  var randChar = chars.charAt(Math.floor(Math.random() * chars.length));
                  var yr = new Date().getFullYear().toString().slice(-2);
                  return "Saiy" + randNum + sym + yr + randChar;
                }

                var currentRegenInmateId = null;
                var lastGeneratedCreds = null;

                $(document).on("click", ".btn-regen-pwd", function(e) {
                  e.preventDefault();
                  var id = $(this).data("id");
                  var name = $(this).data("name");
                  var uid = $(this).data("uid");
                  var email = $(this).data("email") || "";
                  var phone = $(this).data("phone") || "";

                  currentRegenInmateId = id;
                  $("#rgp_inmate_name").text(name || "Inmate");
                  $("#rgp_inmate_uid").text(uid || ("IN" + id));
                  $("#rgp_inmate_email").text(email || "No Email");
                  $("#rgp_inmate_phone").text(phone || "No Phone");

                  if (!email) {
                    $("#rgp_send_email_container").addClass("d-none");
                    $("#rgp_no_email_notice").removeClass("d-none");
                    $("#rgp_send_email").prop("checked", false);
                  } else {
                    $("#rgp_send_email_container").removeClass("d-none");
                    $("#rgp_no_email_notice").addClass("d-none");
                    $("#rgp_email_badge").text(email);
                    $("#rgp_send_email").prop("checked", true);
                  }

                  // Pre-fill suggested password
                  $("#rgp_password_input").val(generateRandomPassword());
                  $("#rgp_error_alert").addClass("d-none").text("");

                  // Show form step, hide success step
                  $("#rgp_step_form").removeClass("d-none");
                  $("#rgp_footer_form").removeClass("d-none");
                  $("#rgp_step_success").addClass("d-none");
                  $("#rgp_footer_success").addClass("d-none");

                  var modalEl = document.getElementById("regenPwdModal");
                  if (modalEl && modalEl.parentNode !== document.body) {
                    document.body.appendChild(modalEl);
                  }
                  var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                  modal.show();
                });

                $("#rgp_btn_suggest").on("click", function() {
                  $("#rgp_password_input").val(generateRandomPassword()).focus();
                });

                $("#rgp_btn_submit").on("click", function() {
                  var pwd = $("#rgp_password_input").val().trim();
                  if (!pwd || pwd.length < 6) {
                    $("#rgp_error_alert").removeClass("d-none").text("Password must be at least 6 characters long.");
                    return;
                  }

                  var $btn = $(this);
                  var origHtml = $btn.html();
                  $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin me-1"></i> Updating...');
                  $("#rgp_error_alert").addClass("d-none").text("");

                  $.ajax({
                    url: "<?php echo base_url('Admin/Inmates/RegeneratePassword'); ?>",
                    type: "POST",
                    data: {
                      inmates_id: currentRegenInmateId,
                      password: pwd,
                      send_email: $("#rgp_send_email").is(":checked") ? 1 : 0,
                      is_ajax: 1
                    },
                    dataType: "json",
                    success: function(res) {
                      $btn.prop("disabled", false).html(origHtml);
                      if (res && res.status) {
                        lastGeneratedCreds = res.credentials;
                        
                        var emailAddr = res.email_address;
                        if (!emailAddr || emailAddr === "None" || emailAddr === "-") {
                          emailAddr = $("#rgp_inmate_email").text().trim();
                        }

                        if (emailAddr && emailAddr !== "No Email" && emailAddr !== "None") {
                          $("#rgp_success_email").text(emailAddr);
                          $("#rgp_email_success_box").removeClass("d-none");
                          $("#rgp_no_email_box").addClass("d-none");
                        } else {
                          $("#rgp_fallback_pwd").text(res.credentials ? res.credentials.password : "");
                          $("#rgp_email_success_box").addClass("d-none");
                          $("#rgp_no_email_box").removeClass("d-none");
                        }

                        $("#rgp_step_form").addClass("d-none");
                        $("#rgp_footer_form").addClass("d-none");
                        $("#rgp_step_success").removeClass("d-none");
                        $("#rgp_footer_success").removeClass("d-none");
                      } else {
                        $("#rgp_error_alert").removeClass("d-none").text(res?.message || "Failed to regenerate password.");
                      }
                    },
                    error: function(xhr) {
                      $btn.prop("disabled", false).html(origHtml);
                      var err = "Server error. Please try again.";
                      try {
                        var json = JSON.parse(xhr.responseText);
                        if (json && json.message) err = json.message;
                      } catch(e) {}
                      $("#rgp_error_alert").removeClass("d-none").text(err);
                    }
                  });
                });

                $("#rgp_btn_copy_all").on("click", function() {
                  if (!lastGeneratedCreds) return;
                  var text = "Hello " + lastGeneratedCreds.name + ",\n" +
                             "Your Saiyoojyam Resident Portal login credentials have been updated:\n\n" +
                             "Portal URL: " + lastGeneratedCreds.portal_url + "\n" +
                             "Username / Login ID: " + lastGeneratedCreds.login_id + "\n" +
                             "Password: " + lastGeneratedCreds.password + "\n\n" +
                             "- Saiyoojyam Ladies Hostels Management";

                  navigator.clipboard.writeText(text).then(function() {
                    var $btn = $("#rgp_btn_copy_all");
                    var orig = $btn.html();
                    $btn.attr("class", "btn btn-success w-100 py-2 fw-bold").html('<i class="fa fa-check me-1.5"></i> Copied to Clipboard!');
                    setTimeout(function() {
                      $btn.attr("class", "btn btn-outline-primary w-100 py-2 fw-bold").html(orig);
                    }, 2500);
                  }).catch(function() {
                    alert("Could not copy automatically. Please copy the credentials manually from the box.");
                  });
                });
              });
            </script>
    
  </body>
</html>
