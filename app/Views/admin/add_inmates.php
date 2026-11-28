<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <!-- Flatpickr CSS & Fancy Theme -->
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" rel="stylesheet"/>

  <style>
    /* Fancy Flatpickr Calendar Theme */
    .flatpickr-calendar {
      z-index: 10650 !important;
      border-radius: 18px !important;
      border: 1.5px solid #ffd8cb !important;
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.16), 0 4px 16px rgba(255, 86, 28, 0.15) !important;
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
      background: linear-gradient(135deg, #ff561c 0%, #e0440d 100%) !important;
      padding: 12px 10px !important;
      position: relative !important;
    }
    .flatpickr-calendar .flatpickr-month {
      color: #ffffff !important;
      fill: #ffffff !important;
      height: 38px !important;
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
      top: 12px !important;
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
      padding: 8px 0 !important;
    }
    .flatpickr-calendar .flatpickr-weekday {
      font-size: 11.5px !important;
      font-weight: 700 !important;
      color: #64748b !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
    }
    .flatpickr-calendar .flatpickr-days {
      padding: 8px 10px 12px 10px !important;
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
      font-size: 13.5px !important;
      font-weight: 600 !important;
      color: #1e293b !important;
      height: 38px !important;
      line-height: 38px !important;
      max-width: 40px !important;
      margin: 2px 0 !important;
      transition: all 0.15s ease !important;
    }
    .flatpickr-calendar .flatpickr-day:hover:not(.flatpickr-disabled) {
      background: #fff2ed !important;
      color: #ff561c !important;
      border-color: #ffd8cb !important;
      transform: translateY(-2px) scale(1.06) !important;
      box-shadow: 0 4px 10px rgba(255, 86, 28, 0.18) !important;
    }
    .flatpickr-calendar .flatpickr-day.today {
      border: 2px solid #ff561c !important;
      color: #ff561c !important;
      font-weight: 700 !important;
      background: #fff8f5 !important;
    }
    .flatpickr-calendar .flatpickr-day.selected,
    .flatpickr-calendar .flatpickr-day.selected:hover {
      background: linear-gradient(135deg, #ff561c 0%, #e0440d 100%) !important;
      color: #ffffff !important;
      border-color: #ff561c !important;
      font-weight: 700 !important;
      box-shadow: 0 6px 14px rgba(255, 86, 28, 0.4) !important;
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

    .fancy-datepicker-group .input-group-text {
      border-color: #e2e8f0;
      transition: all 0.2s ease;
    }
    .fancy-datepicker-group:focus-within .input-group-text {
      border-color: #ff561c;
    }
    .fancy-datepicker-group input.fancy-datepicker-input {
      background: #ffffff !important;
      cursor: pointer !important;
    }
    .fancy-datepicker-group:focus-within input.fancy-datepicker-input {
      border-color: #ff561c;
      box-shadow: none;
    }
  </style>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Layout & Basic with Icons -->
              <div class="row mb-6 gy-6">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                      <h5 class="mb-0">Add Inmates</h5>
                      <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                          <i class="bx bx-file me-1"></i> Import Excel / CSV
                        </button>
                        <a href="<?php echo base_url('Admin/Inmates/DownloadSample'); ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" title="Download Excel template">
                          <i class="bx bx-download me-1"></i> Sample Template
                        </a>
                      </div>
                    </div>
                    <div class="card-body">
                      <form id="add_form" enctype="multipart/form-data">

                        


<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_name" id="basic-default-name" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Age</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_age" id="basic-default-name" placeholder="e.g., 25" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="check_in-date-input">Join In Date</label>
                          <div class="col-sm-10">
                            <div class="input-group fancy-datepicker-group">
                              <span class="input-group-text bg-white border-end-0 text-primary" style="cursor:pointer;" id="join_calendar_icon">
                                <i class="fa fa-calendar-check-o text-primary" style="font-size:16px;"></i>
                              </span>
                              <input type="text" class="form-control border-start-0 border-end-0 text-dark join_in_date_clz fancy-datepicker-input" name="inmates_check_in_date" id="check_in-date-input" placeholder="Select join-in date..." autocomplete="off" required/>
                              <button class="btn btn-outline-primary px-3" type="button" id="btn_open_join_calendar" title="Choose Join Date">
                                <i class="fa fa-calendar me-1"></i> Pick Date
                              </button>
                            </div>
                            <small class="text-muted mt-1 d-block" style="font-size:11.5px;">Click to open the interactive calendar</small>
                          </div>
                        </div>

                        
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Duration of Stay</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select duration_of_stay" name="inmates_duration_of_stay" required>
                               <?php foreach($duration as $durat){
                                 if ((int)$durat->duration_id === 1 || stripos($durat->duration_stay, 'short') !== false) {
                                   continue;
                                 }
                               ?>
                                <option value="<?php echo $durat->duration_id; ?>" selected><?php echo $durat->duration_stay;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        

                        <div class="row mb-6 check_out_div" style="display:none;" >
                          <label class="col-sm-2 col-form-label" for="check_out-date-input">Check Out Date</label>
                          <div class="col-sm-10">
                            <div class="input-group fancy-datepicker-group">
                              <span class="input-group-text bg-white border-end-0 text-danger" style="cursor:pointer;" id="checkout_calendar_icon">
                                <i class="fa fa-calendar-times-o text-danger" style="font-size:16px;"></i>
                              </span>
                              <input type="text" class="form-control border-start-0 border-end-0 text-dark check_out_date_clz fancy-datepicker-input" name="inmates_check_out_date" id="check_out-date-input" placeholder="Select check-out date..." autocomplete="off"/>
                              <button class="btn btn-outline-danger px-3" type="button" id="btn_open_co_calendar" title="Choose Check Out Date">
                                <i class="fa fa-calendar me-1"></i> Pick Date
                              </button>
                            </div>
                            <small class="text-muted mt-1 d-block" style="font-size:11.5px;">Must be after the join-in date</small>
                          </div>
                        </div>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select build_clz" name="inmates_building" required>
                              <option value="" selected disabled>Select Building</option>
                              <?php foreach($building as $build){?> 
                              <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
                              <?php } ?>

                            </select>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select room_clz" name="inmates_rooms" required>
                              <option value="" selected disabled>Select Rooms</option>
                             
                            </select>
                          </div>
                        </div>


                        <input type="hidden" name="inmates_room_type" value="" class="room_type_clz"/>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Phone Number</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="inmates_phone_no" id="html5-date-input" required/>
                          </div>
                        </div>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">WhatsApp Number</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="inmates_whats_app_number" id="html5-date-input" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" name="inmates_email" id="html5-email-input" placeholder="inmate@example.com" required/>
                          </div>
                        </div>
                        

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Place of work or<br>institute name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="place_of_work" id="html5-date-input" placeholder="e.g., Company or College name" required/>
                          </div>
                        </div>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">ID Proof</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="file" name="inmates_id_proof" id="formFile" required/>
                          </div>
                        </div>

                        

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Photo</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="file" name="inmates_photo" id="formFile" required/>
                          </div>
                        </div>


                      <h5 class="mb-0" style="padding-bottom: 30px;">Details of Guardian </h5>

                      <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Guardian Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_guardian_name" id="basic-default-name" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                      </div>


                      <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Relation</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_relation" id="basic-default-name" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                      </div>


                       <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Contact Number</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="inmates_guardian_contact" id="basic-default-name" placeholder="e.g., 9876543210" required/>
                          </div>
                      </div>
                      
                    


                       

                       
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Basic with Icons -->
                
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            
            <?= $this->include('admin/includes/footer') ?>

            <!-- / Footer -->

            <!-- Import Excel Modal -->
            <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                  <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="importExcelModalLabel">
                      <span class="badge bg-label-success p-2 rounded"><i class="bx bx-file fs-4 text-success"></i></span>
                      <span class="fw-bold">Import Inmates via Excel / CSV</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form id="excel_import_form" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                      <!-- Guide alert -->
                      <div class="alert alert-primary d-flex align-items-start gap-2 py-3 px-3 mb-4 rounded-3" style="font-size:12.5px;">
                        <i class="bx bx-info-circle fs-5 mt-0.5 text-primary"></i>
                        <div class="flex-grow-1">
                          <strong>Supported Columns in Excel / CSV:</strong>
                          <div class="mt-1">
                            <div class="mb-1"><strong>Required:</strong> <span class="badge bg-white text-primary border">Full Name</span> <span class="badge bg-white text-primary border">Age</span> <span class="badge bg-white text-primary border">Phone Number</span> <span class="badge bg-white text-primary border">Building Name</span> <span class="badge bg-white text-primary border">Room Name</span></div>
                            <div><strong>Optional:</strong> WhatsApp Number, Email, Join Date (defaults to today), Duration of Stay (defaults to Long Term), Check Out Date, Place of Work / College, Guardian Name, Relation, Guardian Contact.</div>
                            <small class="text-muted d-block mt-1.5" style="font-size:11px;">
                              Room Type, Tariffs, Admission Fee, and Caution Deposit are automatically resolved from the assigned Room and Building!
                            </small>
                          </div>
                          <div class="mt-2.5">
                            <a href="<?php echo base_url('Admin/Inmates/DownloadSample'); ?>" class="btn btn-sm btn-primary py-1 px-3 text-white fw-semibold">
                              <i class="bx bx-download me-1"></i> Download Sample Excel Template (.xlsx)
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- File upload field -->
                      <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Select Excel / CSV File <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <input type="file" class="form-control" id="excel_file_input" name="excel_file" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <small class="text-muted mt-1 d-block" style="font-size:11.5px;">Supported formats: .xlsx (Excel), .xls, or .csv (Max 10MB)</small>
                      </div>

                      <!-- Options -->
                      <div class="row g-2 mb-3">
                        <div class="col-md-6">
                          <div class="p-2.5 bg-light rounded border h-100 d-flex align-items-center gap-2">
                            <span class="badge bg-success p-1.5 rounded-circle"><i class="bx bx-check-shield fs-5 text-white"></i></span>
                            <div>
                              <strong class="d-block text-dark" style="font-size:12.5px;">Strict Duplicate Protection</strong>
                              <small class="text-muted d-block" style="font-size:11px;">Prevents duplicate phone, email, or resident within file & database.</small>
                            </div>
                            <input type="hidden" name="skip_duplicates" value="1">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-check form-switch p-2.5 bg-light rounded border h-100">
                            <input class="form-check-input ms-0 me-2" type="checkbox" id="ignore_capacity" name="ignore_capacity" value="1">
                            <label class="form-check-label fw-semibold text-dark" for="ignore_capacity" style="font-size:12.5px;">
                              Allow over-capacity assignment
                            </label>
                            <small class="text-muted d-block ps-4 ms-2" style="font-size:11px;">
                              Useful when bulk migrating existing/legacy resident records.
                            </small>
                          </div>
                        </div>
                      </div>

                      <!-- Live Result Box (hidden initially) -->
                      <div id="import_result_box" class="d-none mt-3">
                        <div id="import_alert" class="alert py-2.5 px-3 mb-2 rounded-2"></div>
                        <div class="d-flex align-items-center justify-content-between mb-1.5 px-1">
                          <span class="fw-bold text-dark" style="font-size:12px;">Import Details Log:</span>
                          <span id="import_badges" class="d-flex gap-1.5"></span>
                        </div>
                        <div id="import_details_wrap" class="border rounded p-2.5 bg-white" style="max-height: 220px; overflow-y: auto; font-size: 12px;">
                          <ul id="import_logs_list" class="list-unstyled mb-0 space-y-1"></ul>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer border-top p-3 bg-light d-flex justify-content-between">
                      <div>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="<?php echo base_url('Admin/Inmates'); ?>" id="btn_goto_inmates" class="btn btn-primary d-none ms-2">
                          <i class="bx bx-list-ul me-1"></i> View Inmates
                        </a>
                      </div>
                      <button type="submit" id="btn_submit_import" class="btn btn-success fw-bold px-4">
                        <i class="bx bx-upload me-1"></i> Upload & Import
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Flatpickr JS -->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>

            <script>
              var joinPicker = null;
              var checkoutPicker = null;

              $(document).ready(function () {
                var form = $('#add_form');

                // Initialize Fancy Flatpickr on Join In Date
                joinPicker = flatpickr("#check_in-date-input", {
                  dateFormat: "Y-m-d",
                  altInput: true,
                  altFormat: "d M Y",
                  altInputClass: "form-control border-start-0 border-end-0 text-dark fancy-datepicker-input",
                  defaultDate: "<?php echo date('Y-m-d'); ?>",
                  minDate: "today",
                  animate: true,
                  onChange: function(selectedDates, dateStr, instance) {
                    $('.build_clz').val('');
                    $('.room_clz').val('');

                    if (selectedDates.length > 0) {
                      var minCheckout = new Date(selectedDates[0].getTime() + 24 * 60 * 60 * 1000);
                      if (checkoutPicker) {
                        checkoutPicker.set('minDate', minCheckout);
                        if (checkoutPicker.selectedDates.length > 0 && checkoutPicker.selectedDates[0] <= selectedDates[0]) {
                          checkoutPicker.clear();
                        }
                      }
                    }
                  }
                });

                // Initialize Fancy Flatpickr on Check Out Date
                checkoutPicker = flatpickr("#check_out-date-input", {
                  dateFormat: "Y-m-d",
                  altInput: true,
                  altFormat: "d M Y",
                  altInputClass: "form-control border-start-0 border-end-0 text-dark fancy-datepicker-input",
                  minDate: new Date(Date.now() + 24 * 60 * 60 * 1000),
                  animate: true,
                  onChange: function(selectedDates, dateStr, instance) {
                    $('.build_clz').val('');
                    $('.room_clz').val('');
                  }
                });

                // Interactive click handlers to open calendars
                $('#btn_open_join_calendar, #join_calendar_icon').on('click', function(e) {
                  e.preventDefault();
                  if (joinPicker) joinPicker.open();
                });

                $('#btn_open_co_calendar, #checkout_calendar_icon').on('click', function(e) {
                  e.preventDefault();
                  if (checkoutPicker) checkoutPicker.open();
                });

                $.validator.addMethod('checkOutAfterJoin', function(value, element) {
                  var join = $('#check_in-date-input').val();
                  var co = $('#check_out-date-input').val();
                  if(!join || !co){ return true; }
                  return new Date(co) > new Date(join);
                }, 'Check out date must be after the check in date');

                form.validate({
                  rules: {
                    required: 'required',
                    inmates_check_out_date: { checkOutAfterJoin: true },
                  },
                  messages: {
                    required: 'This field is required',
                  },
                  errorClass: "text-danger", 
                  errorPlacement: function (error, element) {
                    error.insertAfter(element);
                  },
                  
                  submitHandler: function (currentForm,event) {
                    event.preventDefault(); 
                    
                    var btn = $(currentForm).find('button[type="submit"]');
                    btn.prop('disabled', true);
                    
                    var formData = new FormData(currentForm);
                    $.ajax({
                      url: "<?php echo base_url(); ?>Admin/Inmates/Add",
                      type: "POST",
                      data: formData,
                      processData: false,
                      contentType: false,
                      success: function(response) {
                        var data = JSON.parse(response);

                        if(data.status === true || data.status === "true"){
                          window.location.href = "<?php echo base_url(); ?>Admin/Inmates";
                        }else{
                          alertify.error(data.msg).delay(3).dismissOthers();
                          btn.prop('disabled', false);
                        }
                      },
                      error: function() {
                        alertify.error("An error occurred. Please try again.").delay(3).dismissOthers();
                        btn.prop('disabled', false);
                      }
                    });
                  }
                });

                /*fetch room by building*/
                $(".build_clz").on('change', function(){ 
                  var Id = $('.build_clz').val();
                  var date = $('#check_in-date-input').val();
                  var check_out_date = $('#check_out-date-input').val();

                  $.ajax({
                    url: "<?php echo base_url(); ?>Admin/Ajax/RoomFilter",
                    type: "POST",
                    data: {
                      ID :Id, 
                      Date : date,
                      Checkout : check_out_date
                    },
                    success: function(data) {
                      var data = JSON.parse(data);
                      $('.room_clz').html(data.rooms);
                    }
                  });
                });

                /*show check out date*/
                $(".duration_of_stay").on('change', function(){
                  var Id = $('.duration_of_stay').val();
                  if(Id === "1"){
                    $('.check_out_div').slideDown(200);
                  }else{
                    $('.check_out_div').slideUp(200);
                    if(checkoutPicker) { checkoutPicker.clear(); }
                    $('.build_clz').val('');
                    $('.room_clz').val('');
                  }
                });

                // Excel / CSV Import Handler
                $('#excel_import_form').on('submit', function(e) {
                  e.preventDefault();
                  var $submitBtn = $('#btn_submit_import');
                  var fileVal = $('#excel_file_input').val();

                  if (!fileVal) {
                    alertify.error('Please select an Excel or CSV file.').delay(3).dismissOthers();
                    return;
                  }

                  $submitBtn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Importing...');
                  $('#import_result_box').addClass('d-none');
                  $('#import_logs_list').empty();
                  $('#import_badges').empty();

                  var formData = new FormData(this);

                  $.ajax({
                    url: '<?php echo base_url('Admin/Inmates/Import'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                      $submitBtn.prop('disabled', false).html('<i class="bx bx-upload me-1"></i> Upload & Import');
                      $('#import_result_box').removeClass('d-none');

                      var alertClz = res.status ? 'alert-success' : 'alert-danger';
                      var alertIcon = res.status ? 'bx-check-circle' : 'bx-error-circle';
                      $('#import_alert').attr('class', 'alert py-2.5 px-3 mb-2 rounded-2 ' + alertClz)
                        .html('<div class="d-flex align-items-center gap-2"><i class="bx ' + alertIcon + ' fs-5"></i><span>' + res.message + '</span></div>');

                      var badgesHtml = '';
                      if (res.imported_count !== undefined) {
                        badgesHtml += '<span class="badge bg-success">' + res.imported_count + ' Imported</span> ';
                      }
                      if (res.skipped_count !== undefined) {
                        badgesHtml += '<span class="badge bg-warning text-dark">' + res.skipped_count + ' Skipped</span> ';
                      }
                      $('#import_badges').html(badgesHtml);

                      if (res.logs && res.logs.length > 0) {
                        $.each(res.logs, function(idx, item) {
                          var icon = item.status === 'success'
                            ? '<i class="bx bx-check text-success me-1"></i>'
                            : '<i class="bx bx-info-circle text-warning me-1"></i>';
                          var textClass = item.status === 'success' ? 'text-success' : 'text-muted';
                          $('#import_logs_list').append('<li class="py-1 border-bottom ' + textClass + '">' + icon + item.message + '</li>');
                        });
                      }

                      if (res.imported_count > 0) {
                        $('#btn_goto_inmates').removeClass('d-none');
                        alertify.success(res.message).delay(4).dismissOthers();
                      } else {
                        alertify.warning(res.message).delay(4).dismissOthers();
                      }
                    },
                    error: function(xhr, status, err) {
                      $submitBtn.prop('disabled', false).html('<i class="bx bx-upload me-1"></i> Upload & Import');
                      $('#import_result_box').removeClass('d-none');
                      var errMsg = 'Server error processing import. Please try again.';
                      if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                      } else if (xhr.responseText) {
                        try {
                          var parsed = JSON.parse(xhr.responseText);
                          if (parsed && parsed.message) errMsg = parsed.message;
                        } catch(e) {}
                      }
                      $('#import_alert').attr('class', 'alert alert-danger py-2.5 px-3 mb-2 rounded-2')
                        .html('<div class="d-flex align-items-center gap-2"><i class="bx bx-error-circle fs-5"></i><span>' + errMsg + '</span></div>');
                      alertify.error(errMsg).delay(4).dismissOthers();
                    }
                  });
                });
              });
            </script>

            
              <!--fetch room type by room_id start-->
              <script>
                $(document).ready(function() {

                  $('body').on('change','.room_clz', function(){ 

                    //alert("sucess");

                    var Id =  $('.room_clz').val();

                    $.ajax({

                          url: "<?php echo base_url(); ?>Admin/Ajax/FetchRoomTypes",
                          type: "POST",
                          data: {ID :Id, },
                          success: function(data) {

                            var data = JSON.parse(data);

                            //console.log(data);

                            $('.room_type_clz').val(data.room_type);


                          }
                    });

      
                  });

                });

              </script>
              <!--end-->
            

   
  </body>
</html>
