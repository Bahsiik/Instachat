document.addEventListener("DOMContentLoaded", () => {
	const feedContainer = document.querySelector('.feed-container');
	const lastChild = feedContainer.lastElementChild;
	let offset = 5;

	const observer = new IntersectionObserver(async (entries) => {
		if (entries[0].isIntersecting) {
			console.log('bottom');
			const request = await fetch(`getFeed?offset=${offset}`, {
				method: 'POST',
				credentials: 'include',
			});
			const text = await request.text();
			feedContainer.insertAdjacentHTML('beforeend', text);
			offset += 5;
		}
	});
	observer.observe(lastChild);
});


