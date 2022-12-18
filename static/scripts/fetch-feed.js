/**
 * @typedef {(elements: HTMLDivElement) => void} Script
 */

export default class FetchFeed {
	/**
	 * @type {string}
	 */
	url;
	/**
	 * @type {number}
	 */
	offset;
	/**
	 * @type {HTMLDivElement}
	 */
	feedContainer;
	/**
	 * @type {IntersectionObserver}
	 */
	observer;
	/**
	 * @type {Script[]}
	 */
	scripts = [];
	/**
	 * @type {Script[]}
	 */
	elementsScripts = [];
	/**
	 * @type {RequestInit}
	 */
	fetchOptions = {
		credentials: 'include',
		method: 'GET',
	};

	/**
	 * @param url {string}
	 * @param feedContainer {HTMLDivElement}
	 */
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

	/**
	 * @param script {Script}
	 */
	addScripts(...script) {
		this.scripts.push(...script);
	}

	/**
	 * @param script {Script}
	 */
	addElementScripts(...script) {
		this.elementsScripts.push(...script);
	}

	/**
	 * @param entries {IntersectionObserverEntry[]}
	 * @returns {void}
	 */
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
		this.scripts.forEach(script => script(div));

		for (const child of div.children) {
			this.elementsScripts.forEach(script => script(child));
		}

		this.observer.unobserve(this.targetElement);
		this.feedContainer.append(...div.children);
		this.observer.observe(this.targetElement);
		this.offset += 5;
	}
}
