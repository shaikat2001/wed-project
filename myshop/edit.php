<?php
$clientsFile = __DIR__ . '/clients.json';
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);
if (file_exists($clientsFile)) {
    $clients = json_decode(file_get_contents($clientsFile), true);
} else {
    $clients = [];
}
$client = null;
foreach ($clients as $c) {
    if ($c['id'] == $id) {
        $client = $c;
        break;
    }
}
if (!$client) {
    echo "Client not found.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($clients as &$c) {
        if ($c['id'] == $id) {
            $c['name'] = htmlspecialchars($_POST['name']);
            $c['email'] = htmlspecialchars($_POST['email']);
            $c['phone'] = htmlspecialchars($_POST['phone']);
            $c['address'] = htmlspecialchars($_POST['address']);
            break;
        }
    }
    file_put_contents($clientsFile, json_encode($clients, JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5" style="max-width:600px;">
        <h2 class="mb-4 text-center">Edit Client</h2>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($client['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($client['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($client['address']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Client</button>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>
