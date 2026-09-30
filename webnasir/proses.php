<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $meja = htmlspecialchars($_POST['meja']);
    $cart_raw = $_POST['cart_data'] ?? '';

    if (empty($cart_raw)) {
        echo "<script>alert('Keranjang kosong!'); window.location.href='kik.html';</script>";
        exit;
    }

    $cart = json_decode($cart_raw, true);
    $total_harga = 0;
    foreach ($cart as $item) {
        $total_harga += $item['price'] * $item['qty'];
    }

    $total_format = number_format($total_harga, 0, ',', '.');

    // Ambil template pembayaran
    $tampilan_html = file_get_contents('pembayaran.html');

    // Suntikkan data ke placeholder
    $tampilan_html = str_replace('{{NAMA}}', $nama, $tampilan_html);
    $tampilan_html = str_replace('{{MEJA}}', $meja, $tampilan_html);
    $tampilan_html = str_replace('{{TOTAL_FORMAT}}', $total_format, $tampilan_html);
    $tampilan_html = str_replace('{{TOTAL_ANGKA}}', $total_harga, $tampilan_html);

    echo $tampilan_html;

} else {
    header("Location: kik.html");
    exit;
}
?>