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
  

<!--page content start-->

<style>

.qr-code-left {

    border-radius: 10px;
    border: 1px solid #e7e7e7;
    padding: 25px;
    margin-bottom: 20px;
    position: relative;
    width: 100%;
	text-align: center;
}

.qr-code-right {

    border-radius: 10px;
    border: 1px solid #e7e7e7;
    padding: 25px;
    margin-bottom: 20px;
    position: relative;
    width: 100%;
}

     
/* Overlay that covers the whole page */
#loader-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(255,255,255,0.8);
  z-index: 9999;

  /* Centering the spinner */
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Spinner styles */
.spinner {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
}

/* Spin animation */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


</style>


<!--page content end-->
 
 
    <div class="Carts-ccsec th-cart-wrapper">
        <div class="container">
            <div class="row  justify-content-center">
                <div class="col-lg-4 col-md-6  col-sm-7 d-flex">
                    <div class="qr-code-left">
                        <img src="<?php echo base_url();?>public/assets/img/qr_code.png" alt="">
                    </div>

                </div>
				
                <div class="col-lg-8 col-md-10 col-sm-11 d-flex">
                    <div class="qr-code-right">
                        <div class="title-area mb-30">
                            <h2 class="sec-title">Here is our bank details</h2>
                        </div>

						<p><strong>Account Name :</strong> THE MARARI BEACH BUNGALOW </p>
						<p><strong>Account No :</strong> 50424658819</p>
						<p><strong>IFSC Code :</strong> IDIB000E020</p>
						<p><strong>Bank :</strong> INDIAN BANK , Pallimukku Branch</p>
						<p><strong>Swift Code:</strong> IDIBINBBEKM</p>

                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="price-bbg">
                                    <?php 

                                        $session = session();
                                        $room_data = $session->get("RoomData"); 
    
	                                ?>

                                    <div class="pps-1">Price</div>
                                    <div class="pps-2">₹ <?php echo $room_data['total_amount']; ?></div>

                                </div>

                            </div>
                            
							<div class="col-auto">
                                <h4> <a class="whatsapp confirm_payment" style="cursor: pointer;">Confirm & Share<img src="assets/img/share.png" alt=""></a> </h4>
                            </div>
                            
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
  <!---->
         
        <div id="loader-overlay">
  <div class="spinner"></div>
</div>
        <!---->

<!--footer section start-->

<?php echo view('user/includes/footer'); ?>

<!--footer section end-->
  
	
 

 <script>
 
$("#areaCode").on("change", function() {
  $('#dialCode').val($('option:selected', this).data('dialcode'));
});
 
 
 </script>

<script>

    // Hide loader once page is fully loaded
    window.addEventListener("load", function(){
        document.getElementById("loader-overlay").style.display = "none";
    });

</script>

<script>
        
        $('.confirm_payment').on('click',function(e){
            
            //e.preventDefault(); 
            var status = 1;

            var url = "https://api.whatsapp.com/send/?phone=+918129339122&text=%2AHey  Saiyoojyam+&app_absent=0";
                        window.open(url, "_blank"); 

            $('#loader-overlay').show();


            $.ajax({
                url: '<?= base_url("Payment") ?>',
                method: 'POST',
                data: { status: status,

                },
                success: function (data) {

                    if (data.status === "success") {

                        $('#loader-overlay').hide();

                        window.location.href = "<?= base_url(); ?>";

                    }

                    
                },
                
            });
         

        });

</script>

 
</body>

</html>