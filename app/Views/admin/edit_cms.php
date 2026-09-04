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
                      <h5 class="mb-0">Edit CMS</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Page</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $cms_data->page; ?>"  name="page" id=""  required readonly/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Title</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $cms_data->cms_tittle; ?>"  name="title" id=""  required/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Description</label>
                          <div class="col-sm-10">
                             <textarea id="contentDetails" name="description"><?php echo $cms_data->cms_desc; ?></textarea>
                          </div>
                        </div>

                        <?php if($cms_data->cms_type == 1){ ?> 
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name"> Image</label>
                          <div class="col-sm-10">
                            <img src="<?php echo base_url();?>public/uploads/cms/thumbs/<?php echo $cms_data->cms_img; ?>" class="edit_image">
                          </div>
                        </div>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Update Image</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="image" type="file" id="image_upload" onchange="Filevalidation()" />
                          </div>
                        </div>


                        <?php } ?>

                        
                        


                        

                       
                        
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


            <script>
                Filevalidation = () => 
                {
                    const fi = document.getElementById('image_upload');
                    // Check if any file is selected.
                    if (fi.files.length > 0) 
                    {
                        for (const i = 0; i <= fi.files.length - 1; i++) {

                            const fsize = fi.files.item(i).size;
                            const file = Math.round((fsize / 1024));
                            // The size of the file.
                            if (file >= 1096) 
                            {
                                alert(
                                    "File too Big, please select a file less than 1mb");
                                $("#image_upload").val('');
                            } 
                        }
                    }
                }
            </script> 

            

   
  </body>
</html>
