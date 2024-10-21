<?php
require_once '../core/dbConfig.php';
require_once '../core/models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = addCustomer($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['contact_number']);
    $gun_id = $_POST['gun_id'];
    $quantity = $_POST['quantity'];

    addOrder($pdo, $customer_id, $gun_id, $quantity);
}

if (isset($_GET['remove'])) {
    $orderIdToRemove = $_GET['remove'];
    removeOrder($pdo, $orderIdToRemove);
    header('Location: index.php'); 
    exit;
}

$guns = getAllGuns($pdo);
$orders = getAllOrders($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gun Shop</title>
    <style>
    body { font-family: Arial, sans-serif; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
    th { background-color: #f2f2f2; }
    form { margin-bottom: 20px; }

    label {
        display: block; 
        margin-bottom: 5px; 
    }

    input[type="text"], input[type="email"], input[type="number"], select {
        width: 30%; 
        padding: 8px;
        margin-bottom: 15px; 
    }

    input[type="submit"] {
        padding: 10px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s; 
    }
    
    input[type="submit"]:hover {
        background-color: #013220; 
    }
</style>

</head>
<body>
    <h1>Welcome to the Gun Shop</h1>
    
	<form action="" method="POST">
    <h3>Customer Information</h3>
    
    <label>First Name:</label>
    <input type="text" name="first_name" required>

    <label>Last Name:</label>
    <input type="text" name="last_name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Contact Number:</label>
    <input type="text" name="contact_number" required>

    <h3>Choose Gun</h3>
    <label>Gun Type:</label>
    <select name="gun_id" required>
        <?php foreach ($guns as $gun): ?>
            <option value="<?php echo $gun['gun_id']; ?>">
                <?php echo $gun['gun_type'] . ' - ' . $gun['gun_name'] . ' (₱' . $gun['price'] . ')'; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Quantity:</label>
    <input type="number" name="quantity" required>

    <input type="submit" value="Place Order">
</form>


    <h2>Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Gun</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                    <td><?php echo $order['gun_name']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>
                        <a href="editOrder.php?id=<?php echo $order['order_id']; ?>">Edit</a> | 
                        <a href="?remove=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
