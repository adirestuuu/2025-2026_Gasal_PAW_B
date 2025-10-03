<?php
$menu = [
	1 => ['nama' => 'Nasi Goreng', 'harga' => 15000],
	2 => ['nama' => 'Mie Ayam', 'harga' => 12000],
	3 => ['nama' => 'Es Teh', 'harga' => 5000],
	4 => ['nama' => 'Jus Jeruk', 'harga' => 8000],
];

$keranjang = [];
$total = 0;

if(isset($_POST['proses'])){
	$pilihan = $_POST['pilihan'];
	$jumlah = $_POST['jumlah'];
	if(isset($menu[$pilihan])){
		$item = $menu[$pilihan];
		$subtotal = $item['harga'] * $jumlah;
		// Simpan ke keranjang
		if(!isset($_POST['keranjang'])){
			$keranjang = [];
		} else {
			$keranjang = json_decode($_POST['keranjang'], true);
		}
		$keranjang[] = [
			'nama' => $item['nama'],
			'harga' => $item['harga'],
			'jumlah' => $jumlah,
			'subtotal' => $subtotal
		];
		$total = 0;
		foreach($keranjang as $k){
			$total += $k['subtotal'];
		}
	}
} elseif(isset($_POST['selesai'])){
	$keranjang = json_decode($_POST['keranjang'], true);
	$total = 0;
	foreach($keranjang as $k){
		$total += $k['subtotal'];
	}
}

if(!isset($_POST['selesai'])){
?>
<h2>Menu Kasir Sederhana</h2>
<form method="post">
	<label>Pilih Menu:</label><br>
	<?php foreach($menu as $key => $item): ?>
		<input type="radio" name="pilihan" value="<?= $key ?>" required> <?= $item['nama'] ?> (Rp<?= number_format($item['harga']) ?>)<br>
	<?php endforeach; ?>
	<label>Jumlah:</label>
	<input type="number" name="jumlah" min="1" required><br>
	<?php if(isset($keranjang) && count($keranjang) > 0): ?>
		<input type="hidden" name="keranjang" value='<?= json_encode($keranjang) ?>'>
	<?php endif; ?>
	<button type="submit" name="proses">Tambah ke Keranjang</button>
	<button type="submit" name="selesai">Selesai & Hitung Total</button>
</form>
<?php
	if(isset($keranjang) && count($keranjang) > 0){
		echo "<h3>Keranjang Belanja:</h3><ul>";
		foreach($keranjang as $k){
			echo "<li>{$k['nama']} x {$k['jumlah']} = Rp".number_format($k['subtotal'])."</li>";
		}
		echo "</ul>";
		echo "<b>Total sementara: Rp".number_format($total)."</b>";
	}
}

if(isset($_POST['selesai'])){
	echo "<h2>Struk Belanja</h2>";
	echo "<ul>";
	foreach($keranjang as $k){
		echo "<li>{$k['nama']} x {$k['jumlah']} = Rp".number_format($k['subtotal'])."</li>";
	}
	echo "</ul>";
	echo "<b>Total Bayar: Rp".number_format($total)."</b>";
	echo '<br><a href="10.php">Transaksi Baru</a>';
}