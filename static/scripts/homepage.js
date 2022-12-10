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

	const form = document.querySelector('.post-form');
	const textarea = document.querySelector('.chat-area');
	const imageInput = document.querySelector('.chat-image-input');
	const chatFormBottom = document.querySelector('.chat-form-bottom');
	const chatButton = chatFormBottom.querySelector('.chat-btn');

	textarea.addEventListener('input', () => {
		updateChatButton();
	});
	imageInput.addEventListener('change', () => {
		updateChatButton();
	});

	function updateChatButton() {
		console.log('updateChatButton');
		if (textarea.value.length < 2 && imageInput.files.length < 1) {
			chatButton.setAttribute('disabled', '');
		} else {
			chatButton.removeAttribute('disabled');
		}
	}

	// Additional security to check when submitting form
	form.addEventListener('submit', (e) => {
		if (textarea.value.length < 2 && imageInput.files.length < 1) {
			e.preventDefault();
		}
	});

	function addImage() {
		const fileInput = document.querySelector('.chat-image-input');
		fileInput.click();
		const reader = new FileReader();
		fileInput.addEventListener('change', () => {
			const file = fileInput.files[0];
			reader.onloadend = () => {
				const fileType = file.type.split('/')[1];
				if (fileType !== 'png' && fileType !== 'jpeg' && fileType !== 'jpg') {
					return;
				}
				if (document.querySelector('.chat-image')) {
					const existingImage = document.querySelector('.chat-image');
					existingImage.remove();
				}
				const img = (`<img class="chat-image" src="${reader.result}" alt="">`);
				const chatFormImageContainer = document.querySelector('.chat-form-image-container');
				chatFormImageContainer.innerHTML += img;
			};
			reader.readAsDataURL(file);
		});
	}

	const imageButton = document.querySelector('.chat-image-btn');
	imageButton.addEventListener('click', addImage);
});