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
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">View CMS</h5>
                  <a href="<?php echo base_url();?>Admin/Cms/Add" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus me-1"></i> Add CMS
                  </a>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Page</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $val){ ?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><span class="badge bg-label-primary"><?php echo $val->page; ?></span></td>
                        <td><strong><?php echo $val->cms_tittle; ?></strong></td>
                        <td><?php echo substr(strip_tags($val->cms_desc),0,90) . (strlen(strip_tags($val->cms_desc)) > 90 ? '...' : ''); ?></td>
                        <td>
                          <a class="btn btn-sm btn-icon btn-outline-primary me-1" href="<?php echo base_url();?>Admin/Cms/Edit/<?php echo $val->id ; ?>" title="Edit">
                            <i class="icon-base bx bx-edit-alt"></i>
                          </a>
                          <a class="btn btn-sm btn-icon btn-outline-danger" href="<?php echo base_url();?>Admin/Cms/Delete/<?php echo $val->id ; ?>" onclick="return confirm('Are you sure you want to delete this CMS item?');" title="Delete">
                            <i class="icon-base bx bx-trash"></i>
                          </a>
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
