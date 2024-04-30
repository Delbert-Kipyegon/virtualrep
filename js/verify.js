document.addEventListener("DOMContentLoaded", () => {
	const otpInputs = document.querySelectorAll(".otp_field");
	const form = document.querySelector("form");
	const errorText = document.querySelector(".error-text");

	// Initially focus the first input field
	otpInputs[0].focus();

	// Handle keydown events for OTP input fields
	otpInputs.forEach((field, index) => {
		field.addEventListener("keydown", (e) => {
			if (e.key >= "0" && e.key <= "9" && index < otpInputs.length - 1) {
				setTimeout(() => {
					otpInputs[Math.min(index + 1, otpInputs.length - 1)].focus();
				}, 10);
			} else if (e.key === "Backspace" && index > 0) {
				setTimeout(() => {
					otpInputs[index - 1].focus();
				}, 10);
			}
		});
	});

	// Form submission event handler
	form.addEventListener("submit", (event) => {
		event.preventDefault();
		let formData = new FormData(form); // Create a FormData object

		let xhr = new XMLHttpRequest(); // Create new XMLHttpRequest
		xhr.open("POST", "php/otp.php", true); // Configure the request

		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				let response = JSON.parse(xhr.responseText); // Make sure to parse the responseText, not response
				handleResponse(response);
			}
		};

		xhr.onerror = () => {
			handleError(
				"An error occurred during OTP verification. Please try again."
			);
		};

		xhr.send(formData); // Send the form data
	});
});

function handleResponse(response) {
	const errorText = document.querySelector(".error-text");
	if (response.success) {
		alert("Verification successful! Redirecting...");
		window.location.href = "homepage.php"; // Redirect to homepage upon successful verification
	} else {
		errorText.textContent = response.message;
		errorText.style.display = "block"; // Display error message if verification is unsuccessful
	}
}

function handleError(errorMessage) {
	const errorText = document.querySelector(".error-text");
	errorText.textContent = errorMessage;
	errorText.style.display = "block"; // Display error message on XHR error
}
