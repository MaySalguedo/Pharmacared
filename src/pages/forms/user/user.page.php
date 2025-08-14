<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Users</title>

		<?php

			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/components/header/header.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/components/user/user_row/user_row.component.php';
			require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/user.service.php';

			$user_url = '/Pharmacared/src/pages/Forms/User/';

			$userService = new UserService();

		?>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.7/dist/sweetalert2.min.js"></script>

		<link rel="stylesheet" href="<?=$user_url?>user.page.css">

	</head>

	<body>

		<?=HeaderComponent($userService->findOne($_SESSION['user_id']))?>

		<div class="container mt-4">

			<div class="d-flex justify-content-between align-items-center mb-4">

				<h2>User Management</h2>

				<button class="btn btn-success" id="btnAdd">

					<i class="fas fa-plus-circle me-2"></i>Add New

				</button>

			</div>

			<div class="table-responsive">

				<table class="table table-striped table-hover" id="UsersTable">

					<!--<thead class="table-dark">

						<tr>

							<th>ID</th>
							<th>Name</th>
							<th>Admin</th>
							<th>State</th>
							<th>Actions</th>

						</tr>

					</thead>-->

					<tbody>

						<?php

							$users = $userService->findAll();

						?>

						<?php foreach($users as $user): ?>

							<?=UserRow($user)?>

						<?php endforeach; ?>

					</tbody>

				</table>

			</div>

		</div>

		<div class="modal fade" id="UserModal" tabindex="-1"></div>

		<script src="<?=$user_url?>user.page.js"></script>

	</body>

</html>