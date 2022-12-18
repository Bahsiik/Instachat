const rightPanelActive = 'right-panel-active';

/**
 * @param url {string}
 */
function changeRoute(url) {
	window.history.pushState({}, '', url);
}

document.addEventListener("DOMContentLoaded", () => {
	const signUpButton = document.querySelector('#signUp');
	const signInButton = document.querySelector('#signIn');
	const container = document.querySelector('#container');
	const usernameInput = document.querySelector('input[name="username"]');

	if (container.classList.contains(rightPanelActive)) changeRoute('/register');

	signUpButton.addEventListener('click', () => {
		container.classList.add(rightPanelActive);
		changeRoute('/register');
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove(rightPanelActive);
		changeRoute('/login');
	});

	usernameInput.addEventListener('input', () => {
		const username = usernameInput.value;
		const usernameRegex = new RegExp(`^${usernameInput.pattern}$`);
		const validity = usernameRegex.test(username) ? '' : 'Le nom d\'utilisateur doit contenir des caractères alphanumériques et/ou des underscores.';
		usernameInput.setCustomValidity(validity);
	});
});
