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
                      <h5 class="mb-0">Edit Tariff</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                         
                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms</label>
                          <div class="col-sm-4">
                              <select id="" class="form-select room_clz" name="tariffs_rooms" required disabled>

                               
                                <?php foreach($rooms as $room){?> 
                                  <option value="<?php echo $room->rooms_id;?>" <?php if($tariff->tariffs_rooms	== $room->rooms_id){echo "selected"; }?>><?php echo $room->rooms_name;?></option>
                                <?php } ?>
                              
                              
                              </select>
                              <input type="hidden" name="tariffs_rooms" value="<?php echo $tariff->tariffs_rooms;?>">
                          </div>
                          <div class="col-sm-3" style="margin-top: -23px;">
                            <label>Building</label>
                            <input type="text" class="form-control build_clz" value="<?php echo $tariff->building_name;?>"  name="" id="" placeholder="Tower1" required readonly/>
                            <input type="hidden" name="tariffs_building"  class="build_id_clz" value="<?php echo $tariff->tariffs_building;?>">
                          </div>
                          <div class="col-sm-3" style="margin-top: -23px;">
                            <label>Room Type</label>
                            <input type="text" class="form-control room_type_clz" value="<?php echo $tariff->room_type_name;?>"   name="" id="" placeholder="3 Share" required readonly/>
                            <input type="hidden" name="tariffs_room_types" class="room_type_id_clz" value="<?php echo $tariff->tariffs_room_types;?>">
                          </div>
                        </div>





                         

<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Monthly Rent</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" name="tariffs_price" min="0" step="0.01" value="<?php echo $tariff->tariffs_price; ?>" id="basic-default-name" placeholder="e.g., 3" required>
                          </div>
</div>

                        


                      


                        
                          
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Basic with Icons -->
                
              </div>

              <div class="row mb-6 gy-6">
                <div class="col-xxl">
                  <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Tariff Edit History</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive text-nowrap">
                        <table class="table display" id="historyTable">
                          <thead>
                            <tr>
                              <th>Sl no</th>
                              <th>Old Price</th>
                              <th>New Price</th>
                              <th>Effective Month</th>
                              <th>Saved Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $j=1; if(!empty($history)){ foreach($history as $hist){ ?> 
                            <tr>
                              <td><?php echo $j;?></td>
                              <td><?php echo number_format($hist->tariff_history_old_price,2);?></td>
                              <td><?php echo number_format($hist->tariff_history_new_price,2);?></td>
                              <td><?php echo $hist->tariff_history_effective_month;?></td>
                              <td><?php echo date('d-m-Y H:i:s', strtotime($hist->tariff_history_created_at));?></td>
                            </tr>
                            <?php $j++; } }else{ ?>
                            <tr>
                              <td colspan="5" class="text-center">No history found</td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
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

              /*fetch building and room type by room*/

                function onRoomChange(){ 

                  var Id =  $('.room_clz').val();

                  $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/Rooms",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.build_clz').val(data.building);

                          $('.room_type_clz').val(data.room_type);

                          $('.build_id_clz').val(data.building_id);

                          $('.room_type_id_clz').val(data.room_type_id);

                        }
                  });

                
    
                }

                /*auto fill building & room type from selected room on page load*/
                $(document).ready(function(){
                  if(!$('.build_clz').val() || !$('.room_type_clz').val()){
                    $(".room_clz").trigger('change');
                  }
                });

                /*end section*/
                
                $(".room_clz").on('change', onRoomChange);
                onRoomChange();
            </script>

            

   
  </body>
</html>
