<?php 
session_start();

if (!isset($_SESSION['login'])) {
	header('location: index.php');
}
require_once 'koneksi.php';
if(isset($_POST['pinjam'])) {
	$id_user = $_POST['user_id'];
	$id_buku = $_POST['buku_id'];

	$pinjaman = mysqli_query($conn, "SELECT * FROM pinjaman WHERE id_user = $id_user AND id_buku = $id_buku");
	if($hasil_pinjaman = mysqli_num_rows($pinjaman)) {
		$_SESSION['penjelasan'] = "buku sudah dipinjam dan belum dikembalikan";
		header('location: index.php');
		die();
	}

	mysqli_query($conn, "INSERT INTO pinjaman (id_buku, id_user) VALUES(
		$id_buku, $id_user
	)");
	if (mysqli_affected_rows($conn)) {
		header('location: index.php');
	}
}