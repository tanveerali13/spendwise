document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("#login-form");
  const errorMessage = document.querySelector("#error-message");

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    console.log("Form submitted");
    const formData = new FormData(form);
    const url = "app/login.php";

    if (form.checkValidity()) {
      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          if (data.success) {
            // Login was successful, redirect to the feed page
            window.location.href = "spendwise.html";
          } else {
            // Display an error message to the user
            errorMessage.innerHTML = data.message;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          errorMessage.innerHTML =
            "An error occurred during login. Please try again.";
        });
    } else {
      // If the form is not valid, display an error message
      errorMessage.innerHTML = "Please fill out all required fields correctly.";
    }
  });
});
