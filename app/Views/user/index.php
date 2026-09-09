<!doctype html>
<html class="no-js" lang="zxx">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Saiyoojyam</title>
<meta name="author" content="">
<meta name="description" content="Saiyoojyam: A perfect home for you is a newly built five-storied ladies hostel with elevator and all modern facilities having the capacity to accommodate more than 250 persons.  It is situated in a very secure and serene location in Kusumagiri, Kakkanad, adjacent to Noel Greenature Apartments. ">
<meta name="keywords" content="Ladies Hostel near Infopark">

  <!---header section start--->
  
  <?php echo view('user/includes/header');?>

  <!---header section end--->





	<div class="as-hero-wrapper hero-1">
  <div class="hero-slider-1 as-carousel" data-fade="true" data-autoplay="true" data-autoplay-speed="3500" data-slide-show="1" data-md-slide-show="1" >

    <!--banner section start-->

    <div class="as-hero-slide">
     <img src="<?php echo base_url();?>public/assets/img/banner1.jpg" data-ani="slideinleft" data-ani-delay="0.1s" class="bann-img" alt="" width="100%">
      <div class="container">
       <div class="hero-style1">
		 <div class="Banner-slide" >
          <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.3s"><span>Saiyoojyam</span><br/>
										a perfect home for you</h1>
		  <!--<p class="hero-text " data-ani="slideinup" data-ani-delay="0.1s" >Newly built ladies hostel complex with elevator and all modern facilities, having the capacity to accommodate more than 100 persons. </p>-->
        </div>
        </div>
      </div>
    </div>

    <div class="as-hero-slide">
       <img src="<?php echo base_url();?>public/assets/img/banner2.jpg" data-ani="slideinleft" data-ani-delay="0.1s" class="bann-img" alt="" width="100%">
	    <div class="Banner-slide" >
      <div class="container">
        <div class="hero-style1">
            <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.3s"> <span>Saiyoojyam</span><br>
								a perfect home for you</h1>
		  <!--<p class="hero-text" data-ani="slideinup" data-ani-delay="0.1s" >Newly built ladies hostel complex with elevator and all modern facilities, having the capacity to accommodate more than 100 persons. </p>-->
     </div>
        </div>
      </div>
    </div>

    <div class="as-hero-slide">
       <img src="<?php echo base_url();?>public/assets/img/banner3.jpg" data-ani="slideinleft" data-ani-delay="0.1s" class="bann-img" alt="" width="100%">
	    <div class="Banner-slide" >
      <div class="container">
        <div class="hero-style1">
            <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.3s"> <span>Saiyoojyam</span><br>
									a perfect home for you</h1>
		            <!--<p class="hero-text" data-ani="slideinup" data-ani-delay="0.1s" >Newly built ladies hostel complex with elevator and all modern facilities, having the capacity to accommodate more than 100 persons. </p>-->
          </div>
        </div>
      </div>
    </div>

    <!--banner section end-->

   
   
 
 
</div>
				
				
                   
                </div>
	
	
	
	

 

<div class="Aboutarea-sec"   id="WelcomeSec">

<div class="container">
   <div class="title-area mb-30 text-center   " data-aos="zoom-in" data-aos-duration="800">
 
      <h2 class="sec-title"><?php echo $about->cms_tittle;?></h2>
    </div>
<div class="row   ">

<div class="col-lg-5" data-aos="zoom-in" data-aos-duration="800">
<div class="About-a-des">
<?php echo $about->cms_desc;?>
<div class="text-cnter">

<div class="btn-group justify-content-center">
<a href="<?php echo base_url();?>About" class="as-btn style7" ><span class="btn-text">
							Read More
							</span></a>
							
							<a href="<?php echo base_url();?>Rooms" class="as-btn style7"><span class="btn-text">
								Book Now
							</span></a>

</div>
</div>

</div>

</div>
 
<div class="col-lg-4" data-aos="zoom-in" data-aos-duration="800">
<div class="About-a-img">
<img src="<?php echo base_url();?>uploads/cms/<?php echo $about->cms_img;?>">
 
</div>

</div>
<div class="col-lg-3" data-aos="zoom-in" data-aos-duration="800">
<div class="row ">
 <div class="col-lg-12 col-md-12 col-sm-12 d-flex">
<div class="Ceworkforce-box  " data-aos="zoom-in" data-aos-duration="800">
<div class="Cework-box-content">
<div class="Cework-box-img d-flex align-items-center">

<img src="<?php echo base_url();?>public/assets/img/mission.png" alt="">
<h3><?php echo $mission->cms_tittle;?></h3>
</div>

<?php echo $mission->cms_desc;?>

</div>
</div>
</div>
 <div class="col-lg-12 col-md-12 col-sm-12 d-flex">
<div class="Ceworkforce-box  " data-aos="zoom-in" data-aos-duration="800">

<div class="Cework-box-content">
<div class="Cework-box-img d-flex align-items-center">

<img src="<?php echo base_url();?>public/assets/img/vision.png" alt="">
<h3><?php echo $vision->cms_tittle;?></h3>
</div>
		 
<?php echo $vision->cms_desc;?>
</div>
</div>
</div>


	   
 

</div>

</div>
</div>



</div>

</div>

<div class="marquee-section">
    <div class="marquee"   >
      <ul class="marquee-group">
        <li class="list-inline-item">AC Rooms</li>
        <li class="list-inline-item">Non A/C Rooms</li>
          <?php foreach($room_types as $room_type){ ?>        
            <li class="list-inline-item"><?php echo $room_type->room_type_name; ?></li>
          <?php } ?>  
                   
                    
					</ul>
       
      </div>

      
    </div>
  </div>
 



<div class="Work-sec">
  <div class="container">
    <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
      <h2 class="sec-title mb-20  ">Our <span>Rooms </span></h2>
	  </div>
	</div>
	<div class="container">
	  <div class="row ">
		  <div class="col-lg-12" data-aos="zoom-in" data-aos-duration="800">
        <div class="taxi-tab filter-menu-active">
          <button data-filter=".cat1" class="as-btn active" type="button">All Rooms</button>

          <?php $i = 2; foreach ($building as $build) { ?>
            <button data-filter=".cat<?= $i ?>" class="as-btn" type="button">
              <?= $build->building_name ?>
            </button>
          <?php $i++; } ?>
         
	      </div>
	    </div>
	  </div>
		
		<div class="taxi-card-slide" data-aos="zoom-in" data-aos-duration="800">
      <div class="row    filter-active-cat1">
      
        <!----->
        <?php $i = 2; foreach ($building as $build) { ?>

          <?php foreach ($build->build_rooms_type as $type) { ?>

            <?php foreach ($type->rooms as $room) { ?>

             

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 filter-item cat1 cat<?= $i ?>">
                  <div class="th-product product-grid">

                    <div class="product-img">
                        <?php if(!empty($room->rooms_image)){ ?> 
                        <img src="<?= base_url('public/uploads/rooms/'.$room->rooms_image) ?>" alt="">
                        <?php } else{ ?> 
                          <img src="<?php echo base_url();?>public/assets/img/logo.png" alt="" style="object-fit: contain;"> 
                        <?php } ?>
                        
                    </div>

                    <div class="product-content">

                        <h3 class="product-title">
                            <a href="<?= base_url('Room/'.$room->rooms_slug) ?>">
                              Room <?= $room->rooms_name ?>
                            </a>
                        </h3>

                        <p><?= $room->rooms_description ?></p>
                        
                    </div>

                    <div class="product-bb-btns">
                        <a href="<?= base_url('Room/'.$room->rooms_slug) ?>" class="as-btn style7">
                          Book Now
                        </a>
                    </div>
                    

                  </div>
                </div>

              

            <?php } ?>

          <?php } ?>

        <?php $i++; } ?>
        <!----->

	  
	    </div>
    </div>
		 
		
	</div>
</div>






<div class="Service-mmsec  home-three ">


<div class="container">

<div class="row justify-content-center ">

<div class="col-lg-12">
<div class="title-area mb-35 text-center" data-aos="zoom-in" data-aos-duration="800">
 
            <h2 class="sec-title  ">Our  <span>Facilities </span></h2>
			
			
          </div>

</div>

</div>


<div class="row  justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-6" data-aos="zoom-in" data-aos-duration="800" >
					<div class="single-offer-box">
						<div class="single-offer-thumb">
							<img src="<?php echo base_url();?>public/assets/img/facilities/f1.jpg" alt="">
						</div>
						
						<div class="offer-content">
							<h4>Rooms

</h4>
						<p>Thirty six (36) well-furnished rooms (each with a space of 24 sq m) with attached bathrooms with rain shower. Kitchen facilities include a large cooking area plus modular kitchen and pantry.
</p><a href="<?php echo base_url();?>Facilities">Read More</a>
						</div>
						<div class="offer-bottom-title">
							<h4>Rooms

 </h4>
						</div>
					</div>
				</div>	
					 <div class="col-lg-4 col-md-6 col-sm-6"  data-aos="zoom-in" data-aos-duration="800">
					<div class="single-offer-box">
						<div class="single-offer-thumb">
							<img src="<?php echo base_url();?>public/assets/img/facilities/f5.jpg" alt="">
						</div>
						
						<div class="offer-content">
							<h4>Security

</h4>
							<p>The whole complex and surroundings is equipped with modern CCTV cameras, in addition to experienced security personnel providing round-the-clock security.
</p>
							<a href="<?php echo base_url();?>Facilities">Read More</a>
						</div>
						<div class="offer-bottom-title">
							<h4>Security

 </h4>
						</div>
					</div>
				</div>	 
 
				
				<div class="col-lg-4  col-md-6 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
					<div class="single-offer-box">
						<div class="single-offer-thumb">
							<img src="<?php echo base_url();?>public/assets/img/facilities/f3.jpg" alt="">
						</div>
						
						<div class="offer-content">
							<h4>
Food

</h4>
						<p>Vegetables, dairy products, chicken and fish will be home-grown and totally reliable in quality. Special food will be served for occupants with health-related issues.
</p><a href="facilities.html">Read More</a>
						</div>
						<div class="offer-bottom-title">
							<h4>Food

</h4>
						</div>
					</div>
				</div>	
		 
			
			 	 
				</div>	
	  
    </div>

 
					
					<div class="text-center mt-10" data-aos="zoom-in" data-aos-duration="800">
				<a href="<?php echo base_url();?>Facilities" class="as-btn style7" tabindex="0"><span class="btn-text">
								Explore all Facilities 
							</span></a>
				
				</div>

</div>
</div>
<div class="nee-sec" data-bg-src="<?php echo base_url();?>public/assets/img/dn-bg.jpg">
<div class="container">
<div class="row justify-content-center">

<div class="col-lg-8" data-aos="zoom-in" data-aos-duration="800">
<div class="text-center ppghgh">
<div class="title-area mb-15 text-center">
 
            <h2 class="sec-title text-white ">Neighbourhood  <span>Facilities </span></h2>
			
			
          </div>
		  
		  <p>Saiyoojyam is located at close proximity to the Collectorate, Info Park, Sunrise Hospital, Wonderla Amusement Park, Rajagiri College and Hospital, Thrikkakara Temple, and few kms from Kadambrayar Boating Center and Eco Village.</p>

</div>
</div>
</div>

  <div class="counter-sec3">
    <div class="row gy-40 justify-content-between">

      <?php foreach(array_slice($cms_data,4,4) as $cms){ ?> 

      <div class="col-xl-auto col-lg-auto col-md-6  col-sm-6 counter-divider2" data-aos="zoom-in" data-aos-duration="800">
        <div class="counter-card">
          <div class="counter-card_icon"><img src="<?php echo base_url();?>public/uploads/cms/<?php echo $cms->cms_img;?>" alt="img"></div>
          <div class="counter-card_content">
            <h2 class="counter-card_number"><span class="counter-number"><?php echo $cms->cms_desc;?></span>+</h2>
            <p class="counter-card_text"><?php echo $cms->cms_tittle;?></p>
          </div>
        </div>
      </div>

      <?php } ?>  


    </div>
  </div>
</div>
</div>
<div class="Proprietor-sec" data-bg-src="<?php echo base_url();?>public/assets/img/dottes-bg.png">
  <div class="container">
<div class="row align-items-center">

<div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="800">

<div class="Prin-1">
<div class="princiMsg">
                        <div class="imgBox">
                            <img class="lazyload" data-src="<?php echo base_url();?>public/uploads/cms/<?php echo $Proprietor->cms_img;?>" src="<?php echo base_url();?>public/uploads/cms/thumbs/<?php echo $Proprietor->cms_img;?>" alt="" width="100%">
                            <div class="tag">Proprietor</div>
                        </div>
                        <div class="MsgBox">
                            <div class="Name"><?php echo $Proprietor->cms_tittle; ?></div>
                        </div>
                    </div>


</div>


</div>
<div class="col-lg-5 col-md-6" data-aos="zoom-in" data-aos-duration="800">

<div class="Prin-2">

<div class="title-area mb-20 prop">
 
          <h2 class="sec-title  ">Meet Our<span> Proprietor </span></h2>
			    <h3><?php echo $Proprietor->cms_tittle; ?></h3>
			
          </div>
		      <?php echo $Proprietor->cms_desc;?>
</div>


</div>
<div class="col-lg-3 col-md-12" data-aos="zoom-in" data-aos-duration="800">

<div class="Prin-3">
<div class="row">
<div class="col-lg-12 col-md-6 col-sm-6 rrtyu">
<div class="adm-sec">

<div class="Adm-icon">
<img src="<?php echo base_url();?>public/assets/img/t1.png" alt="">

</div>
<div class="Adm-desc">
<h3>Tariff  </h3>

<a href="<?php echo base_url();?>Tariff">View Tariff</a>

</div>
</div>

</div>
<div class="col-lg-12 col-md-6 col-sm-6 mt-30  ">
<div class="adm-sec adm-sec1">

<div class="Adm-icon">
<img src="<?php echo base_url();?>public/assets/img/t2.png" alt="">

</div>
<div class="Adm-desc">
<h3>Get In Touch</h3>

<a href="<?php echo base_url();?>Contact">Contact Now</a>

</div>
</div>

</div>

</div>


</div>


</div>





</div>
</div>
</div>
 
 
 
  <div class=" galleryinner-sec" data-bg-src="assets/img/dottes-bg.png">
  <div class="container">
<div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
      <h2 class="sec-title mb-20  ">Our   <span> Gallery </span></h2>
	  
    </div>
    <div class="row justify-content-center">
       <?php $i=1; foreach(array_slice($gallery,0,6) as $gal){ ?> 

      <div class="col-md-6 col-sm-6 <?php if($i == 1){ echo "col-lg-6"; } else if($i == 2){echo "col-lg-3";} else if($i == 3){echo "col-lg-3"; } else if($i == 4){ echo "col-lg-3";} else if($i == 5){echo"col-lg-6";} else if($i == 6){ echo "col-lg-3"; } else{ echo "col-lg-6"; }?>" data-aos="zoom-in" data-aos-duration="800">
        <div class="gallery-card">
          <div class="gallery-img"><div class="auccd"></div><img class="lazyload" src="<?php echo base_url();?>public/uploads/gallery/thumbs/<?php echo $gal->gallery_path;?>" data-src="<?php echo base_url();?>public/uploads/gallery/<?php echo $gal->gallery_path;?>" alt=""> <a href="<?php echo base_url();?>public/uploads/gallery/<?php echo $gal->gallery_path;?>" class="gallery-btn popup-image"><i class="fas fa-image"></i></a></div>
          <div class="gallery-content">
            
          </div>
        </div>
      </div>

      <?php $i++; } ?>

    
      

  
      
     
      


      

     
      
     
    </div>
  </div>
    </div>

    <!---footer section start--->

    <?php echo view('user/includes/footer');?>


    <!--footer section end-->

	

</body>

</html>