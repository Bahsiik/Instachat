/**
 * @param textarea {HTMLTextAreaElement}
 * @param imageInput {HTMLInputElement}
 * @returns {boolean}
 */
function inputsAreValid(textarea, imageInput) {
	const image = imageInput.files[0];
	const maxSize = 16 * 1024 * 1024;
	if (image) {
		if (image.size > maxSize) {
			alert("L'image est trop lourde. Elle ne doit pas dépasser 16 Mo.");
			return false;
		}
		if (!image.type.startsWith('image/')) {
			alert("Le fichier n'est pas une image.");
			return false;
		}
		if (!image.type.endsWith('jpeg') && !image.type.endsWith('png') && !image.type.endsWith('jpg')) {
			alert("Le format de l'image n'est pas supporté. Les formats supportés sont : jpeg, jpg et png.");
			return false;
		}
	}

	return textarea.value.length >= 2 || imageInput.files.length >= 1;
}

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

	textarea.addEventListener('input', () => updateChatButton());
	imageInput.addEventListener('change', () => updateChatButton());

	function updateChatButton() {
		if (inputsAreValid(textarea, imageInput)) chatButton.removeAttribute('disabled');
		else chatButton.setAttribute('disabled', '');
	}

	form.addEventListener('submit', e => {
		if (inputsAreValid(textarea, imageInput)) return;
		e.preventDefault();
	});

	function addImage() {
		imageInput.click();
		const reader = new FileReader();
		imageInput.addEventListener('change', () => {
			const file = imageInput.files[0];
			reader.onloadend = () => {
				const fileType = file.type.split('/')[1];
				if (fileType !== 'png' && fileType !== 'jpeg' && fileType !== 'jpg') return;
				if (document.querySelector('.chat-image')) {
					const existingImage = document.querySelector('.chat-image');
					existingImage.remove();
				}
				const img = `<img class="chat-image" src="${reader.result}" alt="">`;
				const chatFormImageContainer = document.querySelector('.chat-form-image-container');
				chatFormImageContainer.innerHTML += img;
			};
			reader.readAsDataURL(file);
		});
	}

	const imageButton = document.querySelector('.chat-image-btn');
	imageButton.addEventListener('click', addImage);
});
