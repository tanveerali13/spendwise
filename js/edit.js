function editExpense(expense) {
  const editPopup = document.getElementById("edit-popup");
  editPopup.style.display = "block";

  // Populate the form fields with the expense data
  document.querySelector("#edit-id").value = expense.id;
  document.querySelector("#edit-date").value = expense.added_on;
  document.querySelector("#edit-expense-name").value = expense.expense_name;
  document.querySelector("#edit-category-name").value = expense.category_name;
  document.querySelector("#edit-amount").value = expense.amount;
  document.querySelector("#edit-details").value = expense.details;

  const updateButton = document.querySelector("#update-edit");
  updateButton.textContent = "Update";

  // Add an event listener to the update button
  updateButton.addEventListener("click", (event) => {
    event.preventDefault();

    // Retrieve the edited values from the form fields
    const editedId = document.querySelector("#edit-id").value;
    const editedDate = document.querySelector("#edit-date").value;
    const editedExpenseName =
      document.querySelector("#edit-expense-name").value;
    const editedCategoryName = document.querySelector(
      "#edit-category-name"
    ).value;
    const editedAmount = document.querySelector("#edit-amount").value;
    const editedDetails = document.querySelector("#edit-details").value;
    // console.log(editedDate);
    //console.log(editedCategoryName);
    const url = `app/edit.php?id=${editedId}&date=${editedDate}&expense_name=${editedExpenseName}&category_name=${editedCategoryName}&amount=${editedAmount}&details=${editedDetails}`;
    //console.log(url);

    editPopup.style.display = "none";
    updater(url);
  });

  //Cancel and close popup
  const cancelButton = document.querySelector("#edit-cancel");
  cancelButton.textContent = "Cancel";
  cancelButton.addEventListener("click", () => {
    editPopup.style.display = "none";
  });
}

async function updater(url) {
  fetch(url);
  fetchExpense("app/user_select.php");
}
