Koding
<?php
// Daftar harga
$harga = [
    "Medium Room Karaoke" => 80000,
    "VIP Room Karaoke" => 90000,
    "VVIP Room Karaoke" => 150000,
    "LC" => 120000,
    "Minuman OT" => 130000,
    "Minuman Bir" => 120000,
    "Rokok" => 46000
];

$total = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menghitung total pesanan
    $jam_karaoke = intval($_POST['jam_karaoke']);
    $pilihan_room = intval($_POST['room_type']);

    if ($pilihan_room == 1 && $jam_karaoke > 0) {
        $total += $jam_karaoke * $harga["Medium Room Karaoke"];
    } elseif ($pilihan_room == 2 && $jam_karaoke > 0) {
        $total += $jam_karaoke * $harga["VIP Room Karaoke"];
    } elseif ($pilihan_room == 3 && $jam_karaoke > 0) {
        $total += $jam_karaoke * $harga["VVIP Room Karaoke"];
    }

    // Input untuk LC
    $kuantitas_lc = intval($_POST['kuantitas_lc']);
    if ($kuantitas_lc > 0) {
        $jam_lc = intval($_POST['jam_lc']);
        $total += $kuantitas_lc * $jam_lc * $harga["LC"];
    }

    // Input untuk Minuman dan Rokok
    foreach (["Minuman OT", "Minuman Bir", "Rokok"] as $item) {
        $kuantitas = intval($_POST['kuantitas_' . strtolower(str_replace(' ', '_', $item))]);
        if ($kuantitas > 0) {
            $total += $kuantitas * $harga[$item];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Total Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Hitung Total Pesanan</h1>
    <form action="" method="post">
        <h2>Daftar Harga:</h2>
        <ul class="list-group mb-3">
            <?php foreach ($harga as $item => $price): ?>
                <li class="list-group-item"><?php echo $item . ": Rp " . number_format($price, 0, ',', '.'); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Pilih jenis Room Karaoke:</h2>
        <select name="room_type" class="form-control mb-3" required>
            <option value="1">Medium Room Karaoke</option>
            <option value="2">VIP Room Karaoke</option>
            <option value="3">VVIP Room Karaoke</option>
        </select>

        <div class="form-group">
            <label>Berapa jam pesan Room karaoke:</label>
            <input type="number" name="jam_karaoke" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah LC:</label>
            <input type="number" name="kuantitas_lc" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Berapa jam untuk LC:</label>
            <input type="number" name="jam_lc" class="form-control" required>
        </div>

        <?php foreach (["Minuman OT", "Minuman Bir", "Rokok"] as $item): ?>
            <div class="form-group">
                <label>Jumlah <?php echo $item; ?>:</label>
                <input type="number" name="kuantitas_<?php echo strtolower(str_replace(' ', '_', $item)); ?>" class="form-control" required>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Hitung Total</button>
    </form>

    <?php if ($total > 0): ?>
        <h2 class="mt-4">Total Pembayaran: Rp <?php echo number_format($total, 0, ',', '.'); ?></h2>
    <?php endif; ?>
</div>
</body>
</html>