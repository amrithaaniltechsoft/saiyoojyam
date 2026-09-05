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
                      <h5 class="mb-0">Add Building</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                       

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="">Building Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control"  name="building_name" id="" placeholder="Annex" required/>
                          </div>
                        </div>
                        


                       

                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add</button>
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
                    errorPlacement: function (error, element) {
                      error.insertAfter(element); // or leave empty to suppress
                    },
                    errorClass: "text-danger", 
                    submitHandler: function (currentForm) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Building/Add",
                        type: "POST",
                        data: $(currentForm).serialize(), // Use FormData only if you're uploading files
                        success: function(response) {

                          console.log(response);

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
