<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<?= $this->include("admin/includes/header") ?>
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-xxl">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Add Why Choose</h5>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="title" required/>
                </div>
              </div>

              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                  <input class="form-control" name="image" type="file"/>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  <textarea id="contentDetails" name="description"></textarea>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?= base_url() ?>Admin/WhyChoose" class="btn btn-secondary ms-2">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->include("admin/includes/footer") ?>
</body>
</html>
