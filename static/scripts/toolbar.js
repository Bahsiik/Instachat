import {updateCharacterCount} from "./RGB.js";

/**
 * @param chatArea {HTMLTextAreaElement}
 * @param imageInput {HTMLInputElement}
 * @returns {boolean}
 */
function inputsAreValid(chatArea, imageInput) {
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

		if (!['jpg', 'jpeg', 'png'].some(ext => image.name.endsWith(ext))) {
			alert("Le format de l'image n'est pas supporté. Les formats supportés sont : jpeg, jpg et png.");
			return false;
		}
	}

	const regex = /^(?=.*[A-Za-z0-9]{2,})[\s\S]*$/;

	const text = chatArea.value.trim();
	const hasTwoAlphanumericChars = regex.test(text);

	if (!hasTwoAlphanumericChars && !imageInput.files.length >= 1) {
		return false;
	}

	return chatArea.value.length >= 2 || imageInput.files.length >= 1;
}

document.addEventListener('DOMContentLoaded', () => {
	const chatContainers = document.querySelectorAll('.chat-container');
	chatContainers.forEach(chatContainer => {
		const chatArea = chatContainer.querySelector('.chat-area');
		const characterCount = chatContainer.querySelector('.chat-count');
		const form = chatContainer.querySelector('.post-form');
		const imageInput = chatContainer.querySelector('.chat-image-input');
		const chatFormBottom = chatContainer.querySelector('.chat-form-bottom');
		const chatButton = chatFormBottom.querySelector('.chat-btn');
		const imageButton = chatContainer.querySelector('.chat-image-btn');

		chatArea.addEventListener('input', () => {
			updateCharacterCount(chatArea.value, characterCount, 400);
			updateChatButton();
		});

		imageInput.addEventListener('change', () => updateChatButton());

		function updateChatButton() {
			if (inputsAreValid(chatArea, imageInput)) chatButton.removeAttribute('disabled');
			else chatButton.setAttribute('disabled', '');
		}

		form.addEventListener('submit', e => {
			if (inputsAreValid(chatArea, imageInput)) {
				chatButton.setAttribute('disabled', '');
				return;
			}
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
					if (chatContainer.querySelector('.chat-image')) {
						const existingImage = chatContainer.querySelector('.chat-image');
						existingImage.remove();
					}
					const img = `<img class="chat-image" src="${reader.result}" alt="">`;
					const chatFormImageContainer = chatContainer.querySelector('.chat-form-image-container');
					chatFormImageContainer.innerHTML += img;

					if (chatContainer.querySelector('.chat-delete-image-symbol')) {
						const existingSpan = chatContainer.querySelector('.chat-delete-image-symbol');
						existingSpan.remove();
					}
					const deleteSymbol = document.createElement('span');
					deleteSymbol.classList.add('material-symbols-outlined');
					deleteSymbol.classList.add('chat-delete-image-symbol');
					deleteSymbol.innerHTML = 'close';
					chatFormImageContainer.appendChild(deleteSymbol);
					deleteSymbol.addEventListener('click', () => {
						imageInput.value = '';
						chatFormImageContainer.innerHTML = '';
						updateChatButton();
					});
				};
				reader.readAsDataURL(file);
			});
		}

		imageButton.addEventListener('click', addImage);

		chatArea.addEventListener('input', () => {
			chatArea.style.height = "1px";
			chatArea.style.height = `${chatArea.scrollHeight}px`;
		});
	});

	const chatBtn = document.querySelector('.toolbar-chat-btn');
	const chatDialog = document.querySelector('.chat-dialog');
	const chatDialogCloseBtn = document.querySelector('.close-chat-dialog-btn');

	chatBtn.addEventListener('click', () => chatDialog.showModal());

	chatDialogCloseBtn.addEventListener('click', () => chatDialog.close());
});
