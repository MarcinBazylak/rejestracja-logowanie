var labelLogin = document.getElementById('login-label');
var labelRegister = document.getElementById('register-label');
var labelGetPass = document.getElementById('lost-password');

var fieldLogin = document.getElementById('login');
var fieldRegister = document.getElementById('register');
var fieldGetPass = document.getElementById('password-reminder');

labelLogin.onclick = function() {
   fieldRegister.style.display = 'none';
   fieldGetPass.style.display = 'none';
   fieldLogin.style.display = 'block';
   labelLogin.style.backgroundColor = 'white'
   labelRegister.style.backgroundColor = '#ffe4c4'
};

labelRegister.onclick = function() {
   fieldGetPass.style.display = 'none';
   fieldLogin.style.display = 'none';
   fieldRegister.style.display = 'block';
   labelLogin.style.backgroundColor = '#ffe4c4'
   labelRegister.style.backgroundColor = 'white'
};

labelGetPass.onclick = function() {
   fieldLogin.style.display = 'none';
   fieldRegister.style.display = 'none';
   fieldGetPass.style.display = 'block';
};