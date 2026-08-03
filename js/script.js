const searchInput = document.getElementById("searchInput");

searchInput.addEventListener("keyup", function () {
  const value = this.value.toLowerCase();

  const cards = document.querySelectorAll(".card");

  cards.forEach((card) => {
    const text = card.innerText.toLowerCase();

    card.style.display = text.includes(value) ? "block" : "none";
  });
});

const form = document.getElementById("contactForm");

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name").value.trim();

  const email = document.getElementById("email").value.trim();

  const message = document.getElementById("message").value.trim();

  const status = document.getElementById("status");

  if (name == "" || email == "" || message == "") {
    status.style.color = "red";

    status.innerHTML = "Please complete all fields.";

    return;
  }

  status.style.color = "green";

  status.innerHTML = "Thank you! Your inquiry has been submitted.";

  form.reset();
});
