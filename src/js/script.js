navButton.addEventListener("click", () => {
	let visibility = navBar.getAttribute("data-visible");

	if (visibility === "false") {
		navBar.setAttribute("data-visible", true);
	} else if (visibility === "true") {
		navBar.setAttribute("data-visible", false);
	}
});