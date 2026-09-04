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
                      <h5 class="mb-0">Edit Facilities</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Description</label>
                          <div class="col-sm-10">
                             <textarea id="contentDetails" name="description"><?php echo $facilities->facilities_description;?></textarea>
                          </div>
                        </div>
                        
                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Video 1</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $facilities->facilities_video1;?>"  name="video1" id=""  required/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Video 2</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $facilities->facilities_video2;?>"  name="video2" id=""  required/>
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
