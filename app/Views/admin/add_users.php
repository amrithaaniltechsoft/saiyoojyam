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
                      <h5 class="mb-0">Add Customer</h5>
                      
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="e.g., Aman Kumar" />
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="basic-default-name" placeholder="e.g., example@gmail.com" />
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Phone Number</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="e.g., 9876543210" />
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Adress</label>
                          <div class="col-sm-10">
                            <textarea id="basic-default-message" class="form-control" placeholder="EHouse No., Street, City, Pincode" aria-describedby="basic-icon-default-message2"></textarea>
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
