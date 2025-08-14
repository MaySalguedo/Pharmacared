<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/entities/pharmaceutical.entity.php';
	$pharmaceutical_row_url = '/Pharmacared/src/components/pharmaceutical/pharmaceutical_row/';

?>

<link rel="stylesheet" href="<?=$pharmaceutical_row_url?>pharmaceutical_row.component.css">
<script src="<?=$pharmaceutical_row_url?>pharmaceutical_row.component.js"></script>

<?php

function PharmaceuticalRow(Pharmaceutical $pharma): string {

	$expirationDate = new DateTime($pharma->expiresAt);
	$today = new DateTime();
	$daysToExpire = $today->diff($expirationDate)->days;
	$isExpiring = $expirationDate > $today && $daysToExpire <= 30;
	$isExpired = $expirationDate < $today;

	ob_start();

?>

	<div id="pharma-card-<?= $pharma->id ?>" class="pharma-card-<?= $pharma->state==1 ? 'activated' : 'deactivated' ?>">

		<div class="card-header">

			<span class="pharma-id">ID: <?= $pharma->id ?></span>

			<div class="actions-menu">

				<button class="menu-toggle">&#8942;</button>

				<div class="menu-content">

					<button class="btn-edit" onclick="showForm('<?= $pharma->id ?>')">

						<i class="fas fa-edit"></i>

					</button>

					<button class="btn-delete" onclick="toggle('<?= $pharma->id ?>', '<?= !$pharma->state ?>')">

						<i class="fas fa-trash"></i>

					</button>

				</div>

			</div>

		</div>
 
		<div class="card-body">

			<div class="pharma-name"><?= $pharma->name ?></div>
			<div class="pharma-description"><?= $pharma->description ?></div>

			<div class="pharma-attributes">

				<div class="attribute">

					<span>Expires:</span>

					<span class="<?= $isExpiring ? 'expiration-warning' : ($isExpired ? 'text-danger' : '') ?>">

						<?= $isExpired ? 'Expired' :$pharma->expiresAt ?>

						<?php if($isExpiring): ?>

							<i class="fas fa-exclamation-triangle"></i> (<?= $daysToExpire ?> days)

						<?php endif; ?>

					</span>

				</div>
				
				<div class="attribute">

					<span>State:</span>

					<div class="checkbox-container">

						<input id="<?= $pharma->id ?>" type="checkbox" disabled <?= $pharma->state ? 'checked' : '' ?>>

					</div>

				</div>

				<div class="attribute">

					<span>Price:</span>

					<div class="price-container">

						$<?= $pharma!=null ? $pharma->price : '' ?>

					</div>

				</div>

			</div>

		</div>

		<div class="card-footer">

			<span class="created-at">Created: <?= $pharma->createdAt ?></span>
			<span class="updated-at">Updated: <?= $pharma->updatedAt ?></span>

		</div>

	</div>

<?php

	return ob_get_clean();

}

?>