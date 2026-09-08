<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" rel="stylesheet"/>



          
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Bootstrap Table -->
               
              <div class="card">
                <h5 class="card-header">View Inmates</h5>

                <?php
                  $href_base = base_url().'Admin/Inmates';
                  $fq = array();
                  if(!empty($active_status)){ $fq['status'] = $active_status; }
                  if(!empty($active_pay)){ $fq['pay'] = $active_pay; }
                  $href = function($extra) use ($fq){
                    return base_url().'Admin/Inmates?'.http_build_query(array_merge($fq, $extra));
                  };
                  $cls_ab = $active_status == 'active' ? 'btn-success' : 'btn-outline-success';
                  $cls_na = $active_status == 'checked_out' ? 'btn-success' : 'btn-outline-success';
                  $cls_ud = $active_pay == 'unpaid' ? 'btn-warning' : 'btn-outline-warning';
                  $cls_pd = $active_pay == 'paid' ? 'btn-success' : 'btn-outline-success';
                  $cls_pt = $active_pay == 'partial' ? 'btn-primary' : 'btn-outline-primary';
                  $cls_av = $active_pay == 'advance' ? 'btn-info' : 'btn-outline-info';
                ?>

                <div class="card-header d-flex flex-wrap gap-2 align-items-center">
                  <select id="ref_filter" class="form-select form-select-sm" style="width:200px;" onchange="var u='<?php echo base_url();?>Admin/Inmates';if(this.value){u+='?ref='+this.value+'<?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>';}goNav(u);">
                    <option value="">Filter by Reference ID</option>
                    <?php foreach($reffers as $ref){ ?>
                    <option value="<?php echo $ref->inmates_uid;?>" <?php if(!empty($active_ref) && $active_ref == $ref->inmates_uid){ echo 'selected';} ?>><?php echo $ref->inmates_uid; ?> - <?php echo $ref->inmates_name;?></option>
                    <?php } ?>
                  </select>
                  <a href="<?php echo $href_base;?>" class="btn btn-sm btn-outline-secondary filter-link">All</a>
                  <a href="<?php echo $href(array('status' => 'active'));?>" class="btn btn-sm filter-link <?php echo $cls_ab;?>">Active</a>
                  <a href="<?php echo $href(array('status' => 'checked_out'));?>" class="btn btn-sm filter-link <?php echo $cls_na;?>">Inactive</a>
                  <span class="mx-1 text-muted">Payment:</span>
                  <a href="<?php echo $href(array('pay' => 'unpaid'));?>" class="btn btn-sm filter-link <?php echo $cls_ud;?>">Unpaid</a>
                  <a href="<?php echo $href(array('pay' => 'paid'));?>" class="btn btn-sm filter-link <?php echo $cls_pd;?>">Paid</a>
                  <a href="<?php echo $href(array('pay' => 'partial'));?>" class="btn btn-sm filter-link <?php echo $cls_pt;?>">Partially Paid</a>
                  <a href="<?php echo $href(array('pay' => 'advance'));?>" class="btn btn-sm filter-link <?php echo $cls_av;?>">Advance</a>
                  <a href="<?php echo $href_base;?>" class="btn btn-sm btn-outline-danger filter-link">Reset</a>
                </div>

                <div class="card-header d-flex flex-wrap gap-2 align-items-center border-top">
                  <label class="text-muted mb-0">Check In:</label>
                  <input type="date" class="form-control form-control-sm check_in_filter" style="width:150px;" value="<?php echo $active_check_in; ?>" onchange="goNav('<?php echo base_url();?>Admin/Inmates?check_in='+this.value+'<?php echo !empty($active_check_out)?'&check_out='.$active_check_out:''; ?><?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>');"/>
                  <label class="text-muted mb-0 ms-2">Check Out:</label>
                  <input type="date" class="form-control form-control-sm check_out_filter" style="width:150px;" value="<?php echo $active_check_out; ?>" onchange="goNav('<?php echo base_url();?>Admin/Inmates?check_out='+this.value+'<?php echo !empty($active_check_in)?'&check_in='.$active_check_in:''; ?><?php echo !empty($active_status)?'&status='.$active_status:''; ?><?php echo !empty($active_pay)?'&pay='.$active_pay:''; ?>');"/>
                  <a href="<?php echo $href_base.(!empty($fq) ? '?'.http_build_query($fq) : '');?>" class="btn btn-sm btn-outline-secondary filter-link">Reset Dates</a>
                </div>
               
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Sl no</th>
                        <th>Reference ID</th>
                        <th>Name</th>
                        <th>Rooms</th>
                        
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th>Status</th>
                        
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                      <?php $i=1; foreach($pagedata as $val){ ?> 
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val->inmates_uid; ?></td>
                         <td><?php echo $val->inmates_name;?></td>
                        
                        <?php foreach($rooms_data as $rooms){
                           if($rooms->rooms_id  == $val->inmates_rooms){ 
                        ?>

                          <td>
                            <?php echo $rooms->rooms_name;?>
                            <?php foreach($room_types as $rtype){
                              if($rtype->room_type_id == $val->inmates_room_type){
                            ?>
                            <br/><small class="text-muted"><?php echo $rtype->room_type_name; ?></small>
                            <?php } } ?>
                            <?php foreach($buildings as $build){
                              if($build->building_id == $val->inmates_building){
                            ?>
                            <br/><small class="text-muted"><?php echo $build->building_name; ?></small>
                            <?php } } ?>
                          </td>

                        <?php } }  ?>
                       
                        <td><?php echo date('d-M-Y',strtotime($val->inmates_check_in_date)); ?></td>
                        <td><?php if($val->inmates_check_out_date !="0000-00-00"){echo date('d-M-Y',strtotime($val->inmates_check_out_date));} else { ?>
                          <a href="<?php echo base_url();?>Admin/Inmates/CheckOut/<?php echo $val->inmates_id;?>" class="btn btn-danger btn-sm" onclick="return confirm('Check out this inmate?');">Check Out</a>
                        <?php } ?></td>
                        <td>
                          <?php if(!empty($val->inmates_status) && $val->inmates_status == 'checked_out'){ ?>
                            <span class="badge bg-label-danger">Inactive</span>
                          <?php } else { ?>
                            <span class="badge bg-label-success">Active</span>
                          <?php } ?>
                        </td>
                        
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Inmates/View/<?php echo $val->inmates_id;?>"><i class="icon-base bx bx-show me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Inmates/Edit/<?php echo $val->inmates_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Inmates/Delete/<?php echo $val->inmates_id;?>" onclick="return confirm('Are you sure you want to delete this inmate?');"><i class="icon-base bx bx-trash me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Inmates/Receipt/<?php echo $val->inmates_id;?>"><i class="icon-base bx bx-bxs-printer me-2"></i> </a>
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

            <div id="filterLoader" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.35);z-index:99999;text-align:center;">
  <div style="margin-top:20%;"><div class="spinner-border text-light" style="width:3rem;height:3rem;" role="status"><span class="visually-hidden">Loading...</span></div><br/><span style="color:#fff;font-weight:600;">Filtering...</span></div>
</div>

            <!-- Footer section start-->
            
<?= $this->include('admin/includes/footer') ?>

            <!--Footer section end-->

            <script>
              function goNav(url){
                document.getElementById('filterLoader').style.display = 'block';
                window.location = url;
              }
              $(document).ready(function () {
                $('.filter-link').on('click', function (e) {
                  e.preventDefault();
                  var href = $(this).attr('href');
                  $(this).addClass('active');
                  goNav(href);
                });
              });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
            <script>
              $(document).ready(function () {
                $('#ref_filter').select2({
                  theme: 'bootstrap-5',
                  placeholder: 'Filter by Reference ID',
                  allowClear: true,
                  width: '200px'
                });

                flatpickr('.check_in_filter', { dateFormat: 'Y-m-d', allowInput: true });
                flatpickr('.check_out_filter', { dateFormat: 'Y-m-d', allowInput: true });
              });
            </script>
    
  </body>
</html>
