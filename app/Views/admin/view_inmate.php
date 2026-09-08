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
                <a href="<?php echo base_url();?>Admin/Inmates" class="btn btn-secondary btn-sm">Back</a>
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

            <script>
              function showImage(src){
                document.getElementById('modalImage').src = src;
              }
            </script>

            <!-- Footer -->
            
            <?= $this->include('admin/includes/footer') ?>

            <!-- / Footer -->

  </body>
</html>