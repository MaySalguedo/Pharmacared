
document.addEventListener('DOMContentLoaded', () => {

	document.getElementById('btnAdd').addEventListener('click', () => {

		showForm(null);

	});

});

function showForm(id){

    fetch("/Pharmacared/src/components/user/user_form/user_form.component.php" + (id!=null ? "?id="+id : "")).then(

		response => response.text()
	
	).then(data => {

		//console.log(data);

        document.getElementById('UserModal').innerHTML = data;
		
		let script = document.getElementById('controller');
		
		if (script!=null){

			script.remove();

		}

		script = document.createElement('script');
		script.id = 'controller';
		script.type = 'text/javascript';
		script.src = '/Pharmacared/src/core/middleware/request/request.middleware.js';
		script.async = true;

		document.body.appendChild(script);

		const modal = new bootstrap.Modal('#UserModal');
		document.getElementById('form').reset();
		modal.show();

    }).catch(e => 
	
		console.error('Error loading the item: ', e)
		
	);

}