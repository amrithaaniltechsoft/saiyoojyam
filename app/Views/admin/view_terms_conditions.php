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
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between border-bottom pb-3">
          <div>
            <h5 class="mb-1 text-primary"><i class="bx bx-file me-2"></i>Terms and Conditions</h5>
            <small class="text-muted">Manage website Terms &amp; Conditions documents and policies.</small>
          </div>
          <a href="<?= base_url('Admin/TermsConditions/Add') ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Add Terms &amp; Conditions
          </a>
        </div>

        <div class="table-responsive text-nowrap p-3">
          <table class="table table-hover display" id="myTable">
            <thead>
              <tr>
                <th style="width: 60px;">Sl No</th>
                <th>Title</th>
                <th>Small Description</th>
                <th style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <?php $i = 1; if (!empty($terms_list)) { foreach ($terms_list as $row) { ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td>
                    <strong><?= esc($row->title) ?></strong>
                  </td>
                  <td>
                    <?php 
                      $desc = strip_tags($row->small_description ?? '');
                      echo esc(mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . '...' : $desc);
                    ?>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-icon btn-outline-primary me-1" href="<?= base_url('Admin/TermsConditions/Edit/' . $row->id) ?>" title="Edit">
                      <i class="icon-base bx bx-edit-alt"></i>
                    </a>
                    <a class="btn btn-sm btn-icon btn-outline-danger" href="<?= base_url('Admin/TermsConditions/Delete/' . $row->id) ?>" onclick="return confirm('Are you sure you want to delete this Terms & Conditions entry?');" title="Delete">
                      <i class="icon-base bx bx-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php } } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <?= $this->include('admin/includes/footer') ?>
    <!-- / Footer -->
  </body>
</html>

