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
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">List Building</h5>
                  <?php if(session()->get('manage') != 'website'){ ?>
                  <a href="<?= base_url(); ?>Admin/Building/Add" class="btn btn-primary btn-sm"><i class="icon-base bx bx-plus me-1"></i> Add Building</a>
                  <?php } ?>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building Name</th>
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php $i=1; foreach($buildings as $build){ ?> 
                      <tr>
                        
                        <td><?php echo $i; ?></td>
                        <td><?php echo $build->building_name;?></td>
                        
                        <td>
                          <?php if(session()->get('manage') == 'website'){ ?>
                            <a class="dropdown-item" href="<?php echo base_url();?>Admin/Building/EditWeb/<?php echo $build->building_id; ?>" title="Edit Website Building"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <?php } else { ?>
                            <a class="dropdown-item" href="<?php echo base_url();?>Admin/Building/Edit/<?php echo $build->building_id; ?>" title="Edit Building"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                            <a class="dropdown-item" href="<?php echo base_url();?>Admin/Building/Delete/<?php echo $build->building_id; ?>" onclick="return confirm('Are you sure you want to delete this building?');"><i class="icon-base bx bx-trash me-2"></i> </a>
                          <?php } ?>
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
