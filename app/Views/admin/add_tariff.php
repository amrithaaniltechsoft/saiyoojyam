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
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Add Tariff</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form">

                        
                        <div class="table-responsive">
                          <table class="table table-bordered align-middle" id="tariff_table">
                            <thead class="table-light">
                              <tr>
                                <th style="width: 25%;">Building <span class="text-danger">*</span></th>
                                <th style="width: 25%;">Room Type <span class="text-danger">*</span></th>
                                <th style="width: 25%;">Room <span class="text-danger">*</span></th>
                                <th style="width: 20%;">Monthly Rent (₹) <span class="text-danger">*</span></th>
                                <th style="width: 5%; text-align: center;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tariff_tbody">
                              <tr class="tariff-row">
                                <td>
                                  <select class="form-select build_clz" name="tariffs_building[]" required>
                                    <option value="" selected disabled>Select Building</option>
                                    <?php if(!empty($buildings)){ foreach($buildings as $build){ ?> 
                                      <option value="<?php echo $build->building_id; ?>"><?php echo $build->building_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td>
                                  <select class="form-select room_type_clz" name="tariffs_room_types[]" required>
                                    <option value="" selected disabled>Select Room Type</option>
                                  </select>
                                </td>
                                <td>
                                  <select class="form-select room_clz" name="tariffs_rooms[]" required>
                                    <option value="" selected disabled>Select Rooms</option>
                                  </select>
                                </td>
                                <td>
                                  <input type="number" class="form-control" min="0" step="0.01" name="tariffs_price[]" placeholder="e.g., 5000" required/>
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

            <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                $(document).ready(function () {
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
                    newRow.find('select.room_clz').html('<option value="" selected disabled>Select Rooms</option>');
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
                    $row.find('.room_clz').html('<option value="" selected disabled>Select Rooms</option>');

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

                  /* Fetch rooms by room type and building */
                  $('#tariff_tbody').on('change', '.room_type_clz', function () {
                    var $row = $(this).closest('tr');
                    var buildId = $row.find('.build_clz').val();
                    var typeId = $(this).val();

                    $row.find('.room_clz').html('<option value="" selected disabled>Select Rooms</option>');

                    if (typeId) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/tariffRooms",
                        type: "POST",
                        data: { building_id: buildId, room_type_id: typeId },
                        success: function (data) {
                          var res = JSON.parse(data);
                          $row.find('.room_clz').html(res.rooms);
                        }
                      });
                    }
                  });

                  /* Submit Handler */
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
                            $('#tariff_tbody .room_clz').html('<option value="" selected disabled>Select Rooms</option>');
                            updateRemoveButtons();
                          } else {
                            alertify.error(data.msg).delay(4).dismissOthers();
                          }
                        }
                      });
                    }
                  });
                });
              });
            </script>

   
  </body>
</html>
