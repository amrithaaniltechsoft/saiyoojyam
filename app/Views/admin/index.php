<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
<!--header section start-->

   <?= $this->include('admin/includes/header')?>

<!--header section end-->

<!--simple calander start-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/admin/css/simple-calendar.css" />

<!--simple calander end-->

<style>
ul a {
  list-style-type: circle;
}
::marker {
    font-size: 20px;
    color: #ff561c;
}
.small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    background: #cce5fe;
        background: #ff561c57;
}
.small-box>.inner {
    padding: 10px;
}

.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
    color: #000000b5;
    font-size: 30px;
}

.small-box p {
    font-size: 15px;
    color: #000000b5;
}
.small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}
.small-box .icon>a {
    color: #ff5920cf !important;
}
.small-box>.small-box-footer {
    position: relative;
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    z-index: 10;
    background: rgba(0,0,0,0.1);
    text-decoration: none;
    color: white !important;
    background: #ff5920a6 !important;
}
.room-box {
    text-align: center;
    background: #e1e1e1;
    border-radius: 10px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 10px 0px;
   
}
.room-title {
    font-size: 15px;
    padding-top: 35px;
    color: #000000b5;
}
.room-available {
    font-size: 18px;
    margin-top: -20px;
    color: #000000b5;
}

/*new style start*/
.card {
  position: relative;
  width: 200px;
  height: 150px;
  border-radius: 14px;
  z-index: 1111;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px;
}

.bg {
  
  top: 5px;
  left: 5px;
  width: 190px;
  height: 150px;
  z-index: 2;
  background: rgb(248 190 174);
  backdrop-filter: blur(24px);
  border-radius: 10px;
  overflow: hidden;
  outline: 2px solid white;

}



@keyframes blob-bounce{

  0% {
    transform: translate(-100%, -100%) translate3d(0, 0, 0);
  }
  25% {
    transform: translate(-100%, -100%) translate3d(100%, 0, 0);
  }
  50% {
    transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
  }
  75% {
    transform: translate(-100%, -100%) translate3d(0, 100%, 0);
  }
  100% {
    transform: translate(-100%, -100%) translate3d(0, 0, 0);
  }

}


/*new style end*/


/*calander style start*/


#calender-div {
  max-width: 700px;
  margin: 30px auto;
  border: 1px solid #ddd;
  border-radius: 10px;
  font-family: 'Segoe UI', sans-serif;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  overflow: hidden;
}

/* Calendar header: month/year + nav */
.calendar .calendar-header {
  background-color: #007bff;
  color: white;
  padding: 12px 20px;
  font-size: 18px;
  text-align: center;
  font-weight: bold;
}

/* Navigation buttons */
.calendar .calendar-header button {
  background: white;
  color: #007bff;
  border: none;
  padding: 6px 10px;
  margin: 0 5px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}
.calendar .calendar-header button:hover {
  background: #e6f0ff;
}

/* Day names (Sun to Sat) */
.calendar .calendar-days {
  display: flex;
  background-color: #f8f9fa;
  font-weight: 600;
  border-bottom: 1px solid #ddd;
}
.calendar .calendar-days .day {
  flex: 1;
  text-align: center;
  padding: 10px;
  color: #444;
}

/* Calendar dates */
.calendar .calendar-body {
  display: flex;
  flex-wrap: wrap;
}
.calendar .calendar-body .day {
  flex: 1 0 14.2857%;
  height: 80px;
  border: 1px solid #f0f0f0;
  text-align: center;
  padding: 5px;
  box-sizing: border-box;
  cursor: pointer;
  transition: background 0.2s ease-in-out;
  position: relative;
  font-size: 15px;
}

/* Today highlight */
.calendar .calendar-body .day.today {
  background-color: #fffbe6;
  border: 2px solid #ffc107;
}

/* Hover effect */
.calendar .calendar-body .day:hover {
  background-color: #e8f4ff;
}

/* Selected day (optional, if you handle this via JS) */
.calendar .calendar-body .day.selected {
  background-color: #007bff;
  color: white;
  border: 2px solid #0056b3;
}

/* Event indicator dot (optional if you add events) */
.calendar .calendar-body .day .event {
  width: 6px;
  height: 6px;
  background-color: #28a745;
  border-radius: 50%;
  position: absolute;
  bottom: 8px;
  left: 50%;
  transform: translateX(-50%);
}
.calendar header .btn-next {
    top: 10px;
    right: 14px;
}

.calendar header .btn-prev {
    top: 10px;
    left: 14px;
   
}


.card_div{

  display: flex;
    align-items: center;
    justify-content: center;
}


/*calander style end*/

/*room number box style start*/

.room-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  /*gap: 4px;*/ 
}

.room-cell {
  border: 1px solid #ccc;
  padding: 6px;   
  text-align: center;
  background: #fd7d52;
  color: white;
  font-weight: bold;
  font-size: 13px;
}

.room-cell span {
  display: block;
  font-size: 11px;
  font-weight: normal;
  margin-top: 2px;
  color: #fffacd;
}


/*end*/

</style>





          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                 
                <!---->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box" style="">
                    <div class="inner">
                      <h3 style=""><?php echo $todays_check_in;?></h3>
                      <p>Todays Check In's</p>
                    </div>
                    <div class="icon">
                      <!-- <i class="fa fa-shopping-cart"></i>-->
                      <a href="#" style="color:rgba(0, 0, 0, 0.15)"><i class="fa fa-star" style="padding-top:10px"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>


                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box" style="">
                    <div class="inner">
                      <h3 style=""><?php echo $todays_check_out; ?></h3>
                      <p>Todays Check Out's</p>
                    </div>
                    <div class="icon">
                      <!-- <i class="fa fa-shopping-cart"></i>-->
                      <a href="#" style="color:rgba(0, 0, 0, 0.15)"><i class="fa fa-sign-out" style="padding-top:10px"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>


                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box" style="">
                    <div class="inner">
                      <h3 style=""><?php echo $total_inmates;?></h3>
                      <p>Total Inmates</p>
                    </div>
                    <div class="icon">
                      <!-- <i class="fa fa-shopping-cart"></i>-->
                      <a href="#" style="color:rgba(0, 0, 0, 0.15)"><i class="fa fa-sign-in" style="padding-top:10px"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>


                

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box" style="">
                    <div class="inner">
                      <h3 style="">0</h3>
                      <p>Bed Rental</p>
                    </div>
                    <div class="icon">
                      <!-- <i class="fa fa-shopping-cart"></i>-->
                      <a href="#" style="color:rgba(0, 0, 0, 0.15)"><i class="fa fa-user" style="padding-top:10px"></i></a>
                    </div>
                    <a href="#" class="small-box-footer">
                      More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>

                <!---->


                <!---->

                <div class="col-lg-6">
                      
                    <div id="calender-div" class="check_date"></div>


                </div>

                <!------>
                
                <div class="col-lg-6" style="padding-top: 30px;">
                  <div class="room-grid room_available">
                    
                    <?php foreach($available_rooms as $rooms){ ?> 
                      <div class="room-cell"><?php echo $rooms['room_name']; ?><br><span><?php echo $rooms['available']; ?>Persons</span></div>
                    <?php } ?>
   
                    <!-- keep adding rooms here -->

                  </div>
                </div>

                <!----->

          

                <!---->
                
               
                
                

              </div>
            </div>
            <!-- / Content -->

            <!--footer section start-->

            <?= $this->include('admin/includes/footer') ?>

            <!--footer section end-->

            <!--simple calander start-->

            <script type="text/javascript" src="<?php echo base_url();?>public/assets/admin/vendor/js/jquery.simple-calendar.min.js"></script>

            <script>
              var $calendar;
              $(document).ready(function () {
                  let container = $("#calender-div").simpleCalendar({
                    fixedStartDay: 0,
                    disableEmptyDetails: true,
                    onDateSelect: function(date, events) {
                      const clickedDate = date.toLocaleDateString('en-CA');  
                      console.log("Clicked date:", clickedDate);
                      
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Ajax/AvaliableRoom",
                        type: "POST",
                        data: {Selected_date :clickedDate, 
                          
                        },
                        success: function(data) {

                          var data = JSON.parse(data);

                          $('.room_available').html(data.rooms);

                          console.log(data.rooms)

                        }
                      });


                      //$('#clicked_date').val(clickedDate); 
                    }
                  });
                  $calendar = container.data('plugin_simpleCalendar');
              });
            </script>

            <!--simple calander end-->
    
  </body>
</html>
