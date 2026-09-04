<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <style>
    .label_top_margin{

      margin-top: -19px;


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
                      <h5 class="mb-0">Add Bed Rental</h5>
                      
                    </div>
                    <div class="card-body">
                      
                      <form id="add_form">

                       

                        

                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Owner Inmate</label>
                          <div class="col-sm-3">
                            <select id="defaultSelect" class="form-select bed_rental_owner" name="bed_rental_owner" required>
                              <option value="" selected disabled>Select Owner Inmates</option>
                              <?php foreach($inmates as $inmate){?> 
                                <option value="<?php echo $inmate->inmates_id;?>"><?php echo $inmate->inmates_name;?></option>
                              <?php } ?>
                             
                             
                            </select>
                          </div>

                          <!---->
                          <div class="col-sm-3 label_top_margin">
                            <label>Building</label>
                            <input type="text" class="form-control build_clz" name="" value=""  id="html5-date-input" readonly/>
                          </div>
                          <!---->

                          <!---->
                          <div class="col-sm-2 label_top_margin">
                            <label>Room Type</label>
                            <input type="text" class="form-control room_type_clz" name="" value="" id="html5-date-input" readonly/>
                          </div>
                          <!---->


                          <!---->
                          <div class="col-sm-2 label_top_margin">
                            <label>Rooms</label>
                            <input type="text" class="form-control room_clz" name="" value="" id="html5-date-input" readonly/>
                          </div>
                          <!---->

                        </div>

                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rental Customer</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select" name="bed_rental_customer" required>
                              <option value="" selected disabled>Select Customer</option>
                              <?php foreach($inmates as $inmate){?> 
                                <option value="<?php echo $inmate->inmates_id;?>"><?php echo $inmate->inmates_name;?></option>
                              <?php } ?>
                              
                            </select>
                          </div>
                        </div>

                         
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rent per day</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="bed_rental_commission" id="basic-default-name" placeholder="e.g., ₹50" required>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Commission(%)</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control" name="bed_rental_commission" id="basic-default-name" placeholder="e.g., 5%" required>
                          </div>
                        </div>
                       

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Check In Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" onclick="showPicker()"  name="bed_rental_check_in_data" id="html5-date-input" required/>
                          </div>
                        </div>

                        
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Check Out Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control check_out_clz" onclick="showPicker()" name="bed_rental_check_out_date" id="html5-date-input" required/>
                          </div>
                        </div>

                       
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
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
                      url: "<?php echo base_url(); ?>Admin/BedRentals/Add",
                      type: "POST",
                      data: $(currentForm).serialize(), // Use FormData only if you're uploading files
                      success: function(data) {

                        var data = JSON.parse(data);

                        alertify.success(data.msg).delay(3).dismissOthers();

                        form[0].reset(); // Reset the form

                      }
                    });
                  }
                });
              });

             /*end section*/

            /*fetch room details start*/

            $(".bed_rental_owner").on('change', function(){ 

                  var Id =  $('.bed_rental_owner').val();

                  console.log(Id);

                  $.ajax({

                        url: "<?php echo base_url(); ?>Admin/Ajax/inmatesRooms",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.build_clz').val(data.inmates_build);

                          $('.room_type_clz').val(data.inmates_room_type);

                          $('.room_clz').val(data.inmates_room);

                         
                        }
                  });

                
    
            });

            /*fetch room details end*/


            /*fetch dates section start*/

            $(".check_out_clz").on('clcick', function(){ 

                  var calander = $(this).val();

                  console.log(calander);

                  //var Id =  $('.bed_rental_owner').val();

                  //console.log(Id);

                  /*$.ajax({

                        url: "<?php echo base_url(); ?>Admin/Ajax/inmatesRooms",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.build_clz').val(data.inmates_build);

                          $('.room_type_clz').val(data.inmates_room_type);

                          $('.room_clz').val(data.inmates_room);

                         
                        }
                  });*/

                
    
            });


            /*fetch dates section end*/

       
            });
            </script>

   
  </body>
</html>
