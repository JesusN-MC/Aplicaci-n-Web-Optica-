const userMenuToggle = document.getElementById('userMenuToggle');
  const dropdownMenu = document.getElementById('dropdownMenu');

  userMenuToggle.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'flex' ? 'none' : 'flex';
  });

  // Cerrar el menú si se hace clic fuera
  window.addEventListener('click', function(e) {
    if (!userMenuToggle.contains(e.target)) {
      dropdownMenu.style.display = 'none';
    }
  });