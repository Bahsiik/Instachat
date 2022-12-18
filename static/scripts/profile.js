import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const fetch = new FetchFeed(`${window.location.pathname}?offset=`, document.querySelector('.user-post-container'));
	const fetchComment = new FetchFeed(`${window.location.pathname}?offsetComments=`, document.querySelector('.user-comment-container'));
	const fetchReactedPosts = new FetchFeed(`${window.location.pathname}?offsetReactedPosts=`, document.querySelector('.user-reaction-container'));
	fetch.addScripts(elements => twemoji.parse(elements));
	fetchComment.addScripts(elements => twemoji.parse(elements));
	fetchReactedPosts.addScripts(elements => twemoji.parse(elements));

	document.addEventListener('click', async e => {
		const target = e.target;
		if (target.closest('.comment-container')) {
			if (['A', 'BUTTON', 'IMG'].includes(target.tagName) || ['material-symbols-outlined'].some(c => target.classList.contains(c))) return;

			const dataset = target.closest('.comment-container').dataset;
			const commentId = dataset.commentId;
			const postId = dataset.postId;
			window.location.href = `/post?id=${postId}#comment-${commentId}`;
		}
	});

	const editableAvatar = document.querySelector('form.profile-info-avatar');
	if (!editableAvatar) return;

	const avatar = editableAvatar.querySelector('img');
	const saveButton = document.querySelector('.save-avatar');

	avatar.addEventListener('click', e => {
		const target = e.target;
		if (target.closest('.profile-info-avatar')) {
			const input = target.closest('.profile-info-avatar').querySelector('input');
			const reader = new FileReader();
			input.click();

			input.addEventListener('change', async () => {
				const file = input.files[0];
				reader.readAsDataURL(file);
				reader.onload = () => {
					avatar.src = reader.result.toString();
					saveButton.hidden = false;
				}
			});
		}
	});
});
