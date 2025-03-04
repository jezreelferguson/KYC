<style>
  /* Modern UI Styles */
  .main-sidebar {
    background-color: #1e1e2f; /* Dark background */
    color: #fff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }

  .brand-link {
    padding: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .brand-link img {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    transition: transform 0.3s ease;
  }

  .brand-link:hover img {
    transform: scale(1.1);
  }

  .brand-text {
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
  }

  .sidebar {
    padding: 10px;
  }

  .nav-pills .nav-link {
    color: #fff;
    border-radius: 8px;
    margin: 5px 0;
    padding: 10px 15px;
    transition: all 0.3s ease;
  }

  .nav-pills .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
  }

  .nav-pills .nav-link.active {
    background-color: #007bff;
    color: #fff;
    box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
  }

  .nav-icon {
    margin-right: 10px;
    font-size: 1.1rem;
  }

  .nav-treeview {
    padding-left: 20px;
  }

  .nav-treeview .nav-link {
    padding: 8px 15px;
    font-size: 0.9rem;
  }

  .nav-treeview .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.05);
  }

  .nav-header {
    padding: 10px 15px;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .os-scrollbar {
    display: none; /* Hide scrollbars for a cleaner look */
  }
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
    <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image elevation-3">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>

          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link tree-item nav-accounts nav-transactions nav-manage_account">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>
                    Account Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./?page=accounts/manage_account" class="nav-link nav-manage_account">
                      <i class="far fa-circle nav-icon"></i>
                      <p>New Account</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./?page=accounts" class="nav-link nav-index">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Account</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link tree-item nav-transaction nav-deposit nav-withdraw nav-transfer">
                  <i class="nav-icon fas fa-th-list"></i>
                  <p>
                    Transaction
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./?page=transaction" class="nav-link nav-index">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Transactions</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./?page=transaction/deposit" class="nav-link nav-deposit">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Deposit</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./?page=transaction/withdraw" class="nav-link nav-withdraw">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Withdraw</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./?page=transaction/transfer" class="nav-link nav-transfer">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Transfer</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=announcements" class="nav-link nav-announcements">
                  <i class="nav-icon fas fa-bullhorn"></i>
                  <p>Announcements</p>
                </a>
              </li>
              <li class="nav-header">Maintenance</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>Settings</p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  $(document).ready(function(){
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    page = page.split('/');
    page2 = 'index';
    if(Object.keys(page).length > 1)
      page2 = page[1];
    page = page[0];

    if($('.nav-link.nav-'+page).length > 0){
      $('.nav-link.nav-'+page).addClass('active')
      if($('.nav-link.nav-'+page).siblings('.nav-treeview').length > 0){
        $('.nav-link.nav-'+page).parent().addClass('menu-open')
        $('.nav-link.nav-'+page2).addClass('active')
      }
    }
  });
</script>