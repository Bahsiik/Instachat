document.addEventListener("DOMContentLoaded", () => {
	const feedContainer = document.querySelector('.feed-container');
	const lastChild = feedContainer.lastElementChild;
	let offset = 5;

	const observer = new IntersectionObserver(async (entries) => {
		if (entries[0].isIntersecting) {
			const url = `${window.location.origin}/getFeed?offset=${offset}`;
			const request = await fetch(url, {
				method: 'GET',
				credentials: 'include',
			});
			const text = await request.text();
			let div = document.createElement('div');
			div.innerHTML = text;
			for (let child of div.children) {
				let menuChild = child.querySelector('.post-menu');
				if (!menuChild) continue;
				postClicked(menuChild);
			}

			if (div.children.length > 0) {
				feedContainer.appendChild(...div.children);
				offset += 5;
			}
		}
	});
	observer.observe(lastChild);

	let postMenu = getPostMenu();
	console.log("postMenu1", postMenu);
	postMenu.forEach((menu) => {
		postClicked(menu);
	});
});

function postClicked(menu) {
	menu.addEventListener('click', () => {
		showMenu(menu);
	});
}

function showMenu(menu) {
	let nextMenuContainer = menu.nextElementSibling;
	nextMenuContainer.classList.toggle('menu-hidden');
	nextMenuContainer.style.left = menu.getBoundingClientRect().right - (menu.offsetWidth + nextMenuContainer.offsetWidth + 10) + 'px';
	nextMenuContainer.style.top = menu.offsetTop + 'px';
}

function getPostMenu() {
	return document.querySelectorAll('.post-menu');
}



