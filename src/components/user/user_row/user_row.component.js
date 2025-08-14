// Manejar el menú de acciones
document.querySelectorAll('.actions-menu').forEach(menu => {
    const toggle = menu.querySelector('.menu-toggle');
    const content = menu.querySelector('.menu-content');
    
    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        content.style.display = content.style.display === 'flex' ? 'none' : 'flex';
    });
    
    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target)) {
            content.style.display = 'none';
        }
    });
});

// Efecto hover para los botones
document.querySelectorAll('.btn-edit, .btn-delete').forEach(button => {
    button.addEventListener('mouseover', () => {
        button.style.transform = 'scale(1.1)';
    });
    
    button.addEventListener('mouseout', () => {
        button.style.transform = 'scale(1)';
    });
});