const chatArea = document.querySelector('.chat-area');
const characterCount = document.querySelector('.chat-count-number');
const characterCountMax = document.querySelector('.chat-count-max');

class RGB {
	constructor(r, g, b) {
		this.r = r;
		this.g = g;
		this.b = b;
	}
}

function updateCharacterCount() {
	const text = chatArea.value;
	characterCount.innerHTML = text.length;
	const color = new RGB(255, 255 - (text.length / 400) * 255, 0);
	characterCount.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
	characterCountMax.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;

	if (text.length === 0) {
		characterCount.style.color = 'white';
		characterCountMax.style.color = 'white';
	}
}

chatArea.addEventListener('input', updateCharacterCount);