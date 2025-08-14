
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const closeSidebar = document.getElementById('closeSidebar');

sidebarToggle.addEventListener('click', () => {

	sidebar.classList.toggle('show');

});

closeSidebar.addEventListener('click', () => {

	sidebar.classList.remove('show');

});