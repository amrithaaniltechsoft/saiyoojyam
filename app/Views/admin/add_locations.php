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
                      <h5 class="mb-0">Add Location</h5>
                      
                    </div>
                    <div class="card-body">
                      <form>
                        

                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Location</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select">
                              <option>Select Location</option>
                              <option value="1">Tower 1</option>
                              <option value="2">Tower 2</option>
                              <option value="2">Annex</option>
                              
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
