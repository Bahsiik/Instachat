document.addEventListener("DOMContentLoaded", () => {
	const signUpButton = document.querySelector('#signUp');
	const signInButton = document.querySelector('#signIn');
	const container = document.querySelector('#container');
	const usernameInput = document.querySelector('input[name="username"]');

	signUpButton.addEventListener('click', () => {
		container.classList.add('right-panel-active');
		window.history.pushState({}, '', '/register');
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove('right-panel-active');
		window.history.pushState({}, '', '/login');
	});

	usernameInput.addEventListener('input', () => {
		const username = usernameInput.value;
		const usernameRegex = new RegExp(`^${usernameInput.pattern}$`);
		const validity = usernameRegex.test(username) ? '' : 'Le nom d\'utilisateur doit contenir des caractères alphanumériques et/ou des underscores.';
		usernameInput.setCustomValidity(validity);
	});
});
