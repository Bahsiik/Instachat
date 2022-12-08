const tab1 = document.getElementsByClassName("friends-list");
const tab2 = document.getElementsByClassName("waiting-list");
const tab3 = document.getElementsByClassName("requests-list");
const tab1Button = document.getElementsByClassName("friends");
const tab2Button = document.getElementsByClassName("waitings");
const tab3Button = document.getElementsByClassName("requests");
tab1Button[0].onclick = function() {
	tab1[0].classList.remove("hidden");
	tab2[0].classList.add("hidden");
	tab3[0].classList.add("hidden");
	tab1Button[0].classList.add("active");
	tab2Button[0].classList.remove("active");
	tab3Button[0].classList.remove("active");
}
tab2Button[0].onclick = function() {
	tab1[0].classList.add("hidden");
	tab2[0].classList.remove("hidden");
	tab3[0].classList.add("hidden");
	tab1Button[0].classList.remove("active");
	tab2Button[0].classList.add("active");
	tab3Button[0].classList.remove("active");
}
tab3Button[0].onclick = function() {
	tab1[0].classList.add("hidden");
	tab2[0].classList.add("hidden");
	tab3[0].classList.remove("hidden");
	tab1Button[0].classList.remove("active");
	tab2Button[0].classList.remove("active");
	tab3Button[0].classList.add("active");
}