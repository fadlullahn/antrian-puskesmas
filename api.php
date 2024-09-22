<?php
if (isset($_POST['kirimPesan'])) {
    // Token API dan target penerima
    $token = "BqtvD1gwxWQAz6nQ_i+v";
    $target = "6282187338949";

    $namaPasien = "John Doe";
    $pesan = "Halo $namaPasien,<br>Ini adalah pesan Anda.";

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

    // Eksekusi permintaan CURL dan tangani respons
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);

    // Tampilkan kesalahan jika ada
    if (isset($error_msg)) {
        echo "Error: $error_msg";
    } else {
        echo "Response: $response";
    }
}
