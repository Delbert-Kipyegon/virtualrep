document.addEventListener("DOMContentLoaded", () => {
	document
		.getElementById("register-form")
		.addEventListener("submit", function (event) {
			event.preventDefault(); // Prevent the default form submission
			const formData = new FormData(this); // Collect form data
			const xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest

			xhr.open("POST", "php/signup.php", true); // Configure the request
			xhr.onload = function () {
				if (xhr.status === 200) {
					const response = JSON.parse(xhr.responseText);
					console.log(response.success); // Make sure to log the correct property
					handleResponse(response);
				}
			};
			xhr.onerror = function () {
				handleError("An error occurred during registration. Please try again.");
			};
			xhr.send(formData); // Send the form data
		});
});

function handleResponse(response) {
	const errorText = document.querySelector(".error-text");
	if (response.success === true) {
		alert("Registration successful! Check your email for the OTP.");
		console.log("Redirecting...");
		window.location.href = "verify.html"; // Redirect after successful registration
	} else {
		errorText.textContent = response.message;
		errorText.style.display = "block"; // Show error message if not successful
	}
}

function handleError(errorMessage) {
	const errorText = document.querySelector(".error-text");
	errorText.textContent = errorMessage;
	errorText.style.display = "block"; // Show error message on XHR error
}
