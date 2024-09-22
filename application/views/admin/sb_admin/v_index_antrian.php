<?php
include 'config.php';

// Ambil tanggal hari ini dalam format MySQL
$currentDate = date('Y-m-d');

$sql = "SELECT antrian.id_antrian, antrian.tgl_antrian, antrian.no_antrian, antrian.id_pasien, antrian.proses, pasien.no_telp, pasien.nama 
        FROM antrian 
        JOIN pasien ON antrian.id_pasien = pasien.id_pasien
        WHERE DATE(antrian.tgl_antrian) = '$currentDate'";
$result = $conn->query($sql);

$countSql = "SELECT COUNT(*) AS jumlah_antrian FROM antrian WHERE DATE(tgl_antrian) = '$currentDate'";
$countResult = $conn->query($countSql);
$row = $countResult->fetch_assoc();
$jumlahAntrian = $row['jumlah_antrian'];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_antrian'])) {
    $id_antrian = $_POST['id_antrian'];

    // Lakukan update kolom proses menjadi 1 untuk id_antrian yang diberikan
    $updateSql = "UPDATE antrian SET proses = 1 WHERE id_antrian = '$id_antrian'";
    if ($conn->query($updateSql) === TRUE) {
        echo "Update berhasil";
    } else {
        echo "Error: " . $conn->error;
    }
    exit; // Keluar dari script PHP setelah melakukan update
}

// Query untuk mencari nomor antrian sekarang (nomor antrian tertinggi)
$sqlSekarang = "SELECT antrian.id_antrian, antrian.no_antrian 
                FROM antrian 
                WHERE DATE(antrian.tgl_antrian) = '$currentDate' AND antrian.proses = 1
                ORDER BY antrian.no_antrian DESC
                LIMIT 1";
$resultSekarang = $conn->query($sqlSekarang);
if ($resultSekarang->num_rows > 0) {
    $rowSekarang = $resultSekarang->fetch_assoc();
    $nomorAntrianSekarang = $rowSekarang['no_antrian'];
} else {
    $nomorAntrianSekarang = '0';
}

// Query untuk mencari nomor antrian selanjutnya
$sqlSelanjutnya = "SELECT antrian.id_antrian, antrian.no_antrian, pasien.no_telp, pasien.nama 
                  FROM antrian 
                  LEFT JOIN pasien ON antrian.id_pasien = pasien.id_pasien
                  WHERE DATE(antrian.tgl_antrian) = '$currentDate' AND antrian.proses = 0
                  ORDER BY antrian.no_antrian ASC
                  LIMIT 1";
$resultSelanjutnya = $conn->query($sqlSelanjutnya);

if ($resultSelanjutnya->num_rows > 0) {
    $rowSelanjutnya = $resultSelanjutnya->fetch_assoc();
    $nomorAntrianSelanjutnya = $rowSelanjutnya['no_antrian'];
    $noTelpSelanjutnya = $rowSelanjutnya['no_telp'];
    $namaSelanjutnya = $rowSelanjutnya['nama'];
} else {
    $nomorAntrianSelanjutnya = '0';
    $noTelpSelanjutnya = '';
    $namaSelanjutnya = '';
}
?>

<?php
// Menghitung nomor antrian selanjutnya yang diinginkan
$nomorAntrianSelanjutnya1 = $nomorAntrianSekarang + 2; // Jika antrian saat ini adalah 1, maka selanjutnya adalah 3, jika 2 maka 4, jika 3 maka 5, dan seterusnya

// Query untuk mencari nomor antrian selanjutnya menggunakan prepared statement
$sqlSelanjutnya1 = "SELECT antrian.id_antrian, antrian.no_antrian, pasien.no_telp, pasien.nama 
                    FROM antrian 
                    LEFT JOIN pasien ON antrian.id_pasien = pasien.id_pasien
                    WHERE DATE(antrian.tgl_antrian) = ? AND antrian.proses = 0 AND antrian.no_antrian = ?
                    ORDER BY antrian.no_antrian ASC
                    LIMIT 1";

$stmt = $conn->prepare($sqlSelanjutnya1);
$stmt->bind_param('si', $currentDate, $nomorAntrianSelanjutnya1);
$stmt->execute();
$resultSelanjutnya1 = $stmt->get_result();

if ($resultSelanjutnya1->num_rows > 0) {
    $rowSelanjutnya1 = $resultSelanjutnya1->fetch_assoc();
    $nomorAntrianSelanjutnya1 = $rowSelanjutnya1['no_antrian'];
    $noTelpSelanjutnya1 = $rowSelanjutnya1['no_telp'];
    $namaSelanjutnya1 = $rowSelanjutnya1['nama'];
} else {
    $nomorAntrianSelanjutnya1 = '0';
    $noTelpSelanjutnya1 = '';
    $namaSelanjutnya1 = '';
}

?>

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
    <link href="css/plugins/morris.css" rel="stylesheet">


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
                <h2 class="mb-4">Antrian Kajian Awal</h2>
                <br>

                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="huge"><?php echo $jumlahAntrian; ?></div>
                                        <div>Jumlah Antrian</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="huge"><?php echo $nomorAntrianSekarang; ?></div>
                                        <div>Antrian Sekarang</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="huge">
                                            <?php echo $nomorAntrianSelanjutnya; ?>
                                        </div>
                                        <div>Antrian Selanjutnya</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="huge">
                                            <?php
                                            // Query untuk menghitung jumlah antrian yang prosesnya == 0
                                            $countProses0Sql = "SELECT COUNT(*) AS jumlah_proses0 FROM antrian WHERE DATE(tgl_antrian) = '$currentDate' AND proses = 0";
                                            $countProses0Result = $conn->query($countProses0Sql);
                                            $rowProses0 = $countProses0Result->fetch_assoc();
                                            echo $rowProses0['jumlah_proses0'];
                                            ?>
                                        </div>
                                        <div>Sisa Antrian</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="container mt-5">
                    <table class="">
                        <thead class="hidden">
                            <tr>
                                <th class="text-center">Nomor Antrian</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="">
                            <?php if ($result->num_rows > 0) : ?>
                                <?php
                                $counter = 0; // Inisialisasi penghitung
                                while ($row = $result->fetch_assoc()) :
                                    if ($row["proses"] == 0) :
                                        $counter++; // Tambahkan penghitung setiap iterasi
                                ?>
                                        <tr class="">
                                            <td class="hidden"><?= $row["no_antrian"] ?></td>
                                            <td class="">
                                                <form method="post">
                                                    <input type="hidden" name="no_antrian" value="<?= $row["no_antrian"] ?>">
                                                    <input type="hidden" name="no_telp" value="<?= $row["no_telp"] ?>">
                                                    <input type="hidden" name="nama_pasien" value="<?= $row["nama"] ?>">
                                                    <?php if ($counter == 1) : ?>
                                                        <!-- Hanya tampilkan tombol pada iterasi pertama -->
                                                        <button type="submit" name="kirimPesan" style="width: 200px; height: 100px;" class="btn btn-primary" onclick="callAndProcess({ id_antrian: <?= $row['id_antrian'] ?>, no_antrian: '<?= $row['no_antrian'] ?>' })">Panggil</button>
                                                        <button style="width: 200px; height: 100px;" class="btn btn-primary" id="callAntrianBtn">Panggil Ulang</button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="huge" colspan="2">ANTRIAN KOSONG</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>



                        <?php
                        if (isset($_POST['kirimPesan'])) {
                            // Token API
                            $token = "jp+DZ6H1pkxy8_D#UP-y";

                            // Ambil nomor telepon dan nama pasien dari form
                            $target = $_POST['no_telp'];
                            $namaPasien = $_POST['nama_pasien'];
                            $noAntrian = $_POST['no_antrian'];

                            $pesan = "Halo $namaPasien,\n\n"
                                . "Kami dari Puskesmas Buntu Batu ingin memberitahukan bahwa nomor antrian Anda, $noAntrian, telah dipanggil.\n\n"
                                . "Mohon datang ke Puskesmas Buntu Batu.\n\n"
                                . "Terima kasih atas kerjasamanya.\n\n"
                                . "Salam sehat,\n"
                                . "Puskesmas Buntu Batu";
                            $curl = curl_init();

                            // Konfigurasi CURL untuk permintaan POST
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.fonnte.com/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array(
                                    'target' => $target,
                                    'message' => $pesan,
                                ),
                                CURLOPT_HTTPHEADER => array(
                                    "Authorization: $token"
                                ),
                            ));

                            // Eksekusi permintaan CURL
                            curl_exec($curl);
                            curl_close($curl);

                            // Redirect ke halaman lain setelah berhasil mengirim
                            // header("Location: antrian_kajian_awal");
                            // exit;
                        }
                        if (isset($_POST['kirimPesan'])) {
                            // Token API
                            $token = "jp+DZ6H1pkxy8_D#UP-y";

                            $target = $noTelpSelanjutnya1;
                            $namaPasien = $namaSelanjutnya1;
                            $noAntrian = $nomorAntrianSelanjutnya1;

                            $pesan = "Halo $namaPasien,\n\n"
                                . "Ini adalah pemberitahuan penting dari Puskesmas Buntu Batu. Nomor antrian Anda, $noAntrian, akan segera dipanggil di kajian Awal.\n\n"
                                . "Mohon bersiap-siap dan pastikan anda berada di Puskesmas Buntu Batu dalam beberapa waktu ke depan.\n\n"
                                . "Terima kasih atas perhatiaanya.\n\n"
                                . "Salam sehat,\n"
                                . "Puskesmas Buntu Batu BATU";
                            $curl = curl_init();

                            // Konfigurasi CURL untuk permintaan POST
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.fonnte.com/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array(
                                    'target' => $target,
                                    'message' => $pesan,
                                ),
                                CURLOPT_HTTPHEADER => array(
                                    "Authorization: $token"
                                ),
                            ));

                            // Eksekusi permintaan CURL
                            curl_exec($curl);
                            curl_close($curl);

                            // Redirect ke halaman lain setelah berhasil mengirim
                            header("Location: antrian_kajian_awal");
                            // exit;
                        }
                        ?>
                    </table>
                </div>

                <script>
                    document.getElementById('callAntrianBtn').addEventListener('click', function() {
                        // Ambil nomor antrian dari PHP (misal nomor antrian didapat dari variabel PHP)
                        var nomorAntrianSekarang = "<?php echo $nomorAntrianSekarang; ?>";

                        // Cek jika nomor antrian valid
                        if (nomorAntrianSekarang !== '0') {
                            // Buat pesan suara
                            const msg = new SpeechSynthesisUtterance();
                            msg.text = "Dipanggil Sekali Lagi Untuk Nomor antrian " + nomorAntrianSekarang + ", silakan ke Kajian awal";
                            window.speechSynthesis.speak(msg);
                        } else {
                            alert('Belum ada nomor antrian yang dipanggil.');
                        }
                    });
                </script>



            </div>
        </div>

    </div>
    <?php $this->load->view('admin/' . $this->session->userdata('theme') . '/v_footer'); ?>

    <script>
        function callAndProcess(params) {
            const id_antrian = params.id_antrian;
            const nomorAntrian = params.no_antrian;

            const msg = new SpeechSynthesisUtterance();
            msg.text = "Nomor antrian " + nomorAntrian + ", silakan ke Kajian awal";
            window.speechSynthesis.speak(msg);

            $.ajax({
                url: '', // Sesuaikan URL dengan endpoint Anda
                type: 'POST',
                data: {
                    id_antrian: id_antrian
                },
                success: function(response) {
                    console.log('Update berhasil');
                    $('tr').find('td').filter(function() {
                        return $(this).text() === nomorAntrian;
                    }).parent('tr').remove();

                    // Refresh halaman setelah berhasil update
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Update gagal: ' + error);
                }
            });
        }
    </script>





    <script src="js/jquery.js"></script>
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
</body>

</html>

<?php
$conn->close();
?>