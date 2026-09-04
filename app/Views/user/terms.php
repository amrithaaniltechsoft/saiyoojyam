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


 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/who-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">TERMS AND CONDITIONS</h1>
 <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 
 
   <div class="Aboutarea-secinner ">

<div class="container">
 
<div class="row  align-items-center ">
 
<div class="col-lg-12">
<div class="About-a-des">
 <div class="title-area mb-20  ">
 
      <h2 class="sec-title text-center"><?php echo $terms->cms_tittle; ?></h2>
    </div>

     <?php echo $terms->cms_desc; ?>

</div>

</div>
 



</div>

</div>

</div>

<!---footer secion start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->
 
</body>

</html>