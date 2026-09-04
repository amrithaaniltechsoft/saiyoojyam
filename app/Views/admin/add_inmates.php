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
                          <label class="col-sm-2 col-form-label" for="basic-default-name" >Join In Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control join_in_date_clz"  min="<?php echo date("Y-m-d"); ?>"  name="inmates_check_in_date" onclick="showPicker()" id="check_in-date-input" required/>
                          </div>
                        </div>

                        
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Duration of Stay</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select duration_of_stay" name="inmates_duration_of_stay" required>
                              <option value="" selected disabled>Select Room Type</option>
                               <?php foreach($duration as $durat){?>
                                <option value="<?php echo $durat->duration_id; ?>"><?php echo $durat->duration_stay;?></option>
                                <?php } ?>
                              
                            </select>
                             
                          </div>
                        </div>

                        

                        <div class="row mb-6 check_out_div" style="display:none;" >
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Check Out Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control check_out_date_clz" name="inmates_check_out_date" id="check_out-date-input" onclick="showPicker()"  required/>
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
                              <option value="" selected disabled>Select Room Type</option>
                             
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
                            <input type="text" class="form-control" name="inmates_guardian_contact" id="basic-default-name" placeholder="e.g., Rahul Sharma" required/>
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
                    errorClass: "text-danger", 
                    errorPlacement: function (error, element) {
                      error.insertAfter(element); // or leave empty to suppress
                    },
                    
                    
                    
                    submitHandler: function (currentForm,event) {
                      event.preventDefault(); 
                      
                      var formData = new FormData(currentForm);
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Inmates/Add",
                        type: "POST",
                        data: formData, // Use FormData only if you're uploading files
                        processData: false, // ✅ prevent jQuery from serializing
                        contentType: false,
                        success: function(response) {

                          var data = JSON.parse(response);

                          alertify.success(data.msg).delay(3).dismissOthers();

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

                  var  date = $('.join_in_date_clz').val();

                  var  check_out_date = $('.check_out_date_clz').val();
                  
                  console.log(check_out_date);

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

                /*end section*/


                /*show check out date*/
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


                /*end section*/



                /*on change date empty building*/

                $('.join_in_date_clz').on('change', function(){

                  $('.build_clz').val('');
                  $('.room_clz').val('');

                });

                /**/


                /*on change date empty building*/

                $('.check_out_date_clz').on('change', function(){

                  $('.build_clz').val('');
                  $('.room_clz').val('');

                });

                /**/



       
              });
            </script>


            <script>
              document.addEventListener("DOMContentLoaded", function () {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById("check_in-date-input").setAttribute("min", today);
              });

              document.addEventListener("DOMContentLoaded", function () {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById("check_out-date-input").setAttribute("min", today);
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
