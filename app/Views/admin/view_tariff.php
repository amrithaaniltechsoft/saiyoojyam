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
                <div class="container">

                  <form>
                  <div class="row">

                      <?php if(!empty($_GET['building'])){ 

                        $building = $_GET['building'];
                            
                      } else{

                        $building = "";
                      
                       } 
                      if(!empty($_GET['room_type'])){
                         
                        $room_type = $_GET['room_type'];

                      }else{

                        $room_type = "";
                      }
                       
                      ?>

                      <div class="col-lg-2"></div>

                      <div class="col-lg-3">
                          <select id="" class="form-select build_clz" name="building" required>
                            <option value="" selected disabled>Select Buliding</option>
                            <option value="" >Select All</option>
                            <?php  foreach($buildings as $build){ ?>

                              <option value="<?php echo $build->building_id; ?>" <?php if($building == $build->building_id){echo "selected"; }?>><?php echo $build->building_name;?></option>

                            <?php } ?>
                          </select>
                      </div>

                      <div class="col-lg-3">
                          <select id="" class="form-select room_clz" name="room_type">
                            <option value="" selected disabled>Select Room Type</option>
                            <?php foreach($rooms_types as $room_type){?> 
                            <option value="<?php echo $room_type->room_type_id; ?>" <?php if($room_type->room_type_id == $room_type){echo "selected";}?>><?php echo $room_type->room_type_name;?></option>
                            <?php } ?> 

                          </select>
                      </div>

                      <div class="col-lg-2"><button type="submit"   class="btn btn-primary">Submit</button>
                      
                      <div class="col-lg-2"></div>

                    

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
                        <th>Rooms</th>
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

                        <td><?php echo $tariff->rooms_name;?></td>

                        <td><?php echo number_format($tariff->tariffs_caution_deposit,2);?></td>

                        <td><?php echo number_format($tariff->tariffs_admission_fees,2);?></td>
                       
                        <td><?php echo number_format($tariff->tariffs_price,2);?></td>
                        
                        <td>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Tariff/Edit/<?php echo $tariff->tariffs_id;?>"><i class="icon-base bx bx-edit-alt me-2"></i> </a>
                          <a class="dropdown-item" href="<?php echo base_url();?>Admin/Tariff/Delete/<?php echo $tariff->tariffs_id; ?>"><i class="icon-base bx bx-trash me-2"></i> </a>
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

              $('.build_clz').on('click',function(){

                var Id = $(this).val();

               

                $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/tariffRoomTypes",
                        type: "POST",
                        data: {ID :Id},
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.room_clz').html(data.rooms);

                         

                        }
                });

                
              });

            </script>


            
   
  </body>
</html>
