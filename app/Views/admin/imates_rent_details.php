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

  #yearSelect, .month_clz, .build_clz, .status_clz {
    display: inline-block;
    width: auto;
    margin: 0 4px 15px 4px;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
    vertical-align: middle;
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

  .yearly_report {
    display: inline-block;
    vertical-align: middle;
    margin: 0 4px 15px 4px;
  }
  .yearly_report button {
    margin: 0;
    padding: 6px 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
  }
  .yearly_report a {
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

<div style="text-align: center; margin-bottom: 20px;">

  <select id="yearSelect" class="form-control year_clz"></select>

  <select class="form-control month_clz">
    <option value="" selected disabled>Select Month</option>
    <?php foreach($month as $mon){ ?> 
      <option value="<?php echo $mon->month_id;?>"><?php echo $mon->month_short;?></option>
    <?php } ?>
  </select>

  <select class="form-control build_clz">
    <option value="" selected disabled>Select Building</option>
    <?php foreach($building as $build){ ?>
        <option value="<?php echo $build->building_id;?>"><?php echo $build->building_name;?></option>
    <?php } ?>
  </select>

  <select class="form-control status_clz" style="display: none;">
    <option value="all">All Payment Statuses</option>
    <option value="unpaid" selected>Unpaid & Partial Only</option>
    <option value="unpaid_only">Strictly Unpaid Only</option>
    <option value="paid">Paid Only</option>
    <option value="partial">Partial Only</option>
    <option value="advance">Advance Only</option>
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

      $ciDay = (int)date('j', $ciDate);

      for ($m = 1; $m <= 12; $m++) {

        if(($yearToShow > $currentYear) || (($yearToShow < $ciYear) || ($yearToShow == $ciYear && $m < $ciMonth))){

          echo '<td></td>';

          continue;

        }

        $invData = isset($invoiceMonths[$m]) ? $invoiceMonths[$m] : null;
        if (empty($invData) && $ciDay >= 20 && $yearToShow == $ciYear && $m == $ciMonth && isset($invoiceMonths[$m + 1])) {
          $invData = $invoiceMonths[$m + 1];
        }

        if (!empty($invData)) {

          if ($invData['status'] == 1) {

            echo '<td class="paid"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';

          } 
          
          elseif($invData['status'] == 2) {

            echo '<td class="partial"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';

          }

          elseif($invData['status'] == 3) {

            echo '<td class="advance"><a href="'.base_url().'Admin/Inmates/Receipt/'.$inmate->inmates_id.'">₹'.$invData['amount'].'</a></td>';

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

<div id="summaryBanner" style="display:none; margin: 15px auto 25px auto; padding: 12px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); text-align: center;">
  <span style="margin: 0 15px; font-weight: 600;">Total Inmates: <span id="sumTotal" style="color:#2c3e50;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Unpaid: <span id="sumUnpaid" style="color:#c0392b;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Partial: <span id="sumPartial" style="color:#b57f00;">0</span></span> |
  <span style="margin: 0 15px; font-weight: 600;">Paid: <span id="sumPaid" style="color:#2e7d32;">0</span></span>
</div>

<table id="buildingTable" style="display:none;">
  <thead>
    <tr>
      <th style="width: 5%; text-align: center;">#</th>
      <th style="width: 20%;">Inmate Name</th>
      <th style="width: 15%;">Room & Type</th>
      <th style="width: 15%;">Phone Number</th>
      <th style="width: 10%; text-align: right;">Rent (₹)</th>
      <th style="width: 10%; text-align: right;">Paid (₹)</th>
      <th style="width: 10%; text-align: right;">Balance (₹)</th>
      <th style="width: 10%; text-align: center;">Status</th>
      <th style="width: 10%; text-align: center;">Action</th>
    </tr>
  </thead>
 <tbody class="inmates_details">
  
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
    const currentMonth = new Date().getMonth() + 1;

    for (let y = currentYear - 1; y <= currentYear + 2; y++) {
        $('#yearSelect').append(`<option value="${y}">${y}</option>`);
    }
    $('#yearSelect').val(currentYear);

    function fetchBuildingInmates() {
        var build  = $(".build_clz").val();
        var month  = $(".month_clz").val();
        var year   = $(".year_clz").val();
        var status = $(".status_clz").val() || 'all';

        if (!build) {
            return;
        }

        if (!month) {
            $(".month_clz").val(currentMonth);
            month = currentMonth;
        }

        $('.status_clz').show();

        $.ajax({
            url: "<?php echo base_url(); ?>Admin/Ajax/inmatesDetails",
            type: "POST",
            data: { Build: build, Month: month, Year: year, Status: status },
            success: function(data) {
                var res = JSON.parse(data);
                $('.inmates_details').html(res.inmates_details);

                if (res.summary) {
                    $('#sumTotal').text(res.summary.total);
                    $('#sumUnpaid').text(res.summary.unpaid);
                    $('#sumPartial').text(res.summary.partial);
                    $('#sumPaid').text(res.summary.paid);
                    $('#summaryBanner').show();
                }

                $('#calendarTable').hide();
                $('#buildingTable').show();
            }
        });
    }

    $('.year_clz').on('change', function() {
        if ($(".build_clz").val()) {
            fetchBuildingInmates();
        } else {
            var year = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>Admin/Ajax/checkYear",
                type: "POST",
                data: { currentYear: year },
                success: function(data) {
                    var res = JSON.parse(data);
                    $('.tbody_data').html(res.year_html);
                }
            });
            $('.status_clz').hide();
            $('#summaryBanner').hide();
            $('#buildingTable').hide();
            $('#calendarTable').show();
        }
    });

    $('.month_clz, .build_clz, .status_clz').on('change', function() {
        fetchBuildingInmates();
    });
});
</script>

</body>
</html>
