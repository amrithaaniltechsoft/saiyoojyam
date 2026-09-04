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

<div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/rooms-s-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title"><?php echo $room_type->room_type_name;?></h1>
    <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
<div class="room-inner-sec">
  <div class="container">
    <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
      <h2 class="sec-title mb-20">  <span> <?php echo $room_type->room_type_name;?> </span></h2>
	  
    </div>
	</div>



	<div class="container">

	  <div class="row justify-content-center">
        
      <?php foreach($rooms as $room){ ?> 

      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">

        <div class="th-product product-grid">

          <div class="product-img">
            <?php if(!empty($room->rooms_image)){ ?> 
            <img class="lazyload" data-src="<?php echo base_url();?>uploads/rooms/<?php echo $room->rooms_image; ?>" src="<?php echo base_url();?>uploads/rooms/thumbs/<?php echo $room->rooms_image; ?>" alt=" ">
			    <?php } else{ ?> 
             <img src="<?php echo base_url();?>public/assets/img/logo.png" alt="" style="object-fit: contain;"> 
              <?php } ?>
          </div>

          <div class="product-content"> 
			      <h3 class="product-title"><a href="room-detail.html"><?php echo $room->rooms_name;?></a></h3>
			      <p><?php echo substr(strip_tags($room->rooms_description),0,80); ?></p>
          </div>

          <div class="product-bb-btns">
            <a href="<?php echo base_url();?>Room/<?php echo $room->rooms_slug;?>" class="as-btn style7">Book Now</a>
          </div>

        </div>

      </div>

      <?php } ?>
	  
	 
		</div>

	</div>
		
		
		 
		 
</div>
 
<!--footer section start-->

<?php echo view('user/includes/footer');?>

<!--footer section end-->
  
	
 
</body>

</html>