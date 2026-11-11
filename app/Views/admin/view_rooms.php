<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->



       
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">View Room</h5>
                <div class="card-body pb-2">
                  <form id="filter_form" method="GET" action="<?php echo base_url(); ?>Admin/Rooms">
                    <?php 
                      $selected_building  = !empty($selected_building) ? $selected_building : (!empty($_GET['building']) ? $_GET['building'] : '');
                      $selected_room_type = !empty($selected_room_type) ? $selected_room_type : (!empty($_GET['room_type']) ? $_GET['room_type'] : '');
                      $selected_room      = !empty($selected_room) ? $selected_room : (!empty($_GET['room']) ? $_GET['room'] : '');
                    ?>

                    <div class="row g-3 align-items-center justify-content-center mb-3">
                      <div class="col-md-3 col-lg-3">
                        <select id="building_filter" class="form-select build_clz" name="building">
                          <option value="">All Buildings</option>
                          <?php foreach($buildings as $build){ ?>
                            <option value="<?php echo $build->building_id; ?>" <?php if($selected_building == $build->building_id){echo "selected"; }?>><?php echo $build->building_name;?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="col-md-3 col-lg-3">
                        <select id="room_type_filter" class="form-select room_clz" name="room_type">
                          <option value="">All Room Types</option>
                          <?php if(!empty($dropdown_room_types)){ foreach($dropdown_room_types as $rt){ ?> 
                            <option value="<?php echo $rt->room_type_id; ?>" <?php if($selected_room_type == $rt->room_type_id){echo "selected";}?>><?php echo $rt->room_type_name;?></option>
                          <?php } } ?> 
                        </select>
                      </div>

                      <div class="col-md-3 col-lg-3">
                        <select id="room_filter" class="form-select room_item_clz" name="room">
                          <option value="">All Rooms</option>
                          <?php if(!empty($dropdown_rooms)){ foreach($dropdown_rooms as $r){ ?> 
                            <option value="<?php echo $r->rooms_id; ?>" <?php if($selected_room == $r->rooms_id){echo "selected";}?>><?php echo $r->rooms_name;?></option>
                          <?php } } ?> 
                        </select>
                      </div>

                      <div class="col-auto">
                        <a href="<?php echo base_url(); ?>Admin/Rooms" class="btn btn-outline-secondary" title="Reset filter">
                          <i class="bx bx-reset me-1"></i> Reset
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building</th>
                        <th>Room Types</th>
                        <th>Room Name</th>
                        <th>Capacity</th>
                        
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $page_data){?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                        <?php foreach($buildings as $build){
                        if($build->building_id == $page_data->rooms_building){  
                        ?> 
                        <td><?php echo $build->building_name; ?></td>
                        <?php } } ?>
                        
                        <?php 
                        $curCap = $page_data->rooms_capacity;
                        foreach($room_types as $room_type){
                          if($room_type->room_type_id  == $page_data->rooms_type){
                            if(!empty($room_type->room_type_capacity)){
                              $curCap = $room_type->room_type_capacity;
                            }
                        ?> 
                        <td><?php echo $room_type->room_type_name;?></td>

                        <?php } } ?>

                        <td><?php echo $page_data->rooms_name;?></td>
                        <td><?php echo $curCap;?></td>
                        
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Rooms/Edit/<?php echo $page_data->rooms_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Rooms/Delete/<?php echo $page_data->rooms_id; ?>"><i class="icon-base bx bx-trash me-2"></i> </a>
                        </td>
                        
                      </tr>

                      <?php $i++; } ?>
                      
                     
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              

             

              

              
              

            <!-- Contextual Classes -->

              
              
            </div>
            <!-- / Content -->

            <!-- Footer section start-->
            
            <?= $this->include('admin/includes/footer') ?>

            <!--Footer section end-->

            <script>
              $(document).ready(function() {
                // When building changes: clear room type and room, then submit
                $('#filter_form .build_clz').on('change', function() {
                  $('#filter_form .room_clz').val('');
                  $('#filter_form .room_item_clz').val('');
                  $('#filter_form').submit();
                });

                // When room type changes: clear room, then submit
                $('#filter_form .room_clz').on('change', function() {
                  $('#filter_form .room_item_clz').val('');
                  $('#filter_form').submit();
                });

                // When room changes: submit
                $('#filter_form .room_item_clz').on('change', function() {
                  $('#filter_form').submit();
                });
              });
            </script>
   
  </body>
</html>
