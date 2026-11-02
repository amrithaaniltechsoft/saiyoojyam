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
    .gallery-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 1rem;
    }
    .gallery-item {
      position: relative;
      width: 160px;
      height: 120px;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #cbd5e1;
      background: #f1f5f9;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
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
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      border: none;
      cursor: pointer;
    }
    .pillar-card {
      border: 1px solid #fed7aa;
      background: #fffaf8;
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1rem;
    }
    .meal-box {
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 1.25rem;
      background: #ffffff;
      margin-bottom: 1.25rem;
    }
  </style>

  <?php
    $baseUrl = base_url();
    if (!str_ends_with($baseUrl, '/')) {
        $baseUrl .= '/';
    }

    $pillars = !empty($food->pillars_items) ? json_decode($food->pillars_items, true) : [];
    if (!is_array($pillars)) $pillars = [];

    $meals = !empty($food->menu_schedule) ? json_decode($food->menu_schedule, true) : [];
    if (!is_array($meals)) $meals = [];

    $gallery = !empty($food->gallery_images) ? json_decode($food->gallery_images, true) : [];
    if (!is_array($gallery)) $gallery = [];

    $faqs = !empty($food->faq_items) ? json_decode($food->faq_items, true) : [];
    if (!is_array($faqs)) $faqs = [];
  ?>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      
      <!-- Page Header -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Website /</span> Food Quality Page Management</h4>
          <p class="text-muted mb-0">Customize and manage all sections of the live Food Quality page (http://localhost:3000/food-quality)</p>
        </div>
        <div class="d-flex gap-2">
          <a href="http://localhost:3000/food-quality" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="bx bx-link-external me-1"></i> Preview Live Page
          </a>
        </div>
      </div>

      <?php if(session()->getFlashdata('alert')): ?>
        <?php $alert = session()->getFlashdata('alert'); ?>
        <div class="alert alert-<?= $alert['type'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
          <?= $alert['msg'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <form action="<?= base_url(); ?>Admin/FoodQuality/Edit/1" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- SECTION 1: HERO BANNER -->
        <div class="section-card" id="section_hero">
          <div class="section-card-header">
            <span class="section-badge">1</span>
            <h5 class="section-title">Hero Banner Section</h5>
          </div>
          <div class="section-card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Small Badge / Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="<?= esc($food->hero_subtitle ?? 'Hygienic • Nutritious • Homely Meals') ?>" placeholder="e.g. Hygienic • Nutritious • Homely Meals">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Main Heading Title</label>
                <input type="text" name="hero_title" class="form-control" value="<?= esc($food->hero_title ?? 'Wholesome & Homely Food Quality') ?>" placeholder="e.g. Wholesome & Homely Food Quality">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Hero Description</label>
                <textarea name="hero_description" class="form-control" rows="3" placeholder="Description of Saiyoojyam food quality..."><?= esc($food->hero_description ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Custom Hero Background Image</label>
                <input type="file" name="hero_image" class="form-control" accept="image/*">
                <small class="text-muted">Recommended 1920x800px. If empty, default food banner is used.</small>
              </div>
              <div class="col-md-6">
                <?php if(!empty($food->hero_image)): ?>
                  <label class="form-label fw-semibold d-block">Current Hero Image</label>
                  <div class="d-flex align-items-center gap-3">
                    <img src="<?= $baseUrl . 'uploads/food/' . esc($food->hero_image) ?>" style="height: 60px; width: 100px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                    <a href="<?= base_url(); ?>Admin/FoodQuality/DeleteHeroImage" class="btn btn-sm btn-outline-danger" onclick="return confirm('Reset hero image to default?');">Reset to Default</a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION 2: FOUR QUALITY PILLARS -->
        <div class="section-card" id="section_pillars">
          <div class="section-card-header">
            <span class="section-badge">2</span>
            <h5 class="section-title">Four Quality Pillars Section</h5>
          </div>
          <div class="section-card-body">
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Section Badge / Subtitle</label>
                <input type="text" name="pillars_subtitle" class="form-control" value="<?= esc($food->pillars_subtitle ?? 'Our Food Commitment') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Section Main Heading</label>
                <input type="text" name="pillars_title" class="form-control" value="<?= esc($food->pillars_title ?? 'Quality Food You Can Truly Trust Every Day') ?>">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Section Description</label>
                <textarea name="pillars_description" class="form-control" rows="2"><?= esc($food->pillars_description ?? '') ?></textarea>
              </div>
            </div>

            <h6 class="fw-bold text-dark mb-3">Pillar Cards</h6>
            <div class="row g-3">
              <?php for($i = 0; $i < 4; $i++): 
                $p = $pillars[$i] ?? ['title' => '', 'subtitle' => '', 'description' => '', 'icon' => 'Sparkles'];
              ?>
                <div class="col-md-6">
                  <div class="pillar-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-primary">Pillar <?= $i + 1 ?></span>
                      <select name="pillar_icon[]" class="form-select form-select-sm w-auto">
                        <option value="Heart" <?= ($p['icon'] ?? '') == 'Heart' ? 'selected' : '' ?>>Heart</option>
                        <option value="Clock" <?= ($p['icon'] ?? '') == 'Clock' ? 'selected' : '' ?>>Clock</option>
                        <option value="Droplets" <?= ($p['icon'] ?? '') == 'Droplets' ? 'selected' : '' ?>>Droplets</option>
                        <option value="Sparkles" <?= ($p['icon'] ?? '') == 'Sparkles' ? 'selected' : '' ?>>Sparkles</option>
                        <option value="Utensils" <?= ($p['icon'] ?? '') == 'Utensils' ? 'selected' : '' ?>>Utensils</option>
                        <option value="ShieldCheck" <?= ($p['icon'] ?? '') == 'ShieldCheck' ? 'selected' : '' ?>>ShieldCheck</option>
                      </select>
                    </div>
                    <div class="mb-2">
                      <label class="form-label small fw-semibold">Title</label>
                      <input type="text" name="pillar_title[]" class="form-control form-control-sm" value="<?= esc($p['title']) ?>" placeholder="Pillar Title">
                    </div>
                    <div class="mb-2">
                      <label class="form-label small fw-semibold">Subtitle</label>
                      <input type="text" name="pillar_subtitle[]" class="form-control form-control-sm" value="<?= esc($p['subtitle']) ?>" placeholder="Pillar Subtitle">
                    </div>
                    <div>
                      <label class="form-label small fw-semibold">Description</label>
                      <textarea name="pillar_desc[]" class="form-control form-control-sm" rows="3" placeholder="Pillar Description"><?= esc($p['description']) ?></textarea>
                    </div>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>

        <!-- SECTION 3: DAILY MEAL SCHEDULE & MENU -->
        <div class="section-card" id="section_menu">
          <div class="section-card-header">
            <span class="section-badge">3</span>
            <h5 class="section-title">Daily Meal Schedule &amp; Timings</h5>
          </div>
          <div class="section-card-body">
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Section Badge / Subtitle</label>
                <input type="text" name="menu_subtitle" class="form-control" value="<?= esc($food->menu_subtitle ?? 'Daily Routine') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Section Main Heading</label>
                <input type="text" name="menu_title" class="form-control" value="<?= esc($food->menu_title ?? 'Our Daily Meal Schedule & Menu') ?>">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Section Description</label>
                <textarea name="menu_description" class="form-control" rows="2"><?= esc($food->menu_description ?? '') ?></textarea>
              </div>
            </div>

            <h6 class="fw-bold text-dark mb-3">Meal Offerings</h6>
            <div class="row g-3">
              <?php for($i = 0; $i < 4; $i++): 
                $m = $meals[$i] ?? ['meal' => '', 'time' => '', 'readyNote' => '', 'badge' => '', 'icon' => 'Utensils', 'menuItems' => []];
                $menuText = is_array($m['menuItems']) ? implode("\n", $m['menuItems']) : '';
              ?>
                <div class="col-md-6">
                  <div class="meal-box">
                    <div class="row g-2 mb-2">
                      <div class="col-7">
                        <label class="form-label small fw-semibold">Meal Name</label>
                        <input type="text" name="meal_name[]" class="form-control form-control-sm fw-bold" value="<?= esc($m['meal']) ?>" placeholder="e.g. Morning Breakfast">
                      </div>
                      <div class="col-5">
                        <label class="form-label small fw-semibold">Time Slot</label>
                        <input type="text" name="meal_time[]" class="form-control form-control-sm text-primary" value="<?= esc($m['time']) ?>" placeholder="e.g. 7:00 AM – 9:00 AM">
                      </div>
                    </div>
                    <div class="row g-2 mb-2">
                      <div class="col-6">
                        <label class="form-label small fw-semibold">Punctuality Note</label>
                        <input type="text" name="meal_note[]" class="form-control form-control-sm" value="<?= esc($m['readyNote']) ?>" placeholder="e.g. Ready by 7:30 AM">
                      </div>
                      <div class="col-6">
                        <label class="form-label small fw-semibold">Badge Tag</label>
                        <input type="text" name="meal_badge[]" class="form-control form-control-sm" value="<?= esc($m['badge']) ?>" placeholder="e.g. Office Ready">
                      </div>
                    </div>
                    <div class="mb-2">
                      <label class="form-label small fw-semibold">Icon</label>
                      <select name="meal_icon[]" class="form-select form-select-sm">
                        <option value="Sun" <?= ($m['icon'] ?? '') == 'Sun' ? 'selected' : '' ?>>Sun (Breakfast)</option>
                        <option value="Soup" <?= ($m['icon'] ?? '') == 'Soup' ? 'selected' : '' ?>>Soup (Lunch)</option>
                        <option value="Coffee" <?= ($m['icon'] ?? '') == 'Coffee' ? 'selected' : '' ?>>Coffee (Evening)</option>
                        <option value="Moon" <?= ($m['icon'] ?? '') == 'Moon' ? 'selected' : '' ?>>Moon (Dinner)</option>
                        <option value="Utensils" <?= ($m['icon'] ?? '') == 'Utensils' ? 'selected' : '' ?>>Utensils</option>
                      </select>
                    </div>
                    <div>
                      <label class="form-label small fw-semibold">Sample Menu Items (One item per line)</label>
                      <textarea name="meal_items[]" class="form-control form-control-sm" rows="5" placeholder="Steamed Idli with Sambar&#10;Crispy Dosa with Chutney&#10;Kerala Puttu with Kadala"><?= esc($menuText) ?></textarea>
                    </div>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>

        <!-- SECTION 4: KITCHEN & DINING GALLERY -->
        <div class="section-card" id="section_gallery">
          <div class="section-card-header">
            <span class="section-badge">4</span>
            <h5 class="section-title">Dining &amp; Kitchen Spaces Gallery</h5>
          </div>
          <div class="section-card-body">
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Gallery Subtitle</label>
                <input type="text" name="gallery_subtitle" class="form-control" value="<?= esc($food->gallery_subtitle ?? 'Campus Dining Experience') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Gallery Main Heading</label>
                <input type="text" name="gallery_title" class="form-control" value="<?= esc($food->gallery_title ?? 'Glimpse of Our Dining & Kitchen Spaces') ?>">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Gallery Description</label>
                <textarea name="gallery_description" class="form-control" rows="2"><?= esc($food->gallery_description ?? '') ?></textarea>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
              <h6 class="fw-bold text-dark mb-0">Gallery Photos (Top 3 Displayed on Live Page)</h6>
              <span class="badge bg-label-primary"><?= count($gallery) ?> Total Photos</span>
            </div>

            <?php if(!empty($gallery)): ?>
              <div class="row g-3 mb-3">
                <?php foreach($gallery as $gIdx => $gItem): 
                  $imgSrc = $gItem['image'] ?? '';
                  if (!str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/')) {
                      $imgSrc = $baseUrl . 'uploads/food/' . $imgSrc;
                  }
                ?>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card h-100 shadow-none" style="background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0 !important;">
                      <!-- Card Header with Photo number and delete -->
                      <div class="d-flex align-items-center justify-content-between px-3 py-2 bg-light border-bottom">
                        <span class="badge <?= $gIdx < 3 ? 'bg-primary' : 'bg-secondary' ?>" style="font-size: 11px;">
                          Photo #<?= $gIdx + 1 ?> <?= $gIdx < 3 ? '(Active)' : '' ?>
                        </span>
                        <a href="<?= base_url(); ?>Admin/FoodQuality/DeleteGalleryImage/<?= $gIdx ?>" class="text-danger" onclick="return confirm('Delete photo #<?= $gIdx + 1 ?> from gallery?');" title="Delete Photo">
                          <i class="bx bx-trash" style="font-size: 18px;"></i>
                        </a>
                      </div>

                      <!-- Image Preview -->
                      <div style="position: relative; height: 150px; overflow: hidden; background: #f1f5f9;">
                        <img src="<?= esc($imgSrc) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                      </div>

                      <div class="card-body p-3">
                        <!-- Update Image Input -->
                        <div class="mb-2">
                          <label class="form-label small fw-semibold text-primary mb-1 d-flex align-items-center gap-1">
                            <i class="bx bx-image-add"></i> Update / Change Photo
                          </label>
                          <input type="file" name="gallery_item_file_<?= $gIdx ?>" class="form-control form-control-sm" accept="image/*">
                        </div>

                        <!-- Title Input -->
                        <div class="mb-2">
                          <label class="form-label small fw-semibold mb-1">Title</label>
                          <input type="text" name="gallery_item_title[<?= $gIdx ?>]" class="form-control form-control-sm fw-semibold" value="<?= esc($gItem['title'] ?? '') ?>" placeholder="Photo Title">
                        </div>

                        <!-- Caption Input -->
                        <div>
                          <label class="form-label small fw-semibold mb-1">Caption</label>
                          <textarea name="gallery_item_caption[<?= $gIdx ?>]" class="form-control form-control-sm" rows="2" placeholder="Photo caption..."><?= esc($gItem['caption'] ?? '') ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <p class="text-muted small">No custom gallery photos uploaded yet. Default campus photos are in use.</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- SECTION 5: DINING FAQ -->
        <div class="section-card" id="section_faq">
          <div class="section-card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
              <span class="section-badge">5</span>
              <h5 class="section-title">Frequently Asked Questions (FAQ)</h5>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" id="addFaqBtn">
              <i class="bx bx-plus me-1"></i> Add FAQ Item
            </button>
          </div>
          <div class="section-card-body">
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">FAQ Subtitle</label>
                <input type="text" name="faq_subtitle" class="form-control" value="<?= esc($food->faq_subtitle ?? 'Dining FAQ') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">FAQ Main Heading</label>
                <input type="text" name="faq_title" class="form-control" value="<?= esc($food->faq_title ?? 'Frequently Asked Questions') ?>">
              </div>
            </div>

            <div id="faqContainer">
              <?php foreach($faqs as $fIdx => $fItem): ?>
                <div class="faq-row border rounded p-3 mb-3 bg-light position-relative">
                  <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-faq-btn" style="padding: 2px 8px;">
                    <i class="bx bx-x"></i>
                  </button>
                  <div class="mb-2 pe-4">
                    <label class="form-label small fw-semibold">Question</label>
                    <input type="text" name="faq_q[]" class="form-control form-control-sm" value="<?= esc($fItem['q'] ?? '') ?>" placeholder="e.g. What time are tiffins ready?">
                  </div>
                  <div>
                    <label class="form-label small fw-semibold">Answer</label>
                    <textarea name="faq_a[]" class="form-control form-control-sm" rows="2" placeholder="Answer details..."><?= esc($fItem['a'] ?? '') ?></textarea>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- SECTION 6: BOTTOM CTA & CONTACT -->
        <div class="section-card" id="section_cta">
          <div class="section-card-header">
            <span class="section-badge">6</span>
            <h5 class="section-title">Bottom Call to Action &amp; Contact</h5>
          </div>
          <div class="section-card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">CTA Heading</label>
                <input type="text" name="cta_title" class="form-control" value="<?= esc($food->cta_title ?? 'Have Special Dietary Questions?') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">WhatsApp Number</label>
                <input type="text" name="cta_whatsapp_number" class="form-control" value="<?= esc($food->cta_whatsapp_number ?? '917034111368') ?>">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">CTA Description</label>
                <textarea name="cta_description" class="form-control" rows="2"><?= esc($food->cta_description ?? 'Reach out to our hostel team anytime on WhatsApp. We are happy to walk you through our weekly menu, food hygiene standards, and room tariffs.') ?></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">WhatsApp Button Label</label>
                <input type="text" name="cta_whatsapp_button_text" class="form-control" value="<?= esc($food->cta_whatsapp_button_text ?? 'Chat on WhatsApp') ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Secondary Button Label</label>
                <input type="text" name="cta_secondary_button_text" class="form-control" value="<?= esc($food->cta_secondary_button_text ?? 'Explore Rooms') ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Secondary Button URL</label>
                <input type="text" name="cta_secondary_button_link" class="form-control" value="<?= esc($food->cta_secondary_button_link ?? '/search') ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="d-flex justify-content-end gap-3 mb-5">
          <a href="<?= base_url(); ?>Admin/FoodQuality" class="btn btn-outline-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary px-4">
            <i class="bx bx-save me-1"></i> Save All Changes
          </button>
        </div>

      </form>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const addFaqBtn = document.getElementById('addFaqBtn');
      const faqContainer = document.getElementById('faqContainer');

      if (addFaqBtn && faqContainer) {
        addFaqBtn.addEventListener('click', function () {
          const row = document.createElement('div');
          row.className = 'faq-row border rounded p-3 mb-3 bg-light position-relative';
          row.innerHTML = `
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-faq-btn" style="padding: 2px 8px;">
              <i class="bx bx-x"></i>
            </button>
            <div class="mb-2 pe-4">
              <label class="form-label small fw-semibold">Question</label>
              <input type="text" name="faq_q[]" class="form-control form-control-sm" placeholder="Enter Question">
            </div>
            <div>
              <label class="form-label small fw-semibold">Answer</label>
              <textarea name="faq_a[]" class="form-control form-control-sm" rows="2" placeholder="Enter Answer"></textarea>
            </div>
          `;
          faqContainer.appendChild(row);
        });

        faqContainer.addEventListener('click', function (e) {
          const removeBtn = e.target.closest('.remove-faq-btn');
          if (removeBtn) {
            removeBtn.closest('.faq-row').remove();
          }
        });
      }
    });
  </script>

  <!--footer section start-->
  <?= $this->include('admin/includes/footer')?>
  <!--footer section end-->
</html>

