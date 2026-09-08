<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

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
                      <h5 class="mb-0">Edit Inmates</h5>
                    </div>
                    <div class="card-body">
                      <form id="edit_form" enctype="multipart/form-data" method="POST" action="<?php echo base_url();?>Admin/Inmates/Edit/<?php echo $inmate->inmates_id; ?>">

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_name" id="basic-default-name" value="<?php echo $inmate->inmates_name;?>" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Age</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_age" id="basic-default-name" value="<?php echo $inmate->inmates_age;?>" placeholder="e.g., 25" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name" >Join In Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control join_in_date_clz"  name="inmates_check_in_date" onclick="showPicker()" id="check_in-date-input" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $inmate->inmates_check_in_date; ?>" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Duration of Stay</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select duration_of_stay" name="inmates_duration_of_stay" required>
                              <option value="" disabled>Select Duration</option>
                               <?php foreach($duration as $durat){?>
                                <option value="<?php echo $durat->duration_id; ?>" <?php if($inmate->inmates_duration_of_stay == $durat->duration_id){ echo 'selected';} ?>><?php echo $durat->duration_stay;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="row mb-6 check_out_div" style="<?php if($inmate->inmates_duration_of_stay == 1){ echo 'display:flex;'; } else { echo 'display:none;'; } ?>" >
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Check Out Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control check_out_date_clz" name="inmates_check_out_date" id="check_out-date-input" onclick="showPicker()" value="<?php if($inmate->inmates_check_out_date != '0000-00-00'){ echo $inmate->inmates_check_out_date; } ?>"/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select build_clz" name="inmates_building" required>
                              <option value="" disabled>Select Building</option>
                              <?php foreach($building as $build){?> 
                              <option value="<?php echo $build->building_id;?>" <?php if($inmate->inmates_building == $build->building_id){ echo 'selected';} ?>><?php echo $build->building_name;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select room_clz" name="inmates_rooms" required>
                              <option value="" disabled>Select Room</option>
                              <?php foreach($rooms as $room){?>
                              <option value="<?php echo $room->rooms_id;?>" <?php if($inmate->inmates_rooms == $room->rooms_id){ echo 'selected';} ?>><?php echo $room->rooms_name;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <input type="hidden" name="inmates_room_type" value="<?php echo $inmate->inmates_room_type; ?>" class="room_type_clz"/>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Phone Number</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="inmates_phone_no" id="html5-date-input" value="<?php echo $inmate->inmates_phone_no;?>" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">WhatsApp Number</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="inmates_whats_app_number" id="html5-date-input" value="<?php echo $inmate->inmates_whats_app_number;?>" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Place Of Work</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="place_of_work" id="html5-date-input" value="<?php echo $inmate->inmates_place_of_work;?>" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="formFile">ID Proof</label>
                          <div class="col-sm-10">
                            <?php if(!empty($inmate->inmates_id_proof)){ ?>
                            <img src="<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/proof" class="mb-2" style="max-width:150px;border:1px solid #ccc;border-radius:4px;"/>
                            <?php } ?>
                            <input class="form-control" type="file" name="inmates_id_proof" id="formFile"/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="formFile">Photo</label>
                          <div class="col-sm-10">
                            <?php if(!empty($inmate->inmates_photo)){ ?>
                            <img src="<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/photo" class="mb-2" style="max-width:150px;border:1px solid #ccc;border-radius:4px;"/>
                            <?php } ?>
                            <input class="form-control" type="file" name="inmates_photo" id="formFile"/>
                          </div>
                        </div>

                        <h5 class="mb-0" style="padding-bottom: 30px;">Details of Guardian </h5>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Guardian Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_guardian_name" id="basic-default-name" value="<?php echo $inmate->inmates_guardian_name;?>" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Relation</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_relation" id="basic-default-name" value="<?php echo $inmate->inmates_relation;?>" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Contact Number</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="inmates_guardian_contact" id="basic-default-name" value="<?php echo $inmate->inmates_guardian_contact;?>" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
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

            
              <!--fetch room by building start-->
              <script>
                $(document).ready(function () {

                  $(".build_clz").on('change', function(){ 

                    var Id =  $('.build_clz').val();

                    var  date = $('.join_in_date_clz').val();

                    var  check_out_date = $('.check_out_date_clz').val();

                    $.ajax({
                          url: "<?php echo base_url(); ?>Admin/Ajax/RoomFilter",
                          type: "POST",
                          data: {ID :Id, 
                            Date : date,
                            Checkout : check_out_date
                          },
                          success: function(data) {

                            var data = JSON.parse(data);

                            $('.room_clz').html(data.rooms);

                          }
                    });

                  });

                });
              </script>
              <!--end-->


              <!--show check out date start-->
              <script>
                $(document).ready(function () {

                  $(".duration_of_stay").on('change',function(){
                   
                    var Id = $('.duration_of_stay').val();

                    if(Id === "1"){
                      
                      $('.check_out_div').show()
                    
                    }else{

                      $('.check_out_div').hide()

                      $('.check_out_date_clz').val("");

                      $('.build_clz').val('');

                      $('.room_clz').val('');

                    }
                     
                  });

                });
              </script>
              <!--end-->


              <!--on change date empty building start-->
              <script>
                $(document).ready(function () {

                  function setCheckOutMin(){

                    var join = $('.join_in_date_clz').val();

                    var coInput = $('.check_out_date_clz');

                    if(join){

                      var d = new Date(join);

                      d.setDate(d.getDate() + 1);

                      var next = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');

                      coInput.attr('min', next);

                      var co = coInput.val();

                      if(co && new Date(co) <= new Date(join)){

                        coInput.val('');

                      }

                    }else{

                      coInput.removeAttr('min');

                    }

                  }

                  setCheckOutMin();

                  $('.join_in_date_clz').on('change', function(){

                    $('.build_clz').val('');
                    $('.room_clz').val('');

                    setCheckOutMin();

                  });

                  $('.check_out_date_clz').on('change', function(){

                    $('.build_clz').val('');
                    $('.room_clz').val('');

                  });

                  $('#edit_form').on('submit', function(e){

                    var join = $('.join_in_date_clz').val();

                    var co = $('.check_out_date_clz').val();

                    if(join && co && new Date(co) <= new Date(join)){

                      e.preventDefault();

                      alertify.error('Check out date must be after the check in date').delay(3).dismissOthers();

                    }

                  });

                });
              </script>
              <!--end-->


              <!--fetch room type by room_id start-->
              <script>
                $(document).ready(function() {

                  $('.room_clz').on('change', function(){ 

                    var Id =  $('.room_clz').val();

                    $.ajax({

                          url: "<?php echo base_url(); ?>Admin/Ajax/FetchRoomTypes",
                          type: "POST",
                          data: {ID :Id, },
                          success: function(data) {

                            var data = JSON.parse(data);

                            $('.room_type_clz').val(data.room_type);

                          }
                    });

                  });

                });
              </script>
              <!--end-->

    
  </body>
</html>