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


<style>

.packagetable table tbody tr td{

  width: 25%;

}

</style>

<div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/tariff-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Tariff </h1>
    <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 
<div class="tariff-innersec">
  <div class="container">
    <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
      <h2 class="sec-title mb-20"><?php echo $tariffs->cms_tittle; ?></h2>
	  </div>
    <div class="report-sec">
	    <div class="packagetable">
        <?php echo $tariffs->cms_desc;?>
      </div>
		</div>
  </div>
</div>



<!--footer section start-->

<?php echo view('user/includes/footer');?>

<!--footer section end-->


  
	
 
</body>

</html>