<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Monthly Rental Calendar</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
   <style>
  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f7fa;
    margin: 20px;
    color: #333;
  }

  h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 10px;
  }

  #legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 14px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    display: inline-block;
  }

  .legend-paid { background: #eafaf1; border: 1px solid #2e7d32; }
  .legend-unpaid { background: #fdecea; border: 1px solid #c0392b; }
  .legend-partial { background: #fff3cd; border: 1px solid #b57f00; }
  .legend-advance { background: #e6f7fb; border: 1px solid #03c3ec; }
  .legend-vacated { background: #eceff1; border: 1px solid #78909c; }

  #yearSelect {
    display: inline-block;
    margin: 0 auto 20px auto;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
  }

  th {
    background: cadetblue;
    color: #fff;
    padding: 10px;
    font-weight: 600;
    text-transform: uppercase;
  }

  td {
    border: 1px solid #eee;
    padding: 10px;
    text-align: center;
    transition: background 0.3s;
  }

  tr:nth-child(even) td {
    background: #f9fbfc;
  }

  td:hover {
    background: #f0f8ff;
  }

  .paid {
    background: #eafaf1;
    color: #2e7d32;
    font-weight: 500;
  }

  .unpaid {
    background: #fdecea;
    color: #c0392b;
    font-weight: 500;
  }

  .partial {
    background: #fff3cd;
    color: #b57f00;
    font-weight: 500;
  }

  .advance {
    background: #e6f7fb;
    color: #03c3ec;
    font-weight: 500;
  }

  .vacated {
    background: #e0e0e0;
    color: #555;
    font-style: italic;
    font-weight: 500;
  }

  tr.row-vacated td {
    background: #eceff1 !important;
    color: #78909c;
    font-style: italic;
  }

  tr.row-vacated td a {
    color: inherit;
    opacity: .8;
  }

  .paid a, .partial a, .unpaid a, .advance a {
    color: inherit;
    text-decoration: none;
    display: block;
  }

  #pos_adjust {
    display: inline-block;
    margin: 0 auto 20px auto;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
  }
  .yearly_report{

    display: inline-block;
  }
  .yearly_report button{

    margin: 0 auto 20px auto;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
  }
  .yearly_report a{

    color: black;
    text-decoration: none;
  }
</style>
</head>
<body>

<h2>Saiyoojyam Rental Calendar</h2>

<!--- Color Legend -->
<div id="legend">
  <div class="legend-item"><span class="legend-color legend-paid"></span> Paid </div>
  <div class="legend-item"><span class="legend-color legend-partial"></span> Partial</div>
  <div class="legend-item"><span class="legend-color legend-advance"></span> Advance</div>
  <div class="legend-item"><span class="legend-color legend-unpaid"></span> Unpaid</div>
  <div class="legend-item"><span class="legend-color legend-vacated"></span> Checked Out</div>
</div>

<div style="text-align: center;">

  <select id="yearSelect" class="form-control year_clz"></select>

  <select id="pos_adjust" class="form-control month_clz">
    <option value="" selected disabled>Select Month</option>
    <?php foreach($month as $mon){ ?> 

    <option value="<?php echo $mon->month_id;?>" ><?php echo $mon->month_short;?></option>

    <?php } ?>
  </select>

  <select id="pos_adjust" class="form-control build_clz">
    <option value="" selected disabled>Select Building</option>
    <?php foreach($building as $build){ ?>
        <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
    <?php } ?>
  </select>

  <div class="yearly_report"><button><a href="<?php echo base_url();?>Admin/Inmates/RentalDetails">Yearly Report</a></button></div>

</div>

<table id="calendarTable">
  <thead>
    <tr>
      <th>Inmates</th>
      
      <?php $year =0 ;foreach($month as $mon){ ?> 
      <th><?php echo $mon->month_short;?></th>
      <?php } ?>
    </tr>
  </thead>
 <tbody class="tbody_data">
  
<?php foreach($inmates as $inmate){ ?> 
  <tr <?php if($inmate->inmates_status == 'checked_out'){ echo 'class="row-vacated"'; } ?>>
    <td>
      <?php echo $inmate->inmates_name; ?>
      <br/><small class="text-muted"><?php echo $inmate->inmates_uid; ?></small>
      <?php if($inmate->inmates_check_out_date == '0000-00-00' || empty($inmate->inmates_check_out_date)){ ?>
        <br/><a href="<?php echo base_url();?>Admin/Inmates/CheckOut/<?php echo $inmate->inmates_id;?>" onclick="return confirm('Check out this inmate?');" style="font-size:12px;color:#fff;background:#e74c3c;padding:2px 8px;border-radius:4px;text-decoration:none;display:inline-block;">Check Out</a>
      <?php } ?>
    </td>

    <?php  
    
      $invoiceMonths = [];
      foreach($inmate->invoice as $inv){  
          $parts = explode('-', $inv->invoice_payment_month);
          $month = (int)$parts[1];
          $year  = (int)$parts[0];  
          $invoiceMonths[$month] = [
              'month'         => $inv->invoice_payment_month,
              'amount'        => $inv->invoice_paid_amount,
              'status'        => $inv->invoice_status, 
              
          ];
      }
     
      
      $currentMonth = (int)date('m');

      $currentYear  = (int)date('Y');

      $yearToShow = $currentYear;

      $ciDate = strtotime($inmate->inmates_check_in_date);

      $ciYear = (int)date('Y', $ciDate);

      $ciMonth = (int)date('m', $ciDate);

      for ($m = 1; $m <= 12; $m++) {

        if(($yearToShow > $currentYear) || (($yearToShow < $ciYear) || ($yearToShow == $ciYear && $m < $ciMonth))){

          echo '<td></td>';

          continue;

        }

        if (isset($invoiceMonths[$m])) {

          if ($invoiceMonths[$m]['status'] == 1) {

            echo '<td class="paid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';

          } 
          
          elseif($invoiceMonths[$m]['status'] == 2) {

            echo '<td class="partial"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';

          }

          elseif($invoiceMonths[$m]['status'] == 3) {

            echo '<td class="advance"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invoiceMonths[$m]['amount'].'</a></td>';

          }
          
          else{
                  
            //if ($m <= $currentMonth) {
            if($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {

              echo '<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>';
              
            } 
            else {

              echo '<td></td>'; 

            }
            
          }

        } 
        else {
              
          if ($yearToShow > $currentYear || ($yearToShow == $currentYear && $m <= $currentMonth)) {

            echo '<td class="unpaid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">---</a></td>'; 

          } 
          
          else {

            echo '<td></td>'; 

          }

        }
        
      }

    ?>
  </tr>
<?php } ?>



  
  
</tbody>


</table>


<!--table2 section start-->

<table id="buildingTable" style="display:none;">
  <thead>
    <tr>
      <th>Inmates</th>
      <th>Room</th>
      <th>DOA</th>
      <th>Ph No</th>
      <th>Place of Work</th>
      <th>Room Type</th>
      <th>Rent</th>
      <th>CD</th>
      <th>A Fee</th>
      <th>Total</th>
      <th>RENT RDN</th>
      <th>Amount</th>
      <th>Pay Date</th>
      <th>Remark</th>
      <th>Vacate On</th>
      <th>Re Fund</th>
      <th>Rf Date</th>
    </tr>
  </thead>
 <tbody class="inmates_details">
  
  <tr>
    <td>Anju</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
    <td class="">test</td>
  
  </tr>
  
</tbody>
</table>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!--table2 section end-->
<script>

  alertify.set('notifier','position', 'top-center');
      
      
</script>

<script>

$(document).ready(function () {

    const currentYear = new Date().getFullYear();
    for (let y = currentYear - 1; y <= currentYear + 2; y++) {
        $('#yearSelect').append(`<option value="${y}">${y}</option>`);
    }
    $('#yearSelect').val(currentYear);
   

});

</script>


<!--year select start-->
<script>
$('.year_clz').on('change', function(){

  var year = $(this).val();

  $.ajax({
      url: "<?php echo base_url(); ?>Admin/Ajax/checkYear",
      type: "POST",
      data: {currentYear :year},
      success: function(data) {

        var data = JSON.parse(data);

        $('.tbody_data').html(data.year_html);

        

      }
  });
  
});
</script>

<!--year select end-->


<!--month select start-->

<script>
$('.month_clz').on('change', function(){

    var building = $('.build_clz').val();

    if(building == null){

      alertify.error('Please Select Building').delay(8).dismissOthers();

      return false;

    }else{

      var build = $(".build_clz").val();

      var month = $(".month_clz").val();

      var year  = $(".year_clz").val();

      $.ajax({

        url: "<?php echo base_url(); ?>Admin/Ajax/inmatesDetails",
        type: "POST",
        data: {Build :build, Month :month, Year :year},

        success: function(data) {

          var data = JSON.parse(data);

          
          $('.inmates_details').html(data.inmates_details);
          

        }

      });

      $('#calendarTable').hide();

      $('#buildingTable').show();


    }
 
 
});
</script>

<!--month select end-->

<script>

$(document).ready(function () {

  $( ".build_clz" ).on( "change", function() {

    var build = $(".build_clz").val();

    var month = $(".month_clz").val();

    var year  = $(".year_clz").val();

    if(month == null){

        alertify.error('Please Select Month').delay(8).dismissOthers();
    }
    
    /**/

    $.ajax({
      url: "<?php echo base_url(); ?>Admin/Ajax/inmatesDetails",
      type: "POST",
      data: {Build :build, Month :month, Year :year},
      success: function(data) {

        var data = JSON.parse(data);

         
        $('.inmates_details').html(data.inmates_details);
        

      }
    });

    /**/

    $('#calendarTable').hide();

    $('#buildingTable').show();
    
  });

});

</script>

</body>
</html>
