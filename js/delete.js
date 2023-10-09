function deleteExpense(id) {
  const confirmationPopup = document.getElementById("delete-popup");
  const confirmDeleteButton = document.getElementById("confirm-delete");
  const cancelDeleteButton = document.getElementById("cancel-delete");

  // Show the confirmation popup when delete button is clicked
  confirmationPopup.style.display = "block";

  //When yes button is clicked
  confirmDeleteButton.addEventListener("click", () => {
    const url = `app/delete.php?id=${id}`;
    fetch(url);

    // To refresh the list
    fetchExpense("app/user_select.php");

    // Close the confirmation popup
    confirmationPopup.style.display = "none";
  });

  // Close the confirmation popup if clicked on 'no'
  cancelDeleteButton.addEventListener("click", () => {
    confirmationPopup.style.display = "none";
  });
}
