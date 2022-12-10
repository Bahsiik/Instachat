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
			const div = document.createElement('div');
			div.innerHTML = text;
			for (const child of div.children) {
				const menuChild = child.querySelector('.post-menu');
				if (!menuChild) continue;
				postClicked(menuChild);
			}

			if (div.children.length > 0) {
				feedContainer.appendChild(...div.children);
				twemoji.parse(document.body);
				offset += 5;
			}
		}
	});
	observer.observe(lastChild);

	const postMenu = getPostMenu();
	postMenu.forEach((menu) => {
		postClicked(menu);
	});

	document.addEventListener('click', (e) => {
		if (!e.target.closest('.post-menu')) {
			const postMenu = getPostMenu();
			postMenu.forEach((menu) => {
				// hideOthersMenu(menu);
				// if line above is uncommented, it will hide all menus when clicking outside of menu
				// but hiding all menus is also hiding the modal dialog
				// todo: find a way to hide all menus except the modal dialog
				//  (remove menu-hidden class from menu-container)
			});
		}
	});
});

function postClicked(menu) {
	menu.addEventListener('click', () => {
		showMenu(menu);
	});
}

function showMenu(menu) {
	hideOthersMenu(menu);
	const nextMenuContainer = menu.nextElementSibling;
	nextMenuContainer.classList.toggle('menu-hidden');
	nextMenuContainer.style.left = `${menu.getBoundingClientRect().right - (menu.offsetWidth + nextMenuContainer.offsetWidth + 10)}px`;
	nextMenuContainer.style.top = `${menu.offsetTop}px`;
	nextMenuContainer.addEventListener('click', (e) => {
		if (e.target.classList.contains('menu-delete-btn')) {
			const modal = nextMenuContainer.querySelector('dialog');
			modal.showModal();
			if (modal.open) {
				modal.querySelector('.modal-cancel-btn').addEventListener('click', () => {
					modal.close()
				});
			}
		}
	});
}

function hideOthersMenu(menu) {
	const postMenu = getPostMenu();
	postMenu.forEach((e) => {
		if (e !== menu) {
			console.log("hide");
			e.nextElementSibling.classList.add('menu-hidden');
		}
	});
}

function getPostMenu() {
	return document.querySelectorAll('.post-menu');
}