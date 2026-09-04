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


 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/c-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Contact Us</h1>
 <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
 <div class=" Contact-sec"  >
  <div class="container">
  
 <div class="title-area text-center">
      <h2 class="sec-title mb-20 ">Get in <span>Touch </span></h2>
	  
    </div>
	
	
  <div class="row coniuy justify-content-center sebox">
      <div class="col-lg-4 col-md-6 col-md-6 d-flex">
       <div class=" style-eight">
                  <div class="service-box-icon"> <i class="fas fa-location-dot"></i></div>
                  <div class="service-content">
                    <h3>Address</h3>
                    <p><?php echo $contact->contact_adress; ?></p>
                  </div>
                </div>
      </div>
	   
      <div class="col-lg-4 col-md-6 col-md-6 d-flex">
        <div class=" style-eight">
                  <div class="service-box-icon"> <i class="fas fa-phone"></i> </div>
                  <div class="service-content">
                    <h3>Call Us</h3>
                    <p><a href="tel:<?php echo $contact->contact_phone1; ?>"  > </a><?php echo $contact->contact_phone1; ?></p>
                    <p><a href="tel:<?php echo $contact->contact_phone2; ?> "  ><?php echo $contact->contact_phone2; ?></a></p>
                    
					
					
                  </div>
                </div>
      </div>
	  
	   <div class="col-lg-4 col-md-6 col-md-6 d-flex">
        <div class=" style-eight">
                  <div class="service-box-icon"> <i class="fal fa-envelope"></i> </div>
                  <div class="service-content">
                    <h3>Email Us</h3>
                   
					    <p > <a href="mailto:<?php echo $contact->contact_email1; ?>"  ><?php echo $contact->contact_email1; ?></a></p>
						  
                  </div>
                </div>
      </div>
     
      
    </div>
  
  
  
     
    </div>
  
  
  
    
  </div>
</div>


<section class="Contact-areain"  >
  <div class="container">
    <div class="row text-center justify-content-center">
	  <div class="col-lg-8 col-md-10">
    <div class="title-area text-center">
      <h2 class="sec-title">Sent a <span>Message</span></h2>
	  	<p class="text-center">If you have any urgent matter to discuss or some questions that need immediate answers - get in touch with us !</p>
	
    </div>

	</div>
		</div>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-md-12">
        <form action="#" method="POST" class="Contactpage-form contact-form ajax-contact">
          <div class="row">
            <div class="form-group col-md-4">
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" required>
              <i class="fal fa-user"></i></div>
            <div class="form-group col-md-4">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
              <i class="fal fa-envelope"></i></div>
             <div class="form-group col-md-4">
              <input type="text" class="form-control" name="phone"   placeholder="Phone No" required>
              <i class="fal fa-phone"></i></div>
			    
           
            <div class="form-group col-12">
              <textarea name="message" id="message" cols="30" rows="3" class="form-control"  required placeholder="Message"></textarea>
              <i class="fal fa-comment"></i></div>
            <div class="form-btn col-12 mt-10 text-center">
              <button class="as-btn">Send Message Now</button>
            </div>
          </div>
        
        </form>
      </div>
    </div>
	
	   </div>
	 
</section>


<div class="Maparea-sec">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1964.5177523668854!2d76.35017666347655!3d10.013926000000016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b080d42064f8335%3A0xda4cdedd9ad56ec7!2sSaiyoojyam%20Ladies%20Hostel!5e0!3m2!1sen!2sin!4v1747380784556!5m2!1sen!2sin" width="100%" height="370" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

</div>
 

  <!--footer section start-->
   
  <?php echo view('user/includes/footer'); ?>

  <!--footer section end-->
  
	
 
</body>

</html>