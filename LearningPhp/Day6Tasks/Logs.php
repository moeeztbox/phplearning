<?php
$logFile = "logs/app.log";

$logs = [];

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $pattern='/^"(.*?)"\s+\((.*?)\)$/';
    foreach ($lines as $line) {
        if (preg_match($pattern, $line, $matches)) {
            $message = $matches[1];
            $timestamp = $matches[2];

            if (stripos($message, 'FAILED') !== false) {
                $type = 'Error';
            } elseif (stripos($message, 'successfully') !== false || stripos($message, 'removed') !== false) {
                $type = 'Success';
            } else {
                $type = 'Info';
            }

            $logs[] = [
                'message' => $message,
                'timestamp' => $timestamp,
                'type' => $type
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logs Viewer</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .Success { color: green; }
        .Error { color: red; }
        .Info { color: blue; }
    </style>
</head>
<body>
    <h2>Application Logs</h2>

    <?php if (!empty($logs)): ?>
        <table>
            <tr>
                <th>Type</th>
                <th>Message</th>
                <th>Timestamp</th>
            </tr>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td class="<?= $log['type'] ?>"><?= $log['type'] ?></td>
                    <td><?= htmlspecialchars($log['message']) ?></td>
                    <td><?= $log['timestamp'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No logs found.</p>
    <?php endif; ?>
</body>
</html>
