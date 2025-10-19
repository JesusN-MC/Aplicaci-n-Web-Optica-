
    const tabLogin = document.getElementById('tab-login');
    const tabRegister = document.getElementById('tab-register');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    tabLogin.addEventListener('click', () => {
      tabLogin.classList.add('active');
      tabRegister.classList.remove('active');
      loginForm.style.display = 'flex';
      registerForm.style.display = 'none';
    });

    tabRegister.addEventListener('click', () => {
      tabRegister.classList.add('active');
      tabLogin.classList.remove('active');
      loginForm.style.display = 'none';
      registerForm.style.display = 'flex';
    });

    // Calcular edad
    const birthDate = document.getElementById('birthDate');
    const ageInput = document.getElementById('age');
    birthDate.addEventListener('change', () => {
      const birth = new Date(birthDate.value);
      const diff = Date.now() - birth.getTime();
      const age = new Date(diff).getUTCFullYear() - 1970;
      ageInput.value = age;
    });