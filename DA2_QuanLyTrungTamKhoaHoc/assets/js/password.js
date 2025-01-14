function togglePassword() {
    const passwordField = document.getElementById('password');
    const new_passwordField = document.getElementById('new_password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-lock');
        toggleIcon.classList.add('fa-unlock');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-unlock');
        toggleIcon.classList.add('fa-lock');
    }
    
    if (new_passwordField.type === 'password') {
        new_passwordField.type = 'text';
        toggleIcon.classList.remove('fa-lock');
        toggleIcon.classList.add('fa-unlock');
    } else {
        new_passwordField.type = 'password';
        toggleIcon.classList.remove('fa-unlock');
        toggleIcon.classList.add('fa-lock');
    }
}