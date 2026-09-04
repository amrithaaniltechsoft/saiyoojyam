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
                      <h5 class="mb-0">Edit SEO</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                         


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Page</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control"  value="<?php echo $seo->page; ?>"  readonly  required>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Title </label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="meta_title" value="<?php echo $seo->meta_title;?>"   required>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Description</label>
                          <div class="col-sm-10">
                              <textarea type="text" class="form-control" name="meta_desc"   required><?php echo $seo->meta_desc;?></textarea>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Keyword</label>
                          <div class="col-sm-10">
                              <textarea type="text" class="form-control" name="meta_key_word"   required><?php echo $seo->meta_key_word;?></textarea>
                          </div>
                        </div>



                       
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
                          </div>
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

              /*fetch room by building*/

                $(".build_clz").on('change', function(){ 

                  var Id =  $('.build_clz').val();

                  $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/RoomTypes",
                        type: "POST",
                        data: {ID :Id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.room_clz').html(data.rooms);

                         

                        }
                  });

                
    
                });

                 


              /*end section*/

            </script>

            

   
  </body>
</html>
