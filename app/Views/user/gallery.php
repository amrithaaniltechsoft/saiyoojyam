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

<?php echo view('user/includes/header'); ?>

<!--header section end-->


 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/gallery-banner.jpg">
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Gallery</h1>
    <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 
 
<div class="gallery-ss-sec">
  <div class="container">
    <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
      <h2 class="sec-title mb-20  ">Our <span>Gallery </span></h2>
	  
    </div>
	</div>
	<div class="container">
    
	  <div class="row">
		  <div class="col-lg-12" data-aos="zoom-in" data-aos-duration="800">
	      <div class="taxi-tab filter-menu-active">
          <button data-filter=".cat1" class="as-btn active" type="button">All</button>

          <?php $i=2; foreach($category as $cat){ ?>

            <button data-filter=".cat<?php echo $i;?>" class="as-btn" type="button"><?php echo $cat->buildig_namne; ?></button>

          <?php  $i++; } ?>
          
	      </div>
	    </div>
	  </div>
		
		
		 
		
		<div class="taxi-card-slide" data-aos="zoom-in" data-aos-duration="800">
      <div class="row  filter-active-cat1">
        
       
        
      <?php $i=2;  foreach($category as $cat){
             
        foreach($cat->cat_gallery as $gal){

       ?> 

        <div class="col-md-4 col-lg-3 col-sm-6 filter-item cat1 cat<?php echo $i; ?>">
          <div class="gallery-card">
            <div class="gallery-img"><div class="auccd"></div><img class="lazyload" data-src="<?php echo base_url();?>public/uploads/gallery/<?php echo $gal->gallery_path;?>" src="<?php echo base_url();?>public/uploads/gallery/thumbs/<?php echo $gal->gallery_path;?>" alt=""> <a href="<?php echo base_url();?>public/uploads/gallery/thumbs/<?php echo $gal->gallery_path;?>" class="gallery-btn popup-image"><i class="fas fa-image"></i></a></div>
            <div class="gallery-content">
          </div>
        </div>
      </div>


      <?php } $i++; } ?>

      

		</div>
	    </div>
		 
		
		
		
	 
</div>
</div>
 
<!--footer section start--->

<?php echo view('user/includes/footer');?>

<!--footer section end-->
	
 
</body>

</html>