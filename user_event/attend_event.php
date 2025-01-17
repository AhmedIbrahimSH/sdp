<?php


require_once '../EventModule/Model/database_connection.php';

$conn = myDatabase::get_instance();

if (!$conn) {
    die("Connection failed");
}

$query = "SELECT EventID, Title, Location, Date, Price, type FROM events WHERE Date >= CURDATE() ORDER BY Date ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$user_id = 7;

function isUserRegistered($user_id, $event_id) {
    global $conn;
    $query = "SELECT * FROM user_attendees WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id, $event_id]);
    return $stmt->rowCount() > 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .event {
            padding: 20px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .event h2 {
            margin: 0 0 10px;
        }
        .event p {
            margin: 5px 0;
        }
        .event .location a {
            text-decoration: none;
            color: #007bff;
        }
        .event .attend-btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .event .attend-btn.disabled {
            background-color: #ccc;
        }
    </style>
</head>
<body>

<h1>Upcoming Events</h1>

<?php foreach ($events as $event): ?>
    <div class="event">
        <h2><?php echo htmlspecialchars($event['Title']); ?></h2>
        <p><strong>Location:</strong> <span class="location"><a href="https://www.google.com/maps?q=<?php echo urlencode($event['Location']); ?>" target="_blank"><?php echo htmlspecialchars($event['Location']); ?></a></span></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['Date']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($event['Price']); ?></p>
        <p><strong>Type:</strong> <?php echo htmlspecialchars($event['type']); ?></p>

        <?php
        $isRegistered = isUserRegistered($user_id, $event['EventID']);
        ?>

        <p><strong>Status:</strong> <?php echo $isRegistered ? 'You are registered' : 'You are not registered'; ?></p>

        <?php if (!$isRegistered): ?>
            <a href="attend_event.php?event_id=<?php echo $event['EventID']; ?>"
               onclick="attendEvent(<?php echo $event['EventID']; ?>, <?php echo $user_id; ?>);"
               class="attend-btn">
                Attend Event
            </a>

        <?php else: ?>
            <button class="attend-btn disabled" disabled>Already Registered</button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<script src="controller/script.js"></script>
</body>
</html>
