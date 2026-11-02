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
                <h5 class="card-header">View Contact</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Instagram</th>
                        <th>Facebook</th>
                        <th>YouTube</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $val){ ?> 
                      <tr>
                       
                        <td><?php echo $i; ?></td>
                        
                        <td><?php echo $val->contact_phone1; ?></td>

                        <td><?php echo $val->contact_email1; ?></td>

                        <td><?php echo $val->contact_whats_app; ?></td>

                        <td><?php echo !empty($val->contact_instagram) ? '<a href="' . esc($val->contact_instagram) . '" target="_blank"><i class="bx bxl-instagram text-danger fs-5"></i></a>' : '-'; ?></td>

                        <td><?php echo !empty($val->contact_facebook) ? '<a href="' . esc($val->contact_facebook) . '" target="_blank"><i class="bx bxl-facebook-circle text-primary fs-5"></i></a>' : '-'; ?></td>

                        <td><?php echo !empty($val->contact_youtube) ? '<a href="' . esc($val->contact_youtube) . '" target="_blank"><i class="bx bxl-youtube text-danger fs-5"></i></a>' : '-'; ?></td>
                         

                        

                        <td >
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Contact/Edit/<?php echo $val->contact_id ; ?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          
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
