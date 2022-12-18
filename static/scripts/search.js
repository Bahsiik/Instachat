import FetchFeed from "./fetch-feed.js";

document.addEventListener('DOMContentLoaded', () => {
	const fetchSearchedPosts = new FetchFeed(`${window.location.pathname}&offsetSearchedPosts=`, document.querySelector('.found-posts'));
	console.log(fetchSearchedPosts.url);

	fetchSearchedPosts.addScripts(elements => twemoji.parse(elements));
	console.log(fetchSearchedPosts.url);
});