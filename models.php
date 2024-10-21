<?php

function addCustomer($pdo, $first_name, $last_name, $email, $contact_number) {
    $sql = "INSERT INTO customers (first_name, last_name, email, contact_number) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $last_name, $email, $contact_number]);
    return $pdo->lastInsertId();
}

function getAllGuns($pdo) {
    $sql = "SELECT * FROM guns";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addOrder($pdo, $customer_id, $gun_id, $quantity) {
    $sql = "INSERT INTO orders (customer_id, gun_id, quantity) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id, $gun_id, $quantity]);
}

function getAllOrders($pdo) {
    $sql = "SELECT o.order_id, c.first_name, c.last_name, g.gun_name, o.quantity, o.order_date 
            FROM orders o
            JOIN customers c ON o.customer_id = c.customer_id
            JOIN guns g ON o.gun_id = g.gun_id
            ORDER BY o.order_date DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOrderByID($pdo, $orderId) {
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$orderId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateOrder($pdo, $orderId, $data) {
    $sql = "UPDATE orders SET gun_id = ?, quantity = ? WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$data['gun_id'], $data['quantity'], $orderId]);
}

function removeOrder($pdo, $orderId) {
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$orderId]);
}
