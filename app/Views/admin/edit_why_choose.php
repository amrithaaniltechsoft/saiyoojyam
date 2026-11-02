<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<?= $this->include("admin/includes/header") ?>
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-xxl">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Why Choose</h5>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="title" value="<?= isset($why->why_title) ? htmlspecialchars($why->why_title) : '' ?>" required/>
                </div>
              </div>

              <?php if (isset($why->why_image) && !empty($why->why_image)) { ?>
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Current Image</label>
                <div class="col-sm-10">
                  <img src="<?= base_url() ?>uploads/whychoose/<?= $why->why_image ?>" style="height:80px">
                </div>
              </div>
              <?php } ?>
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Update Image</label>
                <div class="col-sm-10">
                  <input class="form-control" name="image" type="file"/>
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  <textarea id="contentDetails" name="description"><?= isset($why->why_desc) ? $why->why_desc : '' ?></textarea>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Update</button>
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
