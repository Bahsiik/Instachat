const tab1 = document.getElementsByClassName("masked-word-list");
const tab2 = document.getElementsByClassName("blocked-user-list");
const tab1Button = document.getElementsByClassName("masked");
const tab2Button = document.getElementsByClassName("blocked");

function showTab(tab) {
	tab1[0].classList.add("hidden");
	tab2[0].classList.add("hidden");

	tab1Button[0].classList.remove("active");
	tab2Button[0].classList.remove("active");

	if (tab === 1) {
		tab1[0].classList.remove("hidden");
		tab1Button[0].classList.add("active");
	} else if (tab === 2) {
		tab2[0].classList.remove("hidden");
		tab2Button[0].classList.add("active");
	}
}

tab1Button[0].onclick = () => {
	showTab(1);
};

tab2Button[0].onclick = () => {
	showTab(2);
};