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
                      <h5 class="mb-0">Edit Room Types</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building Name</label>
                          <div class="col-sm-10">
                              <select id="" name="rooms_building" class="form-select build_clz" required>

                                <?php foreach($building as $build){?> 
                                  <option value="<?php echo $build->building_id;?>" <?php if($rooms->rooms_building	== $build->building_id){echo "selected"; }?>><?php echo $build->building_name;?></option>
                                <?php } ?>
                              
                              </select>
                          </div>
                        </div>



                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Types</label>
                          <div class="col-sm-10">
                              <select id="defaultSelect" name="rooms_type" class="form-select room_clz" required>

                                <?php foreach($room_types as $room_type){?> 
                                  <option value="<?php echo $room_type->room_type_id;?>" <?php if($rooms->rooms_type	== $room_type->room_type_id){echo "selected"; }?>><?php echo $room_type->room_type_name;?></option>
                                <?php } ?>
                              
                              </select>
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Name</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="rooms_name" value="<?php echo $rooms->rooms_name; ?>" id="basic-default-name" placeholder="e.g.,Tower 1, 3 share room" required>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Capacity</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" name="rooms_capacity" value="<?php echo $rooms->rooms_capacity;?>" id="basic-default-name" placeholder="e.g., 3" required>
                          </div>
                        </div>


                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Ac Type</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" name="rooms_ac_type" class="form-select" required>
                              
                              <option value="Non-AC" <?php if($rooms->rooms_ac_type == 'Non-AC'){echo "selected";}?>>Non-AC</option>
                              <option value="AC" <?php if($rooms->rooms_ac_type == "AC"){echo "selected";}?>>AC</option>
                              
                            </select>
                          </div>
                        </div>--->

                        
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

            </script>

            

   
  </body>
</html>
