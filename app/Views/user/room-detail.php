<!doctype html>
<html class="no-js" lang="zxx">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?php if(!empty($rooms->rooms_meta_title)){ echo $rooms->rooms_meta_title;} else{ 'Saiyoojyam'; }?></title>

<meta name="author" content="">
<meta name="description" content="<?php echo $rooms->rooms_meta_description	;?>">
<meta name="keywords" content="<?php echo $rooms->rooms_meta_keyword;?>">


<!--header section start-->

<?php echo view('user/includes/header');?>

<!--header section end-->


<div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/rooms-d-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title"><?php echo $rooms->room_type_name; ?></h1>
    <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>


<div class="room-detail-ssec">

  <div class="container">

    <div class="row justify-content-center ">

      <div class="col-lg-7">

        <div class="rooleft">

        <div class="room-imgd">

          <?php if(!empty($rooms->rooms_image)){ ?> 
          
          <img class="lazyload" data-src="<?php echo base_url();?>public/uploads/rooms/<?php echo $rooms->rooms_image;?>" src="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $rooms->rooms_image;?>" width="100%" alt=" ">
          
          <?php } else{ ?> 

            <img src="<?php echo base_url();?>public/assets/img/logo.png" alt=" " style="object-fit: contain;"> 
          
            
          <?php } ?>

          <div class="title-area mb-15" data-aos="zoom-in" data-aos-duration="800">
 
            <h2 class="sec-title"><?php echo $rooms->rooms_name;?>(<?php echo $rooms->room_type_name; ?>)</h2>

          </div>
	        
          <?php echo $rooms->rooms_description; ?>

        </div>
         
        <?php if(!empty(array_filter($features_data))){ ?> 
        <h3 class="room-ss-title">Features</h3>
       
        
        <div class="row">
 
          <?php  foreach($features_data as $feat_data){   ?> 

          <div class="col-lg-3 col-md-4 col-sm-6 col-6 d-flex">

            <div class="room-ff-box">
              <div class="room-ff-box-icon">
                <img src="<?php echo base_url();?>public/uploads/feature/<?php echo $feat_data->feature_image;?>" alt=""> 
              </div>
              <h3><?php echo $feat_data->feature_name;?></h3>
            </div>

          </div>

          <?php }   ?>

        </div>

        <?php }  ?>
       
        <?php if(!empty($more_images)){ ?> 
        <h3 class="room-ss-title">More Images</h3>

        <div class="row">

        <?php foreach($more_images as $more_img){?> 

        <div class="col-lg-4 col-md-4 col-sm-6 d-flex">
          <div class="gallery-card">
            <div class="gallery-img"> 
              <img class="lazyload" data-src="<?php echo base_url();?>public/uploads/rooms/<?php echo $more_img->more_image_name; ?>" src="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $more_img->more_image_name; ?>" alt=""> <a href="<?php echo base_url();?>public/uploads/rooms/<?php echo $more_img->more_image_name; ?>" class="gallery-btn popup-image"><i class="fas fa-image"></i></a>
            </div>
            <div class="gallery-content">
            
            </div>
          </div>
        </div>

        <?php } ?>

      </div>

      <?php } ?>



    </div>

  </div>

  <div class="col-lg-5 col-md-5">

    <div class="rooright">

      <form action="<?php echo base_url();?>Checkout" method="POST" class="RContactpage-form  ">

        <h3>Book Now</h3>
        <div class="row">


          <div class="form-group col-md-12 col-lg-6">
            <label>Building</label>
			      <input type="text" value="<?php echo $rooms->building_name; ?>" readonly>
			    </div>


          <div class="form-group col-md-12 col-sm-12 col-lg-6">
            <label>No. Persons</label>
            <div id="field1" class="field"> 
              <button type="button" id="sub" class="sub">-</button>
              <input type="text" name="person" id="1" value="1" class="field" min="1" max="<?php echo $rooms->rooms_capacity; ?>" required/>
              <button type="button" id="add" class="add">+</button>
            </div>
          </div>

          <div class="form-group col-md-12 col-lg-6">
            <label>Duration of Stay</label>
            <select name="buiding" class="form-control duration_of_stay" required>  
              <option value="" selected="" disabled=""> Duration of Stay</option>
              
              <?php foreach($duration_of_stay as $dur_of_day){ ?> 

                <option value="<?php echo $dur_of_day->duration_id; ?>"><?php echo $dur_of_day->duration_stay; ?></option>

              <?php } ?>
              
            </select>
			    </div>




          <div class="form-group col-md-12 col-lg-6">
            <label>Check In Date</label>
            <input type="date" name="check_in_date" id="check_in-date-input" onclick="showPicker()"  placeholder="Check In Date" value="" required/>
			    </div>


          <div class="form-group col-md-12 col-lg-6 check_out_div" style="display:none;">
            <label>Check Out  Date</label>
            <input type="date" name="check_out_date" id="check_out-date-input" onclick="showPicker()"  placeholder="Check Out Date" value=""/>
			    </div>


          
          <input type="hidden" name="room_id"  value="<?php echo $rooms->rooms_id; ?>">
			      
          <div class="form-btn col-12 mt-10 ">
            <button type="submit" class="as-btn">Check</button>
          </div>



        </div>
        
      </form>
    </div>

   </div>

</div>


</div>

</div>
 
<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
  $(function() {
     $("#datepicker").datepicker({
		 dateFormat : 'dd/mm/yy'
           
    });
	 
	});

</script>



<script>
    $(function() {
      $("#datepicker2").datepicker({
		    dateFormat : 'dd/mm/yy'
      });
	  });

</script>



<!--<script type="text/javascript">
  $(function() {
    $('input[name="datefilter"]').daterangepicker({
      opens: 'left',
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('ddd DD MMM YYYY') + ' - ' + picker.endDate.format('ddd DD MMM YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  });
</script>--->


<!--<script>
  $('.add').click(function () {
    $(this).prev().val(+$(this).prev().val() + 1);
  });
  $('.sub').click(function () {
    if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
  });
</script>-->


<script>
  $('.add').click(function () {
    var input = $(this).prev('.field');
    var current = parseInt(input.val());
    var max = parseInt(input.attr('max'));

    if (current < max) {
      input.val(current + 1);
    }
  });

  $('.sub').click(function () {
    var input = $(this).next('.field');
    var current = parseInt(input.val());
    var min = parseInt(input.attr('min'));

    if (current > min) {
      input.val(current - 1);
    }
  });
</script>

<script>
  /*show check out date*/

    $(".duration_of_stay").on('change',function(){
        
      var Id = $('.duration_of_stay').val();

      if(Id === "1"){
        
        $('.check_out_div').show()
      
      }else{

        $('.check_out_div').hide()
      }
        
    });

  /*end section*/

</script>


<script>
  
  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("check_in-date-input").setAttribute("min", today);
  });

  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("check_out-date-input").setAttribute("min", today);
  });

</script>



</body>

</html>