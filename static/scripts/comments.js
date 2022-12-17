import FetchFeed from "./fetch-feed.js";
import {showPopup} from "./popup.js";
import {updateCharacterCount} from "./RGB.js";

document.addEventListener('DOMContentLoaded', () => {
	const postId = document.querySelector('article.post-container').dataset.postId;
	const fetchFeed = new FetchFeed(`/comments?post-id=${postId}&offset=`, document.querySelector('.comments'));

	const commentChatArea = document.querySelector('.comment-chat-area');
	const commentCharacterCount = document.querySelector('.comment-chat-count');
	const commentChatButton = document.querySelector('.comment-chat-btn');

	fetchFeed.addScripts(elements => twemoji.parse(elements));

	document.addEventListener('click', async e => {
		const target = e.target;
		if (target.closest('.comment-share')) {
			const link = target.closest('.comment-share').dataset.link;
			await copyToClipboard(window.location.origin + link);
		}
	});

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

	commentChatArea.addEventListener('input', () => {
		updateCharacterCount(commentChatArea.value, commentCharacterCount, 120);
		updateChatButton()
	});
});

async function copyToClipboard(text) {
	await navigator.clipboard.writeText(text);
	showPopup("Lien copié !");
}
