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
                <h5 class="card-header">Building Fees (Admission & Caution Deposit)</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building Name</th>
                        <th>Admission Fees</th>
                        <th>Caution Deposit</th>
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php $i=1; foreach($buildings as $building){ ?> 
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $building->building_name;?></td>
                        <td><?php echo number_format($building->building_admission_fees,2);?></td>
                        <td><?php echo number_format($building->building_caution_deposit,2);?></td>
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/BuildingFees/Edit/<?php echo $building->building_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                        </td>
                      </tr>

                      <?php $i++; } ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

            </div>
            <!-- / Content -->

            <!-- Footer section start-->
            
            <?= $this->include('admin/includes/footer') ?>

            <!--Footer section end-->

   
  </body>
</html>
