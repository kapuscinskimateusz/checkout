<?php

session_start();

require_once "Models/DeliveryMethod.php";
require_once "Controllers/OrderController.php";

if (isset($_POST['functionName']) && $_POST['functionName'] === "getAvailablePayments") {
    $deliveryMethod = new DeliveryMethod();

    $priceOfProducts = 0;
    foreach($_SESSION['cart'] as $cartItem) {
        $priceOfProducts += $cartItem['price']*$cartItem['quantity'];
    }
    $priceofDeliveryMethod = $deliveryMethod->getDeliveryMethodById($_POST['chosenDeliveryMethodId'])->getPrice();
    $availablePaymentsString = $deliveryMethod->getDeliveryMethodById($_POST['chosenDeliveryMethodId'])->getPaymentMethods();
    echo $priceOfProducts."|".$priceofDeliveryMethod."|".$availablePaymentsString;
}

if (isset($_POST['functionName']) && $_POST['functionName'] === "confirmPurchase") {
    $orderController = new OrderController();
    $orderController->confirmPurchase();
}

?>