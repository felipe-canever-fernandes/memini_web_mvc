const userTitleSpan = $('#deckTitleSpan');
const deckIdInput = $('#deckIdInput');

function displayModal(deckId, deckTitle) {
    userTitleSpan.text(deckTitle);
    deckIdInput.val(deckId);
}
