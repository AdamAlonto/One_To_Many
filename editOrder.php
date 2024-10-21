<?php
require_once '../core/dbConfig.php';
require_once '../core/models.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $order = getOrderByID($pdo, $orderId); 

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'gun_id' => $_POST['gun_id'],
            'quantity' => $_POST['quantity']
        ];
        updateOrder($pdo, $orderId, $data);
        header('Location: index.php'); 
        exit;
    }

    $guns = getAllGuns($pdo);
} else {
    die('Order ID not provided.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
</head>
<body>
    <h1>Edit Order</h1>
    <form action="" method="POST">
        <label>Gun Type:</label>
        <select name="gun_id" required>
            <?php foreach ($guns as $gun): ?>
                <option value="<?php echo $gun['gun_id']; ?>" <?php echo $gun['gun_id'] == $order['gun_id'] ? 'selected' : ''; ?>>
                    <?php echo $gun['gun_name'] . ' ($' . $gun['price'] . ')'; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required>

        <input type="submit" value="Update Order">
    </form>
</body>
</html>
