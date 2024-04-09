document.addEventListener("DOMContentLoaded", () => {
	document
		.getElementById("register-form")
		.addEventListener("submit", function (event) {
			event.preventDefault();
			const formData = new FormData(this);
			const xhr = new XMLHttpRequest();

			xhr.open("POST", "php/signup.php", true);
			xhr.onload = function () {
				if (xhr.status === 200) {
					const response = JSON.parse(xhr.responseText);
					console.log(response.sucess);
					handleResponse(response);
				}
			};
			xhr.onerror = function () {
				handleError("An error occurred during registration. Please try again.");
			};
			xhr.send(formData);
		});
});

function handleResponse(response) {
	const errorText = document.querySelector(".error-text");
	if (response.success === true) {
		alert("Registration successful! Check your email for the OTP.");
		console.log("Redirecting...");
		window.location.href = "verify.html";
	} else {
		errorText.textContent = response.message;
		errorText.style.display = "block";
	}
}

function handleError(errorMessage) {
	document.querySelector(".error-text").textContent = errorMessage;
}
