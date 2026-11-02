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
      <!-- Basic Bootstrap Table -->
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="mb-0">About Us Page Sections</h5>
            <small class="text-muted">Manage the 6 main sections shown on http://localhost:3000/about-us</small>
          </div>
          <a href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>" class="btn btn-primary btn-sm"><i class="bx bx-edit-alt me-1"></i> Edit All Sections</a>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table display" id="myTable">
            <thead>
              <tr>
                <th style="width: 60px;">Sl no</th>
                <th>Section Name</th>
                <th>Heading / Title</th>
                <th>Description Preview</th>
                <th style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <!-- Section 1 -->
              <tr>
                <td>1</td>
                <td><strong>Saiyoojyam Ladies Hostels</strong></td>
                <td><?= htmlspecialchars($about->about_title ?? '...A Second Home for Innovators & Professionals') ?></td>
                <td><?= htmlspecialchars(substr(strip_tags($about->about_description ?? $about->about_desc ?? ''), 0, 80)) ?>...</td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#about_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>

              <!-- Section 2 -->
              <tr>
                <td>2</td>
                <td><strong>Saiyoojyam Hostels Network</strong></td>
                <td><?= htmlspecialchars($about->network_title ?? 'Saiyoojyam Hostels Network') ?></td>
                <td><?= htmlspecialchars(substr(strip_tags($about->network_description ?? ''), 0, 80)) ?>...</td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#network_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>

              <!-- Section 3 -->
              <tr>
                <td>3</td>
                <td><strong>Mission &amp; Vision</strong></td>
                <td><?= htmlspecialchars($about->mission_title ?? 'Mission') ?> &amp; <?= htmlspecialchars($about->vision_title ?? 'Vision') ?></td>
                <td><?= htmlspecialchars(substr(strip_tags($about->mission_description ?? ''), 0, 80)) ?>...</td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#mission_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>

              <!-- Section 4 -->
              <tr>
                <td>4</td>
                <td><strong>Specialities</strong></td>
                <td><?= htmlspecialchars($about->specialities_title ?? 'Specialities') ?></td>
                <td>
                  <?php 
                    $spItems = !empty($about->specialities_items) ? json_decode($about->specialities_items, true) : [];
                    echo !empty($spItems) ? count($spItems) . ' Speciality cards configured' : 'Healthy Living, Water Supply, Security...';
                  ?>
                </td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#specialities_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>

              <!-- Section 5 -->
              <tr>
                <td>5</td>
                <td><strong>Neighbourhood Facilities</strong></td>
                <td><?= htmlspecialchars($about->neighbourhood_title ?? 'Neighbourhood Facilities') ?></td>
                <td><?= htmlspecialchars(substr(strip_tags($about->neighbourhood_description ?? ''), 0, 80)) ?>...</td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#neighbourhood_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>

              <!-- Section 6 -->
              <tr>
                <td>6</td>
                <td><strong>Call To Action (CTA)</strong></td>
                <td><?= htmlspecialchars($about->cta_title ?? 'Looking for a comfortable home in Kakkanad?') ?></td>
                <td><?= htmlspecialchars(substr(strip_tags($about->cta_description ?? ''), 0, 80)) ?>...</td>
                <td>
                  <a class="dropdown-item" href="<?= base_url(); ?>Admin/About/Edit/<?= $about->about_id ?? 1; ?>#cta_title"><i class="icon-base bx bx-edit-alt me-2"></i></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Basic Bootstrap Table -->
    </div>
    <!-- / Content -->

    <!-- Footer section start-->
    <?= $this->include('admin/includes/footer') ?>
    <!--Footer section end-->
  </body>
</html>
