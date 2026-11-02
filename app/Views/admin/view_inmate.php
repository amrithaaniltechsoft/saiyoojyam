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
              <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0">Inmate Details</h5>
                <div class="d-flex align-items-center gap-2">
                  <button type="button" class="btn btn-warning btn-sm btn-regen-pwd" 
                    data-id="<?php echo $inmate->inmates_id; ?>" 
                    data-name="<?php echo htmlspecialchars($inmate->inmates_name, ENT_QUOTES); ?>" 
                    data-uid="<?php echo htmlspecialchars($inmate->inmates_uid, ENT_QUOTES); ?>" 
                    data-email="<?php echo htmlspecialchars($inmate->inmates_email ?? '', ENT_QUOTES); ?>" 
                    data-phone="<?php echo htmlspecialchars($inmate->inmates_phone_no ?? '', ENT_QUOTES); ?>">
                    <i class="bx bx-key me-1"></i> Regenerate Password
                  </button>
                  <a href="<?php echo base_url();?>Admin/Inmates" class="btn btn-secondary btn-sm">Back</a>
                </div>
              </div>

              <div class="row gy-4">
                <div class="col-xl-8">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center gap-4 mb-4">
                        <?php if(!empty($inmate->inmates_photo)){ ?>
                        <img src="<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/photo" class="rounded" style="width:100px;height:100px;object-fit:cover;border:1px solid #ddd;"/>
                        <?php } ?>
                        <div>
                          <h4 class="mb-1"><?php echo $inmate->inmates_name; ?></h4>
                          <span class="badge bg-label-primary"><?php echo $inmate->inmates_uid; ?></span>
                          <span class="badge <?php if($inmate->inmates_status == 'checked_out'){ echo 'bg-label-danger'; } else { echo 'bg-label-success'; } ?> ms-2"><?php if($inmate->inmates_status == 'checked_out'){ echo 'Inactive'; } else { echo 'Active'; } ?></span>
                        </div>
                      </div>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <table class="table table-sm table-bordered mb-0">
                            <tbody>
                              <tr><th class="text-nowrap" style="width:140px;">Age</th><td><?php echo $inmate->inmates_age; ?></td></tr>
                              <tr><th>Building</th><td><?php echo $inmate->building_name; ?></td></tr>
                              <tr><th>Room Type</th><td><?php echo $inmate->room_type_name; ?></td></tr>
                              <tr><th>Room</th><td><?php echo $inmate->rooms_name; ?></td></tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table table-sm table-bordered mb-0">
                            <tbody>
                              <tr><th class="text-nowrap" style="width:140px;">Check In</th><td><?php echo date('d-M-Y',strtotime($inmate->inmates_check_in_date)); ?></td></tr>
                              <tr><th>Check Out</th><td><?php if($inmate->inmates_check_out_date != '0000-00-00'){ echo date('d-M-Y',strtotime($inmate->inmates_check_out_date)); } else { echo '---'; } ?></td></tr>
                              <tr><th>Duration of Stay</th><td><?php if(!empty($duration)){ echo $duration->duration_stay; } ?></td></tr>
                              <tr><th>Place of Work</th><td><?php echo $inmate->inmates_place_of_work; ?></td></tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row g-3 mt-2">
                        <div class="col-md-6">
                          <table class="table table-sm table-bordered mb-0">
                            <tbody>
                              <tr><th class="text-nowrap" style="width:140px;">Phone</th><td><?php echo $inmate->inmates_phone_no; ?></td></tr>
                              <tr><th>WhatsApp</th><td><?php echo $inmate->inmates_whats_app_number; ?></td></tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table table-sm table-bordered mb-0">
                            <tbody>
                              <tr><th class="text-nowrap" style="width:140px;">Guardian</th><td><?php echo $inmate->inmates_guardian_name; ?></td></tr>
                              <tr><th>Relation</th><td><?php echo $inmate->inmates_relation; ?></td></tr>
                              <tr><th>Contact</th><td><?php echo $inmate->inmates_guardian_contact; ?></td></tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-4">
                  <div class="card h-100">
                    <div class="card-header">
                      <h5 class="mb-0">Documents</h5>
                    </div>
                    <div class="card-body">
                      <div class="d-flex gap-4 align-items-start">
                        <div>
                          <p class="fw-semibold mb-2">ID Proof</p>
                          <?php if(!empty($inmate->inmates_id_proof)){ ?>
                          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/proof')">
                          <img src="<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/proof" class="rounded" style="width:160px;height:160px;object-fit:cover;border:1px solid #ddd;cursor:pointer;"/>
                          </a>
                          <?php } else { echo '<p class="text-muted">---</p>'; } ?>
                        </div>
                        <div>
                          <p class="fw-semibold mb-2">Photo</p>
                          <?php if(!empty($inmate->inmates_photo)){ ?>
                          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/photo')">
                          <img src="<?php echo base_url();?>Admin/Inmates/Image/<?php echo $inmate->inmates_id; ?>/photo" class="rounded" style="width:160px;height:160px;object-fit:cover;border:1px solid #ddd;cursor:pointer;"/>
                          </a>
                          <?php } else { echo '<p class="text-muted">---</p>'; } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Image Lightbox Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center p-2">
                    <img id="modalImage" src="" class="img-fluid" style="max-height:75vh;"/>
                  </div>
                </div>
              </div>
            </div>

            <!-- Inmate Regenerate Password Modal -->
            <div class="modal fade" id="regenPwdModal" tabindex="-1" aria-labelledby="regenPwdModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                  <div class="modal-header text-white pe-5 position-relative" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);padding:18px 22px;">
                    <div class="d-flex align-items-center gap-2.5">
                      <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.22);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);flex-shrink:0;">
                        <i class="fa fa-key" style="font-size:18px;color:#fff;"></i>
                      </div>
                      <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="regenPwdModalLabel">Regenerate Inmate Password</h5>
                        <small style="font-size:11.5px;color:rgba(255,255,255,0.92);">Reset resident login credentials</small>
                      </div>
                    </div>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>

                  <div class="modal-body p-4">
                    <!-- Inmate Info Banner -->
                    <div class="p-3 mb-3 rounded-3" style="background:#fffbeb;border:1.5px solid #fde68a;">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark" id="rgp_inmate_name" style="font-size:15px;">Inmate Name</span>
                        <span class="badge bg-warning text-dark font-monospace" id="rgp_inmate_uid">IN000000</span>
                      </div>
                      <div class="d-flex flex-wrap align-items-center gap-2 text-muted" style="font-size:12px;">
                        <span id="rgp_email_wrapper"><i class="fa fa-envelope-o me-1 text-primary"></i><span id="rgp_inmate_email">No Email</span></span>
                        <span id="rgp_sep_dot">•</span>
                        <span><i class="fa fa-phone me-1 text-success"></i><span id="rgp_inmate_phone">-</span></span>
                      </div>
                    </div>

                    <!-- Form Step (Visible initially) -->
                    <div id="rgp_step_form">
                      <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size:13px;">New Password</label>
                        <div class="input-group">
                          <input type="text" class="form-control font-monospace" id="rgp_password_input" placeholder="Type custom or click suggest..." style="font-size:14px;letter-spacing:0.5px;">
                          <button class="btn btn-outline-secondary" type="button" id="rgp_btn_suggest" title="Generate New Password Suggestion">
                            <i class="fa fa-random me-1"></i> Suggest
                          </button>
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size:11px;">Min 6 characters. Click <strong>Suggest</strong> to generate a secure random password.</small>
                      </div>

                      <div class="mb-3" id="rgp_send_email_container">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="rgp_send_email" checked style="cursor:pointer;">
                          <label class="form-check-label text-dark fw-semibold" for="rgp_send_email" style="font-size:12.5px;cursor:pointer;">
                            Send updated credentials to inmate's email (<span id="rgp_email_badge" class="text-primary font-monospace">email</span>)
                          </label>
                        </div>
                      </div>

                      <div id="rgp_no_email_notice" class="alert alert-secondary py-2 px-3 mb-3 d-none" style="font-size:11.5px;border-radius:8px;">
                        <i class="fa fa-info-circle me-1 text-muted"></i> This inmate has no email address. The generated password will be shown on screen so you can copy and share it via WhatsApp/SMS.
                      </div>

                      <div id="rgp_error_alert" class="alert alert-danger py-2 px-3 mb-0 d-none" style="font-size:12px;border-radius:8px;"></div>
                    </div>

                    <!-- Success Step (Visible after successful regeneration) -->
                    <div id="rgp_step_success" class="d-none">
                      <div class="text-center py-4 px-2">
                        <div class="mb-3">
                          <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 58px; height: 58px; background-color: #d1e7dd; color: #0f5132;">
                            <i class="fa fa-envelope-o" style="font-size: 26px;"></i>
                          </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Password Updated Successfully</h5>
                        
                        <div id="rgp_email_success_box" class="alert alert-success py-3 px-3 mb-0" style="font-size:14.5px; border-radius:8px;">
                          <i class="fa fa-check-circle me-1.5 text-success"></i> New password sent to mail (<strong id="rgp_success_email"></strong>)
                        </div>

                        <div id="rgp_no_email_box" class="alert alert-warning py-3 px-3 mb-0 d-none text-start" style="font-size:13px; border-radius:8px;">
                          <i class="fa fa-info-circle me-1 text-warning"></i> Inmate has no email address. Updated password: <strong id="rgp_fallback_pwd" class="font-monospace text-dark"></strong>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer px-4 py-3" style="background:#f8fafc;border-top:1px solid #edf2f7;">
                    <div id="rgp_footer_form" class="w-100 d-flex justify-content-between align-items-center">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-warning fw-bold text-dark px-4" id="rgp_btn_submit">
                        <i class="fa fa-key me-1"></i> Update Password
                      </button>
                    </div>
                    <div id="rgp_footer_success" class="w-100 d-none text-end">
                      <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer -->
            
            <?= $this->include('admin/includes/footer') ?>

            <!-- / Footer -->

            <script>
              function showImage(src){
                document.getElementById('modalImage').src = src;
              }

              // --- Inmate Regenerate Password Modal Script ---
              function generateRandomPassword() {
                var randNum = Math.floor(100 + Math.random() * 900);
                var chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
                var syms = ["@", "#", "$", "!", "&"];
                var sym = syms[Math.floor(Math.random() * syms.length)];
                var randChar = chars.charAt(Math.floor(Math.random() * chars.length));
                var yr = new Date().getFullYear().toString().slice(-2);
                return "Saiy" + randNum + sym + yr + randChar;
              }

              var currentRegenInmateId = null;
              var lastGeneratedCreds = null;

              $(document).on("click", ".btn-regen-pwd", function(e) {
                e.preventDefault();
                var id = $(this).data("id");
                var name = $(this).data("name");
                var uid = $(this).data("uid");
                var email = $(this).data("email") || "";
                var phone = $(this).data("phone") || "";

                currentRegenInmateId = id;
                $("#rgp_inmate_name").text(name || "Inmate");
                $("#rgp_inmate_uid").text(uid || ("IN" + id));
                $("#rgp_inmate_email").text(email || "No Email");
                $("#rgp_inmate_phone").text(phone || "No Phone");

                if (!email) {
                  $("#rgp_send_email_container").addClass("d-none");
                  $("#rgp_no_email_notice").removeClass("d-none");
                  $("#rgp_send_email").prop("checked", false);
                } else {
                  $("#rgp_send_email_container").removeClass("d-none");
                  $("#rgp_no_email_notice").addClass("d-none");
                  $("#rgp_email_badge").text(email);
                  $("#rgp_send_email").prop("checked", true);
                }

                // Pre-fill suggested password
                $("#rgp_password_input").val(generateRandomPassword());
                $("#rgp_error_alert").addClass("d-none").text("");

                // Show form step, hide success step
                $("#rgp_step_form").removeClass("d-none");
                $("#rgp_footer_form").removeClass("d-none");
                $("#rgp_step_success").addClass("d-none");
                $("#rgp_footer_success").addClass("d-none");

                var modalEl = document.getElementById("regenPwdModal");
                if (modalEl && modalEl.parentNode !== document.body) {
                  document.body.appendChild(modalEl);
                }
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
              });

              $("#rgp_btn_suggest").on("click", function() {
                $("#rgp_password_input").val(generateRandomPassword()).focus();
              });

              $("#rgp_btn_submit").on("click", function() {
                var pwd = $("#rgp_password_input").val().trim();
                if (!pwd || pwd.length < 6) {
                  $("#rgp_error_alert").removeClass("d-none").text("Password must be at least 6 characters long.");
                  return;
                }

                var $btn = $(this);
                var origHtml = $btn.html();
                $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin me-1"></i> Updating...');
                $("#rgp_error_alert").addClass("d-none").text("");

                $.ajax({
                  url: "<?php echo base_url('Admin/Inmates/RegeneratePassword'); ?>",
                  type: "POST",
                  data: {
                    inmates_id: currentRegenInmateId,
                    password: pwd,
                    send_email: $("#rgp_send_email").is(":checked") ? 1 : 0,
                    is_ajax: 1
                  },
                  dataType: "json",
                  success: function(res) {
                    $btn.prop("disabled", false).html(origHtml);
                    if (res && res.status) {
                      lastGeneratedCreds = res.credentials;
                      
                      var emailAddr = res.email_address;
                      if (!emailAddr || emailAddr === "None" || emailAddr === "-") {
                        emailAddr = $("#rgp_inmate_email").text().trim();
                      }

                      if (emailAddr && emailAddr !== "No Email" && emailAddr !== "None") {
                        $("#rgp_success_email").text(emailAddr);
                        $("#rgp_email_success_box").removeClass("d-none");
                        $("#rgp_no_email_box").addClass("d-none");
                      } else {
                        $("#rgp_fallback_pwd").text(res.credentials ? res.credentials.password : "");
                        $("#rgp_email_success_box").addClass("d-none");
                        $("#rgp_no_email_box").removeClass("d-none");
                      }

                      $("#rgp_step_form").addClass("d-none");
                      $("#rgp_footer_form").addClass("d-none");
                      $("#rgp_step_success").removeClass("d-none");
                      $("#rgp_footer_success").removeClass("d-none");
                    } else {
                      $("#rgp_error_alert").removeClass("d-none").text(res?.message || "Failed to regenerate password.");
                    }
                  },
                  error: function(xhr) {
                    $btn.prop("disabled", false).html(origHtml);
                    var err = "Server error. Please try again.";
                    try {
                      var json = JSON.parse(xhr.responseText);
                      if (json && json.message) err = json.message;
                    } catch(e) {}
                    $("#rgp_error_alert").removeClass("d-none").text(err);
                  }
                });
              });

              $("#rgp_btn_copy_all").on("click", function() {
                if (!lastGeneratedCreds) return;
                var text = "Hello " + lastGeneratedCreds.name + ",\n" +
                           "Your Saiyoojyam Resident Portal login credentials have been updated:\n\n" +
                           "Portal URL: " + lastGeneratedCreds.portal_url + "\n" +
                           "Username / Login ID: " + lastGeneratedCreds.login_id + "\n" +
                           "Password: " + lastGeneratedCreds.password + "\n\n" +
                           "- Saiyoojyam Ladies Hostels Management";

                navigator.clipboard.writeText(text).then(function() {
                  var $btn = $("#rgp_btn_copy_all");
                  var orig = $btn.html();
                  $btn.attr("class", "btn btn-success w-100 py-2 fw-bold").html('<i class="fa fa-check me-1.5"></i> Copied to Clipboard!');
                  setTimeout(function() {
                    $btn.attr("class", "btn btn-outline-primary w-100 py-2 fw-bold").html(orig);
                  }, 2500);
                }).catch(function() {
                  alert("Could not copy automatically. Please copy the credentials manually from the box.");
                });
              });
            </script>

  </body>
</html>