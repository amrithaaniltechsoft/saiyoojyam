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
                <h5 class="card-header">View Room Types</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building</th>
                        <th>Room Type</th>
                        
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $page_data){?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                        <?php foreach($buildings as $build){
                        if($build->building_id == $page_data->room_type_building_id){  
                        ?> 
                        <td><?php echo $build->building_name; ?></td>
                        <?php } } ?>
                        <td><?php echo $page_data->room_type_name;?></td>
                        
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/RoomTypes/Edit/<?php echo $page_data->room_type_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/RoomTypes/Delete/<?php echo $page_data->room_type_id; ?>"><i class="icon-base bx bx-trash me-2"></i> </a>
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
   
  </body>
</html>
