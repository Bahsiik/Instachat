import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const fetch = new FetchFeed(`${window.location.pathname}?offset=`, document.querySelector('.user-post-container'));
	fetch.addScripts(elements => twemoji.parse(elements));
});
