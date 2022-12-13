document.addEventListener('DOMContentLoaded', () => {
	// const currentUrl = window.location.;
	// console.log(JSON.stringify(window.location));
	const fetch = new FetchFeed(`${window.location.pathname}?offset=`, document.querySelector('.user-post-container'));
	console.log(fetch);
	fetch.addScripts(elements => twemoji.parse(elements));
});
