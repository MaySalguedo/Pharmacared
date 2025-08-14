<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/entities/pharmaceutical.entity.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Pharmacared/src/core/services/pharmacared/pharmaceutical/pharmaceutical.service.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id!=null){

	echo PharmaForm(new PharmaceuticalService()->findOne($id));
	$_SESSION['updated_pharma'] = $id;
	$_SESSION['REAL_METHOD'] = 'PATCH';

}else{

	$_SESSION['REAL_METHOD'] = 'POST';
	echo PharmaForm(null);

}

function PharmaForm(?Pharmaceutical $pharma): string {

	$pharmaceutical_url = '/Pharmacared/src/pages/forms/pharmaceutical/';
	$pharmaceutical_form_url = '/Pharmacared/src/components/pharmaceutical/pharmaceutical_form/';

	ob_start();

?>

	<link rel="stylesheet" href="<?=$pharmaceutical_form_url?>pharmaceutical.component.css">
	<script src="<?=$pharmaceutical_form_url?>pharmaceutical.component.js"></script>

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="modalTitle">

					<i class="fas fa-pills"></i> <?=$pharma==null ? 'New' : 'Update'?> Pharmaceutical

				</h5>

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

			</div>
			
			<form id="form" action="<?= $pharmaceutical_url ?>controllers/pharmaceutical.controller.php" method="POST">

				<div class="modal-body">

					<div class="mb-3">

						<label class="form-label" for="name">

							<i class="fas fa-tag"></i> Name

						</label>

						<input type="text" class="form-control" id="name" name="name" value="<?=$pharma!=null ? $pharma->name : '' ?>" required>

					</div>

					<div class="mb-3">

						<label class="form-label" for="description">

							<i class="fas fa-file-alt"></i> Description

						</label>

						<textarea class="form-control" id="description" name="description" rows="3"><?= $pharma!=null ? $pharma->description : '' ?></textarea>

					</div>

					<div class="mb-3">

						<label class="form-label" for="price">

							<i class="fas fa-coins"></i> Price

						</label>

						<input type="number" class="form-control" id="price" name="price" step="0.01" min="1" value="<?= $pharma!=null ? $pharma->price : '' ?>" required>

					</div>

					<div class="mb-3">

						<label class="form-label" for="expiresAt">

							<i class="fas fa-calendar-times"></i> Expires At

						</label>

						<input type="date" class="form-control" id="expiresAt" name="expiresat" value="<?= $pharma!=null ? date('Y-m-d', strtotime($pharma->expiresAt)) : '' ?>" required min="<?= date('Y-m-d') ?>">

					</div>

				</div>
				
				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

					<button type="submit" class="btn btn-save">

						<i class="fas fa-save me-1"></i>Save

					</button>

				</div>

			</form>

		</div>

	</div>

<?php

	return ob_get_clean();

}

?>