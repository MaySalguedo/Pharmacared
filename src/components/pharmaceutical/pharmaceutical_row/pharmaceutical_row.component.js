
document.querySelectorAll('.actions-menu').forEach(menu => {

	const toggle = menu.querySelector('.menu-toggle');
	const content = menu.querySelector('.menu-content');
	
	toggle.addEventListener('click', (e) => {

		e.stopPropagation();
		content.style.display = content.style.display === 'flex' ? 'none' : 'flex';

	});
	
	document.addEventListener('click', (e) => {

		if (!menu.contains(e.target)) {

			content.style.display = 'none';

		}

	});

});

document.querySelectorAll('.btn-edit, .btn-delete').forEach(button => {

	button.addEventListener('mouseover', () => {

		button.style.transform = 'scale(1.1)';

	});
	
	button.addEventListener('mouseout', () => {

		button.style.transform = 'scale(1)';

	});

});


async function warning(b){

	const shot = await Swal.fire({

		title: 'Are you sure you want to proceed?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'toggle state',
		cancelButtonText: 'Cancel',
		reverseButtons: true

	});

	if (shot.isConfirmed){
	
		return true;

	}else{

		Swal.fire('Cancelled', 'Action has been cancelled', 'info');
	
		return false;

	}

}

async function toggle(id, state){

	const b = await warning(state);

	if (b){

		fetch("http://localhost/Pharmacared/src/pages/forms/pharmaceutical/controllers/pharmaceutical.controller.php",{

			method: 'DELETE',
			headers: {

				'Content-Type': 'application/json'

			}, body: JSON.stringify({

				id: id,
				state: state==1

			})

		}).then(response => {

			//console.log(response.text());

			return response.json()

		}).then(data => {

			if (data.status=='success'){

				Swal.fire(data.state==1 ? 'Activated' : 'Deactivated', 'Pharmaceutical has been successfully '+(data.type)+'.', 'success');

				const Checkbox = document.getElementById(id);
				Checkbox.checked = data.state;

				const card = document.getElementById(`pharma-card-${id}`);

				if (card) {

					if (data.state) {

						card.classList.remove('pharma-card-deactivated');
						card.classList.add('pharma-card-activated');

					}else{

						card.classList.remove('pharma-card-activated');
						card.classList.add('pharma-card-deactivated');

					}

				}

			}else{

				formWarning(data);

			}

		}).catch(e => {

			console.error('Error: ', e);
			
		});

	}

}