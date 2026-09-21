// :for studentSignUp.php
const showPasswordToggle = document.getElementById('showPasswordToggle');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');

showPasswordToggle.addEventListener('change', function() {
// Check if the box is ticked
const type = this.checked ? 'text' : 'password';

// Toggle both fields
password.type = type;
confirmPassword.type = type;
});