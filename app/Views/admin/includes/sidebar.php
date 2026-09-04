        
          <style>
            .link-toggle-container{
              background: #ff5920;
              padding: 5px 9px;
              margin: 5px 17px;
              border-radius: 10px;
              text-align: center;
              color: white;
              width: 90%;
              display: flex;

            }

            a.link-toggle-btn{
            
              color:white !important;
              padding: 5px;
              border-radius: 10px;
              font-size: 15px;
              display: inline-block;
              width: 50%;
            }

             a.link-toggle-btn:hover{



            }

             a.link-toggle-btn.active {
                background: #ffffff !important;
                color: black !important;
            }


             a.link-toggle-btn {
                color: white !important;
                padding: 5px;
                border-radius: 10px;
                font-size: 15px;
                display: inline-block;
                width: 50%;
            }

          </style>


        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?=  base_url();?>Admin/Home" class="app-brand-link">
              <img alt="logo" class="dashboard_img" src="<?php echo base_url();?>assets/admin/img/logo.png">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">

            <!----->


            <?php
             
              $website="";
              $booking="";
              if(empty(session()->get('manage')))
              {
              $booking="active";
              }
              else
              {
              $website="active";
              }

            ?>


            <div class="link-toggle-container">


              <a href="<?= base_url() ?>admin/Home/ToggleMenu/Website" class="link-toggle-btn <?= $website ?>">Website</a>

              <a href="<?= base_url() ?>admin/Home/ToggleMenu/Booking" class="link-toggle-btn <?= $booking; ?>">Booking</a>


            </div>

            <!----->

            <!-- Dashboards -->
            <li class="menu-item active open">
              <a href="<?=  base_url();?>Admin/Home" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="">Dashboards</div>
                
              </a>
              
            </li>


            

           
             

           

           <?php if(session()->get('manage') == "bookings" || empty(session()->get('manage'))){ ?>


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Building</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Building/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Building</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Building" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Building</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Room Types</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/RoomTypes/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Room Types</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/RoomTypes" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Room Types</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->
            
            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Rooms</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Rooms/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Rooms</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Rooms" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Rooms</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->



            <!--sidebar pages start-->

            <!--<li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Rooms</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Rooms" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Rooms</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Edit Rooms</div>
                  </a>
                </li>
                
              </ul>
            </li>-->

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <!--<li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Beds</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Beds" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Beds</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Edit Beds</div>
                  </a>
                </li>
                
              </ul>
            </li>--->

            <!--sidebar pages end-->
            

            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Tariff</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Tariff/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Tariff</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Tariff" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Tariff</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->



             <!--sidebar pages start-->

            <!--<li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Customer</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Users" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Customer</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Edit Customer</div>
                  </a>
                </li>
                
              </ul>
            </li>--->

            <!--sidebar pages end-->



            


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Inmates</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Inmates</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Inmates</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/RentalDetails" target="_blank" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Rental Calander </div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->



            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Inmates Bed Rental</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/BedRentals" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add  Bed Rental</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/BedRentals/View" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Bed Rental</div>
                  </a>
                </li>
                
                
              </ul>
            </li>

            <!--sidebar pages end-->



            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Payments</div>
              </a>
              <ul class="menu-sub">
                <!--<li class="menu-item">
                  <a href="<?=  base_url();?>Admin/BedRentals" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Payments</div>
                  </a>
                </li>-->
                <li class="menu-item">
                  <a href="<?= base_url();?>Admin/Payments/View" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View Payments</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <?php } else{?> 


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">About US</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/BedRentals/View" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Bed Rental</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Rooms</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Rooms/WebRoom" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Rooms</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Facilities</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Facilities" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Facilities</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


           


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Gallery</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Gallery/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Gallery</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Gallery" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Gallery</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">CMS</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Cms" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit CMS</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Contact</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Contact" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Contact</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">SEO</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Seo" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit SEO</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


          
              
              
              
              
            <?php } ?> 




           


            <!--sidebar pages start-->

            <!--<li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Payments</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?=  base_url();?>admin/payments" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add payments</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Edit payments</div>
                  </a>
                </li>
                
              </ul>
            </li>--->

            <!--sidebar pages end-->



           


           
            
            
           
            
            
           
           
           
          </ul>
        </aside>