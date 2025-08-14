<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/user/entities/user.entity.php';
	$user_row_url = '/Pharmacared/src/components/user/user_row/';

?>

<link rel="stylesheet" href="<?=$user_row_url?>user_row.component.css">
<script src="<?=$user_row_url?>user_row.component.js"></script>

<?php

function UserRow(User $user): string {

	ob_start();

?>

	<div id="user-card-<?= $user->id ?>" class="user-card-<?= $user->state==1 ? 'activated' : 'deactivated' ?>">

		<div class="card-header">

			<span class="user-id">ID: <?= $user->id ?></span>

			<div class="actions-menu">

				<button class="menu-toggle">&#8942;</button>

				<div class="menu-content">

					<button class="btn-edit" onclick="showForm('<?= $user->id ?>')">

						<i class="fas fa-edit"></i>

					</button>

					<button class="btn-delete" onclick="toggle('<?= $user->id ?>', '<?= !$user->state ?>')">

						<i class="fas fa-trash"></i>

					</button>

				</div>

			</div>

		</div>
 
		<div class="card-body">

			<div class="user-info">

				<div class="user-name"><?= $user->name ?></div>

				<div class="user-attributes">

					<div class="attribute">

						<span>Admin:</span>

						<div class="checkbox-container">

							<input type="checkbox" disabled <?= $user->admin ? 'checked' : '' ?>>

						</div>

					</div>

					<div class="attribute">

						<span>State:</span>

						<div class="checkbox-container">

							<input id="<?= $user->id ?>" type="checkbox" disabled <?= $user->state ? 'checked' : '' ?>>

						</div>

					</div>

					<?php if($user->picture): ?>

					<div class="user-picture">

						<img src="<?= $user->picture ?>" alt="pfp">

					</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

		<div class="card-footer">

			<span class="created-at">Created: <?= $user->createdAt ?></span>
			<span class="updated-at">Updated: <?= $user->updatedAt ?></span>

		</div>

	</div>

<?php

	return ob_get_clean();

}

?>