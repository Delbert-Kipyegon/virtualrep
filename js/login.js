const form = document.getElementsByClassName("form");
const submitbtn = document.getElementsByClassName("submit-button");
const errortxt = document.getElementsByClassName("error-text");

form.onsubmit = (e) => {
	e.preventDefault(); //stops the default action
};

submitbtn.onclick = () => {
	// start ajax

	let xhr = new XMLHttpRequest(); // create xml object
	xhr.open("POST", "./php/login.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				let data = xhr.response;
				console.log(data);
				if (data == "success") {
					window.location.href = "../index.php";
				} else {
					errortxt.textContent = data;
					errortxt.style.display = "block";
				}
			}
		}
	};
	// send data through ajax to php
	let formData = new FormData(form); //creating new object from form data
	xhr.send(formData); //sending data to php
};
