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
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Add Inmates</h5>
                      
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
                              <option value="" selected disabled>Select Duration</option>
                               <?php foreach($duration as $durat){?>
                                <option value="<?php echo $durat->duration_id; ?>"><?php echo $durat->duration_stay;?></option>
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
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Place Of Work</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="place_of_work" id="html5-date-input" required/>
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
