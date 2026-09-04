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
                      <h5 class="mb-0">Edit Room Types</h5>
                      
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">

                          <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="" value="<?php echo $rooms->building_name; ?>"   required readonly>
                          </div>
                        </div>

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Type</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="" value="<?php echo $rooms->room_type_name; ?>"   required readonly>
                          </div>
                        </div>
                        


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Room Name</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="" value="<?php echo $rooms->rooms_name; ?>"   required readonly>
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Description</label>
                          <div class="col-sm-10">
                             <textarea id="contentDetails" name="rooms_description"><?php echo $rooms->rooms_description;?></textarea>
                          </div>
                        </div>

                         <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Slug</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="rooms_slug" value="<?php echo $rooms->rooms_slug; ?>"   required >
                          </div>
                        </div>-->


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Title</label>
                          <div class="col-sm-10">
                              <textarea type="text" class="form-control" name="rooms_meta_title" required ><?php echo $rooms->rooms_meta_title; ?></textarea>
                          </div>
                        </div>

                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Description</label>
                          <div class="col-sm-10">
                              <textarea type="text" class="form-control" name="rooms_meta_description" required ><?php echo $rooms->rooms_meta_description; ?></textarea>
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Meta Keyword</label>
                          <div class="col-sm-10">
                              <textarea type="text" class="form-control" name="rooms_meta_keyword" required ><?php echo $rooms->rooms_meta_keyword; ?></textarea>
                          </div>
                        </div>

                        

                        
                        <?php if(!empty($rooms->rooms_image)){ ?> 

                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name"> Image</label>
                          <div class="col-sm-10">
                            <img src="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $rooms->rooms_image; ?>" class="edit_image">
                          </div>
                        </div>

                        <?php  } ?>




                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Update Image</label>
                          <div class="col-sm-10">
                            <input class="form-control" name="rooms_image" type="file" id="image_upload" onchange="Filevalidation()" />
                          </div>
                        </div>


                         


                        <?php $feature = explode(',',$rooms->rooms_features); ?>
                        <div class="row mb-6" style="border: 1px solid #00000030;">
                          <label style="padding: 15px 20px;">Features:</label>  
                           <?php foreach($features as $feat){?> 
                          <div class="col-sm-2" style="margin-bottom: 15px;">
                             <img src="<?php echo base_url();?>public/uploads/feature/<?php echo $feat->feature_image; ?>" class="">
                             <!-- Checkbox added here -->
                            <div class="form-check mt-2">
                              <input class="form-check-input" name="checkbox[]" type="checkbox" value="<?php echo $feat->feature_id;?>" <?php if(in_array($feat->feature_id ,$feature)){echo "checked"; }?> id="cautionCheck" name="" >
                              <label class="form-check-label" for="cautionCheck">
                                <?php echo $feat->feature_name;?>
                              </label>
                            </div>
                              <!----> 
                          </div>
                          <?php } ?>

                        </div>


                        <!--more image section start-->

                         <div class="row mb-6">
                            <div class="col-sm-2 col-form-label">
                              <label>  More Images<br /><br /></label>
                            </div>
                            <div class="col-xs-12 col-sm-9 row-seperate field_wrapper">
                              
                              <?php 
                              foreach($more_image as $more):
                              ?>

                                <a href="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $more->more_image_name;?>" class="fancybox-media">
                                <img src="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $more->more_image_name;?>" style="width:300px;height:300px;border: 1px solid #ccc;"></a> 
                                <a style="color: red;font-weight: 600;font-size: 15px;" href="<?php echo base_url();?>admin/Rooms/Deletemore/<?php echo $more->more_image_id ;?>" onclick="return confirm('Are you absolutely sure you want to delete?');"><img src="<?php echo base_url();?>assets/admin/img/remove-icon.png"/ ></a>
                                                                          
                              <?php 
                              endforeach
                              ?>
                                                            
                              <input class="form-control" name="document_more[]"  type="file" multiple style="width:40%;display:inline-block;margin-top: 24px;">
                              Add More: &nbsp&nbsp;
                              <a href="javascript:void(0);" class="add_button" title="Add field">
                                <img src="<?php echo base_url();?>assets/admin/img/add-icon.png"/>
                              </a><br /><br />
                            </div>
                          </div>
                                  

                        <!--more image section end-->


                       





                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Capacity</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" name="rooms_capacity" value="<?php echo $rooms->rooms_capacity;?>"  required>
                          </div>
                        </div>--->


                        <!--<div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Ac Type</label>
                          <div class="col-sm-10">
                            <select id="defaultSelect" name="rooms_ac_type" class="form-select" required>
                              
                              <option value="Non-AC" <?php if($rooms->rooms_ac_type == 'Non-AC'){echo "selected";}?>>Non-AC</option>
                              <option value="AC" <?php if($rooms->rooms_ac_type == "AC"){echo "selected";}?>>AC</option>
                              
                            </select>
                          </div>
                        </div>-->



                      
                       
                        
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


            <!--image size validation start--->
          
            <script>
                Filevalidation = () => 
                {
                    const fi = document.getElementById('image_upload');
                    // Check if any file is selected.
                    if (fi.files.length > 0) 
                    {
                        for (const i = 0; i <= fi.files.length - 1; i++) {

                            const fsize = fi.files.item(i).size;
                            const file = Math.round((fsize / 1024));
                            // The size of the file.
                            if (file >= 1096) 
                            {
                                alert(
                                    "File too Big, please select a file less than 1mb");
                                $("#image_upload").val('');
                            } 
                        }
                    }
                }
            </script> 


            
          <!--add more image start-->

            <script type="text/javascript">
	            $(document).ready(function(){
		            var maxField = 10; //Input fields increment limitation
		            var addButton = $('.add_button'); //Add button selector
		            var wrapper = $('.field_wrapper'); //Input field wrapper
		            var fieldHTML = '<div> <input class="form-control" name="document_more[]" multiple type="file" required style="width:40%;display:inline-block">&nbsp&nbsp;<a href="javascript:void(0);" class="remove_button" title="Remove field">&nbsp;<img src="<?php echo base_url();?>assets/admin/img/remove-icon.png"/></a></div><br>'; //New input field html 
		            var x = 1; //Initial field counter is 1
		            $(addButton).click(function(){ //Once add button is clicked
			          if(x < maxField){ //Check maximum number of input fields
				          x++; //Increment field counter
				          $(wrapper).append(fieldHTML); // Add field html
			          }
		          });
		          $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
			          x--; //Decrement field counter
		          });
	          });
          </script>

          <!--add more image end-->

            

   
  </body>
</html>
