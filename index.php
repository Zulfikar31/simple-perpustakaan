<?php 
	session_start();
	require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perpustakaan sederhana</title>
</head>
<body>
<div>
	<?php if(isset($_SESSION['penjelasan'])) :?> 
		<h1><?php echo $_SESSION['penjelasan'] ?></h1>
	<?php $_SESSION['penjelasan'] = '';endif; ?>
</div>
<div>
	<?php if(!isset ($_SESSION['login'])) : ?>
		<a href="login.php">Login</a>
		<a href="registrasi.php">Regsitrasi</a>
			<?php elseif(isset($_SESSION['login'])) :?>
				<a href="logout.php">logout</a>
				<?php 
					$id = $_SESSION['id_user'];
					$result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
					$row = mysqli_fetch_assoc($result);
					$username = $row['username'];
				?>
				<p>Username : <?php echo $username ?></p>
				<a href="pinjaman_buku.php?id=<?php echo $id; ?>">Lihat daftar buku pinjaman</a>
	<?php endif; ?>
	<br><br>
</div>

<?php if(isset($_SESSION['admin'])) : ?>
	<a href="tambah.php">Tambah koleksi buku</a>
<?php endif; ?>

	<table border="1" cellspacing="0" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nama Buku</th>
				<th>Deskripsi Buku</th>
				<?php if (isset($_SESSION['login'] )) : ?>
					<th>Aksi</th>
				<?php endif; ?>
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

				<?php if (isset ($_SESSION['login'])) : ?>
					<?php $id_user = $_SESSION['id_user']; ?>
					<form action="pinjam.php" method="post">
						<input type="hidden" name="user_id" value=<?php echo $id_user ?>>
						<input type="hidden" name="buku_id" value="<?php echo $row['id_buku'] ?>">
					<td>
						<button type="submit" name="pinjam">Pinjam</button>
					</td>
					</form>
				<?php endif; ?>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</body>
</html>
