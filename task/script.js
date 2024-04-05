function toggleTheme() {
	div.classList.toggle("light-theme");
	div.classList.toggle("dark-theme");
}

// common.js
document.addEventListener("DOMContentLoaded", function () {
	const sidebar = document.getElementById("sidebar");
	const sidebarToggle = document.getElementById("sidebarToggle");

	sidebarToggle.addEventListener("click", function (event) {
		event.stopPropagation(); // Prevent click from being immediately propagated to the body
		sidebar.classList.toggle("-translate-x-full");
	});

	document.addEventListener("click", function (event) {
		let targetElement = event.target; // clicked element

		do {
			if (targetElement == sidebar || targetElement == sidebarToggle) {
				// This is a click inside the sidebar or toggle, so ignore.
				return;
			}
			// Go up the DOM
			targetElement = targetElement.parentNode;
		} while (targetElement);

		// This is a click outside, close the sidebar.
		sidebar.classList.add("-translate-x-full");
	});
});
