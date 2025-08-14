document.querySelectorAll('.btn btn-primary').forEach(button => {

    button.addEventListener('mouseover', () => {

        button.style.transform = 'scale(1.02)';

    });
    
    button.addEventListener('mouseout', () => {

        button.style.transform = 'scale(1)';

    });

});