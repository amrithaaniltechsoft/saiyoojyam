<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<?= $this->include("admin/includes/header") ?>
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <h5 class="card-header">View Why Choose Saiyoojyam</h5>
      <div class="table-responsive text-nowrap">
        <table class="table display" id="myTable">
          <thead><tr><th>Sl No</th><th>Title</th><th>Image</th><th>Description</th><th>Action</th></tr></thead>
          <tbody>
            <?php $i = 1; if (isset($why_list) && !empty($why_list)) { foreach ($why_list as $val) { ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($val->why_title) ?></td>
              <td>
                <?php if (!empty($val->why_image)) { ?>
                  <img src="<?= base_url() ?>uploads/whychoose/<?= $val->why_image ?>" style="height:50px">
                <?php } ?>
              </td>
              <td><?= substr(strip_tags($val->why_desc), 0, 80) ?></td>
              <td>
                <a class="dropdown-item" href="<?= base_url() ?>Admin/WhyChoose/Edit/<?= $val->why_id ?>"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                <a class="dropdown-item" href="<?= base_url() ?>Admin/WhyChoose/Delete/<?= $val->why_id ?>" onclick="return confirm('Are you sure you want to delete this?');"><i class="icon-base bx bx-trash me-2"></i></a>
              </td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->include("admin/includes/footer") ?>
</body>
</html>
