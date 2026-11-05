<!doctype html>
<html class="no-js" lang="zxx">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?php if(!empty($seo->meta_title)){ echo $seo->meta_title;} else{ echo 'Saiyoojyam - Terms and Conditions'; }?></title>

<meta name="author" content="">
<meta name="description" content="<?php echo $seo->meta_desc ?? '';?>">
<meta name="keywords" content="<?php echo $seo->meta_key_word ?? '';?>">

<!--header section start-->
<?php echo view('user/includes/header'); ?>
<!--header section end-->

<div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/who-banner.jpg">
  <div class="container z-index-common">
    <h1 class="breadcumb-title">TERMS AND CONDITIONS</h1>
    <h2 class="breadcumb-intitle">Saiyoojyam - A Perfect Home for You</h2>
  </div>
</div>
 
<div class="Aboutarea-secinner py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="About-a-des">
          <div class="title-area mb-20">
            <h2 class="sec-title text-center"><?php echo esc($terms->title ?? $terms->cms_tittle ?? 'Hostel Rules, Terms & Conditions'); ?></h2>
          </div>

          <div class="terms-description mb-30" style="font-size: 16px; line-height: 1.8; color: #444;">
            <?php echo nl2br(esc($terms->small_description ?? $terms->cms_desc ?? '')); ?>
          </div>

          <?php if (!empty($terms->pdf_file)) { ?>
            <div class="text-center mt-4 p-4" style="background: #fdf6f0; border-radius: 12px; border: 1px dashed #ff5920;">
              <h4 style="color: #333; margin-bottom: 15px;">Download Complete Terms &amp; Conditions Document</h4>
              <a href="<?php echo base_url('public/uploads/terms/' . $terms->pdf_file); ?>" target="_blank" class="vs-btn style4" style="padding: 12px 28px; font-size: 15px;">
                <i class="fas fa-file-pdf me-2"></i> Download / View Terms PDF
              </a>
            </div>
          <?php } ?>
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
