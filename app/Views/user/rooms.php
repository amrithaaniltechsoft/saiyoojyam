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

  <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>assets/img/banner/rooms-banner.jpg"  >
    <div class="container z-index-common">
      <h1 class="breadcumb-title">Rooms</h1>
      <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
    </div>
  </div>
 
  <div class="room-inner-sec  roo-inner-bg">

    <div class="container">
      <div class="title-area text-center" data-aos="zoom-in" data-aos-duration="800">
        <h2 class="sec-title mb-20  ">Our <span>Rooms </span></h2>
	    </div>
	  </div>

    <div class="container ">
	
      <div class="row ">
        <div class="col-lg-12 ">
          <ul class="Room-menu mtab">
          
            <?php $first = true; foreach($building as $build){?>

              <li><a href="javascript:void();" onclick="openprofile(event, 'R<?php echo $build->building_id; ?>')" id="<?php if($first == true){echo "defaultOpen"; }?>" class="tablink mtablinks <?php if($first == true){echo "active"; }?>"><?php echo $build->building_name; ?></a></li>

            <?php $first = false; } ?> 

          </ul>
        </div>
      </div>
	  
	  
      <div class="row">
        <div class="col-lg-12">
          <div class="tabmain produc-rightsec aucc-tab room-tabnew">
          
            <!----------- Start  --------->
            <?php foreach($building as $build){?>
            <div id="R<?php echo $build->building_id;?>" class="mtabcontent">

              <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <?php  $first = true; foreach($build->build_rooms_type as $room_type){ ?> 
                <li class="nav-item" role="presentation">
                  <button class="nav-link <?php if($first == true){echo "active"; }?>" id="room-<?php echo $build->building_id?>-<?php echo $room_type->room_type_id;?>-tab" data-bs-toggle="tab" data-bs-target="#room-<?php echo $build->building_id?>-<?php echo $room_type->room_type_id;?>" type="button" role="tab" aria-controls="room-<?php echo $build->building_id?>-<?php echo $room_type->room_type_id;?>" aria-selected="true"><?php echo $room_type->room_type_name;?></button>
                </li>
                <?php $first = false; } ?>

              </ul>

              <div class="tab-content" id="myTabContent2">

                <!-- Tab 1 -->
                <?php $first = true; if(!empty($build->build_rooms_type)){ foreach($build->build_rooms_type as $room_type){ ?> 
                <div class="tab-pane fade show <?php if($first == true){echo "active"; }?>" id="room-<?php echo $build->building_id?>-<?php echo $room_type->room_type_id;?>" role="tabpanel" aria-labelledby="room-<?php echo $build->building_id?>-<?php echo $room_type->room_type_id;?>-tab">
                  <div class="row justify-content-center">

                    <?php if(!empty($room_type->rooms)){ foreach($room_type->rooms as $room){   ?> 
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                      <div class="th-product product-grid">
                        <div class="product-img">
                          <?php if(!empty($room->rooms_image)){ ?> 
                          <img class="lazyload" data-src="<?php echo base_url();?>public/uploads/rooms/<?php echo $room->rooms_image;?>" src="<?php echo base_url();?>public/uploads/rooms/thumbs/<?php echo $room->rooms_image;?>" alt=" ">
                          <?php } else{?> 
                            <img src="<?php echo base_url();?>public/assets/img/logo.png" alt=" " style="object-fit: contain;">  
                          <?php } ?>
                        </div>
                        <div class="product-content">
                          <h3 class="product-title"><a href="room-detail.html"><?php echo $room->rooms_name; ?></a></h3>
                          <p><?php echo substr(strip_tags($room->rooms_description),0,100);?></p>
                        </div>
                        <div class="product-bb-btns">
                          <a href="<?php echo base_url();?>Room/<?php echo $room->rooms_slug; ?>" class="as-btn style7"> Book Now</a>
                        </div>
                      </div>
                    </div>

                    <?php   } } ?>

                    

                  </div>
                </div>
                <?php $first = false; } } ?> 
              </div>
            </div>
            <?php } ?>
            <!----------- Start  --------->
          </div>
        </div>
      </div>
	  </div>
  </div>
 
<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->



  <script>
	function openprofile(evt, profileName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("mtabcontent");
 
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("mtablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
	
  }
  document.getElementById(profileName).style.display = "block";
  evt.currentTarget.className += " active";
   AOS.refresh();
 
}
document.getElementById("defaultOpen").click();

	</script> 
	
	
	
		 <script>
	function openprocity(evt, profileName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(profileName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("activeOpen").click();
	</script> 
 
</body>

</html>