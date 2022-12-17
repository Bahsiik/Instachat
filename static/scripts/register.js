document.addEventListener("DOMContentLoaded", () => {
	const signUpButton = document.querySelector('#signUp');
	const signInButton = document.querySelector('#signIn');
	const container = document.querySelector('#container');
	const usernameInput = document.querySelector('input[name="username"]');

	signUpButton.addEventListener('click', () => container.classList.add('right-panel-active'));
	signInButton.addEventListener('click', () => container.classList.remove('right-panel-active'));

	usernameInput.addEventListener('input', () => {
		const username = usernameInput.value;
		const usernameRegex = new RegExp(`^${usernameInput.pattern}$`);
		usernameRegex.test(username) ? usernameInput.setCustomValidity('') : usernameInput.setCustomValidity('Le nom d\'utilisateur doit contenir des caractères alphanumériques et/ou des underscores.');
	});
});

