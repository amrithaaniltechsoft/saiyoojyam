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
                      <h5 class="mb-0">Add Beds</h5>
                      
                    </div>
                    <div class="card-body">
                      <form>
                        

                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Select Room Type</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select">
                              <option>Select Room Type</option>
                              <option value="1">tower1, 3 Sharing</option>
                              <option value="3">tower1, 4 sharing</option>
                              <option value="2">tower2, Single</option>
                              <option value="3">AnnexA Type Room</option>
                              <option value="3">AnnexC Type Room</option>
                             
                            </select>
                            
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Bed Number</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" id="basic-default-name" placeholder="e.g.,B1">
                          </div>
                        </div>

                      



                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Status</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select">
                              <option>Select Status</option>
                              <option value="1">Availabl</option>
                              <option value="3">Occupied</option>
                             
                            </select>
                            
                          </div>
                        </div>-->


                        


                      


                       

                       
                        
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
