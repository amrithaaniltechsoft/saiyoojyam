        
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
             
              $uriSegs = service('uri')->getSegments();
              $seg2 = strtolower($uriSegs[1] ?? '');
              $seg3 = strtolower($uriSegs[2] ?? '');
              $seg4 = strtolower($uriSegs[3] ?? '');

              $isWebsitePage = in_array($seg2, ['about', 'whychoose', 'foodquality', 'cms', 'contact', 'seo', 'termsconditions', 'terms']);
              if ($isWebsitePage && session()->get('manage') !== 'website') {
                  session()->set('manage', 'website');
              }

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
            <li class="menu-item <?= (empty($seg2) || $seg2 == 'home') ? 'active' : '' ?>">
              <a href="<?=  base_url();?>Admin/Home" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="">Dashboards</div>
              </a>
            </li>


            

           
             

           

           <?php if(session()->get('manage') == "bookings" || empty(session()->get('manage'))){ ?>


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'building' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Building</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($seg2 == 'building' && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Building/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Building</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'building' && ($seg3 == '' || $seg3 == 'index')) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Building" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">List Building</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'roomtypes' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Room Types</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($seg2 == 'roomtypes' && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/RoomTypes/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Room Types</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'roomtypes' && ($seg3 == '' || in_array($seg3, ['index', 'edit']))) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/RoomTypes" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Room Types</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->
            
            <!--sidebar pages start-->

            <li class="menu-item <?= ($seg2 == 'rooms' && $seg3 != 'available') ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Rooms</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($seg2 == 'rooms' && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Rooms/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Rooms</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'rooms' && ($seg3 == '' || in_array($seg3, ['index', 'edit']))) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Rooms" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Rooms</div>
                  </a>
                </li>
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item">
              <a href="<?=  base_url();?>Admin/Rooms/Available" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-hotel"></i>
                <div class="text-truncate" data-i18n="Available Rooms">Available Rooms</div>
              </a>
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

            <li class="menu-item <?= in_array($seg2, ['tariff', 'buildingfees']) ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Tariff</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= $seg2 == 'buildingfees' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/BuildingFees" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Building Fees</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'tariff' && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Tariff/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Tariff</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'tariff' && ($seg3 == '' || in_array($seg3, ['index', 'edit']))) ? 'active' : '' ?>">
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

            <li class="menu-item <?= $seg2 == 'inmates' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Inmates</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= ($seg2 == 'inmates' && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Inmates/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Add Inmates</div>
                  </a>
                </li>
                <li class="menu-item <?= ($seg2 == 'inmates' && ($seg3 == '' || in_array($seg3, ['index', 'edit', 'view'])) && empty($seg4)) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Inmates" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Inmates</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Home#pending-bookings-section" class="menu-link">
                    <div class="text-truncate">Booking Requests <?php 
                      $p_cnt = (new \App\Models\CommonModel())->checkWhereCount('saiyoojyam_inmates', ['inmates_status' => 'pending']);
                      if($p_cnt > 0): ?><span class="badge rounded-pill bg-danger ms-1"><?= $p_cnt ?></span><?php endif; ?>
                    </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/RentalDetails" target="_blank" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Rental Calander </div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/index/active" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Active Inmates</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/index/checked_out" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Inactive Inmates</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/index/paid" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Paid</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/index/unpaid" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Unpaid</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="<?=  base_url();?>Admin/Inmates/index/partial" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Partially Paid</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->



            <!--sidebar pages start-->

            <!--
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
            -->

            <!--sidebar pages end-->



            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'payments' ? 'active open' : '' ?>">
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
                <li class="menu-item <?= $seg2 == 'payments' ? 'active' : '' ?>">
                  <a href="<?= base_url();?>Admin/Payments/View" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View Payments</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <?php } else{?> 


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'building' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Building</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= $seg2 == 'building' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Building" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">List Building</div>
                  </a>
                </li>
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'about' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">About US</div>
              </a>
              <ul class="menu-sub">
                 
                <li class="menu-item <?= $seg2 == 'about' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/About/View" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit About Us</div>
                  </a>
                </li>
                 
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item <?= in_array($seg2, ['whychoose']) ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Why Choose Us</div>
              </a>
              <ul class="menu-sub">
                 
                <li class="menu-item <?= in_array($seg2, ['whychoose']) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/WhyChoose" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Why Choose Saiyoojyam</div>
                  </a>
                </li>
                 
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'foodquality' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-restaurant"></i>
                <div class="text-truncate" data-i18n="Account Settings">Food Quality</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= $seg2 == 'foodquality' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/FoodQuality" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Food Quality</div>
                  </a>
                </li>
              </ul>
            </li>

            <!--sidebar pages end-->

            <!--sidebar pages start-->

            <li class="menu-item <?= in_array($seg2, ['cms']) ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">CMS</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= (in_array($seg2, ['cms']) && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Cms/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Add CMS">Add CMS</div>
                  </a>
                </li>
                <li class="menu-item <?= (in_array($seg2, ['cms']) && in_array($seg3, ['', 'index', 'view'])) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Cms" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit CMS</div>
                  </a>
                </li>
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item <?= in_array($seg2, ['termsconditions', 'terms']) ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div class="text-truncate" data-i18n="Terms and Conditions">Terms &amp; Conditions</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?= (in_array($seg2, ['termsconditions', 'terms']) && $seg3 == 'add') ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/TermsConditions/Add" class="menu-link">
                    <div class="text-truncate" data-i18n="Add Terms & Conditions">Add Terms &amp; Conditions</div>
                  </a>
                </li>
                <li class="menu-item <?= (in_array($seg2, ['termsconditions', 'terms']) && in_array($seg3, ['', 'index', 'view'])) ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/TermsConditions" class="menu-link">
                    <div class="text-truncate" data-i18n="List Terms & Conditions">List Terms &amp; Conditions</div>
                  </a>
                </li>
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'contact' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Contact</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item <?= $seg2 == 'contact' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Contact" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit Contact</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'seo' ? 'active open' : '' ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">SEO</div>
              </a>
              <ul class="menu-sub">
                
                <li class="menu-item <?= $seg2 == 'seo' ? 'active' : '' ?>">
                  <a href="<?=  base_url();?>Admin/Seo" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">View / Edit SEO</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!--sidebar pages end-->


          
              
              
              
              
            <?php } ?> 


            <!--sidebar pages start-->

            <li class="menu-item <?= $seg2 == 'changepassword' ? 'active' : '' ?>">
              <a href="<?= base_url(); ?>Admin/ChangePassword" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock-alt"></i>
                <div class="text-truncate" data-i18n="Change Password">Change Password</div>
              </a>
            </li>

            <!--sidebar pages end-->

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
