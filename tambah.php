<?php 
	session_start();
	require_once 'koneksi.php';

	if (!isset($_SESSION['login'])) {
		header('location: index.php');
	}

	$nama = '';
	$deskripsi = '';
	$id = '';

	if (isset($_POST['submit'])) {
		$judul = $_POST['judul'];
		$deskripsi = $_POST['deskripsi'];
		
		$result = mysqli_query($conn, "SELECT nama FROM buku WHERE nama = '$judul' ");

		if (mysqli_num_rows($result)) {
			echo "buku sudah ditambahkan";
			
			exit();
		}

		mysqli_query($conn, "INSERT INTO buku (nama, deskripsi) VALUES (
			'$judul', '$deskripsi'
		)");
		if (mysqli_affected_rows($conn) > 0) {
			echo "Berhasil";
		}
	}

	// update buku
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		
		$result = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id");
		$row = mysqli_fetch_assoc($result);

		$nama = $row['nama'];
		$deskripsi = $row['deskripsi'];
		$id = $row['id_buku'];
	}
	if (isset($_POST['update'])) {
		$nama = htmlspecialchars( $_POST['judul'] );
		$deskripsi = htmlspecialchars ($_POST['deskripsi']);
		$id = htmlspecialchars ($_POST['idedit']);

		mysqli_query($conn, "UPDATE buku SET nama = '$nama', deskripsi = '$deskripsi' WHERE id_buku = $id");
		if (mysqli_affected_rows($conn) > 0) {
			echo "Berhasil";
		}
	}

	// hapus
	if (isset($_GET['hapus'])) {
		$id = $_GET['hapus'];

		mysqli_query($conn, "DELETE FROM buku WHERE id_buku = $id");
		if (mysqli_affected_rows($conn) > 0) {
			echo "Berhasil";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah koleksi buku</title>
</head>
<body>
	<form action="" method="post">
		<ul>
			<input type="hidden" name="idedit" value="<?php echo $id; ?>">
			<li><input type="text" name="judul" placeholder="Judul Buku" id="" value="<?php echo $nama ?>"></li>
			<li><input type="text" name="deskripsi" id="" placeholder="Deskripsi Buku" value="<?php echo $deskripsi ?>"></li>
			<?php if(isset($_GET['edit'])) : ?>
			<li><button type="submit" name="update">Update Koleksi</button></li>
			<?php else : ?>
				<li><button type="submit" name="submit">Tambah Koleksi</button></li>
			<?php endif; ?>
		</ul>
	</form>

	<table cellpadding="10" cellspacing="0" border="1" >
		<thead>
			<tr>
				<th>ID</th>
				<th>Nama Buku</th>
				<th>Deskripsi Buku</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$result = mysqli_query($conn, "SELECT * FROM buku");
			$i = 0; 
			while( $row = mysqli_fetch_assoc($result)) : 
		?>
			<tr>
				<td><?php echo ++$i ?></td>
				<td><?php echo $row['nama'] ?></td>
				<td><?php echo $row['deskripsi'] ?></td>
				<td>
					<a href="?edit=<?php echo $row['id_buku']?>">Ubah</a>
					<a href="?hapus=<?php echo $row['id_buku']?>">Hapus</a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</body>
</html>
