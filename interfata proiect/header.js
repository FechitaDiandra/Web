document.addEventListener("DOMContentLoaded", function() {
  // Fetch the header content
  fetch("header.html")
    .then(response => response.text())
    .then(data => {
      // Insert the header content into the header-container div
      document.getElementById("header-container").innerHTML = data;
    });
});