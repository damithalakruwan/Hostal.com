// script.js

document.getElementById("hostel-form").addEventListener("submit", function(e) {
  e.preventDefault();

  const userId = document.getElementById("email").value;
  const statusDiv = document.getElementById("status");

  if (userId.trim() === "") {
    statusDiv.textContent = "Please enter a valid User ID.";
    return;
  }

  // Send the user ID to the server for entry/exit processing
  fetch("process-entry-exit.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email: email })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.textContent = `User ${email} has ${data.action} the hostel.`;
    } else {
      statusDiv.textContent = `Error: ${data.message}`;
    }
  })
  .catch(error => {
    statusDiv.textContent = "Error processing the request.";
  });
});
