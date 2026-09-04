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
                      <h5 class="mb-0">Change Password</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form" >

                         
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">New Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password" id="basic-default-name"   required/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Confirm Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="confirm_password" id="basic-default-name"  required/>
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

            <!--image size validation start--->
          
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


             <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                 
    
                /*add section*/  
                
                $(document).ready(function () {
                  var form = $('#add_form');
                  form.validate({
                    rules: {
                    
                      required: 'required',
                    },
                    messages: {
                    
                      required: 'This field is required',
                    },
                    errorClass: "text-danger", 
                    errorPlacement: function (error, element) {
                      error.insertAfter(element); // or leave empty to suppress
                    },
                    
                    
                    
                    submitHandler: function (currentForm,event) {
                      event.preventDefault(); 
                      
                      var formData = new FormData(currentForm);
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/ChangePassword/updatePassword",
                        type: "POST",
                        data: formData, // Use FormData only if you're uploading files
                        processData: false, // ✅ prevent jQuery from serializing
                        contentType: false,
                        success: function(response) {

                          var data = JSON.parse(response);

                          alertify.success(data.msg).delay(3).dismissOthers();

                          form[0].reset(); // Reset the form

                        }
                      });
                    }
                  });
                });

                /*end section*/

       
              });
            </script>

   
  </body>
</html>
