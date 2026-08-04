const modal = document.getElementById("messageModal");

document.querySelectorAll(".read-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    // Only process unread messages
    if (btn.dataset.read === "0") {
      fetch("mark-read.php", {
        method: "POST",

        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },

        body: "id=" + btn.dataset.id,
      });

      // Mark as read locally
      btn.dataset.read = "1";

      // Update counter
      unreadCount--;

      // Optional: visually mark the card as read
      btn.closest(".message-card").classList.add("read-message");

      // Update badge if it exists on this page
      const badge = document.getElementById("messageCount");

      if (badge) {
        badge.textContent = unreadCount;
      }
    }

    // Open the modal
    document.getElementById("mName").textContent = btn.dataset.name;
    document.getElementById("mEmail").textContent = btn.dataset.email;
    document.getElementById("mPhone").textContent = btn.dataset.phone;
    document.getElementById("mSubject").textContent = btn.dataset.subject;
    document.getElementById("mDate").textContent = btn.dataset.date;
    document.getElementById("mMessage").textContent = btn.dataset.message;

    modal.style.display = "flex";
  });
});

document.querySelector(".close-modal").onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (e) {
  if (e.target == modal) {
    modal.style.display = "none";
  }
};
