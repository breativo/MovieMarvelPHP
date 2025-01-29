// Obtener referencias a los elementos del botón de cambio de tema
const themeToggle = document.getElementById('theme-toggle');
const themeIcon = document.getElementById('theme-icon');

// Verificar si el usuario ya tenía guardado un tema preferido
if (localStorage.getItem('theme') === 'light') {
    document.body.classList.add('light-mode');
    themeIcon.classList.replace('fa-moon', 'fa-sun');
} else if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.remove('light-mode');
    themeIcon.classList.replace('fa-sun', 'fa-moon');
}

// Evento de clic para cambiar entre modo claro y oscuro
themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('light-mode');

    if (document.body.classList.contains('light-mode')) {
        themeIcon.classList.replace('fa-moon', 'fa-sun');
        localStorage.setItem('theme', 'light'); // Guardar la preferencia en localStorage
    } else {
        themeIcon.classList.replace('fa-sun', 'fa-moon');
        localStorage.setItem('theme', 'dark'); // Guardar la preferencia en localStorage
    }
});
