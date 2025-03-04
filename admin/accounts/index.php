<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="card card-outline card-primary shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-users mr-2"></i>Account Management</h3>
        <div class="card-tools">
            <a href="?page=accounts/manage_account" class="btn btn-light btn-sm"><i class="fas fa-plus mr-1"></i>Create New Account</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <!-- Search and filter row -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="search-accounts" class="form-control" placeholder="Search accounts...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="balance-filter" class="custom-select">
                        <option value="">All Balances</option>
                        <option value="low">Low Balance (< $1,000.00)</option>
                        <option value="medium">Medium Balance ($1,000.00 - $10,000.00)</option>
                        <option value="high">High Balance (> $10,000.00)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="date-filter" class="custom-select">
                        <option value="">All Dates</option>
                        <option value="today">Added Today</option>
                        <option value="week">Added This Week</option>
                        <option value="month">Added This Month</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button id="export-btn" class="btn btn-success btn-sm btn-block"><i class="fas fa-file-export mr-1"></i>Export</button>
                </div>
            </div>

            <!-- Accounts summary cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-accounts">0</h3>
                            <p>Total Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="total-balance">$0</h3>
                            <p>Total Balance</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="avg-balance">$0</h3>
                            <p>Average Balance</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="inactive-accounts">0</h3>
                            <p>Inactive Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="accounts-table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Account #</th>
                            <th>Name</th>
                            <th class="text-right">Current Balance</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Last Updated</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT *, concat(lastname,', ',firstname, middlename) as `name` from `accounts` order by concat(lastname,', ',firstname, middlename) asc");
                        $total_balance = 0;
                        $account_count = $qry->num_rows;
                        
                        while($row = $qry->fetch_assoc()):
                            $total_balance += $row['balance'];
                            // Determine status based on last activity or other criteria
                            $last_update = strtotime($row['date_updated']);
                            $now = strtotime(date('Y-m-d H:i:s'));
                            $diff = $now - $last_update;
                            $days_inactive = floor($diff / (60 * 60 * 24));
                            
                            $status = 'Active';
                            $status_class = 'success';
                            if($days_inactive > 90) {
                                $status = 'Inactive';
                                $status_class = 'danger';
                            } elseif($days_inactive > 30) {
                                $status = 'Warning';
                                $status_class = 'warning';
                            }
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td>
                                <span class="badge badge-primary"><?php echo $row['account_number'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-circle">
                                        <div class="avatar-initials bg-secondary text-white">
                                            <?php echo substr($row['firstname'], 0, 1) . substr($row['lastname'], 0, 1); ?>
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <strong><?php echo $row['name'] ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <span class="font-weight-bold <?php echo ($row['balance'] < 1000) ? 'text-danger' : 'text-success'; ?>">
                                    $<?php echo number_format($row['balance'], 2) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $status_class; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td>
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?php echo date("M d, Y", strtotime($row['date_created'])) ?>
                            </td>
                            <td>
                                <i class="far fa-clock mr-1"></i>
                                <?php echo date("M d, Y g:i A", strtotime($row['date_updated'])) ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="./?page=accounts/manage_account&id=<?php echo $row['id'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit Account">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="./?page=accounts/view_account&id=<?php echo $row['id'] ?>" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success deposit-btn" data-id="<?php echo $row['id'] ?>" data-toggle="tooltip" title="Make Deposit">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning withdraw-btn" data-id="<?php echo $row['id'] ?>" data-toggle="tooltip" title="Make Withdrawal">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete_data" data-id="<?php echo $row['id'] ?>" data-toggle="tooltip" title="Delete Account">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total Balance:</th>
                            <th class="text-right">$<?php echo number_format($total_balance, 2); ?></th>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <div class="row">
            <div class="col-md-6">
                Showing <span id="shown-entries">0</span> of <span id="total-entries">0</span> entries
            </div>
            <div class="col-md-6 text-right">
                Last updated: <span id="last-update-time"><?php echo date('M d, Y g:i A'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="depositModalLabel">Make a Deposit</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deposit-form">
                <div class="modal-body">
                    <input type="hidden" name="account_id" id="deposit_account_id">
                    <div class="form-group">
                        <label for="account_name">Account Name</label>
                        <input type="text" class="form-control" id="deposit_account_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="current_balance">Current Balance</label>
                        <input type="text" class="form-control" id="deposit_current_balance" readonly>
                    </div>
                    <div class="form-group">
                        <label for="deposit_amount">Deposit Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" class="form-control" id="deposit_amount" name="amount" min="0.01" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deposit_remarks">Remarks</label>
                        <textarea class="form-control" id="deposit_remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="withdrawModalLabel">Make a Withdrawal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="withdraw-form">
                <div class="modal-body">
                    <input type="hidden" name="account_id" id="withdraw_account_id">
                    <div class="form-group">
                        <label for="account_name">Account Name</label>
                        <input type="text" class="form-control" id="withdraw_account_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="current_balance">Current Balance</label>
                        <input type="text" class="form-control" id="withdraw_current_balance" readonly>
                    </div>
                    <div class="form-group">
                        <label for="withdraw_amount">Withdrawal Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" class="form-control" id="withdraw_amount" name="amount" min="0.01" step="0.01" required>
                        </div>
                        <small id="withdraw_error" class="form-text text-danger d-none">Withdrawal amount cannot exceed current balance.</small>
                    </div>
                    <div class="form-group">
                        <label for="withdraw_remarks">Remarks</label>
                        <textarea class="form-control" id="withdraw_remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Submit Withdrawal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Account Deletion</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this account? This action cannot be undone and all transactions associated with this account will also be deleted.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This will permanently remove all data related to this account.
                </div>
                <div class="form-group">
                    <label for="delete_confirmation">Type "DELETE" to confirm:</label>
                    <input type="text" class="form-control" id="delete_confirmation">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete" disabled>Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable with advanced options
        var accountsTable = $('#accounts-table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [[2, 'asc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columnDefs: [
                {
                    targets: [7],
                    orderable: false
                }
            ],
            initComplete: function() {
                // Update summary stats
                updateSummaryStats();
                
                // Update shown entries text
                var info = this.api().page.info();
                $('#shown-entries').text(info.recordsDisplay);
                $('#total-entries').text(info.recordsTotal);
                
                // Enable tooltips
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        
        // Apply formatted values directly to the elements
        var totalBalance = <?php echo $total_balance; ?>;
        var totalAccounts = <?php echo $account_count; ?>;
        var avgBalance = totalBalance / (totalAccounts || 1); // Avoid division by zero
        
        $('#total-balance').text(formatShortCurrency(totalBalance));
        $('#avg-balance').text(formatShortCurrency(avgBalance));
        
        // Custom search functionality
        $('#search-accounts').keyup(function() {
            accountsTable.search($(this).val()).draw();
        });
        
        // Handle balance filtering
        $('#balance-filter').change(function() {
            var val = $(this).val();
            
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (val === '') return true;
                
                var balance = parseFloat(data[3].replace('$', '').replace(',', ''));
                
                if (val === 'low' && balance < 1000) return true;
                if (val === 'medium' && balance >= 1000 && balance <= 10000) return true;
                if (val === 'high' && balance > 10000) return true;
                
                return false;
            });
            
            accountsTable.draw();
            $.fn.dataTable.ext.search.pop();
        });
        
        // Handle date filtering
        $('#date-filter').change(function() {
            var val = $(this).val();
            
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (val === '') return true;
                
                var dateStr = data[5];
                var date = new Date(dateStr);
                var now = new Date();
                
                if (val === 'today') {
                    return date.toDateString() === now.toDateString();
                } else if (val === 'week') {
                    var oneWeekAgo = new Date();
                    oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
                    return date >= oneWeekAgo;
                } else if (val === 'month') {
                    var oneMonthAgo = new Date();
                    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                    return date >= oneMonthAgo;
                }
                
                return true;
            });
            
            accountsTable.draw();
            $.fn.dataTable.ext.search.pop();
        });
        
        // Function to format currency in short form (K for thousands, M for millions)
        function formatShortCurrency(value) {
            if (value >= 1000000) {
                return '$' + (value / 1000000).toFixed(1) + 'M';
            } else if (value >= 1000) {
                return '$' + (value / 1000).toFixed(1) + 'K';
            } else {
                return '$' + value.toFixed(0);
            }
        }
        
        // Update summary stats with shortened format
        function updateSummaryStats() {
            var totalAccounts = <?php echo $account_count; ?>;
            var totalBalance = <?php echo $total_balance; ?>;
            var avgBalance = totalBalance / (totalAccounts || 1); // Avoid division by zero
            
            $('#total-accounts').text(totalAccounts);
            
            // Format total balance in shortened format
            $('#total-balance').text(formatShortCurrency(totalBalance));
            
            // Format average balance in shortened format
            $('#avg-balance').text(formatShortCurrency(avgBalance));
            
            // Count inactive accounts
            var inactiveCount = 0;
            $('.badge-danger').each(function() {
                if ($(this).text().trim() === 'Inactive') {
                    inactiveCount++;
                }
            });
            $('#inactive-accounts').text(inactiveCount);
        }
        
        // Format numbers with commas and two decimal places (for detailed views)
        function numberWithCommas(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if (parts.length === 1) {
                parts.push("00");
            } else if (parts[1].length === 1) {
                parts[1] = parts[1] + "0";
            }
            return parts.join(".");
        }
        
        // Handle deposit button click
        $('.deposit-btn').click(function() {
            var id = $(this).data('id');
            
            // Fetch account details via AJAX
            $.ajax({
                url: _base_url_+"classes/Master.php?f=get_account",
                method: "POST",
                data: {id: id},
                dataType: "json",
                success: function(resp) {
                    if(resp.status === 'success') {
                        $('#deposit_account_id').val(resp.data.id);
                        $('#deposit_account_name').val(resp.data.name);
                        $('#deposit_current_balance').val('$' + numberWithCommas(parseFloat(resp.data.balance).toFixed(2)));
                        $('#depositModal').modal('show');
                    } else {
                        alert_toast("An error occurred.", 'error');
                    }
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                }
            });
        });
        
        // Handle withdrawal button click
        $('.withdraw-btn').click(function() {
            var id = $(this).data('id');
            
            // Fetch account details via AJAX
            $.ajax({
                url: _base_url_+"classes/Master.php?f=get_account",
                method: "POST",
                data: {id: id},
                dataType: "json",
                success: function(resp) {
                    if(resp.status === 'success') {
                        $('#withdraw_account_id').val(resp.data.id);
                        $('#withdraw_account_name').val(resp.data.name);
                        $('#withdraw_current_balance').val('$' + numberWithCommas(parseFloat(resp.data.balance).toFixed(2)));
                        $('#withdrawModal').modal('show');
                    } else {
                        alert_toast("An error occurred.", 'error');
                    }
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                }
            });
        });
        
        // Handle deposit form submission
        $('#deposit-form').submit(function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            start_loader();
            $.ajax({
                url: _base_url_+"classes/Master.php?f=make_deposit",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(resp) {
                    if(resp.status === 'success') {
                        $('#depositModal').modal('hide');
                        alert_toast("Deposit successful.", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("An error occurred.", 'error');
                    }
                    end_loader();
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            });
        });
        
        // Handle withdrawal form submission
        $('#withdraw-form').submit(function(e) {
            e.preventDefault();
            
            var amount = parseFloat($('#withdraw_amount').val());
            var currentBalance = parseFloat($('#withdraw_current_balance').val().replace('$', '').replace(/,/g, ''));
            
            if (amount > currentBalance) {
                $('#withdraw_error').removeClass('d-none');
                return false;
            } else {
                $('#withdraw_error').addClass('d-none');
            }
            
            var formData = $(this).serialize();
            
            start_loader();
            $.ajax({
                url: _base_url_+"classes/Master.php?f=make_withdrawal",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(resp) {
                    if(resp.status === 'success') {
                        $('#withdrawModal').modal('hide');
                        alert_toast("Withdrawal successful.", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("An error occurred.", 'error');
                    }
                    end_loader();
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            });
        });
        
        // Handle delete confirmation input
        $('#delete_confirmation').keyup(function() {
            var value = $(this).val();
            if (value === 'DELETE') {
                $('#confirm-delete').prop('disabled', false);
            } else {
                $('#confirm-delete').prop('disabled', true);
            }
        });
        
        // Handle delete button click
        $('.delete_data').click(function() {
            var id = $(this).data('id');
            $('#delete_confirmation').val('');
            $('#confirm-delete').prop('disabled', true);
            $('#confirm-delete').data('id', id);
            $('#deleteModal').modal('show');
        });
        
        // Handle confirm delete button click
        $('#confirm-delete').click(function() {
            var id = $(this).data('id');
            
            start_loader();
            $.ajax({
                url: _base_url_+"classes/Master.php?f=delete_account",
                method: "POST",
                data: {id: id},
                dataType: "json",
                success: function(resp) {
                    if(resp.status === 'success') {
                        $('#deleteModal').modal('hide');
                        alert_toast("Account deleted successfully.", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("An error occurred.", 'error');
                    }
                    end_loader();
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            });
        });
        
        // Initialize export button
        $('#export-btn').click(function() {
            accountsTable.button('.buttons-excel').trigger();
        });
    });
</script>

<style>
    /* Custom avatar styles */
    .avatar {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }
    
    .avatar-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: bold;
        border-radius: 50%;
    }
    
    /* Improve readability */
    .table {
        font-size: 0.9rem;
    }
    
    /* Highlight row on hover */
    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    /* Style for status badges */
    .badge {
        padding: 0.4rem 0.6rem;
    }
    
    /* Improve small-box appearance */
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.25rem;
        position: relative;
        padding: 1.25rem;
        transition: all 0.3s;
    }
    
    .small-box .inner {
        padding: 0.625rem;
    }
    
    .small-box .inner h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .small-box .icon {
        position: absolute;
        top: 0.625rem;
        right: 0.625rem;
        font-size: 2.75rem;
        opacity: 0.3;
    }
    
    .small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>