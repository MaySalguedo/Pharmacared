<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Users</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/components/header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/components/pharmaceutical/pharmaceutical_row/pharmaceutical_row.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/user.service.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/pharmaceutical.service.php';

			$pharmaceutical_url = '/Pharmacared/src/pages/forms/pharmaceutical/';

			$userService = new UserService();
			$pharmaceuticalService = new PharmaceuticalService();

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>

		<link rel="stylesheet" href="<?=$pharmaceutical_url?>pharmaceutical.page.css">

	</head>

	<body>

		<?=HeaderComponent($userService->findOne($_SESSION['user_id']))?>

		<div class="container mt-4">

			<div class="d-flex justify-content-between align-items-center mb-4">

				<h2>Pharmaceutical Management</h2>

				<button class="btn btn-success" id="btnAdd">

					<i class="fas fa-plus-circle me-2"></i>Add New

				</button>

			</div>

			<div class="table-responsive">

				<table class="table table-striped table-hover" id="UsersTable">

					<tbody>

						<?php

							$pharmas = $pharmaceuticalService->findAll();

						?>

						<?php foreach($pharmas as $pharma): ?>

							<?=PharmaceuticalRow($pharma)?>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<div class="modal fade" id="PharmaModal" tabindex="-1"></div>

		<script src="<?=$pharmaceutical_url?>pharmaceutical.page.js"></script>

	</body>

</html>