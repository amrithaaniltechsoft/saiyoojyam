<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <!-- Select2 CSS & Bootstrap 5 Theme -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>

  <style>
    /* Select2 Bootstrap 5 Styling */
    .select2-container--bootstrap-5 .select2-selection {
      min-height: 40px !important;
      border-radius: 8px !important;
      border: 1.5px solid #d9dee3 !important;
      font-size: 13.5px !important;
      background: #ffffff !important;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
      height: 40px !important;
      display: flex !important;
      align-items: center !important;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
      line-height: 38px !important;
      padding-left: 12px !important;
      color: #495057 !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
      border-color: #696cff !important;
      box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
      border-radius: 8px !important;
      border-color: #d9dee3 !important;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
      font-size: 13.5px !important;
      z-index: 9999 !important;
    }
    /* Ensure the search bar inside dropdown is always visible, prominent, and styled */
    .select2-container--bootstrap-5 .select2-search--dropdown {
      display: block !important;
      padding: 8px !important;
      background: #f8f9fa;
      border-bottom: 1px solid #ebecef;
    }
    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
      display: block !important;
      width: 100% !important;
      border-radius: 6px !important;
      border: 1px solid #ced4da !important;
      font-size: 13.5px !important;
      padding: 7px 12px !important;
      outline: none !important;
    }
    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
      border-color: #696cff !important;
      box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }
  </style>



       
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">View Room</h5>
                <div class="card-body pb-2">
                  <form id="filter_form" method="GET" action="<?php echo base_url(); ?>Admin/Rooms">
                    <?php 
                      $sel_build = !empty($selected_building) ? (is_array($selected_building) ? reset($selected_building) : $selected_building) : ($_GET['building'] ?? '');
                      $sel_rtype = !empty($selected_room_type) ? (is_array($selected_room_type) ? reset($selected_room_type) : $selected_room_type) : ($_GET['room_type'] ?? '');
                      $sel_room  = !empty($selected_room) ? (is_array($selected_room) ? reset($selected_room) : $selected_room) : ($_GET['room'] ?? '');
                    ?>

                    <div class="row g-3 align-items-end mb-3">
                      <!-- Building Filter -->
                      <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold text-dark small mb-1">
                          <i class="bx bx-buildings text-primary me-1"></i> Building
                        </label>
                        <select id="building_filter" class="form-select select2-filter build_clz" name="building" data-placeholder="All Buildings">
                          <option value="">All Buildings</option>
                          <?php foreach($buildings as $build){ ?>
                            <option value="<?php echo $build->building_id; ?>" <?php if((string)$build->building_id === (string)$sel_build){ echo "selected"; }?>>
                              <?php echo $build->building_name;?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- Room Type Filter -->
                      <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold text-dark small mb-1">
                          <i class="bx bx-category text-primary me-1"></i> Room Type
                        </label>
                        <select id="room_type_filter" class="form-select select2-filter room_clz" name="room_type" data-placeholder="All Room Types">
                          <option value="">All Room Types</option>
                          <?php if(!empty($dropdown_room_types)){ foreach($dropdown_room_types as $rt){ ?> 
                            <option value="<?php echo $rt->room_type_id; ?>" <?php if((string)$rt->room_type_id === (string)$sel_rtype){ echo "selected"; }?>>
                              <?php echo $rt->room_type_name;?>
                            </option>
                          <?php } } ?> 
                        </select>
                      </div>

                      <!-- Room Filter -->
                      <div class="col-12 col-md-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <label class="form-label fw-semibold text-dark small mb-0">
                            <i class="bx bx-door-open text-primary me-1"></i> Room
                          </label>
                          <?php if(!empty($sel_build) || !empty($sel_rtype) || !empty($sel_room)): ?>
                            <a href="<?php echo base_url(); ?>Admin/Rooms" class="small text-danger text-decoration-none fw-semibold">
                              <i class="bx bx-x-circle me-1"></i>Reset
                            </a>
                          <?php endif; ?>
                        </div>
                        <select id="room_filter" class="form-select select2-filter room_item_clz" name="room" data-placeholder="All Rooms">
                          <option value="">All Rooms</option>
                          <?php if(!empty($dropdown_rooms)){ foreach($dropdown_rooms as $r){ ?> 
                            <option value="<?php echo $r->rooms_id; ?>" <?php if((string)$r->rooms_id === (string)$sel_room){ echo "selected"; }?>>
                              <?php echo $r->rooms_name;?>
                            </option>
                          <?php } } ?> 
                        </select>
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
                        <th>Room Types</th>
                        <th>Room Name</th>
                        <th>Capacity</th>
                        
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $page_data){?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                        <?php foreach($buildings as $build){
                        if($build->building_id == $page_data->rooms_building){  
                        ?> 
                        <td><?php echo $build->building_name; ?></td>
                        <?php } } ?>
                        
                        <?php 
                        $curCap = $page_data->rooms_capacity;
                        foreach($room_types as $room_type){
                          if($room_type->room_type_id  == $page_data->rooms_type){
                            if(!empty($room_type->room_type_capacity)){
                              $curCap = $room_type->room_type_capacity;
                            }
                        ?> 
                        <td><?php echo $room_type->room_type_name;?></td>

                        <?php } } ?>

                        <td><?php echo $page_data->rooms_name;?></td>
                        <td><?php echo $curCap;?></td>
                        
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Rooms/Edit/<?php echo $page_data->rooms_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Rooms/Delete/<?php echo $page_data->rooms_id; ?>"><i class="icon-base bx bx-trash me-2"></i> </a>
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

            <!-- Select2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
              $(document).ready(function() {
                // Initialize Select2 with search enabled on all dropdowns
                $('#building_filter').select2({
                  theme: 'bootstrap-5',
                  placeholder: 'All Buildings',
                  allowClear: true,
                  width: '100%',
                  minimumResultsForSearch: 0
                });

                $('#room_type_filter').select2({
                  theme: 'bootstrap-5',
                  placeholder: 'All Room Types',
                  allowClear: true,
                  width: '100%',
                  minimumResultsForSearch: 0
                });

                $('#room_filter').select2({
                  theme: 'bootstrap-5',
                  placeholder: 'All Rooms',
                  allowClear: true,
                  width: '100%',
                  minimumResultsForSearch: 0
                });

                // Auto-submit filter form on dropdown selection change
                $('#building_filter, #room_type_filter, #room_filter').on('change', function() {
                  $('#filter_form').submit();
                });

                // Auto-focus search input field when Select2 dropdown opens
                $(document).on('select2:open', function() {
                  setTimeout(function() {
                    var searchInput = document.querySelector('.select2-container--open .select2-search__field');
                    if (searchInput) {
                      searchInput.focus();
                    }
                  }, 50);
                });
              });
            </script>
   
  </body>
</html>
