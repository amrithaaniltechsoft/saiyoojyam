<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
<!--header section start-->

   <?= $this->include('admin/includes/header')?>

<!--header section end-->

<!--simple calander start-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/admin/css/simple-calendar.css" />

<!--simple calander end-->

<style>
ul a {
  list-style-type: circle;
}
::marker {
    font-size: 20px;
    color: #ff561c;
}
.stat-widget {
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  border-radius: 16px !important;
}
.stat-widget:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08) !important;
}
.stat-widget .stat-link:hover .transition-arrow {
  transform: translateX(4px);
}
.transition-arrow {
  display: inline-block;
  transition: transform 0.2s ease;
}
.stat-icon-wrapper {
  transition: transform 0.3s ease;
}
.stat-widget:hover .stat-icon-wrapper {
  transform: scale(1.08);
}
.room-box {
    text-align: center;
    background: #e1e1e1;
    border-radius: 10px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 10px 0px;
   
}
.room-title {
    font-size: 15px;
    padding-top: 35px;
    color: #000000b5;
}
.room-available {
    font-size: 18px;
    margin-top: -20px;
    color: #000000b5;
}




/*calander style start*/


#calender-div {
  max-width: 700px;
  margin: 30px auto;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-family: 'Segoe UI', sans-serif;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  overflow: hidden;
}

/* Calendar container */
.calendar {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  border: 1px solid #e2e8f0;
  overflow: hidden;
}

/* Calendar header: month/year + nav */
.calendar .calendar-header {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  color: white;
  padding: 16px 20px;
  font-size: 18px;
  text-align: center;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
}

/* Navigation buttons */
.calendar .calendar-header button {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: none;
  padding: 6px 12px;
  margin: 0 5px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  backdrop-filter: blur(8px);
  transition: all 0.2s ease;
}
.calendar .calendar-header button:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: scale(1.05);
}

/* Day names (Sun to Sat) */
.calendar .calendar-days {
  display: flex;
  background-color: #f8fafc;
  font-weight: 700;
  border-bottom: 1px solid #e2e8f0;
}
.calendar .calendar-days .day {
  flex: 1;
  text-align: center;
  padding: 12px;
  color: #475569;
  font-size: 13px;
  text-transform: uppercase;
}

/* Calendar dates */
.calendar .calendar-body {
  display: flex;
  flex-wrap: wrap;
}
.calendar .calendar-body .day {
  flex: 1 0 14.2857%;
  height: 75px;
  border: 1px solid #f1f5f9;
  text-align: center;
  padding: 8px;
  box-sizing: border-box;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
  font-size: 15px;
  font-weight: 500;
  color: #334155;
}

/* Today highlight */
.calendar .calendar-body .day.today {
  background-color: #e0e7ff;
  border: 2px solid #6366f1;
  color: #4338ca;
  font-weight: 700;
}

/* Hover effect */
.calendar .calendar-body .day:hover {
  background-color: #f1f5f9;
}

/* Selected day */
.calendar .day.selected {
  background: linear-gradient(135deg, #ff7033 0%, #ff561c 100%) !important;
  color: white !important;
  border: 2px solid #e0440d !important;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(255, 86, 28, 0.35);
  border-radius: 8px;
}
.calendar .day.selected:hover {
  border: 2px solid #e0440d !important;
}

/* Event indicator dot (optional if you add events) */
.calendar .calendar-body .day .event {
  width: 6px;
  height: 6px;
  background-color: #28a745;
  border-radius: 50%;
  position: absolute;
  bottom: 8px;
  left: 50%;
  transform: translateX(-50%);
}
.calendar header .btn-next {
    top: 10px;
    right: 14px;
}

.calendar header .btn-prev {
    top: 10px;
    left: 14px;
   
}


.card_div{

  display: flex;
    align-items: center;
    justify-content: center;
}


/*calander style end*/

/*room number box style start*/

.room-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
  gap: 12px;
  max-height: 480px;
  overflow-y: auto;
  padding: 4px;
}

.room-cell {
  background: #ffffff;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  padding: 14px 8px 12px 8px;
  text-align: center;
  color: #0f172a;
  font-weight: 700;
  font-size: 14px;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
  transition: all 0.25s ease;
  position: relative;
  overflow: hidden;
}

.room-cell::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #ff7033 0%, #ff561c 100%);
  opacity: 0;
  transition: opacity 0.2s ease;
}

.room-cell:hover {
  border-color: #ff561c;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255, 86, 28, 0.15);
}

.room-cell:hover::before {
  opacity: 1;
}

.room-cell span {
  display: inline-block;
  margin-top: 6px;
  font-size: 11px;
  font-weight: 700;
  color: #047857;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-radius: 20px;
  padding: 2px 10px;
  letter-spacing: 0.2px;
}


/*end*/


@keyframes pulse-ring {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 86, 28, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 12px rgba(255, 86, 28, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 86, 28, 0); }
}
.pulse-icon {
  animation: pulse-ring 2s infinite;
}
@keyframes pulse-badge {
  0% { transform: scale(1); }
  50% { transform: scale(1.15); }
  100% { transform: scale(1); }
}
@keyframes pulse-highlight {
  0% { box-shadow: 0 0 0 0 rgba(255, 86, 28, 0.8); }
  50% { box-shadow: 0 0 0 16px rgba(255, 86, 28, 0); }
  100% { box-shadow: 0 0 0 0 rgba(255, 86, 28, 0); }
}
.section-highlight {
  animation: pulse-highlight 1.5s ease-in-out 3;
  border: 2px solid #ff561c !important;
  border-radius: 12px;
}

/* Modal High Stacking Context */
.modal {
  z-index: 10600 !important;
}
.modal-backdrop {
  z-index: 10550 !important;
}
.modal-dialog {
  z-index: 10610 !important;
}
#pending-bookings-section {
  position: relative;
  z-index: 1 !important;
}
#pending-bookings-section .card {
  position: relative;
  z-index: 1 !important;
  width: 100% !important;
  height: auto !important;
}

/* Modal Close Button Fix - Prevent Sneat displacement & clipping */
.modal .modal-header {
  position: relative !important;
}
.modal .modal-header .btn-close,
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
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
  font-size: 16px !important;
  line-height: 1 !important;
}
.modal .modal-header .btn-close:hover,
.modal .modal-header .btn-modal-close:hover {
  background: #ffffff !important;
  color: #ff561c !important;
  border-color: #ffffff !important;
  transform: scale(1.08) !important;
  opacity: 1 !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
}
.modal .modal-header .btn-close::before,
.modal .modal-header .btn-modal-close::before {
  display: none !important;
}
</style>





          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                 
                <!---->
                <!-- Widget 1: Today's Check In's -->
                <div class="col-xl-3 col-md-6 col-12 mb-4">
                  <div class="card stat-widget h-100 border-0 shadow-sm" style="border-radius:16px;background:#ffffff;border:1px solid #edf2f7;transition:all 0.3s ease;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                      <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper" style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg, #10b981 0%, #059669 100%);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px rgba(16,185,129,0.25);">
                          <i class="fa fa-sign-in" style="font-size:22px;"></i>
                        </div>
                        <span class="badge rounded-pill" style="background:#ecfdf5;color:#047857;font-size:11px;font-weight:700;padding:5px 10px;border:1px solid #a7f3d0;">
                          <i class="fa fa-calendar-check-o me-1"></i> Today
                        </span>
                      </div>
                      <div>
                        <h3 class="mb-1 fw-bold text-dark" style="font-size:32px;letter-spacing:-0.5px;"><?php echo $todays_check_in;?></h3>
                        <p class="mb-0 text-muted fw-semibold" style="font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Today's Check In's</p>
                      </div>
                      <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                        <a href="<?= base_url(); ?>Admin/Inmates?check_in=<?= date('Y-m-d'); ?>" class="stat-link text-decoration-none fw-bold" style="color:#059669;font-size:12.5px;">
                          View Inmates <i class="fa fa-arrow-right ms-1 transition-arrow"></i>
                        </a>
                        <small class="text-muted" style="font-size:11px;">Active Arrivals</small>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Widget 2: Today's Check Out's -->
                <div class="col-xl-3 col-md-6 col-12 mb-4">
                  <div class="card stat-widget h-100 border-0 shadow-sm" style="border-radius:16px;background:#ffffff;border:1px solid #edf2f7;transition:all 0.3s ease;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                      <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper" style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px rgba(2,132,199,0.25);">
                          <i class="fa fa-sign-out" style="font-size:22px;"></i>
                        </div>
                        <span class="badge rounded-pill" style="background:#f0f9ff;color:#0369a1;font-size:11px;font-weight:700;padding:5px 10px;border:1px solid #bae6fd;">
                          <i class="fa fa-clock-o me-1"></i> Today
                        </span>
                      </div>
                      <div>
                        <h3 class="mb-1 fw-bold text-dark" style="font-size:32px;letter-spacing:-0.5px;"><?php echo $todays_check_out; ?></h3>
                        <p class="mb-0 text-muted fw-semibold" style="font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Today's Check Out's</p>
                      </div>
                      <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                        <a href="<?= base_url(); ?>Admin/Inmates?check_out=<?= date('Y-m-d'); ?>" class="stat-link text-decoration-none fw-bold" style="color:#0284c7;font-size:12.5px;">
                          View Departures <i class="fa fa-arrow-right ms-1 transition-arrow"></i>
                        </a>
                        <small class="text-muted" style="font-size:11px;">Completed Stays</small>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Widget 3: Active Inmates -->
                <div class="col-xl-3 col-md-6 col-12 mb-4">
                  <div class="card stat-widget h-100 border-0 shadow-sm" style="border-radius:16px;background:#ffffff;border:1px solid #edf2f7;transition:all 0.3s ease;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                      <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper" style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px rgba(79,70,229,0.25);">
                          <i class="fa fa-users" style="font-size:22px;"></i>
                        </div>
                        <span class="badge rounded-pill" style="background:#eef2ff;color:#4338ca;font-size:11px;font-weight:700;padding:5px 10px;border:1px solid #c7d2fe;">
                          <i class="fa fa-check-circle me-1"></i> Current
                        </span>
                      </div>
                      <div>
                        <h3 class="mb-1 fw-bold text-dark" style="font-size:32px;letter-spacing:-0.5px;"><?php echo $active_inmates;?></h3>
                        <p class="mb-0 text-muted fw-semibold" style="font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Active Inmates</p>
                      </div>
                      <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                        <a href="<?= base_url(); ?>Admin/Inmates/index/active" class="stat-link text-decoration-none fw-bold" style="color:#4f46e5;font-size:12.5px;">
                          Manage Inmates <i class="fa fa-arrow-right ms-1 transition-arrow"></i>
                        </a>
                        <small class="text-muted" style="font-size:11px;">Occupied Residents</small>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Widget 4: Pending Bookings -->
                <div class="col-xl-3 col-md-6 col-12 mb-4">
                  <div class="card stat-widget h-100 border-0 shadow-sm" style="border-radius:16px;background:<?php echo (!empty($pending_bookings_count) && $pending_bookings_count > 0) ? 'linear-gradient(145deg, #ffffff 0%, #fff7f4 100%)' : '#ffffff'; ?>;border:1px solid <?php echo (!empty($pending_bookings_count) && $pending_bookings_count > 0) ? '#ffccba' : '#edf2f7'; ?>;transition:all 0.3s ease;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                      <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon-wrapper <?php echo (!empty($pending_bookings_count) && $pending_bookings_count > 0) ? 'pulse-icon' : ''; ?>" style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg, #ff7033 0%, #ff561c 100%);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px rgba(255,86,28,0.28);">
                          <i class="fa fa-clock-o" style="font-size:22px;"></i>
                        </div>
                        <?php if (!empty($pending_bookings_count) && $pending_bookings_count > 0): ?>
                          <span class="badge rounded-pill bg-danger text-white pulse-badge" style="font-size:11px;font-weight:700;padding:5px 10px;">
                            <?php echo $pending_bookings_count; ?> Awaiting
                          </span>
                        <?php else: ?>
                          <span class="badge rounded-pill" style="background:#ecfdf5;color:#047857;font-size:11px;font-weight:700;padding:5px 10px;border:1px solid #a7f3d0;">
                            <i class="fa fa-check me-1"></i> All Clear
                          </span>
                        <?php endif; ?>
                      </div>
                      <div>
                        <h3 class="mb-1 fw-bold" style="font-size:32px;letter-spacing:-0.5px;color:<?php echo (!empty($pending_bookings_count) && $pending_bookings_count > 0) ? '#ff561c' : '#0f172a'; ?>;">
                          <?php echo $pending_bookings_count ?? 0; ?>
                        </h3>
                        <p class="mb-0 text-muted fw-semibold" style="font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Pending Bookings</p>
                      </div>
                      <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                        <a href="#pending-bookings-section" class="stat-link text-decoration-none fw-bold" style="color:#ff561c;font-size:12.5px;">
                          Review Requests <i class="fa fa-arrow-right ms-1 transition-arrow"></i>
                        </a>
                        <small class="text-muted" style="font-size:11px;">Action Required</small>
                      </div>
                    </div>
                  </div>
                </div>





<!-- Pending Booking Requests Section Start -->
                <div class="col-12 mt-4" id="pending-bookings-section">
                  <div class="card shadow-sm border-0" style="border-radius:12px;overflow:hidden;width:100%;height:auto;">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2" style="background:#fff;border-bottom:1px solid #eaeaea;padding:16px 20px;width:100%;">
                      <div>
                        <h5 class="mb-0 text-dark fw-bold d-flex align-items-center gap-2">
                          <i class="fa fa-bell text-warning" style="font-size:20px;"></i>
                          Pending Booking Requests
                          <span class="badge bg-warning text-dark rounded-pill ms-2"><?php echo count($pending_bookings ?? []); ?></span>
                        </h5>
                        <small class="text-muted">Online room reservations submitted and paid by guests awaiting admin approval and inmate account creation.</small>
                      </div>
                      <?php if (!empty($pending_bookings)): ?>
                        <span class="badge text-white px-3 py-2" style="background:#ff561c;font-size:12px;border-radius:8px;">
                          <?php echo count($pending_bookings); ?> Request<?php echo count($pending_bookings) > 1 ? 's' : ''; ?> Awaiting Approval
                        </span>
                      <?php endif; ?>
                    </div>

                    <div class="card-body p-0" style="width:100%;">
                      <?php if (empty($pending_bookings)): ?>
                        <div class="text-center py-5 text-muted">
                          <i class="fa fa-check-circle text-success" style="font-size:48px;display:block;margin-bottom:10px;"></i>
                          <h6 class="fw-semibold text-secondary">No Pending Booking Requests</h6>
                          <p class="mb-0 text-muted" style="font-size:13px;">All online room bookings have been reviewed and approved.</p>
                        </div>
                      <?php else: ?>
                        <div class="table-responsive text-nowrap">
                          <table class="table table-hover align-middle mb-0" style="font-size:13px;width:100%;">
                            <thead style="background:#f8f9fa;">
                              <tr>
                                <th style="width:90px;">UID</th>
                                <th>Guest Details</th>
                                <th>Building &amp; Room</th>
                                <th>Check-in Date</th>
                                <th>Amount Paid</th>
                                <th>Proof / Photo</th>
                                <th>Status</th>
                                <th style="text-align:center;width:200px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($pending_bookings as $booking): 
                                $bName = !empty($booking->building_name) ? $booking->building_name : 'Hostel';
                                $rName = !empty($booking->rooms_name) ? 'Room ' . $booking->rooms_name : 'Room #' . $booking->inmates_rooms;
                                $rtName = !empty($booking->room_type_name) ? $booking->room_type_name : '';
                                $checkInFmt = !empty($booking->inmates_check_in_date) ? date('d-m-Y', strtotime($booking->inmates_check_in_date)) : '-';
                                $paidAmt = !empty($booking->invoice_paid_amount) ? $booking->invoice_paid_amount : (!empty($booking->invoice_total) ? $booking->invoice_total : ($booking->inmates_caution_deposit + $booking->inmates_admission_fee));
                                $idProofUrl = !empty($booking->inmates_id_proof) ? base_url('uploads/inmates/' . $booking->inmates_id_proof) : '';
                                $photoUrl = !empty($booking->inmates_photo) ? base_url('uploads/inmates/' . $booking->inmates_photo) : '';
                              ?>
                                <tr id="booking-row-<?php echo $booking->inmates_id; ?>">
                                  <td>
                                    <span class="badge font-monospace fw-bold" style="background:#e8f4fd;color:#0d6efd;font-size:12px;">
                                      <?php echo $booking->inmates_uid ?: 'IN' . str_pad($booking->inmates_id, 6, '0', STR_PAD_LEFT); ?>
                                    </span>
                                    <div class="text-muted" style="font-size:11px;margin-top:2px;">
                                      <?php echo date('d M Y', strtotime($booking->inmates_created_at ?? date('Y-m-d'))); ?>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="fw-bold text-dark" style="font-size:14px;"><?php echo esc($booking->inmates_name); ?></div>
                                    <div class="text-muted" style="font-size:12px;">
                                      <i class="fa fa-envelope me-1"></i><?php echo esc($booking->inmates_email ?: 'No email entered'); ?><br>
                                      <i class="fa fa-phone me-1"></i><?php echo esc($booking->inmates_phone_no); ?>
                                      <?php if(!empty($booking->inmates_age)): ?><span class="badge bg-light text-secondary ms-1"><?php echo $booking->inmates_age; ?> yrs</span><?php endif; ?>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="fw-semibold text-dark"><?php echo esc($bName); ?></div>
                                    <div class="text-primary fw-medium" style="font-size:12px;">
                                      <?php echo esc($rName); ?> <?php echo $rtName ? '(' . esc($rtName) . ')' : ''; ?>
                                    </div>
                                    <span class="badge" style="background:#e0f2fe;color:#0369a1;font-size:11px;"><?php echo esc($booking->duration_stay ?: 'Long Term'); ?></span>
                                  </td>
                                  <td>
                                    <span class="fw-semibold text-dark"><?php echo $checkInFmt; ?></span>
                                  </td>
                                  <td>
                                    <div class="fw-bold text-success" style="font-size:14px;">
                                      ₹<?php echo number_format((float)$paidAmt, 2); ?>
                                    </div>
                                    <span class="badge bg-success" style="font-size:10px;"><i class="fa fa-check me-1"></i>PAID</span>
                                  </td>
                                  <td>
                                    <div class="d-flex gap-1">
                                      <?php if ($idProofUrl): ?>
                                        <a href="<?php echo $idProofUrl; ?>" target="_blank" class="btn btn-xs btn-outline-secondary" title="View ID Proof">
                                          <i class="fa fa-id-card"></i> ID
                                        </a>
                                      <?php endif; ?>
                                      <?php if ($photoUrl): ?>
                                        <a href="<?php echo $photoUrl; ?>" target="_blank" class="btn btn-xs btn-outline-secondary" title="View Photo">
                                          <i class="fa fa-image"></i> Photo
                                        </a>
                                      <?php endif; ?>
                                      <?php if (!$idProofUrl && !$photoUrl): ?>
                                        <span class="text-muted" style="font-size:11px;">None</span>
                                      <?php endif; ?>
                                    </div>
                                  </td>
                                  <td>
                                    <span class="badge bg-warning text-dark" style="font-size:11px;padding:6px 10px;">
                                      <i class="fa fa-clock-o me-1"></i>Pending Approval
                                    </span>
                                  </td>
                                  <td style="text-align:center;">
                                    <div class="d-inline-flex gap-1">
                                      <button type="button" 
                                        class="btn btn-sm text-white btn-approve-modal"
                                        style="background:#ff561c;border-color:#ff561c;font-weight:600;"
                                        data-id="<?php echo $booking->inmates_id; ?>"
                                        data-uid="<?php echo esc($booking->inmates_uid ?: 'IN' . str_pad($booking->inmates_id, 6, '0', STR_PAD_LEFT)); ?>"
                                        data-name="<?php echo esc($booking->inmates_name); ?>"
                                        data-email="<?php echo esc($booking->inmates_email); ?>"
                                        data-phone="<?php echo esc($booking->inmates_phone_no); ?>"
                                        data-room="<?php echo esc($rName . ' - ' . $bName); ?>"
                                        data-checkin="<?php echo $checkInFmt; ?>"
                                        data-paid="<?php echo number_format((float)$paidAmt, 2); ?>"
                                      >
                                        <i class="fa fa-check-circle me-1"></i>Approve &amp; Set Login
                                      </button>
                                      <button type="button" 
                                        class="btn btn-sm btn-outline-danger btn-reject-booking"
                                        data-id="<?php echo $booking->inmates_id; ?>"
                                        data-name="<?php echo esc($booking->inmates_name); ?>"
                                        title="Reject Booking"
                                      >
                                        <i class="fa fa-times"></i>
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <!-- Pending Booking Requests Section End -->

                



                <!---->


                <!---->

                <div class="col-lg-6 mb-4 mt-4">
                  <div class="card h-100 shadow-sm border-0" style="border-radius:16px;overflow:hidden;border:1px solid #edf2f7;background:#ffffff;">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 p-3.5" style="background:#ffffff;border-bottom:1px solid #edf2f7;">
                      <div class="d-flex align-items-center gap-2.5">
                        <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 8px rgba(79,70,229,0.15);">
                          <i class="fa fa-calendar" style="font-size:16px;"></i>
                        </div>
                        <div>
                          <h6 class="mb-0 fw-bold text-dark" style="font-size:15px;">Date Picker Calendar</h6>
                          <small class="text-muted" style="font-size:11.5px;">Click any date to filter room occupancy</small>
                        </div>
                      </div>
                      <a href="<?= base_url(); ?>Admin/Inmates/RentalDetails" target="_blank" class="btn btn-sm btn-outline-primary fw-bold" style="font-size:12px;border-radius:8px;padding:6px 12px;">
                        <i class="fa fa-calendar-check-o me-1"></i> Open Rental Calendar <i class="fa fa-external-link ms-1" style="font-size:10px;"></i>
                      </a>
                    </div>
                    <div class="card-body p-3.5">
                      <div id="calender-div" class="check_date"></div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 mb-4 mt-4">
                  <div class="card h-100 shadow-sm border-0" style="border-radius:16px;overflow:hidden;border:1px solid #edf2f7;background:#ffffff;">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2.5 p-3" style="background:#ffffff;border-bottom:1px solid #edf2f7;">
                      <div class="d-flex align-items-center gap-2.5">
                        <div style="width:36px;height:36px;border-radius:10px;background:#fff2ed;color:#ff561c;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 8px rgba(255,86,28,0.15);flex-shrink:0;">
                          <i class="fa fa-bed" style="font-size:16px;"></i>
                        </div>
                        <div>
                          <h6 class="mb-0 fw-bold text-dark" id="avail_rooms_label" style="font-size:14.5px;">Available Rooms (<?php echo date('d-m-Y'); ?>)</h6>
                          <small class="text-muted" style="font-size:11px;">Click room for details &amp; tariff</small>
                        </div>
                      </div>

                      <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end">
                        <!-- Search Box for Available Rooms -->
                        <div class="position-relative" style="min-width:140px;max-width:210px;flex:1;">
                          <input type="text" id="search_available_rooms" class="form-control form-control-sm ps-4 pe-4" placeholder="Search room (e.g. 207)..." style="border-radius:8px;font-size:12px;border:1px solid #e2e8f0;background:#f8fafc;height:32px;" autocomplete="off" />
                          <i class="fa fa-search text-muted position-absolute" style="left:10px;top:50%;transform:translateY(-50%);font-size:11px;pointer-events:none;"></i>
                          <button type="button" id="clear_room_search" class="btn btn-link p-0 text-muted position-absolute d-none" style="right:8px;top:50%;transform:translateY(-50%);font-size:15px;line-height:1;text-decoration:none;" title="Clear search">&times;</button>
                        </div>

                        <a href="<?= base_url(); ?>Admin/Rooms/Available" target="_blank" class="btn btn-sm text-white fw-bold d-none d-sm-inline-flex align-items-center" style="background:#ff561c;border-color:#ff561c;font-size:11.5px;border-radius:8px;padding:6px 10px;white-space:nowrap;height:32px;">
                          <i class="fa fa-th-list me-1"></i> Full List <i class="fa fa-external-link ms-1" style="font-size:9px;"></i>
                        </a>
                      </div>
                    </div>
                    <div class="card-body p-3.5">
                      <div class="room-grid room_available">
                        <?php foreach($available_rooms as $rooms){ ?> 
                          <div class="room-cell" data-room-id="<?php echo $rooms['room_id']; ?>" style="cursor:pointer;" title="Click to view room &amp; tariff details"><?php echo $rooms['room_name']; ?><br><span><?php echo $rooms['available']; ?> Persons</span></div>
                        <?php } ?>
                      </div>
                      <div id="no_rooms_found" class="text-center py-4 text-muted d-none">
                        <i class="fa fa-search text-muted mb-1 d-block" style="font-size:24px;opacity:0.4;"></i>
                        <span class="fw-semibold" style="font-size:13px;">No available rooms matching "<span id="search_query_display"></span>"</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!----->

          

                <!---->
                
               
                
                


                

                

              </div>
            </div>
            <!-- / Content -->

            <!--footer section start-->

            <?= $this->include('admin/includes/footer') ?>

            <!--footer section end-->

            <!--simple calander start-->

            <script type="text/javascript" src="<?php echo base_url();?>public/assets/admin/vendor/js/jquery.simple-calendar.min.js"></script>

            <script>
              var $calendar;
              var activeSelectedDate = "<?php echo date('Y-m-d'); ?>";

              $(document).ready(function () {
                  let container = $("#calender-div").simpleCalendar({
                    fixedStartDay: 0,
                    disableEmptyDetails: true,
                    onDateSelect: function(date, events) {
                      const clickedDate = date.toLocaleDateString('en-CA');  
                      activeSelectedDate = clickedDate;
                      console.log("Clicked date:", clickedDate);

                      $('#avail_rooms_label').text('Available Rooms (' + clickedDate.split('-').reverse().join('-') + ')');

                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/AvaliableRoom",
                        type: "POST",
                        data: {Selected_date :clickedDate},
                        success: function(data) {
                          var data = JSON.parse(data);
                          $('.room_available').html(data.rooms);
                          filterAvailableRooms();
                        }
                      });
                    }
                  });

                  // Real-time search filter for Available Rooms
                  function filterAvailableRooms() {
                    var query = ($("#search_available_rooms").val() || "").toLowerCase().trim();
                    if (query) {
                      $("#clear_room_search").removeClass("d-none");
                    } else {
                      $("#clear_room_search").addClass("d-none");
                    }

                    var visibleCount = 0;
                    $(".room_available .room-cell").each(function() {
                      var roomText = $(this).text().toLowerCase();
                      if (!query || roomText.indexOf(query) !== -1) {
                        $(this).show();
                        visibleCount++;
                      } else {
                        $(this).hide();
                      }
                    });

                    if (visibleCount === 0 && query) {
                      $("#search_query_display").text(query);
                      $("#no_rooms_found").removeClass("d-none");
                    } else {
                      $("#no_rooms_found").addClass("d-none");
                    }
                  }

                  $(document).on("input", "#search_available_rooms", filterAvailableRooms);

                  $(document).on("click", "#clear_room_search", function() {
                    $("#search_available_rooms").val("").focus();
                    filterAvailableRooms();
                  });

                  $(document).on("keydown", "#search_available_rooms", function(e) {
                    if (e.key === "Escape") {
                      $(this).val("");
                      filterAvailableRooms();
                    }
                  });

                  container.on('click', '.day', function (e) {
                    $('.calendar .day').removeClass('selected');
                    $(this).addClass('selected');
                  });

                  $calendar = container.data('plugin_simpleCalendar');

                  // Click handler for room cells to open Room Details & Tariff modal
                  $(document).on("click", ".room-cell", function() {
                    var roomId = $(this).data("room-id");
                    if (!roomId) return;
                    openRoomDetailsModal(roomId, activeSelectedDate);
                  });
              });

              function openRoomDetailsModal(roomId, selectedDate) {
                selectedDate = selectedDate || activeSelectedDate || "<?php echo date('Y-m-d'); ?>";

                var modalEl = document.getElementById("roomDetailsModal");
                if (modalEl && modalEl.parentNode !== document.body) {
                  document.body.appendChild(modalEl);
                }

                $("#rdm_loading").removeClass("d-none");
                $("#rdm_content").addClass("d-none");
                $("#rdm_room_name").text("Loading Room...");

                if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
                  var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                  modal.show();
                } else {
                  $("#roomDetailsModal").modal("show");
                }

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
                        var rowHtml = "<tr>" +
                          "<td class='ps-3'><strong class='text-dark'>" + (inm.name || '-') + "</strong></td>" +
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
                  },
                  error: function(xhr, status, err) {
                    $("#rdm_loading").addClass("d-none");
                    alert("Error loading room details. Please try again.");
                  }
                });
              }
            </script>

            <!--simple calander end-->

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
            <div class="card-body" style="padding:12px 16px;">
              <div class="d-flex align-items-center justify-content-between" style="margin-bottom:8px;">
                <span class="fw-bold text-dark" style="font-size:13px;">
                  <i class="fa fa-pie-chart text-primary me-1"></i> Bed Occupancy (<span id="rdm_date_label">Today</span>)
                </span>
                <span class="badge rounded-pill" id="rdm_occupancy_badge" style="font-size:11px;">Available</span>
              </div>
              <div class="row g-2 text-center" style="margin-bottom:8px;">
                <div class="col-4">
                  <div class="rounded-3" style="background:#f1f5f9;padding:6px 4px;border:1px solid #e2e8f0;">
                    <div class="text-muted fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;line-height:1.1;">Capacity</div>
                    <div class="d-flex align-items-baseline justify-content-center gap-1" style="line-height:1.1;margin-top:2px;">
                      <span class="fw-bold text-dark" style="font-size:18px;line-height:1.1;" id="rdm_cap_val">0</span>
                      <span class="text-muted fw-semibold" style="font-size:11px;">Beds</span>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="rounded-3" style="background:#fef2f2;padding:6px 4px;border:1px solid #fee2e2;">
                    <div class="fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;line-height:1.1;color:#dc2626;">Occupied</div>
                    <div class="d-flex align-items-baseline justify-content-center gap-1" style="line-height:1.1;margin-top:2px;">
                      <span class="fw-bold text-danger" style="font-size:18px;line-height:1.1;" id="rdm_occ_val">0</span>
                      <span class="text-muted fw-semibold" style="font-size:11px;">Beds</span>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="rounded-3" style="background:#ecfdf5;padding:6px 4px;border:1px solid #d1fae5;">
                    <div class="fw-semibold" style="font-size:10.5px;text-transform:uppercase;letter-spacing:0.3px;line-height:1.1;color:#059669;">Available</div>
                    <div class="d-flex align-items-baseline justify-content-center gap-1" style="line-height:1.1;margin-top:2px;">
                      <span class="fw-bold text-success" style="font-size:18px;line-height:1.1;" id="rdm_avail_val">0</span>
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

          <!-- 2. Tariff Details Section (User Request: "if tariff added show that also") -->
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
                  <span class="text-secondary fw-semibold ms-2" style="margin-left:8px;">Estimated Total Move-in Amount:</span>
                  <strong class="text-dark me-2" style="font-size:14px;margin-right:4px;">₹<span id="rdm_tariff_total">0.00</span></strong>
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
          <a href="<?= base_url(); ?>Admin/Inmates/RentalDetails" target="_blank" class="btn btn-sm btn-outline-primary fw-semibold" style="font-size:12px;border-radius:8px;">
            <i class="fa fa-calendar me-1"></i> Rental Calendar
          </a>
          <a href="<?= base_url(); ?>Admin/Rooms/Available" target="_blank" class="btn btn-sm btn-outline-secondary fw-semibold" style="font-size:12px;border-radius:8px;">
            <i class="fa fa-th-list me-1"></i> All Available Rooms
          </a>
        </div>
        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" style="font-size:12.5px;border-radius:8px;">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Room Details & Tariff Modal End -->
    

            

<!-- Modals Placed at Body Level to Prevent Z-Index Overlap -->
<?php if (!empty($pending_bookings_count) && $pending_bookings_count > 0): ?>
                <!-- Pending Bookings Welcome Notification Modal -->
                <div class="modal fade" id="pendingAlertModal" tabindex="-1" aria-labelledby="pendingAlertModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 15px 35px rgba(0,0,0,0.25);overflow:hidden;">
                      <div class="modal-header text-white pe-5 position-relative" style="background: linear-gradient(135deg, #ff561c 0%, #e0450d 100%);padding:18px 22px;">
                        <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2 mb-0" id="pendingAlertModalLabel">
                          <span style="background:rgba(255,255,255,0.2);width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;">
                            <i class="fa fa-bell" style="font-size:16px;"></i>
                          </span>
                          Pending Booking Requests Alert
                        </h5>
                        <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                          <div style="width:70px;height:70px;margin:0 auto;border-radius:50%;background:#fff3ee;border:2px solid #ff561c;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 15px rgba(255,86,28,0.2);">
                            <i class="fa fa-user-plus text-danger" style="font-size:32px;color:#ff561c !important;"></i>
                          </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">
                          <?php echo $pending_bookings_count; ?> Booking Request<?php echo $pending_bookings_count > 1 ? 's' : ''; ?> Awaiting Approval
                        </h5>
                        <p class="text-muted" style="font-size:13px;line-height:1.6;margin-bottom:20px;">
                          Guests have selected rooms and completed initial payment online. Please review their submitted details and generate inmate login credentials to officially admit them.
                        </p>

                        <!-- Quick List Preview -->
                        <div class="text-start bg-light rounded-3 p-3 mb-3 border" style="max-height:180px;overflow-y:auto;font-size:12px;">
                          <?php foreach (array_slice($pending_bookings ?? [], 0, 3) as $pb): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                              <div>
                                <strong class="text-dark"><?php echo esc($pb->inmates_name); ?></strong>
                                <div class="text-muted" style="font-size:11px;">
                                  <?php echo esc($pb->rooms_name ? 'Room ' . $pb->rooms_name : 'Room #' . $pb->inmates_rooms); ?> (<?php echo esc($pb->building_name ?: 'Hostel'); ?>)
                                </div>
                              </div>
                              <div class="text-end">
                                <span class="badge bg-success" style="font-size:10px;">PAID ₹<?php echo number_format((float)($pb->invoice_paid_amount ?: $pb->invoice_total), 2); ?></span>
                                <div class="text-muted" style="font-size:10px;">Check-in: <?php echo date('d-m-Y', strtotime($pb->inmates_check_in_date)); ?></div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>

                        <div class="d-grid gap-2">
                          <button type="button" class="btn text-white fw-bold py-2.5" id="btn_alert_goto_requests" style="background:#ff561c;border-radius:10px;font-size:14px;box-shadow:0 4px 12px rgba(255,86,28,0.3);">
                            <i class="fa fa-arrow-down me-1"></i> View &amp; Approve Requests Now
                          </button>
                          <button type="button" class="btn btn-outline-secondary py-2" data-bs-dismiss="modal" style="border-radius:10px;font-size:13px;">
                            Review Later
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
<!-- Approve Booking Modal Start -->
                <div class="modal fade" id="approveBookingModal" tabindex="-1" aria-labelledby="approveBookingModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;box-shadow:0 10px 30px rgba(0,0,0,0.2);">
                      <div class="modal-header pe-5 position-relative" style="background:#ff561c;color:#fff;">
                        <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2" id="approveBookingModalLabel">
                          <i class="fa fa-user-plus" style="font-size:22px;"></i>
                          Approve Booking &amp; Set Login
                        </h5>
                        <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      <form id="approveBookingForm" method="POST" action="<?php echo base_url('Admin/Inmates/ApproveBooking'); ?>">
                        <input type="hidden" name="inmates_id" id="modal_inmate_id" value="">
                        <input type="hidden" name="is_ajax" value="1">
                        
                        <div class="modal-body p-4">
                          <!-- Inmate Info Banner -->
                          <div class="p-3 mb-3 rounded" style="background:#fff3ee;border:1px solid #ffd4c4;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <span class="fw-bold text-dark" id="modal_display_name" style="font-size:15px;">Guest Name</span>
                              <span class="badge bg-primary font-monospace" id="modal_display_uid">IN000000</span>
                            </div>
                            <div class="text-muted" style="font-size:12px;">
                              <span id="modal_display_room">Room</span> · Check-in: <strong id="modal_display_checkin">-</strong> · Paid: <strong class="text-success" id="modal_display_paid">₹0</strong>
                            </div>
                          </div>

                          <p class="text-muted" style="font-size:12px;margin-bottom:15px;">
                            Inmate login credentials generated below. Once approved, the guest is officially registered as an active inmate and can log in with these details:
                          </p>

                          <!-- Username -->
                          <div class="mb-3">
                            <label class="form-label fw-semibold text-dark" for="modal_username" style="font-size:13px;">
                              Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                              <span class="input-group-text bg-light text-muted"><i class="fa fa-user"></i></span>
                              <input type="text" class="form-control bg-light" name="username" id="modal_username" required readonly placeholder="e.g. ananya" autocomplete="off" style="cursor:default;">
                            </div>
                            <small class="text-muted" style="font-size:11px;">System-generated unique username for login</small>
                          </div>

                          <!-- Email -->
                          <div class="mb-3">
                            <label class="form-label fw-semibold text-dark" for="modal_email" style="font-size:13px;">
                              Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                              <span class="input-group-text bg-light text-muted"><i class="fa fa-envelope"></i></span>
                              <input type="email" class="form-control bg-light" name="email" id="modal_email" required readonly placeholder="e.g. guest@email.com" style="cursor:default;">
                            </div>
                          </div>

                          <!-- Phone Number -->
                          <div class="mb-3">
                            <label class="form-label fw-semibold text-dark" for="modal_phone" style="font-size:13px;">
                              Phone Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                              <span class="input-group-text bg-light text-muted"><i class="fa fa-phone"></i></span>
                              <input type="tel" class="form-control bg-light" name="phone" id="modal_phone" required readonly placeholder="e.g. 9876543210" style="cursor:default;">
                            </div>
                          </div>

                          <!-- Password with Toggle & Generator -->
                          <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <label class="form-label fw-semibold text-dark mb-0" for="modal_password" style="font-size:13px;">
                                Login Password <span class="text-danger">*</span>
                              </label>
                              <div class="d-flex align-items-center gap-2">
                                <a href="javascript:void(0);" id="btn_modal_copy_pwd" class="text-secondary text-decoration-none" style="font-size:12px;cursor:pointer;">
                                  <i class="fa fa-copy"></i> Copy
                                </a>
                                <a href="javascript:void(0);" id="btn_modal_generate_pwd" class="text-primary text-decoration-none fw-semibold" style="font-size:12px;cursor:pointer;">
                                  <i class="fa fa-refresh"></i> Generate New
                                </a>
                              </div>
                            </div>
                            <div class="input-group">
                              <span class="input-group-text bg-light text-muted"><i class="fa fa-lock"></i></span>
                              <input type="text" class="form-control font-monospace" name="password" id="modal_password" required placeholder="Min. 8 characters (Upper, Lower, Number)" autocomplete="off">
                              <button class="btn btn-outline-secondary" type="button" id="btn_modal_toggle_pwd" title="Show / Hide Password">
                                <i class="fa fa-eye" id="icon_modal_pwd_eye"></i>
                              </button>
                            </div>
                            
                            <!-- Live Password Requirements Checklist -->
                            <div class="mt-2.5 p-3 rounded-3 border" style="background:#f8fafc;border-color:#cbd5e1;font-size:12.5px;">
                              <div class="fw-bold mb-2" style="color:#0f172a;font-size:13px;">
                                <i class="fa fa-shield me-1" style="color:#ff561c;"></i> Password Requirements:
                              </div>
                              <div class="row g-2">
                                <div class="col-sm-6">
                                  <div id="req_min_len" class="d-flex align-items-center p-2 rounded-2 border" style="background:#ffffff;border-color:#cbd5e1;color:#0f172a;font-weight:600;font-size:12.5px;transition:all 0.2s;">
                                    <i class="fa fa-circle-o me-2" style="color:#475569;font-size:13px;"></i>
                                    <span>Minimum 8 characters</span>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div id="req_lower" class="d-flex align-items-center p-2 rounded-2 border" style="background:#ffffff;border-color:#cbd5e1;color:#0f172a;font-weight:600;font-size:12.5px;transition:all 0.2s;">
                                    <i class="fa fa-circle-o me-2" style="color:#475569;font-size:13px;"></i>
                                    <span>One lowercase letter</span>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div id="req_upper" class="d-flex align-items-center p-2 rounded-2 border" style="background:#ffffff;border-color:#cbd5e1;color:#0f172a;font-weight:600;font-size:12.5px;transition:all 0.2s;">
                                    <i class="fa fa-circle-o me-2" style="color:#475569;font-size:13px;"></i>
                                    <span>One uppercase letter</span>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div id="req_number" class="d-flex align-items-center p-2 rounded-2 border" style="background:#ffffff;border-color:#cbd5e1;color:#0f172a;font-weight:600;font-size:12.5px;transition:all 0.2s;">
                                    <i class="fa fa-circle-o me-2" style="color:#475569;font-size:13px;"></i>
                                    <span>One number</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <small class="text-secondary d-block mt-1 fw-medium" style="font-size:11px;">System-assigned secure password sent to guest via email.</small>
                          </div>

                          <!-- Confirmation Checkbox -->
                          <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="modal_confirm_active" checked disabled>
                            <label class="form-check-label text-dark" for="modal_confirm_active" style="font-size:12px;">
                              Officially mark as <strong>Active Inmate</strong> and activate their booking
                            </label>
                          </div>

                          <div id="modal_approval_error" class="alert alert-danger mt-3 d-none" style="font-size:12px;padding:8px 12px;"></div>
                        </div>

                        <div class="modal-footer" style="background:#f8f9fa;">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn text-white" id="btn_confirm_approve" style="background:#ff561c;border-color:#ff561c;font-weight:600;">
                            <i class="fa fa-check-circle me-1"></i>Confirm &amp; Approve Inmate
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Approve Booking Modal End -->

<!-- Booking Approval Scripts Start -->
            <script>
              $(document).ready(function() {
                // Show Pending Alert Modal on Page Load if pending bookings exist
                if ($("#pendingAlertModal").length > 0) {
                  var alertModalEl = document.getElementById("pendingAlertModal");
                  if (alertModalEl && alertModalEl.parentNode !== document.body) {
                    document.body.appendChild(alertModalEl);
                  }
                  if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
                    var alertModal = bootstrap.Modal.getOrCreateInstance(alertModalEl);
                    alertModal.show();
                  } else {
                    $("#pendingAlertModal").modal("show");
                  }
                }

                $("#btn_alert_goto_requests").on("click", function() {
                  var alertModalEl = document.getElementById("pendingAlertModal");
                  if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
                    var alertModal = bootstrap.Modal.getInstance(alertModalEl);
                    if (alertModal) alertModal.hide();
                  } else {
                    $("#pendingAlertModal").modal("hide");
                  }

                  setTimeout(function() {
                    var target = document.getElementById("pending-bookings-section");
                    if (target) {
                      target.scrollIntoView({ behavior: "smooth", block: "start" });
                      target.classList.add("section-highlight");
                    }
                  }, 350);
                });

                // Auto-scroll and highlight if URL has #pending-bookings-section
                if (window.location.hash === "#pending-bookings-section") {
                  setTimeout(function() {
                    var target = document.getElementById("pending-bookings-section");
                    if (target) {
                      target.scrollIntoView({ behavior: "smooth", block: "start" });
                      target.classList.add("section-highlight");
                    }
                  }, 400);
                }

                function generateRandomPassword() {
                  var upper = "ABCDEFGHJKLMNPQRSTUVWXYZ"; // avoid confusing chars like I, O
                  var lower = "abcdefghijkmnopqrstuvwxyz"; // avoid confusing chars like l
                  var digits = "23456789"; // avoid 0, 1
                  var symbols = "!@#$%^&*";
                  var all = upper + lower + digits + symbols;

                  var chars = [
                    upper.charAt(Math.floor(Math.random() * upper.length)),
                    lower.charAt(Math.floor(Math.random() * lower.length)),
                    digits.charAt(Math.floor(Math.random() * digits.length)),
                    symbols.charAt(Math.floor(Math.random() * symbols.length))
                  ];

                  for (var i = 0; i < 8; i++) {
                    chars.push(all.charAt(Math.floor(Math.random() * all.length)));
                  }

                  // Shuffle
                  return chars.sort(function() { return 0.5 - Math.random(); }).join("");
                }

                function updatePasswordRequirements(val) {
                  val = val || "";
                  var hasLen = val.length >= 8;
                  var hasLower = /[a-z]/.test(val);
                  var hasUpper = /[A-Z]/.test(val);
                  var hasNumber = /[0-9]/.test(val);

                  function setBadge(elId, valid) {
                    var $el = $("#" + elId);
                    var $icon = $el.find("i");
                    // Remove all Bootstrap contextual text/color classes to prevent low-contrast template styles (e.g. #71dd37 lime text or #6c757d muted gray)
                    $el.removeClass("text-muted text-secondary text-danger text-success text-warning fw-semibold fw-bold");
                    $icon.removeClass("fa-circle fa-circle-o fa-check-circle fa-times-circle text-muted text-secondary text-danger text-success text-warning");

                    if (valid) {
                      $el.css({
                        "background": "#ecfdf5",
                        "border-color": "#86efac",
                        "color": "#065f46",
                        "font-weight": "700"
                      });
                      $icon.addClass("fa-check-circle me-2").css("color", "#059669");
                    } else if (val && val.length > 0) {
                      $el.css({
                        "background": "#fef2f2",
                        "border-color": "#fca5a5",
                        "color": "#991b1b",
                        "font-weight": "600"
                      });
                      $icon.addClass("fa-times-circle me-2").css("color", "#dc2626");
                    } else {
                      $el.css({
                        "background": "#ffffff",
                        "border-color": "#cbd5e1",
                        "color": "#0f172a",
                        "font-weight": "600"
                      });
                      $icon.addClass("fa-circle-o me-2").css("color", "#475569");
                    }
                  }

                  setBadge("req_min_len", hasLen);
                  setBadge("req_lower", hasLower);
                  setBadge("req_upper", hasUpper);
                  setBadge("req_number", hasNumber);

                  var allValid = hasLen && hasLower && hasUpper && hasNumber;
                  $("#btn_confirm_approve").prop("disabled", !allValid);
                  return allValid;
                }

                function sanitizeUsername(name) {
                  if (!name) return "inmate" + Math.floor(Math.random() * 900 + 100);
                  var clean = name.toLowerCase().replace(/[^a-z0-9]/g, "");
                  if (clean.length < 3) clean += Math.floor(Math.random() * 900 + 100);
                  return clean;
                }

                $(document).on("click", ".btn-approve-modal", function() {
                  var id = $(this).data("id");
                  var uid = $(this).data("uid");
                  var name = $(this).data("name");
                  var email = $(this).data("email");
                  var phone = $(this).data("phone");
                  var room = $(this).data("room");
                  var checkin = $(this).data("checkin");
                  var paid = $(this).data("paid");

                  $("#modal_inmate_id").val(id);
                  $("#modal_display_name").text(name);
                  $("#modal_display_uid").text(uid);
                  $("#modal_display_room").text(room);
                  $("#modal_display_checkin").text(checkin);
                  $("#modal_display_paid").text("₹" + paid);

                  $("#modal_username").val(sanitizeUsername(name));
                  $("#modal_email").val(email || "");
                  $("#modal_phone").val(phone || "");
                  
                  var initialPass = generateRandomPassword();
                  $("#modal_password").val(initialPass).attr("type", "text");
                  $("#icon_modal_pwd_eye").removeClass("fa-eye-slash").addClass("fa-eye");
                  updatePasswordRequirements(initialPass);
                  $("#modal_approval_error").addClass("d-none").text("");

                  var modalEl = document.getElementById("approveBookingModal");
                  if (modalEl && modalEl.parentNode !== document.body) {
                    document.body.appendChild(modalEl);
                  }
                  if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                  } else {
                    $("#approveBookingModal").modal("show");
                  }
                });

                $("#btn_modal_generate_pwd").on("click", function() {
                  var newPass = generateRandomPassword();
                  $("#modal_password").val(newPass).attr("type", "text");
                  $("#icon_modal_pwd_eye").removeClass("fa-eye-slash").addClass("fa-eye");
                  updatePasswordRequirements(newPass);
                });

                $("#modal_password").on("input", function() {
                  updatePasswordRequirements($(this).val());
                });

                $("#btn_modal_copy_pwd").on("click", function() {
                  var val = $("#modal_password").val();
                  if (!val) return;
                  if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(val);
                  } else {
                    var $temp = $("<input>");
                    $("body").append($temp);
                    $temp.val(val).select();
                    document.execCommand("copy");
                    $temp.remove();
                  }
                  var $btn = $(this);
                  var origHtml = $btn.html();
                  $btn.html('<i class="fa fa-check text-success"></i> Copied!');
                  setTimeout(function() {
                    $btn.html(origHtml);
                  }, 2000);
                });

                $("#btn_modal_toggle_pwd").on("click", function() {
                  var $pwd = $("#modal_password");
                  var isText = $pwd.attr("type") === "text";
                  $pwd.attr("type", isText ? "password" : "text");
                  $("#icon_modal_pwd_eye").toggleClass("fa-eye fa-eye-slash");
                });

                $("#approveBookingForm").on("submit", function(e) {
                  e.preventDefault();
                  var pwdVal = $("#modal_password").val();
                  if (!updatePasswordRequirements(pwdVal)) {
                    $("#modal_approval_error").removeClass("d-none").text("Please ensure password has at least 8 characters, 1 lowercase letter, 1 uppercase letter, and 1 number.");
                    return false;
                  }

                  var $btn = $("#btn_confirm_approve");
                  var origText = $btn.html();
                  $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin me-1"></i> Approving...');
                  $("#modal_approval_error").addClass("d-none").text("");

                  $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(res) {
                      $btn.prop("disabled", false).html(origText);
                      if (res && res.status) {
                        alert("Success! " + res.message);
                        location.reload();
                      } else {
                        $("#modal_approval_error").removeClass("d-none").text(res?.message || "Error approving booking.");
                      }
                    },
                    error: function(xhr) {
                      $btn.prop("disabled", false).html(origText);
                      var err = "Server error. Please try again.";
                      try {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) err = parsed.message;
                      } catch(e) {}
                      $("#modal_approval_error").removeClass("d-none").text(err);
                    }
                  });
                });

                $(document).on("click", ".btn-reject-booking", function() {
                  var id = $(this).data("id");
                  var name = $(this).data("name");
                  if (!confirm("Are you sure you want to reject the booking request for " + name + "?")) {
                    return;
                  }
                  $.ajax({
                    url: "<?php echo base_url('Admin/Inmates/RejectBooking'); ?>",
                    type: "POST",
                    data: { inmates_id: id, is_ajax: 1 },
                    dataType: "json",
                    success: function(res) {
                      if (res && res.status) {
                        alert(res.message);
                        location.reload();
                      } else {
                        alert(res?.message || "Failed to reject booking.");
                      }
                    },
                    error: function() {
                      alert("Server error while rejecting booking.");
                    }
                  });
                });
              });
            </script>
            <!-- Booking Approval Scripts End -->

  </body>
</html>
