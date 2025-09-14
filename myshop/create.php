<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5" style="max-width:600px;">
        <h2 class="mb-4 text-center">Add New Client</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $address = htmlspecialchars($_POST['address']);
            $created_at = date('Y-m-d H:i:s');

            $clientsFile = __DIR__ . '/clients.json';
            $clients = [];
            if (file_exists($clientsFile)) {
                $clients = json_decode(file_get_contents($clientsFile), true);
            }
            $newId = count($clients) > 0 ? max(array_column($clients, 'id')) + 1 : 1;
            $clients[] = [
                'id' => $newId,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'created_at' => $created_at
            ];
            file_put_contents($clientsFile, json_encode($clients, JSON_PRETTY_PRINT));
            header('Location: index.php');
            exit;
        }
        ?>
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add Client</button>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>