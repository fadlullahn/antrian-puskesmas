<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitor</title>
    <link rel="shortcut icon" href="assets/user/img/logo.png">

    <!-- Custom fonts for this theme -->
    <link href="<?php echo base_url('assets/user') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="<?php echo base_url('assets/user') ?>/css/freelancer.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/user') ?>/lib/noty.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/user') ?>/lib/themes/metroui.css" rel="stylesheet">

</head>

<body id="page-top">
    <script>
        var eventSource = new EventSource('sse_poli.php');

        eventSource.onmessage = function(event) {
            var nomorAntrianPoli = event.data;
            document.getElementById('nomor-antrian-poli').innerHTML = nomorAntrianPoli;
        };

        eventSource.onerror = function(error) {
            console.error('SSE error:', error);
            eventSource.close();
        };
    </script>

    <script>
        var eventSource = new EventSource('sse_poli_gigi.php');

        eventSource.onmessage = function(event) {
            var nomorAntrianPoliGigi = event.data;
            document.getElementById('nomor-antrian-poli-gigi').innerHTML = nomorAntrianPoliGigi;
        };

        eventSource.onerror = function(error) {
            console.error('SSE error:', error);
            eventSource.close();
        };
    </script>

    <script>
        var eventSource = new EventSource('sse_poli_kia.php');

        eventSource.onmessage = function(event) {
            var nomorAntrianPoliKia = event.data;
            document.getElementById('nomor-antrian-poli-kia').innerHTML = nomorAntrianPoliKia;
        };

        eventSource.onerror = function(error) {
            console.error('SSE error:', error);
            eventSource.close();
        };
    </script>


    <!-- Masthead -->
    <header class="masthead bg-primary text-white text-center d-flex align-items-center">
        <div class="container d-flex flex-column align-items-center">
            <div class="row my-5 max-w-lg">
                <div class="col-12 mb-4">
                    <div class="font-weight-bold border p-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 display-4">Poli Umum</h6>
                        <div class="border p-4 display-1" id="nomor-antrian-poli">
                            <?php echo $nomorAntrianPoli; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="border p-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 display-4">Poli Gigi</h6>
                        <div class="border p-4 display-1" id="nomor-antrian-poli-gigi">
                            <?php echo $nomorAntrianPoliGigi; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border p-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 display-4">Poli Kesehatan Ibu & Anak</h6>
                        <div class="border p-4 display-1" id="nomor-antrian-poli-kia">
                            <?php echo $nomorAntrianPoliKia; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url('assets/user') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/user') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url('assets/user') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="<?php echo base_url('assets/user') ?>/js/jqBootstrapValidation.js"></script>
    <script src="<?php echo base_url('assets/user') ?>/js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo base_url('assets/user') ?>/js/freelancer.min.js"></script>
    <script src="<?php echo base_url('assets/user') ?>/lib/noty.min.js"></script>


</body>

</html>