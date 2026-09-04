
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

<link rel="icon" type="image/png"  href="<?php echo base_url();?>public/assets/img/favicon.png">

<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/css/app.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/css/fontawesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/css/responsive.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
 
</head>

<style>

.alertify-notifier .ajs-message {

  text-align: center;
  color: white !important; 

}

@media only screen and (max-width: 1499px) and (min-width: 1440px){

  .main-menu ul.mega-menu li li a {

    font-size: 9px;
    padding-left: 14px;
    margin-bottom: 0px;
   
  }

}


@media only screen and (max-width: 1499px) and (min-width: 1024px){

     .main-menu ul.mega-menu li li a {

    font-size: 9px;
    padding-left: 14px;
    margin-bottom: 0px;
   
  }


}


</style>








<body class="theme-red">

<div class="as-menu-wrapper">
  <div class="as-menu-area text-center">
    <button class="as-menu-toggle"><i class="fal fa-times"></i></button>
    <div class="mobile-logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>public/assets/img/logo.png" alt=""></a></div>
    <div class="as-mobile-menu">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li class="menu-item-has-children"><a href="javascript:void()'">About Us</a>
          <ul class="sub-menu">
            <li><a href="<?php echo base_url();?>About">Who We Are</a></li>
            <li><a href="<?php echo base_url();?>Mission-Vision">Mission & Vision</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url();?>Facilities">Facilities </a></li>
        <li><a href="<?php echo base_url();?>Tariff">Tariff </a></li>

 
<!--<li class="menu-item-has-children">  <a href="rooms.html">Rooms</a>
   <ul class="sub-menu">
    <li><a href="rooms-category.html">AC Rooms  </a>
	  <ul class="sub-menu">
    <li><a href="rooms-sub-category.html">Tower 1  Rooms </a></li>
 <li><a href="rooms-sub-category.html">Tower 2 Rooms</a></li>
 <li><a href="rooms-sub-category.html">Annex Rooms</a></li>
</ul>

	</li>
 <li><a href="rooms-category.html">Non A/C Rooms</a>
 
 	  <ul class="sub-menu">
    <li><a href="rooms-sub-category.html">Tower 1 Rooms  </a></li>
 <li><a href="rooms-sub-category.html">Tower 2 Rooms</a></li>
 <li><a href="rooms-sub-category.html">Annex Rooms</a></li>
</ul>
 </li>
 
</ul>

</li>-->

<!---->

  <li class="menu-item-has-children">  <a href="<?php echo base_url();?>Rooms">Rooms</a>
    <ul class="sub-menu">

      <?php foreach($common_building as $build){ ?> 
      <li><a href="<?php echo base_url()?>Categories/<?php echo $build->building_slug?>">	<?php echo $build->building_name?> </a>
	      <ul class="sub-menu">
          <?php foreach($build->build_rooms_type as $room_type){ ?> 
          <li><a href="<?php echo base_url();?>Category/<?php echo $room_type->room_type_slug;?>"><?php echo $room_type->room_type_name;?></a></li>
          <?php } ?>

        </ul>
      </li>
      <?php } ?>

      <!--<li><a href="rooms-category.html">	Saiyoojyam LH - Tower 1</a>
        <ul class="sub-menu">
          <li><a href="rooms-sub-category.html">3 Share</a></li>
          <li><a href="rooms-sub-category.html">4 Share-2</a></li>
          <li><a href="rooms-sub-category.html">4 Share-1</a></li>
          <li><a href="rooms-sub-category.html">3 Share AC</a></li>
          <li><a href="rooms-sub-category.html">4 Share AC  </a></li>
        </ul>
      </li>-->


      <!--<li><a href="rooms-category.html">Saiyoojyam LH - Tower 2</a>
        <ul class="sub-menu">
          <li><a href="rooms-sub-category.html">Single</a></li>
          <li><a href="rooms-sub-category.html">2 Share</a></li>
          <li><a href="rooms-sub-category.html">3 Share</a></li>
          <li><a href="rooms-sub-category.html">4 Share  </a></li>
          <li><a href="rooms-sub-category.html">4 Share; Bunk beds; Night AC</a></li>
          <li><a href="rooms-sub-category.html">6 Share; Bunk Beds; Night AC</a></li>
          <li><a href="rooms-sub-category.html">8 Share; Bunk Beds; Night AC </a></li>
          <li><a href="rooms-sub-category.html">10 Share-1; Bunk Beds; Night AC</a></li>
          <li><a href="rooms-sub-category.html">10 Share-2; Bunk Beds; Night AC</a></li>
          <li><a href="rooms-sub-category.html">3 Share AC </a></li>
          <li><a href="rooms-sub-category.html">Single AC</a></li>
          <li><a href="rooms-sub-category.html">2 Share AC</a></li>
        </ul>
      </li>-->


    </ul>
  </li>

<!----->


 <li ><a href="gallery.html">Gallery  </a></li>
 <li ><a href="contact.html">Contact Us </a></li>
	
      </ul>
    </div>
  </div>
</div>

 
<?php

$uri =service('uri');
$uri->setSilent();
?>


<header class="as-header header-layout2">
 
  <div class="sticky-wrapper">
    <div class="sticky-active">
      <div class="menu-area">
        <div class="container">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
            <div class="header-logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>public/assets/img/logo.png" alt=""></a></div>
            </div>
			
			
			<div class="col-auto oo2">
			
			<div class="he-top-area">
	
 
	  <div class="row align-items-center justify-content-end">
	  
	  <div class="col-auto">
	  <div class="header-top-six   d-none d-md-inline-block">
           
                <div class="row justify-content-end align-items-center">
                    <div class="col-auto">
                        <ul class="header-top-info v6 list-unstyled m-0">
                            
                          <li><i class=""><img src="<?php echo base_url();?>public/assets/img/h1.png"></i><a href="tel:<?php echo $common_contact->contact_phone1;?>"><?php echo $common_contact->contact_phone1;?></a></li>
                          <li><i class=""><img src="<?php echo base_url();?>public/assets/img/so3.png"></i><a href="https://api.whatsapp.com/send/?phone=<?php echo $common_contact->contact_whats_app;?>&text=%2AHey  Saiyoojyam+&app_absent=0"><?php echo $common_contact->contact_whats_app;?></a></li>
							            
                          <!--<li><i class=" "><img src="<?php //echo base_url();?>public/assets/img/h1.png"></i><a href="tel:<?php //echo $common_contact->contact_phone2;?>"><?php //echo $common_contact->contact_phone2;?></a></li>
                          <li><i class=" "><img src="<?php //echo base_url();?>public/assets/img/h1.png"></i><a href="tel:<?php //echo $common_contact->contact_phone3;?>"><?php //echo $common_contact->contact_phone3;?></a></li>-->						 
							 		
                        </ul>
                    </div>

					<div class="col-auto sso-c-auto">
					
					      
                       <div class="online-paymentbtn" ><a href="<?php echo base_url();?>Contact">Book Now</a></div>
					
			 
  
            </div>
        </div>
	  </div>
		</div>
	</div>
	</div>
               <nav class="main-menu d-none d-lg-inline-block">
   <ul>
  <li ><a href="<?php echo base_url();?>">Home</a>   </li>
 
  <li class="menu-item-has-children <?php if($uri->getSegment(1) == 'About' || $uri->getSegment(1) == 'Mission-Vision'){ echo "active"; }?>">  <a href="javascript:void()'">About Us</a>
    <ul class="sub-menu">
      <li><a href="<?php echo base_url();?>About">Who We Are</a></li>
      <li><a href="<?php echo base_url();?>Mission-Vision">Mission & Vision</a></li>
      <li><a href="<?php echo base_url();?>terms-and-conditions">Terms & Conditions</a></li>
      <li><a href="<?php echo base_url();?>rules-and-procedures">Rules & Procedures</a></li>
      <li><a href="<?php echo base_url();?>kitchen-and-dining">Kitchen & Dining</a></li>
    </ul>
  </li>
  <li class="<?php if($uri->getSegment(1) == 'Facilities'){echo "active"; }?>"><a href="<?php echo base_url();?>Facilities">Facilities </a></li>
  <li class="<?php if($uri->getSegment(1) == 'Tariff'){echo "active"; }?>"><a href="<?php echo base_url();?>Tariff">Tariff </a></li>



  <!---->
  
  <li class="menu-item-has-children mega-menu-wrap"><a href="<?php echo base_url();?>Rooms">Rooms</a>
    <ul class="mega-menu">
      <div class="row">

        <!--<div class="col-lg-3">
          <li><a href="rooms-category.html">	Saiyoojyam Annex </a>
            <ul>
              <li><a href="rooms-sub-category.html">4 Share </a></li>
            </ul>
          </li>
        </div>-->

        <!--<div class="col-lg-3">
          <li><a href="rooms-category.html">	Saiyoojyam LH - Tower 1</a>
            <ul>
              <li><a href="rooms-sub-category.html">3 Share</a></li>
              <li><a href="rooms-sub-category.html">4 Share-2</a></li>
              <li><a href="rooms-sub-category.html">4 Share-1</a></li>
              <li><a href="rooms-sub-category.html">3 Share AC</a></li>
              <li><a href="rooms-sub-category.html">4 Share AC  </a></li>
            </ul>
          </li>
        </div>-->


        <?php $i = 1; foreach($common_building as $build){ ?> 
        <div class="<?php
        if ($i == 3) {
            echo 'col-lg-6';
        } else {
            echo 'col-lg-3';
        }
    ?>">
          <li><a href="<?php echo base_url()?>Categories/<?php echo $build->building_slug?>"><?php echo $build->building_name?></a>
            <div class="row">
              
              <?php foreach(array_slice($build->build_rooms_type,0,6) as $room_type){ ?> 
              <div class="col-lg-6">
                <ul>
                  
                  <li><a href="<?php echo base_url();?>Category/<?php echo $room_type->room_type_slug;?>"><?php echo $room_type->room_type_name;?></a></li>
                  
                </ul>
              </div>
              <?php } if(!empty(array_slice($build->build_rooms_type,6))){ foreach(array_slice($build->build_rooms_type,6) as $room_type){ ?> 
              <div class="col-lg-6">
                <ul>

                  <li><a href="<?php echo base_url();?>Category/<?php echo $room_type->room_type_slug;?>"><?php echo $room_type->room_type_name;?></a></li>
                  
                </ul>
              </div>

              <?php } } ?>


            </div>
          </li>
        </div>
        <?php $i++; } ?> 




      </div>
    </ul>
  </li>

  <!---->



  <li class="<?php if($uri->getSegment(1) == 'Gallery'){echo "active"; }?>"><a href="<?php echo base_url();?>Gallery">Gallery</a></li>
  <li class="<?php if($uri->getSegment(1) == 'Contact'){echo "active"; }?>"><a href="<?php echo base_url();?>Contact">Contact Us</a></li>
    </ul>
    </nav>
          <button type="button" class="as-menu-toggle d-inline-block d-lg-none"><i class="far fa-bars"></i></button>
			   </div>
			
          </div>
        </div>
	 
        
      </div>
    </div>
  </div>
</header>


