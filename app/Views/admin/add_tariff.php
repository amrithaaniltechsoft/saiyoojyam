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
              <!-- Basic Layout & Basic with Icons -->
              <div class="row mb-6 gy-6">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                      <h5 class="mb-0">Add Tariff</h5>
                      <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                          <i class="bx bx-file me-1"></i> Import Excel / CSV
                        </button>
                        <a href="<?php echo base_url('Admin/Tariff/DownloadSample'); ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" title="Download Excel template">
                          <i class="bx bx-download me-1"></i> Sample Template
                        </a>
                      </div>
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                        
                        <div class="table-responsive">
                          <table class="table table-bordered align-middle" id="tariff_table">
                            <thead class="table-light">
                              <tr>
                                <th style="width: 38%;">Building <span class="text-danger">*</span></th>
                                <th style="width: 38%;">Room Type <span class="text-danger">*</span></th>
                                <th style="width: 19%;">Monthly Rent (₹) <span class="text-danger">*</span></th>
                                <th style="width: 5%; text-align: center;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tariff_tbody">
                              <tr class="tariff-row">
                                <td>
                                  <select class="form-select build_clz" name="tariffs_building[]" required>
                                    <option value="" <?php echo empty($selected_building_id) ? 'selected' : ''; ?> disabled>Select Building</option>
                                    <?php if(!empty($buildings)){ foreach($buildings as $build){ ?> 
                                      <option value="<?php echo $build->building_id; ?>" <?php echo (!empty($selected_building_id) && $selected_building_id == $build->building_id) ? 'selected' : ''; ?>><?php echo $build->building_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="form-select room_type_clz" name="tariffs_room_types[]" required>
                                    <option value="" <?php echo empty($selected_type_id) ? 'selected' : ''; ?> disabled>Select Room Type</option>
                                    <?php if(!empty($preselected_room_types)){ foreach($preselected_room_types as $rt){ ?>
                                      <option value="<?php echo $rt->room_type_id; ?>" <?php echo (!empty($selected_type_id) && $selected_type_id == $rt->room_type_id) ? 'selected' : ''; ?>><?php echo $rt->room_type_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="number" class="form-control" min="0" step="0.01" name="tariffs_price[]" placeholder="e.g., 5000" required <?php echo !empty($selected_type_id) ? 'autofocus' : ''; ?>/>
                                </td>
                                <td class="text-center">
                                  <button type="button" class="btn text-danger remove-row-btn" style="display: none;">
                                    <i class="bx bx-trash"></i>
                                  </button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                          <button type="button" class="btn btn-secondary" id="add_more_btn">
                            <i class="bx bx-plus me-1"></i> Add More Row
                          </button>
                          <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i> Submit Tariffs
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Basic with Icons -->
                
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            
            <?= $this->include('admin/includes/footer') ?>

            <!-- / Footer -->

            <!-- Import Excel Modal -->
            <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                  <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="importExcelModalLabel">
                      <span class="badge bg-label-success p-2 rounded"><i class="bx bx-file fs-4 text-success"></i></span>
                      <span class="fw-bold">Import Tariffs via Excel / CSV</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form id="excel_import_form" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                      <!-- Guide alert -->
                      <div class="alert alert-primary d-flex align-items-start gap-2 py-3 px-3 mb-4 rounded-3" style="font-size:12.5px;">
                        <i class="bx bx-info-circle fs-5 mt-0.5 text-primary"></i>
                        <div class="flex-grow-1">
                          <strong>Required Columns in Excel / CSV:</strong>
                          <div class="mt-1">
                            Your spreadsheet only needs these <strong>3 columns</strong>:
                            <div class="mt-1 d-flex flex-wrap gap-1">
                              <span class="badge bg-white text-primary border">1. Building Name</span>
                              <span class="badge bg-white text-primary border">2. Room Type Name</span>
                              <span class="badge bg-white text-primary border">3. Monthly Rent</span>
                            </div>
                            <small class="text-muted d-block mt-1.5" style="font-size:11px;">
                              Admission fees and caution deposit will automatically use each building's defaults.
                            </small>
                          </div>
                          <div class="mt-2.5">
                            <a href="<?php echo base_url('Admin/Tariff/DownloadSample'); ?>" class="btn btn-sm btn-primary py-1 px-3 text-white fw-semibold">
                              <i class="bx bx-download me-1"></i> Download 3-Column Sample Template (.xlsx)
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- File upload field -->
                      <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Select Excel / CSV File <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <input type="file" class="form-control" id="excel_file_input" name="excel_file" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <small class="text-muted mt-1 d-block" style="font-size:11.5px;">Supported formats: .xlsx (Excel), .xls, or .csv (Max 10MB)</small>
                      </div>

                      <!-- Options -->
                      <div class="form-check form-switch mb-3 p-2 bg-light rounded border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" id="update_existing" name="update_existing" value="1" checked>
                        <label class="form-check-label fw-semibold text-dark" for="update_existing" style="font-size:13px;">
                          Update price if tariff already exists for the building & room type
                        </label>
                        <small class="text-muted d-block ps-4 ms-2" style="font-size:11.5px;">
                          When enabled, existing matching tariffs will have their monthly price updated and recorded in the price history.
                        </small>
                      </div>

                      <!-- Live Result Box (hidden initially) -->
                      <div id="import_result_box" class="d-none mt-3">
                        <div id="import_alert" class="alert py-2.5 px-3 mb-2 rounded-2"></div>
                        <div class="d-flex align-items-center justify-content-between mb-1.5 px-1">
                          <span class="fw-bold text-dark" style="font-size:12px;">Import Details Log:</span>
                          <span id="import_badges" class="d-flex gap-1.5"></span>
                        </div>
                        <div id="import_details_wrap" class="border rounded p-2.5 bg-white" style="max-height: 200px; overflow-y: auto; font-size: 12px;">
                          <ul id="import_logs_list" class="list-unstyled mb-0 space-y-1"></ul>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer border-top p-3 bg-light d-flex justify-content-between">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="btn_submit_import" class="btn btn-success fw-bold px-4">
                        <i class="bx bx-upload me-1"></i> Upload & Import
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                $(document).ready(function () {
                  <?php if(!empty($selected_building_id)): ?>
                  $('#tariff_tbody .tariff-row:first .build_clz').val('<?php echo $selected_building_id; ?>');
                  <?php endif; ?>
                  <?php if(!empty($selected_type_id)): ?>
                  $('#tariff_tbody .tariff-row:first .room_type_clz').val('<?php echo $selected_type_id; ?>');
                  <?php endif; ?>

                  function updateRemoveButtons() {
                    var rowCount = $('#tariff_tbody .tariff-row').length;
                    if (rowCount > 1) {
                      $('.remove-row-btn').show();
                    } else {
                      $('.remove-row-btn').hide();
                    }
                  }

                  /* Add More Row */
                  $('#add_more_btn').on('click', function () {
                    var firstRow = $('#tariff_tbody .tariff-row:first');
                    var newRow = firstRow.clone();

                    newRow.find('select.build_clz').val('');
                    newRow.find('select.room_type_clz').html('<option value="" selected disabled>Select Room Type</option>');
                    newRow.find('input').val('');

                    $('#tariff_tbody').append(newRow);
                    updateRemoveButtons();
                  });

                  /* Remove Row */
                  $('#tariff_tbody').on('click', '.remove-row-btn', function () {
                    if ($('#tariff_tbody .tariff-row').length > 1) {
                      $(this).closest('tr').remove();
                      updateRemoveButtons();
                    }
                  });

                  /* Fetch room type by building */
                  $('#tariff_tbody').on('change', '.build_clz', function () {
                    var $row = $(this).closest('tr');
                    var Id = $(this).val();

                    $row.find('.room_type_clz').html('<option value="" selected disabled>Select Room Type</option>');

                    if (Id) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/tariffRoomTypes",
                        type: "POST",
                        data: { ID: Id },
                        success: function (data) {
                          var res = JSON.parse(data);
                          $row.find('.room_type_clz').html(res.rooms);
                        }
                      });
                    }
                  });

                  /* Submit Handler for Manual Add */
                  var form = $('#add_form');
                  form.validate({
                    errorClass: "text-danger",
                    submitHandler: function (currentForm) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Tariff/Add",
                        type: "POST",
                        data: $(currentForm).serialize(),
                        success: function (response) {
                          var data = JSON.parse(response);

                          if (data.status === "true") {
                            alertify.success(data.msg).delay(4).dismissOthers();
                            $('#tariff_tbody .tariff-row:gt(0)').remove();
                            form[0].reset();
                            $('#tariff_tbody .room_type_clz').html('<option value="" selected disabled>Select Room Type</option>');
                            updateRemoveButtons();
                          } else {
                            alertify.error(data.msg).delay(4).dismissOthers();
                          }
                        }
                      });
                    }
                  });

                  /* Submit Handler for Excel Import */
                  $('#excel_import_form').on('submit', function (e) {
                    e.preventDefault();

                    var fileInput = $('#excel_file_input')[0];
                    if (!fileInput.files.length) {
                      alertify.error('Please select an Excel or CSV file.').delay(3).dismissOthers();
                      return;
                    }

                    var btn = $('#btn_submit_import');
                    var origText = btn.html();
                    btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Importing...');

                    var formData = new FormData(this);

                    $('#import_result_box').addClass('d-none');
                    $('#import_logs_list').empty();
                    $('#import_badges').empty();

                    $.ajax({
                      url: '<?php echo base_url("Admin/Tariff/Import"); ?>',
                      type: 'POST',
                      data: formData,
                      contentType: false,
                      processData: false,
                      dataType: 'json',
                      success: function (res) {
                        btn.prop('disabled', false).html(origText);
                        $('#import_result_box').removeClass('d-none');

                        if (res && res.status) {
                          alertify.success(res.message).delay(5).dismissOthers();
                          $('#import_alert').removeClass('alert-danger').addClass('alert-success').html('<strong><i class="bx bx-check-circle me-1"></i>Success:</strong> ' + res.message);
                        } else {
                          alertify.error(res?.message || 'Import failed').delay(5).dismissOthers();
                          $('#import_alert').removeClass('alert-success').addClass('alert-danger').html('<strong><i class="bx bx-error me-1"></i>Notice:</strong> ' + (res?.message || 'Import failed.'));
                        }

                        // Add badges
                        if (res.added !== undefined && res.added > 0) {
                          $('#import_badges').append('<span class="badge bg-success" style="font-size:11px;"><i class="bx bx-check me-0.5"></i>' + res.added + ' Added</span>');
                        }
                        if (res.updated !== undefined && res.updated > 0) {
                          $('#import_badges').append('<span class="badge bg-info" style="font-size:11px;"><i class="bx bx-edit me-0.5"></i>' + res.updated + ' Updated</span>');
                        }
                        if (res.skipped !== undefined && res.skipped > 0) {
                          $('#import_badges').append('<span class="badge bg-warning text-dark" style="font-size:11px;"><i class="bx bx-skip-next me-0.5"></i>' + res.skipped + ' Skipped</span>');
                        }

                        if (res.logs && res.logs.length > 0) {
                          res.logs.forEach(function (log) {
                            var badge = log.status === 'added' ? '<span class="badge bg-label-success" style="font-size:10.5px;">Added</span>' :
                                       log.status === 'updated' ? '<span class="badge bg-label-info" style="font-size:10.5px;">Updated</span>' :
                                       '<span class="badge bg-label-danger" style="font-size:10.5px;">Skipped</span>';
                            $('#import_logs_list').append('<li class="py-1.5 border-bottom d-flex align-items-center justify-content-between gap-2"><span>' + log.message + '</span> ' + badge + '</li>');
                          });
                        }
                      },
                      error: function (xhr) {
                        btn.prop('disabled', false).html(origText);
                        $('#import_result_box').removeClass('d-none');
                        var err = xhr.responseJSON?.message || 'An error occurred during import. Please check file format and try again.';
                        $('#import_alert').removeClass('alert-success').addClass('alert-danger').html('<strong><i class="bx bx-error me-1"></i>Error:</strong> ' + err);
                        alertify.error(err).delay(5).dismissOthers();
                      }
                    });
                  });

                });
              });
            </script>

   
  </body>
</html>
