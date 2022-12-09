document.addEventListener('DOMContentLoaded', () => {
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
		if (text.length === 0) {
			characterCount.style.color = 'white';
			characterCountMax.style.color = 'white';
		} else {
			const color = text.length <= 100
				? new RGB(255, 255, 255 - (text.length / 100) * 255)
				: new RGB(255, 255 - ((text.length - 100) / 300) * 255, 0);
			characterCount.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
			characterCountMax.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
		}
	}

	chatArea.addEventListener('input', updateCharacterCount);

	function addImage() {
		const fileInput = document.querySelector('.chat-image-input');
		fileInput.click();
		const reader = new FileReader();
		fileInput.addEventListener('change', () => {
			const file = fileInput.files[0];
			reader.onload = () => {
				const img = (`<img class="chat-image" src='${reader.result}' alt="">`);
				const chatFormImageContainer = document.querySelector('.chat-form-image-container');
				chatFormImageContainer.innerHTML += img;
			};
			reader.readAsDataURL(file);
		});
	}

	const imageButton = document.querySelector('.chat-image-btn');
	imageButton.addEventListener('click', addImage);
});