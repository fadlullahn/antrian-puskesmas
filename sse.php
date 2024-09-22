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
    // Query untuk mencari nomor antrian terbaru
    $sql = "SELECT no_antrian FROM antrian WHERE DATE(tgl_antrian) = '$currentDate' AND proses = 1 ORDER BY no_antrian DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorAntrian = $row['no_antrian'];
        sendNewQueueNumber($nomorAntrian);
    } else {
        sendNewQueueNumber(':)');
    }

    // Tunggu beberapa saat sebelum memeriksa kembali
    sleep(3); // Misalnya, tunggu 3 detik sebelum memeriksa kembali
}
