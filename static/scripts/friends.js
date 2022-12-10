const tab1 = document.getElementsByClassName("friends-list");
const tab2 = document.getElementsByClassName("waiting-list");
const tab3 = document.getElementsByClassName("requests-list");
const tab1Button = document.getElementsByClassName("friends");
const tab2Button = document.getElementsByClassName("waitings");
const tab3Button = document.getElementsByClassName("requests");

function showTab(tab) {
	tab1[0].classList.add("hidden");
	tab2[0].classList.add("hidden");
	tab3[0].classList.add("hidden");

	tab1Button[0].classList.remove("active");
	tab2Button[0].classList.remove("active");
	tab3Button[0].classList.remove("active");

	if (tab === 1) {
		tab1[0].classList.remove("hidden");
		tab1Button[0].classList.add("active");
	} else if (tab === 2) {
		tab2[0].classList.remove("hidden");
		tab2Button[0].classList.add("active");
	} else if (tab === 3) {
		tab3[0].classList.remove("hidden");
		tab3Button[0].classList.add("active");
	}
}

tab1Button[0].onclick = () => {
	showTab(1);
};

tab2Button[0].onclick = () => {
	showTab(2);
};

tab3Button[0].onclick = () => {
	showTab(3);
};