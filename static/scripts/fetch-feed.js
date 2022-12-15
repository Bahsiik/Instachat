export default class FetchFeed {
	url;
	offset;
	feedContainer;
	observer;
	scripts = [];
	elementsScripts = [];
	fetchOptions = {
		credentials: 'include',
		method: 'GET',
	};

	constructor(url, feedContainer) {
		if (!url) throw new Error('url is required');
		if (!feedContainer) throw new Error('feedContainer is required');
		this.url = url;
		this.feedContainer = feedContainer;
		this.offset = 5;
		this.observer = new IntersectionObserver(this.handleIntersect.bind(this));
		this.observer.observe(this.targetElement);
	}

	get targetElement() {
		return this.feedContainer.lastElementChild;
	}

	addScripts(...script) {
		this.scripts.push(...script);
	}

	addElementScripts(...script) {
		this.elementsScripts.push(...script);
	}

	async handleIntersect(entries) {
		if (!entries[0].isIntersecting) return;
		await this.fetchFeed();
	}

	async fetchFeed() {
		const url = this.url + this.offset;
		const request = await fetch(url, this.fetchOptions);

		const text = await request.text();
		const div = document.createElement('div');
		div.innerHTML = text;

		if (div.children.length <= 0) return;

		for (const child of div.children) {
			this.elementsScripts.forEach(script => script(child));
		}

		this.observer.unobserve(this.targetElement);
		this.feedContainer.append(...div.children);
		this.observer.observe(this.targetElement);
		this.scripts.forEach(script => script(div));
		this.offset += 5;
	}
}
