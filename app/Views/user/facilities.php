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


 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/facilities-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Facilities  </h1>
 <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 
 
 <div class="facilities-innersec">
 
 <div class="container">
 
 
<div class="row justify-content-between align-items-center">
     <div class="col-md-12 col-lg-6 ">
                      <div class="about-imgt">
                                <img src="<?php echo base_url();?>public/assets/img/about-img-01.png" alt="Image" class="aa-img-one">
                                <img src="<?php echo base_url();?>public/assets/img/about-img-02.jpg" alt="Image" class="aa-img-two">
                                 <img src="<?php echo base_url();?>public/assets/img/about-img-03.jpg" alt="Image" class="aa-img-three">
                            </div>
                    
                     
                     </div>
                     <div class="col-md-12 col-lg-6 ">
					              <div class="ff-content ">
                          <div class="section-title style1  mb-20">
                            <h2>Our Facilities</h2>
                          </div>
                          
                          <?php echo $facilities->facilities_description;?>


				               </div>
                     </div>
                  
                  </div>
 </div>
 
 
 </div>
 
 
 <div class="facility-videosec">
 <div class="container">
 <div class="row justify-content-center">
 
  <div class="col-lg-6 col-md-6">
 <div class="download-video">
 <video width="100%" >
 <source src="<?php echo base_url();?>public/assets/img/facilities/video1.mp4" type="video/mp4">
  <source src="mov_bbb.ogg" type="video/ogg">
  

  
  
</video>
<div class="d-video-hover">
 <a href="<?php echo base_url();?>public/assets/img/facilities/video1.mp4" class="play-btn style3 popup-video" tabindex="-1"><i class="fas fa-play"></i></a></div>
 </div>
 
 </div>
  <div class="col-lg-6 col-md-6">
 <div class="download-video">
 <video width="100%" >
 <source src="<?php echo base_url();?>public/assets/img/facilities/video2.mp4" type="video/mp4">
  <source src="mov_bbb.ogg" type="video/ogg">
  

  
  
</video>
<div class="d-video-hover">
 <a href="<?php echo base_url();?>public/assets/img/facilities/video2.mp4" class="play-btn style3 popup-video" tabindex="-1"><i class="fas fa-play"></i></a></div>
 </div>
 
 </div>
 
 </div>
 
 
 </div>
 
 
 <div>


<!--footer section start-->

<?php echo view('user/includes/footer');?>

<!--footer section end-->
  
	
 
</body>

</html>