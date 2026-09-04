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
                      <h5 class="mb-0">Edit Contact</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Adress</label>
                          <div class="col-sm-10">
                            <textarea type="text" class="form-control"   name="contact_adress" id=""  required ><?php echo $contact->contact_adress; ?></textarea>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Phone1</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $contact->contact_phone1; ?>"  name="contact_phone1" id=""  required/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Phone2</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $contact->contact_phone2; ?>"  name="contact_phone2" id=""  required/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Phone3</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $contact->contact_phone3; ?>"  name="contact_phone3" id="" />
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Email1</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" value="<?php echo $contact->contact_email1; ?>"  name="contact_email1" id=""  required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Email2</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" value="<?php echo $contact->contact_email2; ?>"  name="contact_email2" id="" />
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">What's app</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $contact->contact_whats_app; ?>"  name="contact_whats_app" id=""  required/>
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
