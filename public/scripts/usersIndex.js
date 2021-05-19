const userNameSpan = $('#userNameSpan');
const userIdInput = $('#userIdInput');

function displayModal(userId, userName, userEmail) {
    userNameSpan.text(`${userEmail} (${userName})`);
    userIdInput.val(userId);
}
