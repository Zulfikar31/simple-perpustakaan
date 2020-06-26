<?php 
session_start();
require_once 'koneksi.php';

if (isset($_POST['submit'])) {
	$username = htmlspecialchars( $_POST['username'] );
	$password = htmlspecialchars ($_POST['password'] );
	$konfirmasi = htmlspecialchars ($_POST['konfirmasi']);

	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "username sudah ada, silahkan ganti yang lain";
		exit();
	}
	if ($password != $konfirmasi) {
		echo "password tidak match!";
		exit();
	}
	$enkripsi = password_hash($password, PASSWORD_DEFAULT);
	
	mysqli_query($conn, "INSERT INTO user (username, password) VALUES (
	'$username', '$enkripsi') ");

	$aff = mysqli_affected_rows($conn);
	if ($aff) {
		$_SESSION['login'] = true;
		$query = mysqli_query($conn, "SELECT * FROM user WHERE id = LAST_INSERT_ID()");
		$result = mysqli_fetch_assoc($query);
		$_SESSION['id_user'] = $result['id'];
		$_SESSION['username'] = $result['username'];
	} else {
		echo "gagal";
		exit();
	}
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registrasi</title>
</head>
<body>
	<form action="" method="post">
		<ul>
			<li><input type="text" name="username" placeholder="username" id="" ></li>
			<li><input type="password" name="password" placholder="password" id=""></li>
			<li><input type="password" name="konfirmasi" placeholder="konfirmasi password anda" id=""></li>
			<li><button type="submit" name="submit">Registrasi</button></li>
		</ul>
	</form>
</body>
</html>