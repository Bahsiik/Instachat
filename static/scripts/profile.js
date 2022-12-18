import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const fetch = new FetchFeed(`${window.location.pathname}?offset=`, document.querySelector('.user-post-container'));
	const fetchComment = new FetchFeed(`${window.location.pathname}?offsetComments=`, document.querySelector('.user-comment-container'));
	const fetchReactedPosts = new FetchFeed(`${window.location.pathname}?offsetReactedPosts=`, document.querySelector('.user-reaction-container'));
	fetch.addScripts(elements => twemoji.parse(elements));
	fetchComment.addScripts(elements => twemoji.parse(elements));
	fetchReactedPosts.addScripts(elements => twemoji.parse(elements));
});
