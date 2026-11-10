<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->



       
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">View Tariff</h5>
                <div class="card-body pb-2">

                  <form id="filter_form" method="GET" action="<?php echo base_url(); ?>Admin/Tariff">
                    <?php 
                      $selected_building  = !empty($_GET['building']) ? $_GET['building'] : '';
                      $selected_room_type = !empty($_GET['room_type']) ? $_GET['room_type'] : '';
                    ?>

                    <div class="row g-3 align-items-center justify-content-center mb-3">
                      <div class="col-md-4 col-lg-3">
                        <select id="building_filter" class="form-select build_clz" name="building">
                          <option value="">All Buildings</option>
                          <?php foreach($buildings as $build){ ?>
                            <option value="<?php echo $build->building_id; ?>" <?php if($selected_building == $build->building_id){echo "selected"; }?>><?php echo $build->building_name;?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="col-md-4 col-lg-3">
                        <select id="room_type_filter" class="form-select room_clz" name="room_type">
                          <option value="">All Room Types</option>
                          <?php foreach($rooms_types as $rt){ ?> 
                            <option value="<?php echo $rt->room_type_id; ?>" <?php if($selected_room_type == $rt->room_type_id){echo "selected";}?>><?php echo $rt->room_type_name;?></option>
                          <?php } ?> 
                        </select>
                      </div>

                      <div class="col-auto">
                        <a href="<?php echo base_url(); ?>Admin/Tariff" class="btn btn-outline-secondary" title="Reset filter">
                          <i class="bx bx-reset me-1"></i> Reset
                        </a>
                      </div>
                    </div>
                  </form>

                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Building</th>
                        <th>Room Type</th>
                        <th>Caution deposit</th>
                        <th>Admission fees</th>
                        <th>Price</th>
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php $i=1; foreach($tariffs as $tariff){ ?> 
                      <tr>
                        <td><?php echo $i;?></td>
                       
                        <td><?php echo $tariff->building_name;?></td>
                        
                        <td><?php echo $tariff->room_type_name;?></td>

                        <td><?php echo number_format($tariff->building_caution_deposit,2);?></td>

                        <td><?php echo number_format($tariff->building_admission_fees,2);?></td>
                       
                        <td><?php echo number_format($tariff->tariffs_price,2);?></td>
                        
                        <td>
                          <a class="dropdown-item" style="display:inline-block; width:auto;" href="<?php echo base_url();?>Admin/Tariff/Edit/<?php echo $tariff->tariffs_id;?>" title="Edit"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <?php if(!empty($used_tariffs[$tariff->tariffs_id])): ?>
                            <a class="dropdown-item text-danger" style="display:inline-block; width:auto; cursor:pointer;" href="javascript:void(0);" onclick="cannotDeleteTariff('<?php echo esc($used_tariffs[$tariff->tariffs_id]); ?>'); return false;" title="Cannot delete: In use by <?php echo esc($used_tariffs[$tariff->tariffs_id]); ?>"><i class="icon-base bx bx-trash me-2 text-danger" style="opacity: 0.65;"></i> </a>
                          <?php else: ?>
                            <a class="dropdown-item" style="display:inline-block; width:auto;" href="<?php echo base_url();?>Admin/Tariff/Delete/<?php echo $tariff->tariffs_id; ?>" onclick="return confirm('Are you sure you want to delete this tariff?');" title="Delete"><i class="icon-base bx bx-trash me-2"></i> </a>
                          <?php endif; ?>
                        </td>
                        

                        
                      </tr>

                      <?php $i++; } ?>
                      
                     
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              

             

              

              
              

            <!-- Contextual Classes -->

              
              
            </div>
            <!-- / Content -->

            <!-- Footer section start-->
            
            <?= $this->include('admin/includes/footer') ?>

            <!--Footer section end-->

            <script>

              function cannotDeleteTariff(uids) {
                var msg = 'Cannot delete: This tariff price is currently used by inmate(s)' + (uids ? ' (' + uids + ')' : '') + '.';
                if (typeof alertify !== 'undefined') {
                  alertify.error(msg).delay(8).dismissOthers();
                } else {
                  alert(msg);
                }
              }

              $(document).ready(function() {
                // When building changes: fetch room types of that building via AJAX and submit
                $('#filter_form .build_clz').on('change', function() {
                  var buildId = $(this).val();

                  $.ajax({
                    url: "<?php echo base_url(); ?>Admin/Ajax/tariffRoomTypes",
                    type: "POST",
                    data: { ID: buildId, filter_mode: 1 },
                    success: function(data) {
                      try {
                        var res = JSON.parse(data);
                        $('#filter_form .room_clz').html(res.rooms);
                      } catch (e) {}
                      $('#filter_form .room_clz').val('');
                      $('#filter_form').submit();
                    },
                    error: function() {
                      $('#filter_form .room_clz').val('');
                      $('#filter_form').submit();
                    }
                  });
                });

                // Auto-submit on room type change
                $('#filter_form .room_clz').on('change', function() {
                  $('#filter_form').submit();
                });
              });

            </script>


            
   
  </body>
</html>
