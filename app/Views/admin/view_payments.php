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
                <h5 class="card-header">View Payments</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Customer</th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Payment Mode</th>
                        <th>Payment Status</th>
                        <th>Payment Date</th>
                        <th>Due Date</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td>John Doe</td>
                        <td>INV-2025-00123</td>
                        <td>$1,250.00</td>
                        <td>2025-05-15</td>
                        <td>Bank Transfer</td>
                        <td>Paid</td>
                        <td>2025-05-15</td>
                        <td>2025-06-15</td>
                        <td>Online Payment</td>
                        <td style="display: flex;">
                          <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-trash me-2"></i> </a>
                        </td>
                        

                        <!--<td>
                          <i class="icon-base bx bxl-angular icon-md text-danger me-4"></i> <span>Angular Project</span>
                        </td>
                        <td>Albert Cook</td>
                        
                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="icon-base bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>-->
                      </tr>
                      
                     
                      
                      
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
