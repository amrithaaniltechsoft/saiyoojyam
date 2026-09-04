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
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building</th>
                        <th>Room Types</th>
                        <th>Room Name</th>
                        <th>Capacity</th>
                        <th>Ac/Non Ac</th>
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $page_data){?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                       
                        
                        <td><?php echo $page_data->building_name;?></td>
                        <td><?php echo $page_data->room_type_name;?></td>

                        <td><?php echo $page_data->rooms_name;?></td>
                        <td><?php echo $page_data->rooms_capacity;?></td>
                        <td><?php echo $page_data->rooms_ac_type;?></td>
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Rooms/EditWeb/<?php echo $page_data->rooms_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          
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
