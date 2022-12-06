document.addEventListener('DOMContentLoaded', () => {
	const optionsChoices = document.querySelectorAll('.option');
	const optionGroups = document.querySelectorAll('.options-group');

	optionsChoices.forEach((option, choiceIndex) => {
		option.addEventListener('click', () => {
			optionsChoices.forEach((option) => option.classList.remove('selected'));
			option.classList.add('selected');

			optionGroups.forEach((group, groupIndex) => {
				if (groupIndex === choiceIndex) group.classList.add('active');
				else group.classList.remove('active');
			});
		});
	});
});