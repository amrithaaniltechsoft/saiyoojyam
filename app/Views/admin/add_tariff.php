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
                      <h5 class="mb-0">Add Tariff</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                        
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Rooms</label>
                          <div class="col-sm-4">
                            <select id="" class="form-select room_clz" name="tariffs_rooms" required>
                              <option value="" selected disabled>Select Rooms</option>
                              <?php foreach($rooms as $room){?> 

                                  <option value="<?php echo $room->rooms_id; ?>" ><?php echo $room->rooms_name; ?></option>

                                <?php } ?>
                                
                                
                            </select>
                          </div>

                          <div class="col-sm-3" style="margin-top: -23px;">
                            <label>Building</label>
                            <input type="text" class="form-control build_clz"   name="" id="" placeholder="Tower1" required readonly/>
                            <input type="hidden" name="tariffs_building"  class="build_id_clz">
                          </div>


                          <div class="col-sm-3" style="margin-top: -23px;">
                            <label>Room Type</label>
                            <input type="text" class="form-control room_type_clz"   name="" id="" placeholder="3 Share" required readonly/>
                            <input type="hidden" name="tariffs_room_types" class="room_type_id_clz">
                          </div>


                        </div>


                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Rooms Type</label>
                          <div class="col-sm-10">
                            <select id="" class="form-select room_clz" name="tariffs_room_types" required>
                              <option value="" selected disabled>Select Room Types</option>
                              
                            </select>
                          </div>
                        </div>-->


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Admission fees</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" min="0" step="0.01"  name="tariffs_admission_fees" id="" placeholder="e.g., ₹50" required/>
                          </div>
                        </div>
                        

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Caution deposit</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control caution_deposit" min="0" step="0.01"  name="tariffs_caution_deposit" id="" placeholder="e.g., ₹50" />
                              
                             <!-- Checkbox added here -->
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" value="1" id="cautionCheck" name="" checked>
                              <label class="form-check-label" for="cautionCheck">
                                One Month Rent
                              </label>
                            </div>
                              <!---->                          
                          </div>
                        </div>


                        


                        

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Monthly Rent</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" min="0" step="0.01"  name="tariffs_price" id="" placeholder="e.g., ₹50" required/>
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

            <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                 
    
                /*add section*/  
                
                $(document).ready(function () {
                  var form = $('#add_form');
                  form.validate({
                    rules: {
                    
                      required: 'required',
                    },
                    messages: {
                    
                      required: 'This field is required',
                    },
                    errorPlacement: function (error, element) {
                      error.insertAfter(element); // or leave empty to suppress
                    },
                    errorClass: "text-danger", 
                    submitHandler: function (currentForm) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Tariff/Add",
                        type: "POST",
                        data: $(currentForm).serialize(), // Use FormData only if you're uploading files
                        
                        success: function(response) {

                          console.log(response);

                          var data = JSON.parse(response);

                          if(data.status === "true"){
                               
                            alertify.success(data.msg).delay(3).dismissOthers();

                          }else{
                            
                            alertify.error(data.msg).delay(3).dismissOthers();

                          }

                          form[0].reset(); // Reset the form

                        }

                      });
                    }
                  });
                });

                /*end section*/


                /*fetch building and room type by room*/

                $(".room_clz").on('change', function(){ 

                  var Id =  $('.room_clz').val();

                  $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/Rooms",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.build_clz').val(data.building);

                          $('.room_type_clz').val(data.room_type);

                          $('.build_id_clz').val(data.building_id);

                          $('.room_type_id_clz').val(data.room_type_id);

                        }
                  });

                
    
                });

                 


                /*end section*/

                /*caution_deposit checked or unchecked*/

                $("#cautionCheck").on('change', function () {

                  if ($(this).is(':checked')) {

                    //$('.caution_deposit').prop('required', false);
                    //$('.caution_deposit').prop('disabled', true);
                    $('.caution_deposit').val('').prop('required', false).prop('disabled', true);
                  } else {

                    //$('.caution_deposit').prop('required', true);
                    $('.caution_deposit').prop('disabled', false).prop('required', true);
                  }

                    
                
                });

                $("#cautionCheck").trigger('change');

                /*end section*/

       
              });
            </script>

   
  </body>
</html>
