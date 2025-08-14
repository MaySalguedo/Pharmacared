<?php

	session_start();
	$_SESSION['user_id'] = null;

?>

<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>System Access</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>

		<link rel="stylesheet" href="login.page.css">

	</head>

	<body class="bg-light">

		<div class="container">

			<div class="card login-card shadow-lg mx-auto mt-5">

				<div class="card-body">

					<div class="text-center mb-4">

						<h2 class="mt-3">Login</h2>

					</div>

					<form id = "form" action="controllers/auth.controller.php" method="POST">

						<div class="mb-3">

							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email" name="email">

						</div>

						<div class="mb-4">

							<label for="password" class="form-label">Password</label>
							<input type="password" class="form-control" id="password" name="password">

						</div>

						<button type="submit" class="btn btn-primary w-100">Ingresar</button>

					</form>

				</div>

			</div>

		</div>

		<!--><script src="/Pharmacared/src/core/middleware/request/request.middleware.js"></script><!-->

	</body>

</html>