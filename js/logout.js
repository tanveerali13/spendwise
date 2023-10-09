const logoutPopup = document.getElementById("logout-popup");
const confirmLogoutButton = document.getElementById("confirm-logout");
const cancelLogoutButton = document.getElementById("cancel-logout");
const logoutButton = document.querySelector("#logout-button");

//When the logout button is clicked
logoutButton.addEventListener("click", () => {
  logoutPopup.style.display = "block";

  //when yes button is clicked
  confirmLogoutButton.addEventListener("click", () => {
    logoutPopup.style.display = "none";
    window.location.href = "./app/logout.php";
  });
  //when no button is clicked
  cancelLogoutButton.addEventListener("click", () => {
    logoutPopup.style.display = "none";
  });
});
