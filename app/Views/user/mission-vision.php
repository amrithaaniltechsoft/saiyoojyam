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

 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/mission-vision-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Mission & Vision </h1>
 <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 
 
   <div class="mission-vv-secinner ">

<div class="container">
 
<div class="row  align-items-center ">
 <div class="col-lg-6">
<div class="mi-a-img">
<img class="lazyload" data-src="<?php echo base_url();?>public/uploads/cms/<?php echo $mission->cms_img;?>" src="<?php echo base_url();?>public/uploads/cms/thumbs/<?php echo $mission->cms_img;?>" alt="" width="100%">
 
</div>

</div>
<div class="col-lg-6">
<div class="mis-a-des">
 <div class="title-area mb-20  ">
 
      <h2 class="sec-title  "><?php echo $mission->cms_tittle;?></h2>
    </div>
     <?php echo $mission->cms_desc; ?>
</div>

</div>
 

</div>
<div class="row  align-items-center ">
<div class="col-lg-6 mi-order2">
<div class="vis-a-des">
 <div class="title-area mb-20  ">
 
      <h2 class="sec-title  "><?php echo $vision->cms_tittle; ?></h2>
    </div>
    <?php echo $vision->cms_desc; ?>
</div>

</div>
 <div class="col-lg-6 mi-order1">
<div class="mi-a-img">
<img class="lazyload" data-src="<?php echo base_url();?>public/uploads/cms/<?php echo $vision->cms_img;?>" src="<?php echo base_url();?>public/uploads/cms/thumbs/<?php echo $vision->cms_img;?>" alt="" width="100%">
 
</div>

</div>

 

</div>

</div>

</div>


<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->
  
	
 
</body>

</html>