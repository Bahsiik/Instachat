import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const postId = document.querySelector('article.post-container').dataset.postId;
	const fetchFeed = new FetchFeed(`/comments?post-id=${postId}&offset=`, document.querySelector('.comments'));

	const commentChatArea = document.querySelector('.comment-chat-area');
	const commentCharacterCount = document.querySelector('.comment-chat-count-number');
	const commentCharacterCountMax = document.querySelector('.comment-chat-count-max');
	const commentChatButton = document.querySelector('.comment-chat-btn');
	const commentForm = document.querySelector('.create-comment');

	fetchFeed.addScripts(elements => twemoji.parse(elements));

	document.addEventListener('click', async e => {
		const target = e.target;
		if (target.closest('.comment-share')) {
			const link = target.closest('.comment-share').dataset.link;
			await copyToClipboard(window.location.origin + link);
		}
	});

	class RGB {
		constructor(r, g, b) {
			this.r = r;
			this.g = g;
			this.b = b;
		}
	}

	function updateCharacterCount() {
		const text = commentChatArea.value;
		commentCharacterCount.innerHTML = text.length;
		if (text.length === 0) {
			commentCharacterCount.style.color = 'white';
			commentCharacterCountMax.style.color = 'white';
		} else {
			const color = text.length <= 50
				? new RGB(255, 255, 255 - (text.length / 30) * 255)
				: new RGB(255, 255 - ((text.length - 40) / 90) * 255, 0);
			commentCharacterCount.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
			commentCharacterCountMax.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
		}
	}

	commentChatArea.addEventListener('input', updateCharacterCount);

	commentChatArea.addEventListener('input', () => updateChatButton());

	function updateChatButton() {
		if (inputIsValid(commentChatArea)) commentChatButton.removeAttribute('disabled');
		else commentChatButton.setAttribute('disabled', '');
	}

	function inputIsValid(commentChatArea) {
		const regex = /^(?=.*[A-Za-z0-9]{2,})[\s\S]*$/;
		const text = commentChatArea.value.trim();
		const hasTwoAlphanumericChars = regex.test(text);

		if (!hasTwoAlphanumericChars) return false;

		return commentChatArea.value.length >= 2;
	}
});

async function copyToClipboard(text) {
	await navigator.clipboard.writeText(text);
	showPopup("Lien copié !");
}
