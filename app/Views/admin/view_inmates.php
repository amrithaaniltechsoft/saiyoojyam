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
                <h5 class="card-header">View Inmates</h5>
               
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        
                        <th>Name</th>
                        <th>Building</th>
                        <th>Rooms</th>
                        
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $val){ ?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                         <td><?php echo $val->inmates_name;?></td>
                        <?php foreach($buildings as $build){ 
                           if($build->building_id  == $val->inmates_building){ 
                        ?> 
                        <td><?php echo $build->building_name?></td>
                        <?php }  }  ?>
                        
                        <?php foreach($rooms_data as $rooms){
                           if($rooms->rooms_id  == $val->inmates_rooms){ 
                        ?>

                          <td><?php echo $rooms->rooms_name;?></td>

                        <?php } }  ?>
                       
                        <td><?php echo date('d-M-Y',strtotime($val->inmates_check_in_date)); ?></td>
                        <td><?php if($val->inmates_check_out_date !="0000-00-00"){echo date('d-M-Y',strtotime($val->inmates_check_out_date));} ?></td>
                        
                        <td style="display: flex;">
                          <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-trash me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Inmates/Receipt/<?php echo $val->inmates_id;?>"><i class="icon-base bx bx-bxs-printer me-2"></i> </a>
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
