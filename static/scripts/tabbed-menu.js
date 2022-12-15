document.addEventListener('DOMContentLoaded', () => {
	const tabbedMenues = document.querySelectorAll('.tabbed-menu');

	tabbedMenues.forEach(tabbedMenu => {
		const tabs = tabbedMenu.querySelectorAll('.tabs > .tab');
		const contents = tabbedMenu.querySelectorAll('.content > div');

		tabs.forEach((tab, index) =>
			tab.addEventListener('click', () => {
				const content = contents[index];

				tabs.forEach(tab => tab.classList.remove('selected'));
				contents.forEach(content => content.classList.remove('selected'));

				tab.classList.add('selected');
				content.classList.add('selected');
			}));
	});
});
