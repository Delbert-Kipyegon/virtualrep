// const form = document.getElementsByClassName("form");
// submitbtn = form.getElementsByClassName("submit-button");
// // const submitbtn = document.getElementsByClassName("submit-button");
// errortxt = form.getElementsByClassName("error-text");
// // const errortxt = document.getElementsByClassName("error-text");

// form.onsubmit = (e) => {
// 	e.preventDefault(); //stops the default action
// };

// submitbtn.onclick = () => {
// 	// start ajax

// 	let xhr = new XMLHttpRequest(); // create xml object
// 	xhr.open("POST", "./Php/login.php", true);
// 	xhr.onload = () => {
// 		if (xhr.readyState === XMLHttpRequest.DONE) {
// 			if (xhr.status === 200) {
// 				let data = xhr.response;
// 				console.log(data);
// 				if (data == "success") {
// 					window.location.href = "./index.php";
// 				} else {
// 					errortxt.textContent = data;
// 					errortxt.style.display = "block";
// 				}
// 			}
// 		}
// 	};
// 	// send data through ajax to php
// 	let formData = new FormData(form); //creating new object from form data
// 	xhr.send(formData); //sending data to php
// };

// Assuming there is only one form and one submit button
const form = document.getElementsByClassName("form"); // Access the first form
const submitbtn = document.getElementsByClassName("submit-button"); // Access the first submit button
const errortxt = document.getElementsByClassName("error-text"); // Access the first error text

// form.onsubmit = (e) => {
// 	e.preventDefault(); //stops the default action
// }

submitbtn.onclick = () => {

	console.log("submit button clicked");

	// start ajax
	let xhr = new XMLHttpRequest(); // create xml object
	xhr.open("POST", "./Php/login.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				let data = xhr.response;
				console.log(data);
				if (data == "success") {
					console.log("Redirecting to index.php");
					location.href= "/index.php";
				} else {
					console.log("Failed to redirect");
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
