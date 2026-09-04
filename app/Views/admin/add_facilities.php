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
                      <h5 class="mb-0">Add Facilities</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Title</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="facilities_name" id="basic-default-name" placeholder="e.g., Rahul Sharma" required/>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                          <div class="col-sm-10">
                            <textarea
                              id="basic-default-message"
                              class="form-control"
                              placeholder="Enter description of the service"
                              
                              aria-describedby="basic-icon-default-message2" name="facilities_description" required></textarea>
                          </div>
                        </div>
                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Image</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="facilities_image" type="file" id="formFile" />
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
                        url: "<?php echo base_url(); ?>Admin/Facilities/Add",
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
