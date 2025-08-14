<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home - Purchase System</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/components/header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/user.service.php';

			$home_url = '/Pharmacared/src/pages/home/';

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $home_url ?>home.page.css" rel="stylesheet">

	</head>

	<body>

		<?php

			$user = new UserService()->findOne($_SESSION['user_id']);

		?>

		<?=HeaderComponent($user)?>

		<div class="welcome-container">

			<h1 class="welcome-text">Welcome<br><span><?=$user->name?></span></h1>

		</div>

		<script src="<?= $home_url ?>home.page.js"></script>

	</body>

</html>