<?php 
session_start();
require_once('koneksi.php');
$conn = mysqli_connect('localhost', 'admin', 'password', 'library');
if (isset($_POST['submit'])) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];


	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	if (mysqli_num_rows($result) === 1) {
		$row = mysqli_fetch_assoc($result);
		$enc_pass = $row['password'];
		
		if (password_verify($password, $enc_pass)) {

			if ($username == 'admin') {
				$_SESSION['login'] = true;
				$_SESSION['id_user'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['admin'] = true;
				header('location: index.php');
			}

			$_SESSION['login'] = true;
			$_SESSION['id_user'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			
			header('location: index.php');
		} else {
			echo "password tidak match";
			exit();
		}
	} else {
		echo "username tidak terdaftar";
		exit();
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
</head>
<body>
	<h1>Halaman Login</h1>
	<form action="" method="post">
		<ul>
			<li><input type="text" name="username" placeholder="Masukkan username" id=""></li>
			<li><input type="password" name="password" id="" placeholder="Masukkan password"></li>
			<li><button type="submit" name="submit">Login</button></li>
		</ul>
	</form>
</body>
</html>