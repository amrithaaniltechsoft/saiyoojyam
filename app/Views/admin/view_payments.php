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
    #myTable th.col-sl,
    #myTable td.col-sl,
    #myTable th:first-child,
    #myTable td:first-child {
      width: 50px !important;
      max-width: 55px !important;
      min-width: 45px !important;
      text-align: center !important;
      padding-left: 6px !important;
      padding-right: 6px !important;
      white-space: nowrap !important;
    }
    .kpi-card {
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      transition: all 0.2s ease;
      background: #ffffff;
    }
    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .kpi-icon-box {
      width: 46px;
      height: 46px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }
  </style>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

              <!-- Breadcrumb & Header -->
              <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                  <h4 class="fw-bold py-1 mb-1">
                    <span class="text-muted fw-light">Payments /</span> View Payments
                  </h4>
                  <p class="text-muted mb-0 small">Overview of all resident invoices, collected payments, and pending dues.</p>
                </div>
                <div>
                  <a href="<?= base_url('Admin/Inmates') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-user-check me-1"></i> View Inmates
                  </a>
                </div>
              </div>

              <!-- Top KPI Summary Cards -->
              <div class="row g-3 mb-4">
                <!-- Total Collected -->
                <div class="col-sm-6 col-lg-3">
                  <div class="card kpi-card h-100 shadow-none">
                    <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Total Collected</span>
                        <div class="kpi-icon-box bg-label-success text-success">
                          <i class="bx bx-wallet"></i>
                        </div>
                      </div>
                      <h4 class="mb-1 text-success fw-bold">₹<?= number_format($stats->total_collected ?? 0, 2) ?></h4>
                      <small class="text-muted">Total rent & fees received</small>
                    </div>
                  </div>
                </div>

                <!-- Pending / Outstanding Balance -->
                <div class="col-sm-6 col-lg-3">
                  <div class="card kpi-card h-100 shadow-none">
                    <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Pending Balance</span>
                        <div class="kpi-icon-box bg-label-danger text-danger">
                          <i class="bx bx-time-five"></i>
                        </div>
                      </div>
                      <h4 class="mb-1 text-danger fw-bold">₹<?= number_format($stats->total_balance ?? 0, 2) ?></h4>
                      <small class="text-muted">Total dues remaining to collect</small>
                    </div>
                  </div>
                </div>

                <!-- Total Invoices -->
                <div class="col-sm-6 col-lg-3">
                  <div class="card kpi-card h-100 shadow-none">
                    <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Total Invoices</span>
                        <div class="kpi-icon-box bg-label-primary text-primary">
                          <i class="bx bx-receipt"></i>
                        </div>
                      </div>
                      <h4 class="mb-1 text-primary fw-bold"><?= (int)($stats->total_count ?? 0) ?></h4>
                      <small class="text-muted">Total billed: ₹<?= number_format($stats->total_billed ?? 0, 2) ?></small>
                    </div>
                  </div>
                </div>

                <!-- Payment Status Overview -->
                <div class="col-sm-6 col-lg-3">
                  <div class="card kpi-card h-100 shadow-none">
                    <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-semibold">Status Breakdown</span>
                        <div class="kpi-icon-box bg-label-info text-info">
                          <i class="bx bx-bar-chart-alt-2"></i>
                        </div>
                      </div>
                      <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                        <span class="badge bg-label-success small"><i class="bx bx-check me-0.5"></i><?= (int)($stats->paid_count ?? 0) ?> Paid</span>
                        <span class="badge bg-label-warning small"><i class="bx bx-time me-0.5"></i><?= (int)($stats->partial_count ?? 0) ?> Partial</span>
                        <span class="badge bg-label-danger small"><i class="bx bx-x me-0.5"></i><?= (int)($stats->unpaid_count ?? 0) ?> Unpaid</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Main Payments Table Card -->
              <div class="card">
                <!-- Filter Bar -->
                <div class="card-header border-bottom py-3">
                  <form method="GET" action="<?= base_url('Admin/Payments/View') ?>" id="paymentsFilterForm" class="row g-2 align-items-center">
                    
                    <!-- Month Filter -->
                    <div class="col-md-3 col-sm-6">
                      <label class="form-label small text-muted mb-1">Billing Month</label>
                      <select name="month" class="form-select form-select-sm" onchange="document.getElementById('paymentsFilterForm').submit();">
                        <option value="">All Months</option>
                        <?php if(!empty($billing_months)): foreach($billing_months as $bm): 
                          $valM = date('Y-m', strtotime($bm->pay_month));
                          $labelM = date('F Y', strtotime($bm->pay_month));
                        ?>
                          <option value="<?= $valM ?>" <?= ($month_filter == $valM) ? 'selected' : '' ?>><?= $labelM ?></option>
                        <?php endforeach; endif; ?>
                      </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div class="col-md-3 col-sm-6">
                      <label class="form-label small text-muted mb-1">Payment Status</label>
                      <select name="status" class="form-select form-select-sm" onchange="document.getElementById('paymentsFilterForm').submit();">
                        <option value="">All Statuses</option>
                        <option value="1" <?= ($status_filter === '1') ? 'selected' : '' ?>>Fully Paid</option>
                        <option value="2" <?= ($status_filter === '2') ? 'selected' : '' ?>>Partially Paid</option>
                        <option value="3" <?= ($status_filter === '3') ? 'selected' : '' ?>>Advance Paid</option>
                        <option value="0" <?= ($status_filter === '0') ? 'selected' : '' ?>>Unpaid</option>
                      </select>
                    </div>

                    <!-- Building Filter -->
                    <div class="col-md-3 col-sm-6">
                      <label class="form-label small text-muted mb-1">Building</label>
                      <select name="building" class="form-select form-select-sm" onchange="document.getElementById('paymentsFilterForm').submit();">
                        <option value="">All Buildings</option>
                        <?php if(!empty($buildings)): foreach($buildings as $b): ?>
                          <option value="<?= $b->building_id ?>" <?= ($building_filter == $b->building_id) ? 'selected' : '' ?>><?= esc($b->building_name) ?></option>
                        <?php endforeach; endif; ?>
                      </select>
                    </div>

                    <!-- Filter / Reset Action Buttons -->
                    <div class="col-md-3 col-sm-6 d-flex align-items-end gap-1 mt-auto">
                      <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                      </button>
                      <a href="<?= base_url('Admin/Payments/View') ?>" class="btn btn-sm btn-outline-secondary" title="Reset Filters">
                        <i class="bx bx-refresh"></i> Reset
                      </a>
                    </div>
                  </form>
                </div>

                <!-- Table Content -->
                <div class="table-responsive text-nowrap">
                  <table class="table display" id="myTable">
                    <thead>
                      <tr>
                        <th class="text-center col-sl">Sl no</th>
                        <th>Invoice #</th>
                        <th>Resident / Inmate</th>
                        <th>Room & Building</th>
                        <th>Billing Month</th>
                        <th class="text-end">Total Bill</th>
                        <th class="text-end">Paid Amount</th>
                        <th class="text-end">Balance</th>
                        <th>Paid Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php if(!empty($invoices)): $i=1; foreach($invoices as $inv): ?>
                      <tr>
                        <!-- Sl No -->
                        <td class="text-center col-sl"><?= $i++ ?></td>

                        <!-- Invoice Number -->
                        <td>
                          <span class="fw-bold text-dark">#INV-<?= $inv->invoice_id ?></span>
                        </td>

                        <!-- Inmate Name & Reference ID -->
                        <td>
                          <div class="d-flex flex-column">
                            <span class="fw-semibold text-dark"><?= esc($inv->inmates_name ?: 'Resident #' . $inv->invoice_inmates) ?></span>
                            <small class="text-muted" style="font-size: 11px;">
                              <i class="bx bx-id-card me-0.5"></i><?= esc($inv->inmates_uid ?: 'N/A') ?>
                              <?php if(!empty($inv->inmates_phone_no)): ?>
                                &bull; <i class="bx bx-phone me-0.5"></i><?= esc($inv->inmates_phone_no) ?>
                              <?php endif; ?>
                            </small>
                          </div>
                        </td>

                        <!-- Building & Room -->
                        <td>
                          <span class="fw-semibold text-dark">Room <?= esc($inv->rooms_name ?: 'N/A') ?></span>
                          <small class="text-muted d-block" style="font-size: 11px;">
                            <?= esc($inv->building_name ?: 'Main Building') ?>
                            <?= !empty($inv->room_type_name) ? ' &bull; ' . esc($inv->room_type_name) : '' ?>
                          </small>
                        </td>

                        <!-- Billing Month -->
                        <td data-order="<?= $inv->invoice_payment_month ?>">
                          <span class="badge bg-label-secondary fw-semibold">
                            <?= date('M-Y', strtotime($inv->invoice_payment_month)) ?>
                          </span>
                        </td>

                        <!-- Total Bill -->
                        <td class="text-end fw-semibold">
                          ₹<?= number_format((float)$inv->invoice_total, 2) ?>
                        </td>

                        <!-- Paid Amount -->
                        <td class="text-end">
                          <span class="fw-bold text-success">
                            ₹<?= number_format((float)$inv->invoice_paid_amount, 2) ?>
                          </span>
                        </td>

                        <!-- Balance -->
                        <td class="text-end">
                          <?php if((float)$inv->invoice_balance > 0): ?>
                            <span class="fw-bold text-danger">₹<?= number_format((float)$inv->invoice_balance, 2) ?></span>
                          <?php else: ?>
                            <span class="text-muted">₹0.00</span>
                          <?php endif; ?>
                        </td>

                        <!-- Paid Date -->
                        <td>
                          <?php if(!empty($inv->invoice_paid_date) && $inv->invoice_paid_date != '0000-00-00'): ?>
                            <span class="small text-muted"><?= date('d-M-Y', strtotime($inv->invoice_paid_date)) ?></span>
                          <?php else: ?>
                            <span class="text-muted small">-</span>
                          <?php endif; ?>
                        </td>

                        <!-- Payment Status Badge -->
                        <td>
                          <?php if($inv->invoice_status == 1): ?>
                            <span class="badge bg-label-success"><i class="bx bx-check-circle me-1"></i>Fully Paid</span>
                          <?php elseif($inv->invoice_status == 2): ?>
                            <span class="badge bg-label-warning partiall_paid_clz" 
                                  style="cursor: pointer;" 
                                  data-id="<?= $inv->invoice_id ?>" 
                                  data-total="<?= $inv->invoice_total ?>" 
                                  data-paid="<?= $inv->invoice_paid_amount ?>"
                                  title="Click to record balance payment">
                              <i class="bx bx-time me-1"></i>Partially Paid
                            </span>
                          <?php elseif($inv->invoice_status == 3): ?>
                            <span class="badge bg-label-info"><i class="bx bx-up-arrow-circle me-1"></i>Advance Paid</span>
                          <?php else: ?>
                            <span class="badge bg-label-danger"><i class="bx bx-x-circle me-1"></i>Unpaid</span>
                          <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td class="text-center">
                          <div class="d-flex align-items-center justify-content-center gap-1">
                            <!-- Inmate Receipts & Invoices -->
                            <a class="btn btn-sm btn-icon btn-outline-primary p-1" 
                               href="<?= base_url('Admin/Inmates/Receipt/' . $inv->invoice_inmates) ?>" 
                               title="Manage Inmate Invoices & Payments">
                              <i class="icon-base bx bx-receipt" style="font-size:17px;"></i>
                            </a>

                            <!-- Print Invoice -->
                            <a class="btn btn-sm btn-icon btn-outline-secondary p-1" 
                               href="<?= base_url('Admin/Inmates/Print/' . $inv->invoice_inmates) ?>" 
                               target="_blank" 
                               title="Print Invoice">
                              <i class="icon-base bx bx-printer" style="font-size:17px;"></i>
                            </a>

                            <!-- View Installment History Modal -->
                            <button type="button" 
                                    class="btn btn-sm btn-icon btn-outline-info p-1 history_clz" 
                                    data-history="<?= $inv->invoice_id ?>" 
                                    title="View Payment Installment History">
                              <i class="icon-base bx bx-history" style="font-size:17px;"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach; endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

            </div>
            <!-- / Content -->

            <!-- Footer section start-->
            <?= $this->include('admin/includes/footer') ?>
            <!--Footer section end-->

            <!-- Balance Payment Modal -->
            <div class="modal fade" id="partial_modal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-sm" role="document">
                <form method="post" action="<?= base_url('Admin/Payments/PayBalance') ?>">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Pay Balance Amount</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-2">
                      <div class="mb-3">
                        <label class="form-label small fw-semibold">Amount to Pay</label>
                        <div class="input-group">
                          <span class="input-group-text">₹</span>
                          <input type="number" step="0.01" name="paid_amount" class="form-control amount_clz" required />
                        </div>
                        <input type="hidden" name="invoice_id" class="invoice_id">
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center py-2">
                      <button type="submit" class="btn btn-primary btn-sm w-100">Record Payment</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Installment History Modal -->
            <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Payment Installment History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered table-striped" style="width: 100%;">
                      <thead class="table-light">
                        <tr>
                          <th>Payment Date</th>
                          <th>Amount Paid</th>
                        </tr>
                      </thead>
                      <tbody class="history_data">
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                // Installment History AJAX popup
                $('body').on('click', '.history_clz', function () {
                  var invoice_id = $(this).data('history');
                  $.ajax({
                    url: "<?= base_url('Admin/Inmates/viewHistory') ?>",
                    type: "POST",
                    data: { ID: invoice_id },
                    success: function(data) {
                      try {
                        var res = JSON.parse(data);
                        if (res.status === true) {
                          $('.history_data').html(res.history_html);
                          $('#historyModal').modal('show');
                        } else {
                          if (typeof alertify !== 'undefined') {
                            alertify.error("No separate installment history (One-time payment).").delay(3).dismissOthers();
                          } else {
                            alert("No separate installment history (One-time payment).");
                          }
                        }
                      } catch(e) {
                        alert("Could not load payment history.");
                      }
                    },
                    error: function() {
                      alert("Error loading payment history.");
                    }
                  });
                });

                // Partial Payment Modal Trigger
                $('body').on('click', '.partiall_paid_clz', function () {
                  var id = $(this).data('id');
                  var total = $(this).data('total');
                  var paid = $(this).data('paid');
                  var balance = parseFloat(total) - parseFloat(paid);
                  $('.invoice_id').val(id);
                  $('.amount_clz').val(balance.toFixed(2));
                  $('#partial_modal').modal('show');
                });
              });
            </script>
    
  </body>
</html>
