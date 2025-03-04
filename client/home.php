<h1 class="text-dark text-center display-4 mb-4">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="my-4">
<div class="container py-3 m-1 p-2">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <i class="fas fa-id-card fa-3x text-primary"></i>
                        </div>
                        <div class="col-9">
                            <h5 class="card-title text-muted mb-1">Total Users</h5>
                            <h2 class="mb-0">
                                <?php echo number_format($conn->query("SELECT * FROM accounts")->num_rows); ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <i class="fas fa-wallet fa-2x text-success mr-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-subtitle text-muted">Account Number</h5>
                            <h3 class="card-title"><?php echo $_settings->userdata('account_number') ?></h3>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-coins fa-2x text-warning mr-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-subtitle text-muted">Current Balance (US$)</h5>
                            <h3 class="card-title">$ <?php echo number_format($_settings->userdata('balance'),2) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

