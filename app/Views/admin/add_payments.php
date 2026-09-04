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
                      <h5 class="mb-0">Add Payments</h5>
                      
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">User</label>
                          <div class="col-sm-10">
                            <select name="username" class="form-select">
                              <option value="">Select a username</option>
                              <option value="arjun99">arjun99</option>
                              <option value="nisha_singh">nisha_singh</option>
                              <option value="rohit.kumar">rohit.kumar</option>
                              <option value="maya2025">maya2025</option>
                              <option value="deepak_guest">deepak_guest</option>
                            </select>

                          </div>
                        </div>

                         

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select">
                              <option>Select Room Type</option>
                              <option value="1">Single Room</option>
                              <option value="2">Double Room</option>
                              <option value="2">Deluxe Room</option>
                              <option value="3">Suite Room</option>
                              <option value="3">Dormitory</option>
                            </select>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Payment Amount</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id=""/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Payment Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control" id="html5-date-input"/>
                          </div>
                        </div>

                        
                       


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Status</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select">
                              <option>Select Status</option>
                              <option value="1">Paid</option>
                              <option value="2">Pending</option>
                              
                            </select>
                          </div>
                        </div>
                       

                      

                       

                       
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
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
