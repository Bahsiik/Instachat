const chatArea = document.querySelector('.chat-area');
const characterCount = document.querySelector('.chat-count-number');

function updateCharacterCount() {
	const text = chatArea.value;
	characterCount.innerHTML = text.length;
}

chatArea.addEventListener('input', updateCharacterCount);