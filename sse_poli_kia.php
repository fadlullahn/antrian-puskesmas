<?php
include 'config.php';

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Ambil tanggal hari ini dalam format MySQL
$currentDate = date('Y-m-d');

// Fungsi untuk mengirimkan nomor antrian terbaru ke client
function sendNewQueueNumber($number)
{
    echo "data: $number\n\n";
    ob_flush();
    flush();
}

// Loop SSE untuk mengirimkan data terbaru ke client
while (true) {
    // Query untuk mencari nomor antrian terbaru dengan filter kode_poli PLUM
    $sql = "SELECT ap.no_antrian_poli 
            FROM antrian_poli ap
            JOIN kategori_poli kp ON ap.id_poli = kp.id_poli
            WHERE DATE(ap.tgl_antrian_poli) = '$currentDate' 
            AND ap.proses = 1 
            AND kp.kode_poli = 'PLKIA'
            ORDER BY ap.no_antrian_poli DESC 
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorAntrian = $row['no_antrian_poli'];
        sendNewQueueNumber($nomorAntrian);
    } else {
        sendNewQueueNumber(':)');
    }

    // Tunggu beberapa saat sebelum memeriksa kembali
    sleep(3); // Misalnya, tunggu 3 detik sebelum memeriksa kembali
}
