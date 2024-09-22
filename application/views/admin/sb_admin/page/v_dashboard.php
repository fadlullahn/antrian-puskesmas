<!-- Morris Charts CSS -->
<link href="css/plugins/morris.css" rel="stylesheet">
<div class="container d-flex justify-content-center">
    <div class="justify-content-center">
        <div class="panel panel-primary justify-content-center">
            <div class="panel-heading justify-content-center">
                <div class="row">
                    <div class="text-center justify-content-center">
                        <div style="font-weight: 800; font-size: xxx-large;" id="nomor-antrian" class="huge">
                            <?php echo $total_antrian; ?>
                        </div>
                        <div>Kajian Awal</div>
                    </div>
                </div>
            </div>
            <a href="/antrian-puskesmas/admin/antrian_kajian_awal">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <!-- <i class="fa fa-comments fa-5x"></i> -->
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $poli_umum ?></div>
                        <div>Poli Umum</div>
                    </div>
                </div>
            </div>
            <a href="/antrian-puskesmas/admin/antrian_poli">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <!-- <i class="fa fa-tasks fa-5x"></i> -->
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $poli_gigi ?></div>
                        <div>Poli Gigi</div>
                    </div>
                </div>
            </div>
            <a href="/antrian-puskesmas/admin/antrian_poli_gigi">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <!--  <i class="fa fa-shopping-cart fa-5x"></i> -->
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $poli_kia ?></div>
                        <div>Poli KIA</div>
                    </div>
                </div>
            </div>
            <a href="/antrian-puskesmas/admin/antrian_poli_kia">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->






<script src="js/jquery.js"></script>
<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>