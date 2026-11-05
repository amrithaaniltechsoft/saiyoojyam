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
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid #e2e8f0;
      border-radius: 12px 12px 0 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
    }
    .section-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: #FF561C;
      color: #fff;
      font-weight: 700;
      font-size: 1.1rem;
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
    .menu-day-badge {
      font-size: 0.85rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      padding: 0.4rem 0.8rem;
      border-radius: 6px;
      background: #fff5f1;
      color: #FF561C;
      border: 1px solid #ffd7a8;
      display: inline-block;
    }
    .meal-textarea {
      font-size: 0.85rem;
      line-height: 1.45;
      resize: vertical;
    }
    .meal-textarea:focus {
      border-color: #FF561C;
      box-shadow: 0 0 0 0.2rem rgba(255, 86, 28, 0.15);
    }
    .table-meal thead th {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 700;
      background-color: #f8fafc;
      color: #334155;
      padding: 0.85rem 0.75rem;
    }
  </style>

  <?php
    $baseUrl = base_url();
    if (!str_ends_with($baseUrl, '/')) {
        $baseUrl .= '/';
    }

    $weeklySchedule = !empty($food->weekly_schedule) ? json_decode($food->weekly_schedule, true) : [];
    if (!is_array($weeklySchedule) || empty($weeklySchedule)) {
        $weeklySchedule = [
            ['day' => 'MONDAY', 'breakfast' => 'TEA, PUTTU & KADALA CURRY', 'lunch' => "RICE & VEGGIES\n(Thoran/ Mezhukku Puratti & Curries)", 'teaTime' => "TEA & ANY ONE SNACK\n(Uzhunnu Vada, Parippu Vada, Bread Baji, Pazham Pori, Bonda, Unniyappam, Kozhukatta)", 'dinner' => 'APPAM/ IDIYAPPAM & EGG/ VEG CURRY'],
            ['day' => 'TUESDAY', 'breakfast' => 'TEA, DOSA, SAMBAR & CHUTNY', 'lunch' => 'RICE & VEGGIES', 'teaTime' => 'TEA & RUSK/ BISCUIT', 'dinner' => 'GHEE RICE & CHICKEN/ VEG CURRY'],
            ['day' => 'WEDNESDAY', 'breakfast' => 'TEA, IDLY, SAMBAR & CHUTNY', 'lunch' => 'RICE, FISH FRY & VEGGIES', 'teaTime' => 'TEA & ONE SNACK', 'dinner' => 'CHAPATHI & EGG/ VEG CURRY'],
            ['day' => 'THURSDAY', 'breakfast' => 'TEA, APPAM & STEW/ KURUMA', 'lunch' => 'RICE & VEGGIES', 'teaTime' => 'TEA & RUSK/ BISCUIT', 'dinner' => 'CHICKEN/ VEG BIRIYANI'],
            ['day' => 'FRIDAY', 'breakfast' => 'TEA, PUTTU & KADALA CURRY', 'lunch' => 'RICE & VEGGIES', 'teaTime' => 'TEA & ONE SNACK', 'dinner' => 'CHAPATHI & VEG CURRY'],
            ['day' => 'SATURDAY', 'breakfast' => 'TEA, DOSA, SAMBAR & CHUTNY', 'lunch' => 'RICE & VEGGIES', 'teaTime' => 'TEA & ONE SNACK', 'dinner' => 'POROTTA & CHICKEN/ VEG CURRY'],
            ['day' => 'SUNDAY', 'breakfast' => 'TEA, PURI & POTATO CURRY', 'lunch' => 'RICE, FISH CURRY & VEGGIES', 'teaTime' => 'TEA & RUSK/ BISCUIT', 'dinner' => 'KANJI, THORAN & CHAMMANTHI/ PAPPAD'],
        ];
    }
  ?>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      
      <!-- Page Header -->
      <div class="mb-4">
        <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Website /</span> Food Quality Menu</h4>
        <p class="text-muted mb-0">Manage the 7-day weekly meal timetable (DAYS • BREAKFAST • LUNCH • TEA TIME • DINNER) displayed on the live Food Quality page.</p>
      </div>

      <form action="<?= base_url(); ?>Admin/FoodQuality/Edit/1" method="POST">
        <?= csrf_field() ?>

        <div class="section-card">
          <div class="section-card-header">
            <div class="d-flex align-items-center gap-2">
              <span class="section-badge"><i class="bx bx-restaurant"></i></span>
              <div>
                <h5 class="section-title">Weekly Meal Menu Timetable (7 Days)</h5>
                <small class="text-muted">Columns: DAYS • BREAKFAST • LUNCH • TEA TIME • DINNER</small>
              </div>
            </div>
          </div>
          <div class="section-card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-meal align-middle mb-0">
                <thead>
                  <tr class="text-center align-middle">
                    <th style="width: 140px;" class="text-start ps-3"><i class="bx bx-calendar me-1 text-primary"></i> DAYS</th>
                    <th style="width: 21.5%;"><i class="bx bx-sun me-1 text-warning"></i> BREAKFAST</th>
                    <th style="width: 21.5%;"><i class="bx bx-dish me-1 text-primary"></i> LUNCH</th>
                    <th style="width: 21.5%;"><i class="bx bx-coffee me-1 text-success"></i> TEA TIME</th>
                    <th style="width: 21.5%;"><i class="bx bx-moon me-1 text-info"></i> DINNER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $dayNames = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
                    foreach ($dayNames as $dIdx => $dName):
                      $curDayData = null;
                      foreach ($weeklySchedule as $ws) {
                        if (strcasecmp($ws['day'] ?? '', $dName) === 0) {
                          $curDayData = $ws;
                          break;
                        }
                      }
                      $bfVal = $curDayData['breakfast'] ?? '';
                      $luVal = $curDayData['lunch'] ?? '';
                      $teaVal = $curDayData['teaTime'] ?? '';
                      $dinVal = $curDayData['dinner'] ?? '';
                  ?>
                    <tr>
                      <td class="text-start ps-3 bg-light align-top pt-3">
                        <span class="menu-day-badge"><?= esc($dName) ?></span>
                        <input type="hidden" name="weekly_day[]" value="<?= esc($dName) ?>">
                      </td>
                      <td class="align-top p-2">
                        <textarea name="weekly_breakfast[]" class="form-control meal-textarea" rows="3" placeholder="Enter Breakfast items..."><?= esc($bfVal) ?></textarea>
                      </td>
                      <td class="align-top p-2">
                        <textarea name="weekly_lunch[]" class="form-control meal-textarea" rows="3" placeholder="Enter Lunch items..."><?= esc($luVal) ?></textarea>
                      </td>
                      <td class="align-top p-2">
                        <textarea name="weekly_tea[]" class="form-control meal-textarea" rows="3" placeholder="Enter Tea Time &amp; snacks..."><?= esc($teaVal) ?></textarea>
                      </td>
                      <td class="align-top p-2">
                        <textarea name="weekly_dinner[]" class="form-control meal-textarea" rows="3" placeholder="Enter Dinner items..."><?= esc($dinVal) ?></textarea>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- SUBMIT BAR -->
        <div class="d-flex justify-content-end mb-5">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bx bx-save me-1"></i> Save Menu Changes
          </button>
        </div>

      </form>

    </div>
  </div>

  <!--footer section start-->
  <?= $this->include('admin/includes/footer')?>
  <!--footer section end-->
</html>
