<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
        }
        .table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .table th {
            background: #343a40;
            color: #fff;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
        }
        .container {
            max-width: 700px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>List of client</h2>
        <div class="mb-3 text-end">
            <a href="create.php" class="btn btn-success">Add New Client</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Always show the static 6 clients
                $clients = [
                    [
                        'id' => 1,
                        'name' => 'Asif',
                        'email' => 'asif@example.com',
                        'phone' => '012743885',
                        'address' => 'Dhaka, Bangladesh',
                        'created_at' => '2024-06-01 10:00:00'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Sami',
                        'email' => 'sami@example.com',
                        'phone' => '0128437649',
                        'address' => 'Chittagong, Bangladesh',
                        'created_at' => '2024-06-02 11:30:00'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Shipon',
                        'email' => 'shipon@example.com',
                        'phone' => '01711223344',
                        'address' => 'Khulna, Bangladesh',
                        'created_at' => '2024-06-03 09:15:00'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Monir',
                        'email' => 'monir@example.com',
                        'phone' => '01822334455',
                        'address' => 'Rajshahi, Bangladesh',
                        'created_at' => '2024-06-04 14:20:00'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Akash',
                        'email' => 'akash@example.com',
                        'phone' => '01933445566',
                        'address' => 'Sylhet, Bangladesh',
                        'created_at' => '2024-06-05 16:45:00'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Jabir',
                        'email' => 'jabir@example.com',
                        'phone' => '01644556677',
                        'address' => 'Barisal, Bangladesh',
                        'created_at' => '2024-06-06 12:10:00'
                    ],
                ];
                foreach ($clients as $client) {
                    echo "<tr>";
                    echo "<td>{$client['id']}</td>";
                    echo "<td>{$client['name']}</td>";
                    echo "<td>{$client['email']}</td>";
                    echo "<td>{$client['phone']}</td>";
                    echo "<td>{$client['address']}</td>";
                    echo "<td>{$client['created_at']}</td>";
                    echo "<td>
                        <a href='edit.php?id={$client['id']}' class='btn btn-sm btn-primary'>Edit</a>
                        <a href='?delete={$client['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this client?');\">Delete</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php if (!empty($clients)): ?>
            <div class="mt-5">
                <h4>All Client Details</h4>
                <ul class="list-group">
                    <?php foreach ($clients as $client): ?>
                        <li class="list-group-item">
                            <strong>ID:</strong> <?php echo $client['id']; ?> |
                            <strong>Name:</strong> <?php echo $client['name']; ?> |
                            <strong>Email:</strong> <?php echo $client['email']; ?> |
                            <strong>Phone:</strong> <?php echo $client['phone']; ?> |
                            <strong>Address:</strong> <?php echo $client['address']; ?> |
                            <strong>Created At:</strong> <?php echo $client['created_at']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>