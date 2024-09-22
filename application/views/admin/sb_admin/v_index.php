<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?php echo base_url('assets/admin/' . $this->session->userdata('theme')); ?>/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo isset($title) ? $title : 'Admin' ?></title>

    <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_header_script'); ?>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_header'); ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_sidebar'); ?>
            </div>
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo isset($judul_1) ? $judul_1 : ''; ?> <small><?php echo isset($judul_2) ? $judul_2 : ''; ?></small>
                        </h1>
                        <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_breadcumbs'); ?>
                    </div>
                </div>
                <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/page/' . $page); ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_footer'); ?>
</body>

</html>