<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  
  <!--header section start-->

   <?= $this->include('admin/includes/header')?>

  <!--header section end-->

  <style>
    .history_btn{
      
      background: cadetblue;
      border: cadetblue;
      color: #fff !important;

    }

    .history_btn:hover {

      background: cadetblue;
      border: cadetblue;
      color: #fff !important;
    }

    .historyTable,
    .historyTable th,
    .historyTable td {

      border: 1px solid #dbdee0;
      border-collapse: collapse;

    }

    .historyTable th,
    .historyTable td {

      padding: 10px 10px;

    }

    .historyTable th{

      color: #000000c4;
      font-weight: 500;

    }
    

  </style>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Layout & Basic with Icons -->
              <div class="row mb-6 gy-6">
                <!-- Basic Layout -->
                <?php 

                  $check_date = date('Y-m-01');  if($last_paid_amount!=$check_date){

                    $oldDate = $inmates_check_out;

                    $date = new DateTime($oldDate);

                    $date->setDate($date->format('Y'), $date->format('m'), 01);

                    $newCheckDate = $date->format('Y-m-d');

                    if($last_paid_amount!=$newCheckDate){
                    
                ?> 
                <div class="col-xxl invoice_detail">
                  <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">View Invoice</h5>
                      
                    </div>
                    <div class="card-body">
                      <form id="add_form" enctype="multipart/form-data">

                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="" id="basic-default-name" value="<?php echo $inmates->inmates_name;?>" readonly/>
                          </div>
                        </div>

                         

                       
                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Join In Date</label>
                          <div class="col-sm-10">
                            <input type="date" class="form-control join_in_date_clz" name="" value="<?php echo $inmates->inmates_check_in_date;?>" id="html5-date-input" readonly/>
                          </div>
                        </div>


                         <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Payment Month</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control payment_month" name="" value="<?php echo date('M-Y',strtotime($payment_month));?>" id="html5-date-input" readonly/>
                          </div>
                        </div>

                        
                        



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Building</label>
                          <div class="col-sm-10">
                             <input type="text" class="form-control" name="" id="basic-default-name" value="<?php echo $inmates->building_name;?>" readonly/>
                          </div>
                        </div>


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rooms</label>
                          <div class="col-sm-10">
                             <input type="text" class="form-control" name="" id="basic-default-name" value="<?php echo $inmates->rooms_name;?>" readonly/>
                          </div>
                        </div>


                        <?php if(empty($invoices)){ ?> 

                        <div class="row mb-6 caution_div">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Caution Deposit</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control caution_deposit" name="caution_deposit" id="basic-default-name" value="<?php echo $tariffs->tariffs_caution_deposit;?>" readonly />
    
                            <!-- Checkbox added here -->
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" value="1" id="cautionCheck" name="caution_check" checked>
                              <label class="form-check-label" for="cautionCheck">
                                Pay Caution Deposit
                              </label>
                            </div>
                          </div>
                        </div>


                        <!---->

                        <?php } ?>

                        <?php if(empty($invoices)){ ?> 

                         <div class="row mb-6 admission_fees">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Admission fees</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control admission_fee" name="admission_fees" id="basic-default-name" value="<?php echo $tariffs->tariffs_admission_fees;?>" readonly/>
                            <!-- Checkbox added here -->
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" value="2" id="admissionFees" name="admission_check" checked>
                              <label class="form-check-label" for="admissionFees">
                                Pay Admission fees
                              </label>
                            </div>
                          
                          </div>
                        </div>

                        <?php } ?>



                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Rent Per Month</label>
                          <div class="col-sm-10">
                             <input type="text" class="form-control rent_per_day" name="one_month_amount" id="basic-default-name" value="<?php echo $tariffs->tariffs_price;?>" readonly/>
                          </div>
                        </div>


                        
                        <!--<div class="row mb-6 balance_amt_div" style="<?php if(!empty($last_paid_invoice->invoice_balance)){ echo "display:none"; } ?>">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Last Month’s Balance</label>
                          <div class="col-sm-10">
                             <input type="text" class="form-control balance_amt" name="one_month_amount" id="basic-default-name" value="<?php if(isset($last_paid_invoice->invoice_balance)){ echo $last_paid_invoice->invoice_balance; }?>" readonly/>
                          </div>
                        </div>--->


                        <div class="row mb-6 balance_amt_div" style="<?php echo (!empty($last_paid_invoice->invoice_balance) && $last_paid_invoice->invoice_balance!=0.00) ? '' : 'display:none'; ?>">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Last Month’s Balance</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control balance_amt" name="one_month_amount" id="basic-default-name" 
                              value="<?php echo !empty($last_paid_invoice->invoice_balance) ? $last_paid_invoice->invoice_balance : ''; ?>" readonly/>
                          </div>
                        </div>
                        


                        <div class="row mb-6">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Total Amount</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control total_amount" name="total_amount" id="basic-default-name" value="<?php echo $total_rent_month; ?>" readonly/>
                            <!---->
                             <!-- Checkbox added here -->
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="checkbox" value="3" id="fullyPaid" name="fully_paid" checked>
                              <label class="form-check-label" for="">
                                Fully Paid
                              </label>
                            </div>
                            <!---->
                          </div>
                        </div>

                        <!---->

                        <div class="row mb-6 paid_status_div" style="display:none;">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Paid Amount</label>
                          <div class="col-sm-10">
                             <input type="text" class="form-control paid_input_clz" name="paid_amount" id="basic-default-name" value="" />
                          </div>
                        </div>

                        <!---->


                        <input type="hidden" name="inmates_id" value="<?php echo $inmates->inmates_id; ?>">
                        
                        
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="<?php echo base_url();?>Admin/Inmates/Print" target="_blank" class="btn btn-primary" style="color:#fff;">Print Invoice</a>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
                <?php } } ?>
                <!-- Basic with Icons -->



                 <!-- Basic Bootstrap Table -->
                 <div class="card">
                <h5 class="card-header">View Payments</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th>Payment Month</th>
                        <th>Paid Date</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Status</th> 
                        <th>Payment History</th>
                        <!--<th>Action</th>---> 
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 payment_data">

                      <?php foreach($invoices as $invoice){ ?> 
                        
                      <tr>

                        <td data-order="<?= $invoice->invoice_payment_month ?>">
                          <?= date('M-Y', strtotime($invoice->invoice_payment_month)) ?>
                        </td>
                       
                        <td><?php echo $invoice->invoice_paid_date;?></td>

                        <td><?php echo $invoice->invoice_total;?></td>

                        <td><?php echo $invoice->invoice_paid_amount;?></td>

                        <?php if($invoice->invoice_status == 1){ ?> 
                          <td><span class="btn btn-success">Fully Paid</span></td>
                        <?php } elseif($invoice->invoice_status == 2){ ?> 
                          <td>
                              <span class="btn btn-warning partiall_paid_clz" data-id="<?php echo $invoice->invoice_id;?>" data-total="<?php echo $invoice->invoice_total;?>" data-paid="<?php echo $invoice->invoice_paid_amount;?>">Partially Paid</span>
                              
                          </td>
                        <?php } elseif($invoice->invoice_status == 3){ ?> 
                          <td><span class="btn btn-info">Advance Paid</span></td>
                        <?php } ?>

                        <td><span class="btn history_btn history_clz" data-history="<?php echo $invoice->invoice_id; ?>">History</span></td>

                      </tr>

                      <?php } ?>
                      
                     
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->


                   




                
              </div>
            </div>
            <!-- / Content -->

            

            <!-- Footer -->
            
            <?= $this->include('admin/includes/footer') ?>

            <!-- / Footer -->

            <!--partially paid modal start-->

            <div class="modal fade" id="partial_modal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-sm" role="document">
                <form method="post" action="<?php echo base_url();?>Admin/Inmates/History">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Balance Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" style="padding-bottom: 2px;">
                    <div class="row">
                      <div class="col mb-6">
                        <label for="nameSmall" class="form-label">Amount</label>
                        <input type="text" id="" name="paid_amount" class="form-control amount_clz"/>
                        <input type="hidden" name="invoice_id" class="invoice_id">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer" style="justify-content: center;">
                    <button type="submit" class="btn btn-primary" style="justify-content: center;">Save changes</button>
                  </div>
                </div>
                </form>
              </div>
            </div>

            <!--partially paid modal end-->


            <!--history modal start-->

            <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Payment Details</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close">
                    </button>
                  </div>
                  <div class="modal-body">

                    <table class="historyTable" style="width: 100%;">
                        <thead>
                          <tr>
                            <th>Payment Date</th>
                            <th>Amount</th>
                          </tr>
                        </thead>

                        <tbody class="history_data">
                          

                        </tbody>

                    </table>
                    
                  </div>
                  
                </div>
              </div>
            </div>

            <!--history modal end-->

            <script>
              document.addEventListener("DOMContentLoaded", function(event) {
                 
    


                /*caution_deposit checked or unchecked*/

                $("#cautionCheck").on('change', function () {

                  var caution_deposit = parseFloat($('.caution_deposit').val()) || 0;

                  
                  var total_amount_raw = $('.total_amount').val().replace(/,/g, '');
                  var total_amount = parseFloat(total_amount_raw) || 0;

                  var current_amount;

                  if ($(this).is(':checked')) {
                      current_amount = total_amount + caution_deposit;
                  } else {
                      current_amount = total_amount - caution_deposit;
                  }

                  var formattedPrice = current_amount.toLocaleString("en-US", {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                  });

                  $('.total_amount').val(formattedPrice);
                
                });

                /*end section*/



                /*admission fees is checked or unchecked*/

                $("#admissionFees").on('change', function () {

                  var admission_fees = parseFloat($('.admission_fee').val()) || 0;
                   
                  //console.log(admission_fees);
                  var total_amount_raw = $('.total_amount').val().replace(/,/g, '');
                  var total_amount = parseFloat(total_amount_raw) || 0;

                  var current_amount;

                  if ($(this).is(':checked')) {
                      
                      current_amount = total_amount + admission_fees;
                      
                  } else {
                      
                      current_amount = total_amount - admission_fees;
                      
                  }

                  
                  var formattedPrice = current_amount.toLocaleString("en-US", {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                  });

                  $('.total_amount').val(formattedPrice);
                
                });

                /**/


                /*paid status section start*/

                $('#fullyPaid').on('change',function () {

                  if ($(this).is(':checked')) {
                      
                    $('.paid_status_div').hide();

                    $('.paid_input_clz').val('');
                      
                  }else{
                      
                    $('.paid_status_div').show();
                      
                  }

                });

                /**/


                /*partially paid status start*/

                //$('.partiall_paid_clz').on('click',function () {

                $('body').on('click', '.partiall_paid_clz', function () {

                  var invoice_id = $(this).data('id');

                  var total_amount = parseFloat($(this).data('total'));

                  var paid_amount = parseFloat($(this).data('paid'));

                  var balance     = total_amount -  paid_amount;

                  $('.amount_clz').val(balance);

                  $('.invoice_id').val(invoice_id);

                  $('#partial_modal').modal('show');


                });

                /*partially paid status end*/


                /*payment history start*/

                //$('.history_clz').on('click',function () {

                $('body').on('click','.history_clz',function () {


                  var invoice_id = $(this).data('history');

                  $.ajax({

                        url: "<?php echo base_url(); ?>Admin/Inmates/viewHistory",
                        type: "POST",
                        data: {ID :invoice_id, },
                        success: function(data) {

                          var data = JSON.parse(data);

                          if(data.status === true){

                            $('.history_data').html(data.history_html);

                            $('#historyModal').modal('show');

                          }else{

                            alertify.error("No History: One-Time Payment").delay(3).dismissOthers();
                          }


                        }
                  });

                 


                });

                /*payment history end*/


                

                /*add section*/  
                
                $(document).ready(function () {
                  var form = $('#add_form');
                  form.validate({
                    rules: {
                    
                      required: 'required',
                    },
                    messages: {
                    
                      required: 'This field is required',
                    },
                    errorPlacement: function (error, element) {
                      error.insertAfter(element); // or leave empty to suppress
                    },
                    errorClass: "text-danger", 
                    submitHandler: function (currentForm) {
                      $.ajax({
                        url: "<?php echo base_url(); ?>Admin/Inmates/AddReceipt",
                        type: "POST",
                        data: $(currentForm).serialize(), // Use FormData only if you're uploading files
                        success: function(response) {

                          console.log(response);

                          var data = JSON.parse(response);

                          $('.payment_data').html(data.payment_data)

                          alertify.success(data.msg).delay(3).dismissOthers();

                          $('.caution_div').hide();

                          $('.admission_fees').hide();

                          $('.paid_status_div').hide();

                          $('#fullyPaid').prop('checked', true);

                          $('.paid_input_clz').val('');
                          
                          if(data.payment === 1){
                           
                            $('.invoice_detail').hide();

                          }
                          else{
                           
                            $('.invoice_detail').show();

                            $('.payment_month').val(data.payment_month1);

                            $('.rent_per_day').val(data.rent_per_day);

                            $('.total_amount').val(data.monthly_rent);
                            
                            if(data.last_month_balance !=""){
                               
                              $('.balance_amt').val(data.last_month_balance);

                              $('.balance_amt_div').show();

                            }
                            else{
                              
                              $('.balance_amt').val();

                              $('.balance_amt_div').hide();

                            }

                          }
                        }
                      });
                    }
                  });
                });

                /*end section*/

                /*sorted by start*/
                $('#myTable').DataTable({
                  "order": [[0, "desc"]] 
                });

                /*end*/


       
              });
            </script>

   
  </body>
</html>
