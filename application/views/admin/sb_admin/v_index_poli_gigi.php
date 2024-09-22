<?php
include 'config.php';

// Ambil tanggal hari ini dalam format MySQL
$currentDate = date('Y-m-d');

$sql = "SELECT antrian_poli.id_antrian_poli, antrian_poli.tgl_antrian_poli, antrian_poli.no_antrian_poli, antrian_poli.id_pasien, antrian_poli.proses, pasien.no_telp, pasien.nama, kategori_poli.kode_poli, antrian_poli.id_poli
        FROM antrian_poli 
        JOIN pasien ON antrian_poli.id_pasien = pasien.id_pasien
        JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli
        WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate'";

$result = $conn->query($sql);


// Query untuk menghitung jumlah antrian_poli dengan kode_poli 'PLGG'
$countSql = "SELECT COUNT(*) AS jumlah_antrian_poli
             FROM antrian_poli
             JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli
             WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate'
               AND kategori_poli.kode_poli = 'PLGG'";
$countResult = $conn->query($countSql);

if ($countResult === false) {
    // Penanganan kesalahan jika query gagal
    echo "Error: " . $conn->error;
} else {
    $row = $countResult->fetch_assoc();
    $jumlahAntrian_poli = $row['jumlah_antrian_poli'];
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_antrian_poli'])) {
    $id_antrian_poli = $_POST['id_antrian_poli'];

    // Lakukan update kolom proses menjadi 1 untuk id_antrian_poli yang diberikan
    $updateSql = "UPDATE antrian_poli SET proses = 1 WHERE id_antrian_poli = '$id_antrian_poli'";
    if ($conn->query($updateSql) === TRUE) {
        echo "Update berhasil";
    } else {
        echo "Error: " . $conn->error;
    }
    exit; // Keluar dari script PHP setelah melakukan update
}

// Query untuk mencari nomor antrian_poli sekarang (nomor antrian_poli tertinggi) dengan kode_poli 'PLGG'
$sqlSekarang = "SELECT antrian_poli.id_antrian_poli, antrian_poli.no_antrian_poli 
                FROM antrian_poli 
                JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli
                WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate' 
                  AND antrian_poli.proses = 1 
                  AND kategori_poli.kode_poli = 'PLGG'
                ORDER BY antrian_poli.no_antrian_poli DESC
                LIMIT 1";

$resultSekarang = $conn->query($sqlSekarang);

if ($resultSekarang === false) {
    // Penanganan kesalahan jika query gagal
    echo "Error: " . $conn->error;
} else {
    if ($resultSekarang->num_rows > 0) {
        $rowSekarang = $resultSekarang->fetch_assoc();
        $nomorAntrian_poliSekarang = $rowSekarang['no_antrian_poli'];
    } else {
        $nomorAntrian_poliSekarang = '0';
    }
}



// Query untuk mencari nomor antrian_poli selanjutnya dengan kode_poli 'PLGG'
$sqlSelanjutnya = "SELECT antrian_poli.id_antrian_poli, antrian_poli.no_antrian_poli
                  FROM antrian_poli
                  JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli
                  WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate' 
                    AND antrian_poli.proses = 0 
                    AND kategori_poli.kode_poli = 'PLGG'
                  ORDER BY antrian_poli.no_antrian_poli ASC
                  LIMIT 1";

$resultSelanjutnya = $conn->query($sqlSelanjutnya);

if ($resultSelanjutnya === false) {
    // Penanganan kesalahan jika query gagal
    echo "Error: " . $conn->error;
} else {
    if ($resultSelanjutnya->num_rows > 0) {
        $rowSelanjutnya = $resultSelanjutnya->fetch_assoc();
        $nomorAntrian_poliSelanjutnya = $rowSelanjutnya['no_antrian_poli'];
    } else {
        $nomorAntrian_poliSelanjutnya = '0';
    }
}



// Menghitung nomor antrian_poli selanjutnya yang diinginkan
$nomorAntrian_poliSelanjutnya1 = $nomorAntrian_poliSekarang + 1; // Misal, jika antrian_poli saat ini adalah 1, maka selanjutnya adalah 3, jika 2 maka 4, dan seterusnya

// Query untuk mencari nomor antrian_poli selanjutnya dengan kode_poli 'PLGG'
$sqlSelanjutnya1 = "SELECT antrian_poli.id_antrian_poli, antrian_poli.no_antrian_poli, pasien.no_telp, pasien.nama 
                  FROM antrian_poli 
                  JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli
                  LEFT JOIN pasien ON antrian_poli.id_pasien = pasien.id_pasien
                  WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate' 
                    AND antrian_poli.proses = 0 
                    AND antrian_poli.no_antrian_poli = $nomorAntrian_poliSelanjutnya1
                    AND kategori_poli.kode_poli = 'PLGG'
                  ORDER BY antrian_poli.no_antrian_poli ASC
                  LIMIT 1";

$resultSelanjutnya1 = $conn->query($sqlSelanjutnya1);

if ($resultSelanjutnya1 === false) {
    // Penanganan kesalahan jika query gagal
    echo "Error: " . $conn->error;
} else {
    if ($resultSelanjutnya1->num_rows > 0) {
        $rowSelanjutnya1 = $resultSelanjutnya1->fetch_assoc();
        $nomorAntrian_poliSelanjutnya1 = $rowSelanjutnya1['no_antrian_poli'];
        $noTelpSelanjutnya1 = $rowSelanjutnya1['no_telp'];
        $namaSelanjutnya1 = $rowSelanjutnya1['nama'];
    } else {
        $nomorAntrian_poliSelanjutnya1 = '0';
        $noTelpSelanjutnya1 = '0';
        $namaSelanjutnya1 = '0';
    }
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
                <h2 class="mb-4">Antrian Poli Gigi</h2>

                <br>

                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="huge"><?php echo $jumlahAntrian_poli; ?></div>
                                        <div>Jumlah Antrian Poli</div>
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
                                        <div class="huge"><?php echo $nomorAntrian_poliSekarang; ?></div>
                                        <div>Antrian Poli Sekarang</div>
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
                                            <?php echo $nomorAntrian_poliSelanjutnya; ?>
                                        </div>
                                        <div>Antrian Poli Selanjutnya</div>
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
                                            // Query untuk menghitung jumlah antrian_poli yang prosesnya == 0 dan kode_poli == 'PLGG'
                                            $countProses0Sql = "
        SELECT COUNT(*) AS jumlah_proses0 
        FROM antrian_poli 
        JOIN kategori_poli ON antrian_poli.id_poli = kategori_poli.id_poli 
        WHERE DATE(antrian_poli.tgl_antrian_poli) = '$currentDate' 
          AND antrian_poli.proses = 0 
          AND kategori_poli.kode_poli = 'PLGG'";

                                            $countProses0Result = $conn->query($countProses0Sql);

                                            if ($countProses0Result === false) {
                                                // Penanganan kesalahan jika query gagal
                                                echo "Error: " . $conn->error;
                                            } else {
                                                $rowProses0 = $countProses0Result->fetch_assoc();
                                                echo $rowProses0['jumlah_proses0'];
                                            }
                                            ?>
                                        </div>

                                        <div>Sisa Antrian Poli</div>
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
                                <th class="text-center">Nomor Antrian Poli Gigi</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if ($result->num_rows > 0) : ?>
                                <?php
                                $counter = 0; // Inisialisasi penghitung
                                while ($row = $result->fetch_assoc()) :
                                    if ($row["proses"] == 0 && $row["kode_poli"] == "PLGG") :
                                        $counter++; // Tambahkan penghitung setiap iterasi
                                ?>
                                        <tr>
                                            <td class="hidden"><?= $row["no_antrian_poli"] ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="no_antrian_poli" value="<?= $row["no_antrian_poli"] ?>">
                                                    <input type="hidden" name="no_telp" value="<?= $row["no_telp"] ?>">
                                                    <input type="hidden" name="nama_pasien" value="<?= $row["nama"] ?>">
                                                    <?php if ($counter == 1) : ?>
                                                        <!-- Hanya tampilkan tombol pada iterasi pertama -->
                                                        <button type="submit" name="kirimPesan" style="width: 200px; height: 100px;" class="btn btn-primary" onclick="callAndProcess({ id_antrian_poli: <?= $row['id_antrian_poli'] ?>, no_antrian_poli: '<?= $row['no_antrian_poli'] ?>' })">Panggil</button>
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
                            $noAntrian_poli = $_POST['no_antrian_poli'];

                            $pesan = "Halo $namaPasien,\n\n"
                                . "Kami dari Puskesmas Buntu Batu ingin memberitahukan bahwa nomor Antrian Poli Gigi Anda, $noAntrian_poli, telah dipanggil.\n\n"
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
                            // header("Location: antrian_poli_kajian_awal");
                            // exit;
                        }
                        if (isset($_POST['kirimPesan'])) {
                            // Token API
                            $token = "jp+DZ6H1pkxy8_D#UP-y";

                            $target = $noTelpSelanjutnya1;
                            $namaPasien = $namaSelanjutnya1;
                            $noAntrian_poli = $nomorAntrian_poliSelanjutnya1;

                            $pesan = "Halo $namaPasien,\n\n"
                                . "Ini adalah pemberitahuan penting dari Puskesmas Buntu Batu. Nomor antrian Poli Gigi Anda, $noAntrian_poli, akan segera dipanggil di Poli Gigi.\n\n"
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
                            header("Location: antrian_poli");
                            // exit;
                        }
                        ?>
                    </table>
                </div>

                <script>
                    document.getElementById('callAntrianBtn').addEventListener('click', function() {
                        // Ambil nomor antrian dari PHP (misal nomor antrian didapat dari variabel PHP)
                        var nomorAntrian_poliSekarang = "<?php echo $nomorAntrian_poliSekarang; ?>";

                        // Cek jika nomor antrian valid
                        if (nomorAntrian_poliSekarang !== '0') {
                            // Buat pesan suara
                            const msg = new SpeechSynthesisUtterance();
                            msg.text = "Dipanggil Sekali Lagi Untuk Nomor antrian " + nomorAntrian_poliSekarang + ", silakan ke Poli GIGI";
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
            const id_antrian_poli = params.id_antrian_poli;
            const nomorAntrian_poli = params.no_antrian_poli;

            const msg = new SpeechSynthesisUtterance();
            msg.text = "Nomor antrian poli " + nomorAntrian_poli + ", silakan ke Poli Gigi";
            window.speechSynthesis.speak(msg);

            $.ajax({
                url: '', // Sesuaikan URL dengan endpoint Anda
                type: 'POST',
                data: {
                    id_antrian_poli: id_antrian_poli
                },
                success: function(response) {
                    console.log('Update berhasil');
                    $('tr').find('td').filter(function() {
                        return $(this).text() === nomorAntrian_poli;
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