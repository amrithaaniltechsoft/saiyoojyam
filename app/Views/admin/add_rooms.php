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
                      <h5 class="mb-0">Add Rooms</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building</label>
                          <div class="col-sm-10">

                            <select id="" name="rooms_building" class="form-select build_clz" required>
                              <option value="" selected disabled>Select Building</option>
                              <?php foreach($building as $build){?> 
                              <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
                              <?php } ?>
                             
                            </select>
                          </div>
                        </div>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms Type</label>
                          <div class="col-sm-10">
                            <select id="" class="form-select room_clz" name="rooms_type" required>
                              <option value="" selected disabled>Select Room Types</option>
                              
                            </select>
                          </div>
                        </div>


                        
                        

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Name</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="rooms_name" id="" placeholder="e.g.,Tower 1, 3 share room" required>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Capacity</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" name="rooms_capacity" id="" placeholder="e.g., 3" required>
                          </div>
                        </div>


                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Ac Type</label>
                          <div class="col-sm-10">
                            <select id="" name="rooms_ac_type" class="form-select" required>
                              <option value="" selected disabled>Select Ac Type</option>
                              <option value="Non-AC">Non-AC</option>
                              <option value="AC">AC</option>
                              
                            </select>
                          </div>
                        </div>-->


                        
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
                      url: "<?php echo base_url(); ?>Admin/Rooms/Add",
                      type: "POST",
                      data: $(currentForm).serialize(), // Use FormData only if you're uploading files
                      success: function(response) {

                        var data = JSON.parse(response);

                        if(data.status === 'true'){
                            
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


             /*fetch room by building*/

                $(".build_clz").on('change', function(){ 

                  var Id =  $('.build_clz').val();

                  $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/RoomTypes",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.room_clz').html(data.rooms);

                         

                        }
                  });

                
    
                });

              /*end section*/


             

       
            });
            </script>

   
  </body>
</html>
