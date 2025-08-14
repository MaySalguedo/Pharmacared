
window.addEventListener('DOMContentLoaded', () => {

	const welcomeText = document.querySelector('.welcome-text');
	
	welcomeText.addEventListener('animationend', () => {

		welcomeText.style.animation = 'none';

	});

	document.addEventListener('mousemove', (e) => {

		const x = (window.innerWidth / 2 - e.pageX) / 30;
		const y = (window.innerHeight / 2 - e.pageY) / 30;

		welcomeText.style.transform = `translate(${x}px, ${y}px)`;

	});

});