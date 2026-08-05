<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

$sql = "SELECT * FROM contact_messages ORDER BY is_read ASC, created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Database Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Messages | Hope Ways Realty</title>

    <link rel="stylesheet" href="css/messages.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

 

<header class="top-header">

    <div class="header-content">

        <div>

            <h1>
                <i class="fas fa-user-shield"></i>
                HopeWays Realty Admin
            </h1>

            <p>
                Welcome,
                <strong><?php echo $_SESSION['admin']; ?></strong>
            </p>

        </div>

        <div class="header-actions">

            <a href="view-messages.php" class="nav-btn active">
                <i class="fas fa-envelope"></i>
                Messages
            </a>

            <a href="manage-properties.php" class="nav-btn">
                <i class="fas fa-building"></i>
                Properties
            </a>

            <a href="logout.php" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i>
                Logout
            </a>

        </div>

    </div>

</header>


<section class="dashboard">

    <div class="dashboard-title">

        <h2>
    <i class="fas fa-envelope-open-text"></i>
    Customer Messages
</h2>

        <span>
            <?php echo $result->num_rows; ?> Total Message(s)
        </span>

    </div>


    <div class="messages-grid">

        <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <div class="message-card <?php echo $row['is_read'] ? 'read-message' : ''; ?>">

                    <div class="card-top">

                        <div class="avatar">

                            <?php
                            echo strtoupper(substr($row['fullname'],0,1));
                            ?>

                        </div>

                        <div class="user-details">

    <h3>
        <?php echo htmlspecialchars($row['fullname']); ?>
    </h3>

    <span>
        <i class="fas fa-calendar-alt"></i>
        <?php echo date("F d, Y • h:i A", strtotime($row['created_at'])); ?>
    </span>

    <span class="status-badge <?php echo $row['is_read'] ? '' : 'hidden'; ?>">
        ✓ Opened
    </span>

</div>

                    </div>


                    <div class="card-content">

                        <div class="info-row">

                            <i class="fas fa-envelope"></i>

                            <span>

                                <?php echo htmlspecialchars($row['email']); ?>

                            </span>

                        </div>

                        <div class="info-row">

                            <i class="fas fa-phone"></i>

                            <span>

                                <?php echo htmlspecialchars($row['phone']); ?>

                            </span>

                        </div>

                        <div class="info-row">

                            <i class="fas fa-tag"></i>

                            <span>

                                <?php echo htmlspecialchars($row['subject']); ?>

                            </span>

                        </div>

                       <div class="message-area">

    <h4>
        <i class="fas fa-comment"></i>
        Customer Message
    </h4>

    <p>
        <?php
        $preview = strlen($row['message']) > 100
            ? substr($row['message'], 0, 100) . "..."
            : $row['message'];

        echo nl2br(htmlspecialchars($preview));
        ?>
    </p>

   <button
    class="read-btn <?php echo $row['is_read'] ? 'unread-btn' : ''; ?>"
    data-id="<?php echo $row['id']; ?>"
    data-read="<?php echo $row['is_read']; ?>"
    data-name="<?php echo htmlspecialchars($row['fullname']); ?>"
    data-email="<?php echo htmlspecialchars($row['email']); ?>"
    data-phone="<?php echo htmlspecialchars($row['phone']); ?>"
    data-subject="<?php echo htmlspecialchars($row['subject']); ?>"
    data-date="<?php echo date('F d, Y • h:i A', strtotime($row['created_at'])); ?>"
    data-message="<?php echo htmlspecialchars($row['message']); ?>">

    <i class="fas <?php echo $row['is_read'] ? 'fa-envelope' : 'fa-book-open'; ?>"></i>

    <?php echo $row['is_read'] ? 'Unread' : 'Read'; ?>

</button>
<a
    href="delete-message.php?id=<?php echo $row['id']; ?>"
    class="delete-btn"
    onclick="return confirm('Are you sure you want to delete this message?');">

    <i class="fas fa-trash"></i> Delete

</a>


                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="empty-state">

                <i class="fas fa-inbox"></i>

                <h2>No Messages Found</h2>

                <p>
                    Customer inquiries will appear here.
                </p>

            </div>

        <?php } ?>

    </div>

</section>
<div id="messageModal" class="modal">

    <div class="modal-box">

        <span class="close-modal">&times;</span>

        <h2>
            <i class="fas fa-envelope-open-text"></i>
            Customer Message
        </h2>

        <hr>

        <p><strong>Name:</strong> <span id="mName"></span></p>

        <p><strong>Email:</strong> <span id="mEmail"></span></p>

        <p><strong>Phone:</strong> <span id="mPhone"></span></p>

        <p><strong>Subject:</strong> <span id="mSubject"></span></p>

        <p><strong>Date:</strong> <span id="mDate"></span></p>

        <hr>

        <div id="mMessage"></div>

    </div>

</div>

<script>

const modal = document.getElementById("messageModal");

document.querySelectorAll(".read-btn").forEach(btn => {

    btn.addEventListener("click", () => {

        fetch("mark-read.php", {

            method: "POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:"id="+btn.dataset.id

        })

        .then(response => response.json())

        .then(data => {

            btn.dataset.read = data.is_read;

            const card = btn.closest(".message-card");

            const badge = card.querySelector(".status-badge");

            if(data.is_read == 1){

                card.classList.add("read-message");

                badge.classList.remove("hidden");

                btn.classList.add("unread-btn");

                btn.innerHTML =
                    '<i class="fas fa-envelope"></i> Unread';

            }else{

                card.classList.remove("read-message");

                badge.classList.add("hidden");

                btn.classList.remove("unread-btn");

                btn.innerHTML =
                    '<i class="fas fa-book-open"></i> Read';

            }

        });

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

}

window.onclick = function (e) {

    if (e.target == modal) {

        modal.style.display = "none";

    }

}

</script>
</body>



</html>

<?php
$conn->close();
?>