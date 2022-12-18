import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const fetchSearchedPosts = new FetchFeed(`${window.location.href}&offsetSearchedPosts=`, document.querySelector('.found-posts'));
	fetchSearchedPosts.addScripts(elements => twemoji.parse(elements));
});
