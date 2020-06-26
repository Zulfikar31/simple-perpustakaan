<?php 
	session_start();
	require_once 'koneksi.php';
		if (!isset($_SESSION['login'])) {
		header('location: index.php');
	}
	$id = $_GET['id'];
	$result = mysqli_query($conn, "SELECT u.id, b.id_buku, b.nama, b.deskripsi, p.id_user
									FROM pinjaman AS p 
									JOIN buku AS b ON p.id_buku = b.id_buku
									JOIN user AS u ON p.id_user = u.id
									WHERE u.id = $id
									"
	);

	if (isset($_POST['balikin'])) {
		$id_buku = $_POST['id_buku'];
		$id_user = $_POST['id_user'];

		mysqli_query($conn, "DELETE FROM pinjaman WHERE id_buku = $id_buku AND id_user = $id_user");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar buku yang dipinjam</title>
</head>
<body>

<div>
<?php 
$requery = mysqli_query($conn, "SELECT * FROM pinjaman"); if (mysqli_num_rows($requery) == 0) :?>
	<h1>tidak ada buku yang dipinjam</h1>
	<a href="index.php" class="">Kembali</a>
	<?php else : ?>
		<a href="index.php">Kembali</a>
<?php endif; ?>

</div>
		<table border="1" cellspacing="0" cellpadding="10">
			<thead>
				<tr>
					<th>ID</th>
					<th>Judul Buku</th>
					<th>Deskripsi Buku</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; while($row = mysqli_fetch_assoc($result)) :?>

				<tr>
					<td><?php echo ++$i ?></td>
					<td><?php echo $row['nama'] ?></td>
					<td><?php echo $row['deskripsi'] ?></td>
					<td>
						<form action="" method="post">
							<input type="hidden" name="id_buku" value="<?php echo $row['id_buku'] ?>">
							<input type="hidden" name="id_user" value="<?php echo $row['id_user'] ?>">
							<button type="submit" name="balikin">Kembalikan Buku</button>
						</form>
					</td>
				</tr>

				<?php endwhile; ?>
			</tbody>
		</table>
</body>
</html>