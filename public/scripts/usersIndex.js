const userNameSpan = $('#userNameSpan');
const userIdInput = $('#userIdInput');

function toggleVisibility() {
    eye.toggleClass('bi-eye-fill bi-eye-slash');

    const type = password.prop('type') === 'password' ? 'text' : 'password';
    password.prop('type', type);
}

function displayModal(userId, userName, userEmail) {
    userNameSpan.text(`${userEmail} (${userName})`);
    userIdInput.val(userId);
}
