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
                              <select id="defaultSelect" name="room_type_building_id" class="form-select" required>

                               
                                <?php foreach($building as $build){?> 
                                  <option value="<?php echo $build->building_id;?>" <?php if($room_type->room_type_building_id	== $build->building_id){echo "selected"; }?>><?php echo $build->building_name;?></option>
                                <?php } ?>
                              
                              
                              </select>
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Types</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="room_type_name" value="<?php echo $room_type->room_type_name; ?>" id=""  required>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-capacity">Capacity</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" name="room_type_capacity" value="<?php echo $room_type->room_type_capacity ?? 1; ?>" id="basic-default-capacity" min="<?php echo !empty($min_allowed_capacity) ? $min_allowed_capacity : 1; ?>" required>
                              <?php if (!empty($min_allowed_capacity) && $min_allowed_capacity > 0 && !empty($occupied_rooms_info)): ?>
                                <div class="alert alert-warning d-flex align-items-start gap-2 mt-2 p-2.5 rounded-3" style="font-size:12.5px;">
                                  <i class="fa fa-exclamation-triangle mt-1"></i>
                                  <div>
                                    <strong>Minimum allowed capacity: <?php echo $min_allowed_capacity; ?>.</strong><br/>
                                    Existing rooms of this type currently have active inmates:
                                    <ul class="mb-0 mt-1 ps-3">
                                      <?php foreach($occupied_rooms_info as $ori): ?>
                                        <li>Room <strong><?php echo $ori['room_name']; ?></strong>: <?php echo $ori['occupied']; ?> active inmate(s)</li>
                                      <?php endforeach; ?>
                                    </ul>
                                    <span class="d-block mt-1">To reduce capacity below <?php echo $min_allowed_capacity; ?>, please reallocate or check out inmates first.</span>
                                  </div>
                                </div>
                              <?php else: ?>
                                <div class="form-text text-muted mt-1">
                                  Bed capacity for rooms of this room type (minimum 1).
                                </div>
                              <?php endif; ?>
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

            

   
  </body>
</html>
