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

 <div class="breadcumb-wrapper" data-bg-src="<?php echo base_url();?>public/assets/img/banner/rooms-check-banner.jpg"  >
  <div class="container z-index-common">
    <h1 class="breadcumb-title">Make Payment </h1>
 <h2 class="breadcumb-intitle"> Saiyoojyam a perfect home for you</h2>
  </div>
</div>
  

 
 
 
<div class="Carts-ccsec th-cart-wrapper">

<div class="container">

 
	 
<div class="row ">

<div class="col-lg-4 col-md-6 ">
<div class="Booking-left">

<?php 
    $session = session();
    $room_data = $session->get("RoomData"); 
    
	
	
	
?>
 
<div class="booki-box2">
<h3>Your booking details</h3>

<h4>Room </h4>
<h5><?php echo $room_data['room_name']; ?>(<?php echo $room_data['room_type']; ?>)</h5>
<hr>
<div class="row  ">

<div class="col-lg-6 col-md-6">

<div class="cc-check">
<h4>Check-in</h4>
<h5><?php echo $room_data['check_in_date']; ?></h5>

<p>From 1:00 PM</p>
</div>
</div>
<div class="col-lg-6 col-md-6">

<div class="cc-check">
<h4>Check-out</h4>
<h5><?php echo $room_data['check_out_date']; ?></h5>

<p>Until 11:00 AM</p>
</div>
</div>
</div>
<hr>
<!--<h4>Ac Type</h4>
<h5><?php //echo $room_data['ac_type']; ?></h5>
<hr>-->
<h4>Building</h4>
<h5><?php echo $room_data['building_name']; ?></h5>
<hr>
<?php if(!empty($room_data['lenght_of_stay']->days)){ ?> 
<h4>Total length of stay:</h4>
<h5><?php echo $room_data['lenght_of_stay']->days; ?> Days</h5>
<hr>
<?php } ?>

<h4>You selected</h4>
<h5><?php echo $room_data['no_person']; ?>Person</h5>
</div>


<div class="booki-box3">
<h3>Your price summary</h3>
<div class="price-bbg ">

<div class="pps-1">Price</div>
<div class="pps-2"><?php echo $room_data['total_amount']; ?><span> Include taxes and fee<br>(One month payment)</span>
 </div>
</div>

 
</div>

</div>
</div>

<div class="col-lg-8 col-md-6">
    <div class="Booking-right">
        <div class="Booking-right-ss">
            <h3>Enter your details</h3>
			<form method="post" action="<?php echo base_url();?>Rooms/Booking" enctype="multipart/form-data">
                <div class="row   Guest pay-form">
                

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Name</label>
						<input type="text" class="form-control" placeholder="" name="name" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Age</label>
						<input type="number" class="form-control" placeholder="" name="age" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Email Address</label>
						<input type="email" class="form-control" placeholder=" " name="email" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Phone Number</label>
						<input type="text" class="form-control" placeholder="" name="phone" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>WhatsApp Number</label>
						<input type="whatsapp" class="form-control" placeholder="" name="whatsapp" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>ID Proof</label>
						<input type="file" class="form-control" placeholder="" name="id_proof" required="">
					</div>


					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Photo</label>
						<input type="file" class="form-control" placeholder="" name="photo" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Guardian Name</label>
						<input type="text" class="form-control" placeholder="" name="guardian_name" required="">
					</div>

					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Relation</label>
						<input type="text" class="form-control" placeholder="" name="relation" required="">
					</div>


					<div class="col-lg-6 col-md-12 form-group col-sm-6">
						<label>Contact Number</label>
						<input type="text" class="form-control" placeholder="" name="guardian_phone" required="">
					</div>
			

					<div class="col-lg-12    col-sm-12">
						<p>  To verify your booking, and for the Hostel to connect if needed</p>
					</div>
			
					<div class="col-lg-12 form-group ">
						<button class="as-btn" type="submit">Make Payment</button>
					</div>

				
			
		        </div>
			</form>
        </div>
    </div>
</div>


</div>
 
 </div>
</div>


<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->
  
	
 

 <script>
 
$("#areaCode").on("change", function() {
  $('#dialCode').val($('option:selected', this).data('dialcode'));
});
 
 
 </script>
 
</body>

</html>