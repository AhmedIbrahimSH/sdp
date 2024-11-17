<?php require_once("notify-logic-viw.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Event Notifications</h1>
        
        <div class="row">
            <!-- Registration Section (Left) -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Volunteer Registrations
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($registrationLog as $registration): ?>
                                <li class="list-group-item"><?= htmlspecialchars($registration); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Notifications Section (Right) -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        Notifications
                    </div>
                    <div class="card-body">
                        <?php foreach ($notificationLog as $notification): ?>
                            <div class="alert alert-info" role="alert">
                                <strong>Sending notifications for <?= htmlspecialchars($notification['event']); ?>:</strong>
                                <p><?= htmlspecialchars($notification['message']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
