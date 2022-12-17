const button = document.getElementsByClassName("show-more-button")[0];
button.addEventListener("click", changeTrendsDisplay);

function changeTrendsDisplay() {
	const text = event.target.className;
	switch (text) {
		case "show-more-button":
			const hiddenTrends = document.getElementsByClassName("trend hidden");
			[...hiddenTrends].forEach(trend => trend.classList.remove("hidden"));
			document.getElementsByClassName("show-more-button")[0].innerText = "Afficher moins";
			document.getElementsByClassName("show-more-button")[0].className = "show-less-button";
			break;
		case "show-less-button":
			const trendsToHide = document.getElementsByClassName("trend");
			[...trendsToHide].forEach((trend, index) => {
				if (index > 4) {
					trend.classList.add("hidden");
				}
			}, 0);
			document.getElementsByClassName("show-less-button")[0].innerText = "Afficher plus";
			document.getElementsByClassName("show-less-button")[0].className = "show-more-button";
			break;
	}
}