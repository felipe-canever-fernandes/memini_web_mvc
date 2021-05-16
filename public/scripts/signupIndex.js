const password = $('#password');
const eye = $('#eye');

function toggleVisibility() {
    eye.toggleClass('bi-eye-fill bi-eye-slash');

    const type = password.prop('type') === 'password' ? 'text' : 'password';
    password.prop('type', type);
}
