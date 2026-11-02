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
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      margin-bottom: 2rem;
      background: #ffffff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .section-card-header {
      background: #f8fafc;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #e2e8f0;
      border-radius: 12px 12px 0 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .section-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #FF561C;
      color: #fff;
      font-weight: 700;
      font-size: 0.875rem;
    }
    .section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #1e293b;
      margin: 0;
    }
    .section-card-body {
      padding: 1.5rem;
    }
    .ck-editor__editable_inline {
      min-height: 160px;
    }
    .gallery-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 1rem;
    }
    .gallery-item {
      position: relative;
      width: 150px;
      height: 115px;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #cbd5e1;
      background: #f1f5f9;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .gallery-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.12);
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .gallery-item-delete {
      position: absolute;
      top: 6px;
      right: 6px;
      background: rgba(220, 38, 38, 0.92);
      color: #ffffff !important;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      transition: all 0.2s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.25);
      border: none;
      cursor: pointer;
      text-decoration: none;
    }
    .gallery-item-delete:hover {
      background: #b91c1c;
      color: #ffffff !important;
      transform: scale(1.1);
    }
    .gallery-item-badge {
      position: absolute;
      bottom: 4px;
      left: 4px;
      background: rgba(15, 23, 42, 0.75);
      color: #fff;
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 4px;
      pointer-events: none;
    }
  </style>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1">Edit About Us Sections</h4>
          <p class="text-muted mb-0">Manage content for all 3 sections of the About Us page</p>
        </div>
        <div>
          <a href="<?= base_url(); ?>Admin/About/View" class="btn btn-outline-secondary me-2">Back to Overview</a>
          <button type="submit" form="aboutForm" class="btn btn-primary"><i class="bx bx-save me-1"></i> Save Changes</button>
        </div>
      </div>

      <form id="aboutForm" method="POST" enctype="multipart/form-data">

        <!-- ======================================================== -->
        <!-- SECTION 1: Saiyoojyam Ladies Hostels -->
        <!-- ======================================================== -->
        <div class="section-card">
          <div class="section-card-header">
            <span class="section-badge">1</span>
            <div>
              <h5 class="section-title">Section 1: Saiyoojyam Ladies Hostels</h5>
              <small class="text-muted">Introduction &amp; Role of Hostel Accommodation</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="about_subtitle">Tag / Subtitle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="about_subtitle" id="about_subtitle" value="<?= htmlspecialchars($about->about_subtitle ?? 'Role of Hostel Accommodation') ?>" placeholder="e.g. Role of Hostel Accommodation" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="about_title">Heading / Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="about_title" id="about_title" value="<?= htmlspecialchars($about->about_title ?? '...A Second Home for Innovators & Professionals') ?>" required />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="editor_about">Description</label>
              <div class="col-sm-10">
                <textarea id="editor_about" class="form-control rich-editor" name="about_description"><?= $about->about_description ?? $about->about_desc ?? '' ?></textarea>
              </div>
            </div>

            <?php if (!empty($about->about_image)) { ?>
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold">Current Image</label>
              <div class="col-sm-10">
                <img src="<?= base_url('uploads/about/' . $about->about_image) ?>" style="max-height:100px; border-radius: 8px; border: 1px solid #e2e8f0;">
              </div>
            </div>
            <?php } ?>

            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold" for="about_image">Update Image</label>
              <div class="col-sm-10">
                <input class="form-control" name="about_image" type="file" id="about_image" />
              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 2: Saiyoojyam Hostels Network -->
        <!-- ======================================================== -->
        <div class="section-card">
          <div class="section-card-header">
            <span class="section-badge">2</span>
            <div>
              <h5 class="section-title">Section 2: Saiyoojyam Hostels Network</h5>
              <small class="text-muted">Properties overview (Towers, Premier, Annex)</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="network_subtitle">Tag / Subtitle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="network_subtitle" id="network_subtitle" value="<?= htmlspecialchars($about->network_subtitle ?? 'Our Properties') ?>" placeholder="e.g. Our Properties" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="network_title">Heading / Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="network_title" id="network_title" value="<?= htmlspecialchars($about->network_title ?? 'Saiyoojyam Hostels Network') ?>" required />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="editor_network">Description</label>
              <div class="col-sm-10">
                <textarea id="editor_network" class="form-control rich-editor" name="network_description"><?= $about->network_description ?? '' ?></textarea>
              </div>
            </div>

            <!-- Multiple Carousel Images for Section 2 -->
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold">Added Photos</label>
              <div class="col-sm-10">
                
                <!-- Existing Uploaded Images Grid -->
                <?php 
                  $netImages = !empty($about->network_images) ? json_decode($about->network_images, true) : [];
                  $validNetImages = [];
                  if (!empty($netImages) && is_array($netImages)) {
                    foreach ($netImages as $item) {
                      $fn = is_array($item) ? ($item['image'] ?? '') : $item;
                      if (!empty($fn)) $validNetImages[] = $fn;
                    }
                  }
                ?>

                <?php if (!empty($validNetImages)) { ?>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <label class="form-label small fw-bold text-dark mb-0">
                      <i class="bx bx-images text-primary me-1"></i> Current Added Photos (<?= count($validNetImages) ?> photo<?= count($validNetImages) > 1 ? 's' : '' ?>)
                    </label>
                    <small class="text-muted">Click the red trash icon on any photo to delete it</small>
                  </div>
                  <div class="gallery-grid" id="network_gallery_grid">
                    <?php foreach ($validNetImages as $idx => $imgFile) { ?>
                      <div class="gallery-item" id="net_box_<?= $idx ?>">
                        <img src="<?= base_url('uploads/about/' . $imgFile) ?>" alt="Network Photo <?= $idx + 1 ?>">
                        <a href="<?= base_url(); ?>Admin/About/DeleteNetworkImage?img=<?= urlencode($imgFile) ?>" 
                           onclick="return confirm('Are you sure you want to delete this photo from Section 2?');" 
                           class="gallery-item-delete" 
                           title="Delete this photo">
                          <i class="bx bx-trash"></i>
                        </a>
                        <span class="gallery-item-badge">Photo <?= $idx + 1 ?></span>
                        <input type="hidden" name="existing_network_images[]" value="<?= htmlspecialchars($imgFile) ?>">
                      </div>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                  <div class="alert alert-light border d-flex align-items-center gap-2 p-3 mb-3">
                    <i class="bx bx-info-circle text-primary fs-4"></i>
                    <div>
                      <strong>No custom photos uploaded yet for Section 2.</strong><br>
                      <small class="text-muted">The website is currently displaying the 3 default property slides (Towers, Premier, Annex). Upload your photos below to display them on the website carousel.</small>
                    </div>
                  </div>
                <?php } ?>

                <!-- Add More Photos Input -->
                <div class="mt-3">
                  <label class="form-label small fw-semibold text-dark mb-1">
                    <i class="bx bx-upload me-1 text-primary"></i> Upload More Photos
                  </label>
                  
                  <div id="more_network_images_wrapper">
                    <div class="d-flex align-items-center gap-2 mb-2">
                      <input type="file" name="network_images[]" multiple class="form-control net-file-input" accept="image/*" style="max-width: 480px;">
                      <button type="button" class="btn btn-outline-secondary btn-sm" id="addMoreNetworkImageBtn">
                        <i class="bx bx-plus"></i> Add Another
                      </button>
                    </div>
                  </div>
                  <small class="text-muted d-block mb-2">
                    <i class="bx bx-info-circle me-1"></i> Select JPG, PNG, or WEBP photos. You can select multiple images at once (hold Ctrl/Cmd) or use <strong>+ Add Another</strong>.
                  </small>

                  <!-- Live Client-side Preview of newly selected files -->
                  <div id="new_images_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 3: Mission & Vision -->
        <!-- ======================================================== -->
        <div class="section-card">
          <div class="section-card-header">
            <span class="section-badge">3</span>
            <div>
              <h5 class="section-title">Section 3: Mission &amp; Vision</h5>
              <small class="text-muted">Purpose &amp; Commitment statements</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="mission_subtitle">Tag / Subtitle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="mission_subtitle" id="mission_subtitle" value="<?= htmlspecialchars($about->mission_subtitle ?? 'Purpose & Commitment') ?>" placeholder="e.g. Purpose & Commitment" />
              </div>
            </div>

            <hr class="my-4">

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="mission_title">Mission Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="mission_title" id="mission_title" value="<?= htmlspecialchars($about->mission_title ?? 'Mission') ?>" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="editor_mission">Mission Description</label>
              <div class="col-sm-10">
                <textarea id="editor_mission" class="form-control rich-editor" name="mission_description"><?= $about->mission_description ?? '' ?></textarea>
              </div>
            </div>

            <hr class="my-4">

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="vision_title">Vision Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="vision_title" id="vision_title" value="<?= htmlspecialchars($about->vision_title ?? 'Vision') ?>" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="editor_vision">Vision Description</label>
              <div class="col-sm-10">
                <textarea id="editor_vision" class="form-control rich-editor" name="vision_description"><?= $about->vision_description ?? '' ?></textarea>
              </div>
            </div>

            <?php if (!empty($about->mission_image)) { ?>
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold">Current Mission Image</label>
              <div class="col-sm-10">
                <img src="<?= base_url('uploads/about/' . $about->mission_image) ?>" style="max-height:100px; border-radius: 8px; border: 1px solid #e2e8f0;">
              </div>
            </div>
            <?php } ?>

            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold" for="mission_image">Update Mission Image</label>
              <div class="col-sm-10">
                <input class="form-control" name="mission_image" type="file" id="mission_image" />
              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 4: Specialities -->
        <!-- ======================================================== -->
        <div class="section-card" id="specialities_section">
          <div class="section-card-header">
            <span class="section-badge">4</span>
            <div>
              <h5 class="section-title">Section 4: Specialities</h5>
              <small class="text-muted">Speciality cards (Healthy Living, Water Supply, Security, etc.)</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="specialities_subtitle">Tag / Subtitle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="specialities_subtitle" id="specialities_subtitle" value="<?= htmlspecialchars($about->specialities_subtitle ?? 'Why Residents Trust Us') ?>" placeholder="e.g. Why Residents Trust Us" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="specialities_title">Heading / Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="specialities_title" id="specialities_title" value="<?= htmlspecialchars($about->specialities_title ?? 'Specialities') ?>" required />
              </div>
            </div>

            <hr class="my-4">

            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold">Speciality Cards</label>
              <div class="col-sm-10">
                <p class="text-muted small mb-3">Add or edit the speciality cards shown in this section. You can customize the title, icon, and description for each card.</p>
                
                <div id="specialities_container" class="d-flex flex-column gap-3 mb-3">
                  <?php 
                    $specList = !empty($about->specialities_items) ? json_decode($about->specialities_items, true) : [];
                    if (empty($specList) || !is_array($specList)) {
                      $specList = [
                        ['title' => 'Healthy Living Environment', 'icon' => 'Sparkles', 'desc' => 'Saiyoojyam provides a healthy living with homely food, hygienic environment, clean drinking water (well water with RO plant and 24 hrs boiled drinking water) and conducive environment for the overall individual development'],
                        ['title' => 'Water Supply', 'icon' => 'Droplets', 'desc' => 'Wells attached with modern purification plant provide clean water for drinking and other requirements. There is also provision for full-time supply of hot water to the bathrooms.'],
                        ['title' => 'Security', 'icon' => 'ShieldCheck', 'desc' => 'The whole complex and surroundings is equipped with modern CCTV cameras, in addition to experienced staff, all staying in the same building providing round-the-clock security.'],
                      ];
                    }

                    foreach ($specList as $sIdx => $spec) {
                      $sTitle = is_array($spec) ? ($spec['title'] ?? '') : '';
                      $sIcon  = is_array($spec) ? ($spec['icon'] ?? 'Sparkles') : 'Sparkles';
                      $sDesc  = is_array($spec) ? ($spec['desc'] ?? '') : '';
                  ?>
                    <div class="p-3 border rounded bg-light position-relative speciality-item-card" id="spec_row_<?= $sIdx ?>">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-label-primary">Card #<span class="spec-num"><?= $sIdx + 1 ?></span></span>
                        <button type="button" class="btn btn-outline-danger btn-sm p-1 rounded-circle" style="width:28px; height:28px; display:flex; align-items:center; justify-content:center;" onclick="this.closest('.speciality-item-card').remove(); renumberSpecCards();" title="Remove Card">
                          <i class="bx bx-trash" style="font-size:14px;"></i>
                        </button>
                      </div>
                      <div class="row g-2 mb-2">
                        <div class="col-md-8">
                          <label class="form-label small mb-1 fw-semibold">Card Title</label>
                          <input type="text" class="form-control form-control-sm" name="speciality_title[]" value="<?= htmlspecialchars($sTitle) ?>" placeholder="e.g. Healthy Living Environment" required />
                        </div>
                        <div class="col-md-4">
                          <label class="form-label small mb-1 fw-semibold">Icon</label>
                          <select class="form-select form-select-sm" name="speciality_icon[]">
                            <option value="Sparkles" <?= $sIcon === 'Sparkles' ? 'selected' : '' ?>>Sparkles (Environment/Clean)</option>
                            <option value="Droplets" <?= $sIcon === 'Droplets' ? 'selected' : '' ?>>Droplets (Water Supply)</option>
                            <option value="ShieldCheck" <?= $sIcon === 'ShieldCheck' ? 'selected' : '' ?>>ShieldCheck (Security)</option>
                            <option value="CheckCircle" <?= $sIcon === 'CheckCircle' ? 'selected' : '' ?>>CheckCircle (Guarantee/Quality)</option>
                            <option value="Home" <?= $sIcon === 'Home' ? 'selected' : '' ?>>Home (Living/Comfort)</option>
                            <option value="Heart" <?= $sIcon === 'Heart' ? 'selected' : '' ?>>Heart (Care/Homely)</option>
                            <option value="MapPin" <?= $sIcon === 'MapPin' ? 'selected' : '' ?>>MapPin (Location)</option>
                          </select>
                        </div>
                      </div>
                      <div>
                        <label class="form-label small mb-1 fw-semibold">Description</label>
                        <textarea class="form-control form-control-sm" name="speciality_desc[]" rows="2" placeholder="Brief description of this speciality"><?= htmlspecialchars($sDesc) ?></textarea>
                      </div>
                    </div>
                  <?php } ?>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="addSpecialityCardBtn">
                  <i class="bx bx-plus me-1"></i> Add Another Speciality Card
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 5: Neighbourhood Facilities -->
        <!-- ======================================================== -->
        <div class="section-card" id="neighbourhood_section">
          <div class="section-card-header">
            <span class="section-badge">5</span>
            <div>
              <h5 class="section-title">Section 5: Neighbourhood Facilities</h5>
              <small class="text-muted">Prime location description and nearby landmark facilities</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="neighbourhood_subtitle">Tag / Subtitle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="neighbourhood_subtitle" id="neighbourhood_subtitle" value="<?= htmlspecialchars($about->neighbourhood_subtitle ?? 'Prime Location') ?>" placeholder="e.g. Prime Location" />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="neighbourhood_title">Heading / Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="neighbourhood_title" id="neighbourhood_title" value="<?= htmlspecialchars($about->neighbourhood_title ?? 'Neighbourhood Facilities') ?>" required />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="editor_neighbourhood">Description</label>
              <div class="col-sm-10">
                <textarea id="editor_neighbourhood" class="form-control rich-editor" name="neighbourhood_description"><?= $about->neighbourhood_description ?? '<p>Saiyoojyam Towers are located at close proximity to the Collectorate, Info Park, Sunrise Hospital, Wonderla Amusement Park, Rajagiri College and Hospital, Thrikkakara Temple, and few kilometers from Kadambrayar Boating Center and Eco Village.</p><p>Saiyoooyam Premeir and Saiyoojyam Annex are also ladies hostels situated in the same locality, Kuzhikattumoola, Kusumagiri P.O., Kakkanad.</p>' ?></textarea>
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold" for="neighbourhood_landmarks">Nearby Landmarks</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="neighbourhood_landmarks" id="neighbourhood_landmarks" rows="3" placeholder="Enter landmark places separated by commas"><?= htmlspecialchars($about->neighbourhood_landmarks ?? 'Collectorate Kakkanad, Infopark & SmartCity, Sunrise Hospital, Wonderla Amusement Park, Rajagiri College & Hospital, Thrikkakara Temple, Kadambrayar Boating Center, Eco Village') ?></textarea>
                <small class="text-muted d-block mt-1">
                  <i class="bx bx-info-circle me-1"></i> Enter landmarks separated by commas (e.g., <code>Collectorate Kakkanad, Infopark, Sunrise Hospital</code>). Each landmark will display as an attractive location badge with an icon on the website.
                </small>
              </div>
            </div>
          </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 6: Call To Action (Looking for a comfortable home in Kakkanad?) -->
        <!-- ======================================================== -->
        <div class="section-card" id="cta_section">
          <div class="section-card-header">
            <span class="section-badge">6</span>
            <div>
              <h5 class="section-title">Section 6: Call To Action (CTA Banner)</h5>
              <small class="text-muted">Bottom banner with WhatsApp enquiry and exploration buttons</small>
            </div>
          </div>
          <div class="section-card-body">
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_title">Banner Heading / Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="cta_title" id="cta_title" value="<?= htmlspecialchars($about->cta_title ?? 'Looking for a comfortable home in Kakkanad?') ?>" placeholder="e.g. Looking for a comfortable home in Kakkanad?" required />
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_description">Subtext / Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="cta_description" id="cta_description" rows="3" placeholder="Enter supporting subtext"><?= htmlspecialchars($about->cta_description ?? 'Connect with our team to inquire about room availability, schedule a campus visit, or book your accommodation.') ?></textarea>
              </div>
            </div>

            <!-- Existing CTA Background Image Preview -->
            <?php if (!empty($about->cta_image) && file_exists(FCPATH . 'uploads/about/' . $about->cta_image)) { ?>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label fw-semibold">Current Background</label>
              <div class="col-sm-10">
                <img src="<?= base_url('uploads/about/' . $about->cta_image) ?>" style="max-height:100px; border-radius: 8px; border: 1px solid #e2e8f0;">
              </div>
            </div>
            <?php } ?>

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_image">Background Image</label>
              <div class="col-sm-10">
                <input class="form-control" name="cta_image" type="file" id="cta_image" />
                <small class="text-muted">Recommended: High resolution wide background image (1920x600 or 16:9)</small>
              </div>
            </div>

            <hr class="my-4">

            <div class="row mb-4">
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_whatsapp_button_text">WhatsApp Button Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="cta_whatsapp_button_text" id="cta_whatsapp_button_text" value="<?= htmlspecialchars($about->cta_whatsapp_button_text ?? 'Enquire via WhatsApp') ?>" placeholder="e.g. Enquire via WhatsApp" />
              </div>
            </div>

            <div class="row mb-2">
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_secondary_button_text">Secondary Button Text</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="cta_secondary_button_text" id="cta_secondary_button_text" value="<?= htmlspecialchars($about->cta_secondary_button_text ?? 'Explore Rooms') ?>" placeholder="e.g. Explore Rooms" />
              </div>
              <label class="col-sm-2 col-form-label fw-semibold" for="cta_secondary_button_link">Secondary Button Link</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="cta_secondary_button_link" id="cta_secondary_button_link" value="<?= htmlspecialchars($about->cta_secondary_button_link ?? '/search') ?>" placeholder="e.g. /search" />
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button Bar -->
        <div class="card mb-6">
          <div class="card-body d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary px-4"><i class="bx bx-save me-1"></i> Update All Sections</button>
            <a href="<?= base_url() ?>Admin/About/View" class="btn btn-secondary ms-2">Cancel</a>
          </div>
        </div>

      </form>
    </div>
    <!-- / Content -->

    <!-- Footer section start-->
    <?= $this->include('admin/includes/footer') ?>
    <!--Footer section end-->

    <!-- Initialize CKEditor on all rich-editor textareas -->
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        if (typeof ClassicEditor !== 'undefined') {
          const editorIds = ['#editor_about', '#editor_network', '#editor_mission', '#editor_vision', '#editor_neighbourhood'];
          editorIds.forEach(function(selector) {
            const el = document.querySelector(selector);
            if (el && !el.classList.contains('ck-editor-initialized')) {
              ClassicEditor.create(el, {
                toolbar: {
                  items: [
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                  ]
                }
              }).then(function(editor) {
                el.classList.add('ck-editor-initialized');
              }).catch(function(error) {
                console.error('Editor error on ' + selector, error);
              });
            }
          });
        }

        // Speciality Cards Repeater
        const addSpecBtn = document.getElementById('addSpecialityCardBtn');
        if (addSpecBtn) {
          addSpecBtn.addEventListener('click', function() {
            const container = document.getElementById('specialities_container');
            const count = container.querySelectorAll('.speciality-item-card').length + 1;
            const div = document.createElement('div');
            div.className = 'p-3 border rounded bg-light position-relative speciality-item-card';
            div.innerHTML = `
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-label-primary">Card #<span class="spec-num">${count}</span></span>
                <button type="button" class="btn btn-outline-danger btn-sm p-1 rounded-circle" style="width:28px; height:28px; display:flex; align-items:center; justify-content:center;" onclick="this.closest('.speciality-item-card').remove(); renumberSpecCards();" title="Remove Card">
                  <i class="bx bx-trash" style="font-size:14px;"></i>
                </button>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-md-8">
                  <label class="form-label small mb-1 fw-semibold">Card Title</label>
                  <input type="text" class="form-control form-control-sm" name="speciality_title[]" placeholder="e.g. High Speed Wi-Fi" required />
                </div>
                <div class="col-md-4">
                  <label class="form-label small mb-1 fw-semibold">Icon</label>
                  <select class="form-select form-select-sm" name="speciality_icon[]">
                    <option value="Sparkles">Sparkles (Environment/Clean)</option>
                    <option value="Droplets">Droplets (Water Supply)</option>
                    <option value="ShieldCheck">ShieldCheck (Security)</option>
                    <option value="CheckCircle">CheckCircle (Guarantee/Quality)</option>
                    <option value="Home">Home (Living/Comfort)</option>
                    <option value="Heart">Heart (Care/Homely)</option>
                    <option value="MapPin">MapPin (Location)</option>
                  </select>
                </div>
              </div>
              <div>
                <label class="form-label small mb-1 fw-semibold">Description</label>
                <textarea class="form-control form-control-sm" name="speciality_desc[]" rows="2" placeholder="Brief description of this speciality"></textarea>
              </div>
            `;
            container.appendChild(div);
          });
        }

        window.renumberSpecCards = function() {
          const cards = document.querySelectorAll('.speciality-item-card');
          cards.forEach((card, idx) => {
            const numEl = card.querySelector('.spec-num');
            if (numEl) numEl.textContent = idx + 1;
          });
        };

        // Add More Network Image input dynamically
        const addBtn = document.getElementById('addMoreNetworkImageBtn');
        if (addBtn) {
          addBtn.addEventListener('click', function() {
            const wrapper = document.getElementById('more_network_images_wrapper');
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-2';
            div.innerHTML = `
              <input type="file" name="network_images[]" multiple class="form-control net-file-input" accept="image/*" style="max-width: 480px;">
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.remove(); renderPreviews();">
                <i class="bx bx-trash"></i>
              </button>
            `;
            wrapper.appendChild(div);
            div.querySelector('.net-file-input').addEventListener('change', renderPreviews);
          });
        }

        // Live preview of newly selected files
        function renderPreviews() {
          const preview = document.getElementById('new_images_preview');
          if (!preview) return;
          preview.innerHTML = '';
          const inputs = document.querySelectorAll('.net-file-input');
          inputs.forEach(function(input) {
            const files = input.files;
            if (files && files.length > 0) {
              for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                  const div = document.createElement('div');
                  div.className = 'border rounded p-1 bg-white shadow-sm';
                  div.style.width = '110px';
                  div.innerHTML = '<img src="' + evt.target.result + '" style="width:100%; height:75px; object-fit:cover; border-radius:4px;"><small class="d-block text-truncate text-success text-center fw-semibold mt-1" style="font-size:10px;"><i class="bx bx-check"></i> Ready to save</small>';
                  preview.appendChild(div);
                };
                reader.readAsDataURL(files[i]);
              }
            }
          });
        }

        const firstInput = document.querySelector('.net-file-input');
        if (firstInput) {
          firstInput.addEventListener('change', renderPreviews);
        }
      });
    </script>
  </body>
</html>
