<!doctype html>
<html class="no-js" lang="zxx">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?php if(!empty($seo->meta_title)){ echo $seo->meta_title;} else{ 'Saiyoojyam'; }?></title>

<meta name="author" content="">
<meta name="description" content="<?php echo $seo->meta_desc;?>">
<meta name="keywords" content="<?php echo $seo->meta_key_word;?>">


<!--header section start-->

<?php echo view('user/includes/header');?>

<!--header section end-->

 
<div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>assets/img/banner/rooms-c-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title"><?php echo $room_building->building_name; ?></h1>
    <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 

<div class="room-inner-sec">
  <div class="container">
    <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
    </div>
	</div>
	<div class="container ">
	  <div class="row ">
		  <div class="col-lg-12 " data-aos="zoom-in" data-aos-duration="800">
	
	      <div class="taxi-tab filter-menu-active">
          <button data-filter=".cat1" class="as-btn active" type="button">All Rooms </button>
          <?php $i = 2; foreach($rooms_type as $room_type){?> 
          <button data-filter=".cat<?= $i ?>" class="as-btn" type="button"><?php echo $room_type->room_type_name; ?></button>
          <?php $i++; } ?>
         
	  
        </div>
	    </div>
	  </div>
		
		
		 
		
		<div class="taxi-card-slide" data-aos="zoom-in" data-aos-duration="800">
      <div class="row    filter-active-cat1">
        <?php $i = 2; foreach($rooms_type as $room_type){ 
              foreach($room_type->rooms as $room){  
        ?> 
		    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6  filter-item cat1 cat<?= $i ?>">
          <div class="th-product product-grid">
            <div class="product-img">
              <?php if(!empty($room->rooms_image)){ ?> 
              <img src="<?= base_url('public/uploads/rooms/'.$room->rooms_image) ?>" alt=" ">
			        <?php } else{ ?> 
                <img src="<?php echo base_url();?>public/assets/img/logo.png" alt="" style="object-fit: contain;"> 
              <?php } ?>
 
            </div>
            <div class="product-content"> 
	            <h3 class="product-title"><a href="<?php echo base_url();?>Room/<?php echo $room->rooms_slug; ?>"><?php echo $room->rooms_name; ?></a></h3>
			        
            </div>
			      <div class="product-bb-btns">
			        <a href="<?php echo base_url();?>Room/<?php echo $room->rooms_slug; ?>" class="as-btn style7"> Book Now</a>
			      </div>
          </div>
        </div>
        <?php } $i++;}  ?>


	  
	 
	  	 	
	  



	  


			</div>
    </div>
		 
		
</div>
</div>


<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->
	
 
</body>

</html>