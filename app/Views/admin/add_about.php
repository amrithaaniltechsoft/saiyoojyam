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
            <div class="card-header d-flex align-items-center justify-content-between">
              <h5 class="mb-0">Add About Section</h5>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">

                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="about_subtitle">Tag / Subtitle</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="e.g. Role of Hostel Accommodation" name="subtitle" id="about_subtitle" />
                  </div>
                </div>

                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="about_title">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="e.g. ...A Second Home for Innovators & Professionals" name="title" id="about_title" required />
                  </div>
                </div>

                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="contentDetails">Description</label>
                  <div class="col-sm-10">
                    <textarea id="contentDetails" name="description"></textarea>
                  </div>
                </div>

                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="image">Section Image</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="image" type="file" id="image" />
                  </div>
                </div>

                <div class="row justify-content-end">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="<?= base_url() ?>Admin/About/View" class="btn btn-secondary ms-2">Cancel</a>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->

    <!-- Footer section start-->
    <?= $this->include('admin/includes/footer') ?>
    <!--Footer section end-->
  </body>
</html>
