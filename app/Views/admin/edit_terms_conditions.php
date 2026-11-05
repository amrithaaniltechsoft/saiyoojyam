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
      <div class="row mb-6 gy-6">
        <div class="col-xxl">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom pb-3">
              <div>
                <h5 class="mb-1 text-primary"><i class="bx bx-file me-2"></i>Edit Terms and Conditions</h5>
                <small class="text-muted">Manage website Terms &amp; Conditions title, description, and downloadable PDF document.</small>
              </div>
              <div class="d-flex gap-2">
                <a href="<?= base_url('Admin/TermsConditions') ?>" class="btn btn-sm btn-outline-secondary">
                  <i class="bx bx-list-ul me-1"></i> List All Terms
                </a>
                <?php if (!empty($terms->pdf_file)): ?>
                  <a href="<?= base_url('public/uploads/terms/' . $terms->pdf_file) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                    <i class="bx bxs-file-pdf me-1"></i> View Live PDF
                  </a>
                <?php endif; ?>
              </div>
            </div>

            <div class="card-body pt-4">
              <form method="POST" action="<?= base_url('Admin/TermsConditions/Edit/' . ($terms->id ?? '')) ?>" enctype="multipart/form-data">
                
                <!-- Title Field -->
                <div class="row mb-4">
                  <label class="col-sm-3 col-form-label fw-semibold" for="terms_title">
                    Title <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="text" 
                      class="form-control" 
                      id="terms_title" 
                      name="title" 
                      value="<?= esc($terms->title ?? 'Hostel Rules, Terms & Conditions') ?>" 
                      required 
                      placeholder="e.g. Hostel Rules, Terms & Conditions" 
                    />
                    <div class="form-text">Main headline displayed on the Terms &amp; Conditions page.</div>
                  </div>
                </div>

                <!-- Small Description Field -->
                <div class="row mb-4">
                  <label class="col-sm-3 col-form-label fw-semibold" for="small_description">
                    Small Description
                  </label>
                  <div class="col-sm-9">
                    <textarea 
                      class="form-control" 
                      id="small_description" 
                      name="small_description" 
                      rows="5" 
                      placeholder="Enter a brief summary or guidelines of the hostel terms of stay..."
                    ><?= esc($terms->small_description ?? '') ?></textarea>
                    <div class="form-text">Brief overview or summary shown to inmates and visitors.</div>
                  </div>
                </div>

                <!-- PDF Upload Option -->
                <div class="row mb-4">
                  <label class="col-sm-3 col-form-label fw-semibold" for="pdf_upload">
                    PDF Document
                  </label>
                  <div class="col-sm-9">
                    <?php if (!empty($terms->pdf_file)): ?>
                      <div class="alert alert-secondary d-flex flex-wrap align-items-center justify-content-between p-3 mb-3 border" role="alert">
                        <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                          <i class="bx bxs-file-pdf fs-1 text-danger me-2"></i>
                          <div>
                            <div class="fw-bold text-dark">Current Attached PDF:</div>
                            <small class="text-muted text-break"><?= esc($terms->pdf_file) ?></small>
                          </div>
                        </div>
                        <div class="d-flex gap-2">
                          <a 
                            href="<?= base_url('public/uploads/terms/' . $terms->pdf_file) ?>" 
                            target="_blank" 
                            class="btn btn-sm btn-primary"
                          >
                            <i class="bx bx-show me-1"></i> View / Download
                          </a>
                          <a 
                            href="<?= base_url('Admin/TermsConditions/DeletePdf/' . $terms->id) ?>" 
                            onclick="return confirm('Are you sure you want to remove the current Terms & Conditions PDF?');" 
                            class="btn btn-sm btn-outline-danger"
                          >
                            <i class="bx bx-trash me-1"></i> Remove PDF
                          </a>
                        </div>
                      </div>
                    <?php endif; ?>

                    <input 
                      class="form-control" 
                      name="pdf_file" 
                      type="file" 
                      id="pdf_upload" 
                      accept=".pdf,application/pdf" 
                      onchange="PdfValidation(this)" 
                    />
                    <div class="form-text mt-1">
                      Allowed format: <strong>.pdf</strong> only. Maximum file size: <strong>25MB</strong>.
                      <?php if (!empty($terms->pdf_file)): ?>
                        <span class="text-muted ms-1">(Selecting a new file will replace the existing PDF).</span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="row mt-5">
                  <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary px-4 me-2">
                      <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                    <a href="<?= base_url('Admin/Home') ?>" class="btn btn-outline-secondary">
                      Cancel
                    </a>
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
      function PdfValidation(input) {
        if (!input || !input.files || input.files.length === 0) return;

        var file = input.files[0];
        var fileName = file.name;
        var fileSize = file.size; // in bytes
        var ext = fileName.split('.').pop().toLowerCase();

        // 1. Check extension
        if (ext !== 'pdf') {
          var errorMsg = 'Invalid file type. Please select a valid PDF (.pdf) document.';
          if (typeof alertify !== 'undefined') {
            alertify.error(errorMsg).delay(5).dismissOthers();
          } else {
            alert(errorMsg);
          }
          input.value = '';
          return false;
        }

        // 2. Check size (max 25MB = 25 * 1024 * 1024 bytes)
        var maxSize = 25 * 1024 * 1024;
        if (fileSize > maxSize) {
          var sizeMsg = 'File is too large. Please select a PDF file smaller than 25MB.';
          if (typeof alertify !== 'undefined') {
            alertify.error(sizeMsg).delay(5).dismissOthers();
          } else {
            alert(sizeMsg);
          }
          input.value = '';
          return false;
        }

        if (typeof alertify !== 'undefined') {
          alertify.success('Selected PDF: ' + fileName).delay(3).dismissOthers();
        }
        return true;
      }
    </script>
  </body>
</html>

