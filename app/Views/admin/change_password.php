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

              <!-- Basic Layout -->
              <div class="row mb-6 gy-6">
                <div class="col-xxl col-lg-8">
                  <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between py-3">
                      <h5 class="mb-0 fw-semibold">
                        <i class="bx bx-key text-primary me-2"></i>Change Admin Password
                      </h5>
                    </div>
                    <div class="card-body pt-4">
                      <form id="add_form">

                        <div class="row mb-4">
                          <label class="col-sm-3 col-form-label fw-semibold" for="new_password">New Password</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <span class="input-group-text"><i class="bx bx-lock"></i></span>
                              <input 
                                type="password" 
                                class="form-control" 
                                name="new_password" 
                                id="new_password" 
                                placeholder="Enter new password (min. 8 characters)" 
                                minlength="8" 
                                required
                              />
                            </div>
                            <div class="form-text text-muted mt-1">
                              Password must be at least 8 characters long.
                            </div>
                          </div>
                        </div>

                        <div class="row mb-4">
                          <label class="col-sm-3 col-form-label fw-semibold" for="confirm_password">Confirm Password</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                              <input 
                                type="password" 
                                class="form-control" 
                                name="confirm_password" 
                                id="confirm_password" 
                                placeholder="Re-enter new password" 
                                minlength="8" 
                                required
                              />
                            </div>
                          </div>
                        </div>

                        <div class="row justify-content-end mt-4">
                          <div class="col-sm-9 offset-sm-3">
                            <button type="submit" id="btn_submit" class="btn btn-primary px-4">
                              <i class="bx bx-check-circle me-1"></i> Update Password
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?= $this->include('admin/includes/footer') ?>
            <!-- / Footer -->

             <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                $(document).ready(function () {
                  var form = $('#add_form');
                  form.validate({
                    rules: {
                      new_password: {
                        required: true,
                        minlength: 8
                      },
                      confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                      }
                    },
                    messages: {
                      new_password: {
                        required: "Please enter a new password",
                        minlength: "Password must be at least 8 characters long"
                      },
                      confirm_password: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                      }
                    },
                    errorClass: "text-danger small mt-1", 
                    errorPlacement: function (error, element) {
                      if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                      } else {
                        error.insertAfter(element);
                      }
                    },
                    submitHandler: function (currentForm, event) {
                      event.preventDefault(); 
                      
                      var submitBtn = $('#btn_submit');
                      submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Updating...');

                      var formData = new FormData(currentForm);
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/ChangePassword/updatePassword",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                          var data = (typeof response === 'object') ? response : null;
                          if (!data) {
                            try { data = JSON.parse(response); } catch(e){}
                          }

                          if (data && data.status) {
                            alertify.success(data.msg).delay(3).dismissOthers();
                            form[0].reset();
                          } else {
                            var errMsg = (data && data.msg) ? data.msg : 'Failed to update password.';
                            alertify.error(errMsg).delay(4).dismissOthers();
                          }
                        },
                        error: function(xhr) {
                          alertify.error('An unexpected error occurred. Please try again.').delay(4).dismissOthers();
                        },
                        complete: function() {
                          submitBtn.prop('disabled', false).html('<i class="bx bx-check-circle me-1"></i> Update Password');
                        }
                      });
                    }
                  });
                });
              });
            </script>

  </body>
</html>
