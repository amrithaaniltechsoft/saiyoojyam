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
                      <h5 class="mb-0">Add CMS</h5>
                      <a href="<?= base_url('Admin/Cms') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-arrow-back me-1"></i> Back to List
                      </a>
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="page">Page</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="page" id="page" placeholder="e.g. Terms and Conditions, Home, About" required />
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="title">Title</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter CMS Title" required />
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="contentDetails">Description</label>
                          <div class="col-sm-10">
                             <textarea id="contentDetails" name="description"></textarea>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="image_upload">Image (Optional)</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="image" type="file" id="image_upload" onchange="Filevalidation()" />
                            <small class="text-muted">Leave empty if this CMS section does not require an image.</small>
                          </div>
                        </div>
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save CMS</button>
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

  </body>
</html>

