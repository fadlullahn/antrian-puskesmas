<!-- Brand and toggle get grouped for better mobile display -->
<style type="text/css">
    .navbar-inverse .navbar-collapse,
    .navbar-inverse .navbar-form {
        border-color: #fff !important;
    }
</style>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url('admin/dashboard'); ?>"><b>Puskesmas - Admin</b></a>
</div>
<ul class="nav navbar-right top-nav">
    <li>
        <a class="fa fa-user"></i> <?php echo $this->session->userdata('nama'); ?></a>
    </li>

    <li>
        <a href="<?php echo base_url('admin/login/logout'); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
    </li>
</ul>