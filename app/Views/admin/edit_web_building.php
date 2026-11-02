<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->
  <?= $this->include('admin/includes/header')?>
  <!--header section end-->

  <style>
    .section-card {
      background: #fdfdfd;
      border: 1px solid #e7e7e8;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 24px;
    }
    .section-card-title {
      font-size: 16px;
      font-weight: 600;
      color: #384551;
      margin-bottom: 16px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .amenity-row, .facility-row {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 12px;
      margin-bottom: 10px;
      transition: all 0.2s;
    }
    .amenity-row:hover, .facility-row:hover {
      border-color: #cbd5e1;
      box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .gallery-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
    }
    .gallery-item {
      position: relative;
      width: 140px;
      height: 110px;
      border-radius: 6px;
      overflow: hidden;
      border: 1px solid #ddd;
      background: #000;
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .gallery-item-delete {
      position: absolute;
      top: 5px;
      right: 5px;
      background: rgba(220, 38, 38, 0.9);
      color: #fff !important;
      border-radius: 50%;
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      transition: background 0.2s;
    }
    .gallery-item-delete:hover {
      background: #b91c1c;
    }
    .main-img-preview {
      max-width: 280px;
      max-height: 180px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      margin-bottom: 10px;
      display: block;
    }
  </style>

  <?php
    // Prepare values with fallback to default config if empty in DB
    $buildingName = $building->building_name ?? '';
    $buildingSlug = $building->building_slug ?? '';
    $tagline = !empty($building->building_tagline) ? $building->building_tagline : ($default_config['tagline'] ?? '');
    $address = !empty($building->building_address) ? $building->building_address : ($default_config['address'] ?? '');
    $mapEmbed = !empty($building->building_map) ? $building->building_map : ($default_config['mapEmbedUrl'] ?? '');
    $mapDirect = !empty($building->building_map_link) ? $building->building_map_link : ($default_config['mapDirectUrl'] ?? '');
    $whatsapp = !empty($building->building_whatsapp) ? $building->building_whatsapp : ($default_config['whatsapp'] ?? '917034111368');
    $description = !empty($building->building_description) ? $building->building_description : ($default_config['description'] ?? '');
    $metaTitle = $building->building_meta_title ?? '';
    $metaDescription = $building->building_meta_description ?? '';
    $metaKeywords = $building->building_meta_keywords ?? '';

    // Parse Key facilities & amenities
    $keyAmenities = [];
    if (!empty($building->building_key_amenities)) {
        $decoded = json_decode($building->building_key_amenities, true);
        if (is_array($decoded)) {
            $keyAmenities = $decoded;
        }
    }
    if (empty($keyAmenities) && !empty($default_config['amenitiesGrid'])) {
        $keyAmenities = $default_config['amenitiesGrid'];
    }

    // Parse Hostel Amenities & Living Facilities
    $livingFacilities = [];
    if (!empty($building->building_living_facilities)) {
        $decoded = json_decode($building->building_living_facilities, true);
        if (is_array($decoded)) {
            $livingFacilities = $decoded;
        }
    }
    if (empty($livingFacilities) && !empty($default_config['featuresList'])) {
        $livingFacilities = $default_config['featuresList'];
    }
  ?>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row mb-6 gy-6">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div>
                <h5 class="mb-0">Edit Building (Website Details)</h5>
                <small class="text-muted">Manage website overview page, photos, key amenities, and facilities</small>
              </div>
              <div class="d-flex align-items-center gap-2">
                <a href="<?= base_url(); ?>Admin/Building" class="btn btn-secondary btn-sm">
                  <i class="icon-base bx bx-list-ul me-1"></i> List Building
                </a>
              </div>
            </div>

            <div class="card-body">
              <form method="POST" enctype="multipart/form-data" id="editBuildingWebForm">

                <!-- 1. Basic Info Section -->
                <div class="section-card">
                  <div class="section-card-title">
                    <i class="icon-base bx bx-info-circle text-primary"></i> 1. Basic Information
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Building Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="building_name" value="<?= esc($buildingName) ?>" readonly style="background-color: #f8f9fa;">
                      <small class="text-muted">Building name is fixed and managed from Booking mode</small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Tagline / Subheading</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="building_tagline" value="<?= esc($tagline) ?>" placeholder="e.g. 5 Residential Floors · 35,000 Sq.ft Premier Living Near Infopark">
                      <small class="text-muted">Displayed right above the building title on the overview header</small>
                    </div>
                  </div>

                </div>

                <!-- 2. Address & Map Section -->
                <div class="section-card">
                  <div class="section-card-title">
                    <i class="icon-base bx bx-map-pin text-primary"></i> 2. Address &amp; Google Map
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Address <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="building_address" rows="3" required placeholder="e.g. Opposite Solace Kids, Painakkil Junction, 1st left from Noel Palmdale Lane, Kakkanad, Kochi"><?= esc($address) ?></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Google Map Embed (URL or Iframe)</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="building_map" rows="3" placeholder="Paste Google Maps embed iframe or URL (e.g. https://www.google.com/maps/embed?pb=...)"><?= esc($mapEmbed) ?></textarea>
                      <small class="text-muted">You can paste the entire &lt;iframe src="..."&gt;&lt;/iframe&gt; code or just the URL.</small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Google Map Direct Link</label>
                    <div class="col-sm-9">
                      <input type="url" class="form-control" name="building_map_link" value="<?= esc($mapDirect) ?>" placeholder="https://www.google.com/maps/place/...">
                      <small class="text-muted">Link that opens directly in Google Maps application</small>
                    </div>
                  </div>
                </div>

                <!-- 3. Images Section (Main Image & More Images) -->
                <div class="section-card">
                  <div class="section-card-title">
                    <i class="icon-base bx bx-image text-primary"></i> 3. Building Images
                  </div>

                  <!-- Main Image -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label font-medium">Main Building Image</label>
                    <div class="col-sm-9">
                      <?php if (!empty($building->building_image)) { ?>
                        <div class="mb-2">
                          <img src="<?= base_url() ?>public/uploads/buildings/thumbs/<?= esc($building->building_image) ?>" class="main-img-preview" alt="Current Image">
                          <small class="text-success"><i class="bx bx-check-circle"></i> Current main image active</small>
                        </div>
                      <?php } ?>
                      <input type="file" class="form-control" name="building_image" accept="image/*">
                      <small class="text-muted">Upload high quality banner image (JPG, PNG, or WEBP)</small>
                    </div>
                  </div>

                  <hr class="my-3">

                  <!-- More Images (Gallery) -->
                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">More Images (Gallery)</label>
                    <div class="col-sm-9">
                      <?php if (!empty($more_image)) { ?>
                        <div class="gallery-grid">
                          <?php foreach ($more_image as $more) { ?>
                            <div class="gallery-item">
                              <img src="<?= base_url() ?>public/uploads/buildings/thumbs/<?= esc($more->more_image_name) ?>" alt="Gallery item">
                              <a href="<?= base_url() ?>Admin/Building/Deletemore/<?= esc($more->more_image_id) ?>" 
                                 onclick="return confirm('Are you sure you want to delete this gallery photo?');" 
                                 class="gallery-item-delete" 
                                 title="Delete image">
                                <i class="bx bx-trash"></i>
                              </a>
                            </div>
                          <?php } ?>
                        </div>
                      <?php } else { ?>
                        <p class="text-muted small mb-2">No additional gallery photos uploaded yet.</p>
                      <?php } ?>

                      <div id="more_images_wrapper">
                        <div class="d-flex align-items-center gap-2 mb-2">
                          <input type="file" name="document_more[]" multiple class="form-control" accept="image/*" style="max-width: 450px;">
                          <button type="button" class="btn btn-outline-secondary btn-sm" id="addMoreImageBtn">
                            <i class="bx bx-plus"></i> Add Another
                          </button>
                        </div>
                      </div>
                      <small class="text-muted">You can select multiple images at once (Ctrl + Click or Cmd + Click).</small>
                    </div>
                  </div>
                </div>

                <!-- 4. Key facilities & amenities Section -->
                <div class="section-card">
                  <div class="section-card-title justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                      <i class="icon-base bx bx-grid-alt text-primary"></i> 4. Key facilities &amp; amenities
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addAmenityBtn">
                      <i class="bx bx-plus me-1"></i> Add Facility &amp; Amenity
                    </button>
                  </div>
                  <p class="text-muted small mb-3">These appear in the top amenities grid with icons on the building overview page.</p>

                  <div id="amenities_container">
                    <?php if (!empty($keyAmenities)) { ?>
                      <?php foreach ($keyAmenities as $idx => $am) { ?>
                        <div class="amenity-row" id="amenity_row_<?= $idx ?>">
                          <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                              <label class="form-label small text-muted mb-1">Title</label>
                              <input type="text" class="form-control form-control-sm" name="amenities_title[]" value="<?= esc($am['title'] ?? '') ?>" placeholder="e.g. Elevator Facility" required>
                            </div>
                            <div class="col-md-4">
                              <label class="form-label small text-muted mb-1">Subtitle / Specification</label>
                              <input type="text" class="form-control form-control-sm" name="amenities_subtitle[]" value="<?= esc($am['subtitle'] ?? '') ?>" placeholder="e.g. All floors & Basement-1">
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small text-muted mb-1">Icon</label>
                              <select class="form-select form-select-sm" name="amenities_icon[]">
                                <?php
                                  $iconVal = $am['icon'] ?? 'Building';
                                  $icons = [
                                    'Building' => '🏢 Building / Lift / Cleaning',
                                    'Wifi'     => '📶 Wifi / Internet',
                                    'Utensils' => '🍽️ Utensils / Homely Food',
                                    'Car'      => '🚗 Car / Cab / Transit',
                                    'Lock'     => '🔒 Lock / Biometric / Security',
                                    'Zap'      => '⚡ Zap / Generator / Backup',
                                  ];
                                  foreach ($icons as $key => $lbl) {
                                    $sel = ($iconVal == $key) ? 'selected' : '';
                                    echo "<option value=\"{$key}\" {$sel}>{$lbl}</option>";
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-1 text-end pt-3">
                              <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAmenityRow('amenity_row_<?= $idx ?>')">
                                <i class="bx bx-trash"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    <?php } else { ?>
                      <!-- Default Empty Row -->
                      <div class="amenity-row" id="amenity_row_0">
                        <div class="row g-2 align-items-center">
                          <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Title</label>
                            <input type="text" class="form-control form-control-sm" name="amenities_title[]" placeholder="e.g. 24/7 Wi-Fi">
                          </div>
                          <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Subtitle / Specification</label>
                            <input type="text" class="form-control form-control-sm" name="amenities_subtitle[]" placeholder="e.g. With inverter backup">
                          </div>
                          <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">Icon</label>
                            <select class="form-select form-select-sm" name="amenities_icon[]">
                              <option value="Wifi">📶 Wifi / Internet</option>
                              <option value="Building">🏢 Building / Lift / Cleaning</option>
                              <option value="Utensils">🍽️ Utensils / Homely Food</option>
                              <option value="Car">🚗 Car / Cab / Transit</option>
                              <option value="Lock">🔒 Lock / Biometric / Security</option>
                              <option value="Zap">⚡ Zap / Generator / Backup</option>
                            </select>
                          </div>
                          <div class="col-md-1 text-end pt-3">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAmenityRow('amenity_row_0')">
                              <i class="bx bx-trash"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <!-- 5. Hostel Amenities & Living Facilities Section -->
                <div class="section-card">
                  <div class="section-card-title justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                      <i class="icon-base bx bx-check-shield text-primary"></i> 5. Hostel Amenities &amp; Living Facilities
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addLivingFacilityBtn">
                      <i class="bx bx-plus me-1"></i> Add Specification Line
                    </button>
                  </div>
                  <p class="text-muted small mb-3">Detailed list of living facilities and hostel specifications (with green checkmarks on website).</p>

                  <div id="facilities_container">
                    <?php if (!empty($livingFacilities)) { ?>
                      <?php foreach ($livingFacilities as $idx => $fac) { ?>
                        <div class="facility-row" id="facility_row_<?= $idx ?>">
                          <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-success"><i class="bx bx-check"></i></span>
                            <input type="text" class="form-control" name="living_facilities[]" value="<?= esc($fac) ?>" placeholder="e.g. 24/7 Wi-Fi with inverter backup" required>
                            <button class="btn btn-outline-danger" type="button" onclick="removeFacilityRow('facility_row_<?= $idx ?>')">
                              <i class="bx bx-trash"></i>
                            </button>
                          </div>
                        </div>
                      <?php } ?>
                    <?php } else { ?>
                      <div class="facility-row" id="facility_row_0">
                        <div class="input-group input-group-sm">
                          <span class="input-group-text bg-light text-success"><i class="bx bx-check"></i></span>
                          <input type="text" class="form-control" name="living_facilities[]" placeholder="e.g. Homely food; North & South Indian combo menu">
                          <button class="btn btn-outline-danger" type="button" onclick="removeFacilityRow('facility_row_0')">
                            <i class="bx bx-trash"></i>
                          </button>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <!-- 6. SEO & Meta Tags Section -->
                <div class="section-card">
                  <div class="section-card-title">
                    <i class="icon-base bx bx-search-alt text-primary"></i> 6. Search Engine Optimization (SEO Meta Tags)
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Meta Title</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="building_meta_title" value="<?= esc($metaTitle) ?>" placeholder="e.g. Saiyoojyam Annex | Ladies Hostel Near Infopark Kakkanad">
                      <small class="text-muted">Recommended 50–60 characters. Appears in browser tab and search engine results.</small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Meta Description</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="building_meta_description" rows="3" placeholder="e.g. Premium ladies hostel accommodation in Kakkanad near Infopark. Homely food, Wi-Fi, 24/7 security, AC & Non-AC sharing rooms."><?= esc($metaDescription) ?></textarea>
                      <small class="text-muted">Recommended 150–160 characters. Summarizes page content for search engines.</small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-3 col-form-label font-medium">Meta Keywords</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="building_meta_keywords" rows="2" placeholder="e.g. ladies hostel kakkanad, infopark hostel, working women hostel kochi, saiyoojyam annex"><?= esc($metaKeywords) ?></textarea>
                      <small class="text-muted">Comma-separated keywords (e.g. ladies hostel, kakkanad, infopark).</small>
                    </div>
                  </div>
                </div>

                <!-- Action Button -->
                <div class="d-flex justify-content-end gap-3 pt-3">
                  <a href="<?= base_url(); ?>Admin/Building" class="btn btn-outline-secondary">Cancel</a>
                  <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-1"></i> Update Building Website Details
                  </button>
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
      let amenityIndex = <?= count($keyAmenities) + 10 ?>;
      let facilityIndex = <?= count($livingFacilities) + 10 ?>;

      // Add Amenity Row
      document.getElementById('addAmenityBtn').addEventListener('click', function() {
        amenityIndex++;
        const rowId = `amenity_row_${amenityIndex}`;
        const html = `
          <div class="amenity-row" id="${rowId}">
            <div class="row g-2 align-items-center">
              <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Title</label>
                <input type="text" class="form-control form-control-sm" name="amenities_title[]" placeholder="e.g. Elevator Facility" required>
              </div>
              <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Subtitle / Specification</label>
                <input type="text" class="form-control form-control-sm" name="amenities_subtitle[]" placeholder="e.g. All floors & Basement-1">
              </div>
              <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Icon</label>
                <select class="form-select form-select-sm" name="amenities_icon[]">
                  <option value="Building">🏢 Building / Lift / Cleaning</option>
                  <option value="Wifi">📶 Wifi / Internet</option>
                  <option value="Utensils">🍽️ Utensils / Homely Food</option>
                  <option value="Car">🚗 Car / Cab / Transit</option>
                  <option value="Lock">🔒 Lock / Biometric / Security</option>
                  <option value="Zap">⚡ Zap / Generator / Backup</option>
                </select>
              </div>
              <div class="col-md-1 text-end pt-3">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAmenityRow('${rowId}')">
                  <i class="bx bx-trash"></i>
                </button>
              </div>
            </div>
          </div>
        `;
        document.getElementById('amenities_container').insertAdjacentHTML('beforeend', html);
      });

      function removeAmenityRow(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
      }

      // Add Living Facility Row
      document.getElementById('addLivingFacilityBtn').addEventListener('click', function() {
        facilityIndex++;
        const rowId = `facility_row_${facilityIndex}`;
        const html = `
          <div class="facility-row" id="${rowId}">
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light text-success"><i class="bx bx-check"></i></span>
              <input type="text" class="form-control" name="living_facilities[]" placeholder="e.g. Clean drinking water facilities and hot water availability" required>
              <button class="btn btn-outline-danger" type="button" onclick="removeFacilityRow('${rowId}')">
                <i class="bx bx-trash"></i>
              </button>
            </div>
          </div>
        `;
        document.getElementById('facilities_container').insertAdjacentHTML('beforeend', html);
      });

      function removeFacilityRow(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
      }

      // Dynamic More Image Inputs
      document.getElementById('addMoreImageBtn').addEventListener('click', function() {
        const wrapper = document.getElementById('more_images_wrapper');
        const div = document.createElement('div');
        div.className = 'd-flex align-items-center gap-2 mb-2';
        div.innerHTML = `
          <input type="file" name="document_more[]" multiple class="form-control" accept="image/*" style="max-width: 450px;">
          <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.remove()">
            <i class="bx bx-trash"></i>
          </button>
        `;
        wrapper.appendChild(div);
      });
    </script>
</body>
</html>
