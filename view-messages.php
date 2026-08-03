<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
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

 <body>

<header class="top-header">

    <div class="header-content">

        <div>

            <h1>
                <i class="fas fa-envelope-open-text"></i>
                Customer Messages
            </h1>

            <p>
                Welcome,
                <strong><?php echo $_SESSION['admin']; ?></strong>
            </p>

        </div>

        <a href="logout.php" class="logout-btn">
            <i class="fas fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</header>


<section class="dashboard">

    <div class="dashboard-title">

        <h2>Inbox</h2>

        <span>
            <?php echo $result->num_rows; ?> Message(s)
        </span>

    </div>


    <div class="messages-grid">

        <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <div class="message-card">

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

                                <?php echo date("F d, Y • h:i A",strtotime($row['created_at'])); ?>

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

                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>

                            </p>

                        </div>

                    </div>

                    <div class="card-footer">

                        <a href="mailto:<?php echo $row['email']; ?>" class="reply-btn">

                            <i class="fas fa-reply"></i>

                            Reply

                        </a>

                    </div>

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

</body>

</body>

</html>

<?php
$conn->close();
?>