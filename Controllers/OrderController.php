<?php

require_once "Models/Address.php";
require_once "Models/DeliveryMethod.php";
require_once "Models/Order.php";
require_once "Models/User.php";

class OrderController {
    public function validateForm() {
        $formFields = ['firstname', 'lastname', 'country', 'address', 'zipCode', 'city', 'phone'];

        if (isset($_POST['newAccount']) && $_POST['newAccount'] === "true") {
            $registrationFields = ['login', 'password'];
            foreach($registrationFields as $registrationField) {
                if((isset($_POST[$registrationField]) && strlen($_POST[$registrationField])) === FALSE) {
                    return false;
                }
            }
            if($_POST['password'] !== $_POST['passwordConfirmation']) {
                return false;
            }
        }

        if (isset($_POST['otherAddressCheckbox']) && $_POST['otherAddressCheckbox'] === "true") {
            $otherAddressFields = ['otherAddress', 'otherZipCode', 'otherCity'];
            foreach($otherAddressFields as $otherAddressField) {
                if((isset($_POST[$otherAddressField]) && strlen($_POST[$otherAddressField])) === FALSE) {
                    return false;
                }
            }
        }

        foreach($formFields as $formField) {
            if((isset($_POST[$formField]) && strlen($_POST[$formField])) === FALSE) {
                return false;
            }
        }
        if (!preg_match('/^[0-9]{2}-[0-9]{3}$/', $_POST['zipCode'])) {
            return false;
        }
        if (!preg_match('/^[0-9]{9}$/', $_POST['phone'])) {
            return false;
        }
        if (isset($_POST['rules']) && $_POST['rules'] === "false") {
            return false;
        }

        return true;
    }

    public function confirmPurchase() {
        if ($this->validateForm()) {
            $hashedPasword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = new User();
            if (isset($_POST['newAccount']) && $_POST['newAccount'] === "true") {
                $user = new User($_POST['login'], $hashedPasword, $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['phone']);
                $user->addUserToDb();
            }

            $address = new Address();
            if (isset($_POST['otherAddressCheckbox']) && $_POST['otherAddressCheckbox'] === "true") {
                $address = new Address($_POST['firstname'], $_POST['lastname'], $_POST['country'], $_POST['otherAddress'], $_POST['otherZipCode'], $_POST['otherCity'], $_POST['phone'], $user->getId());
            } else {
                $address = new Address($_POST['firstname'], $_POST['lastname'], $_POST['country'], $_POST['address'], $_POST['zipCode'], $_POST['city'], $_POST['phone'], $user->getId());
            }
            $address->addAddressToDb();
    
            $addressId = $address->getId();
            $deliveryMethod = new DeliveryMethod();
            $chosenDeliveryMethod = $deliveryMethod->getDeliveryMethodById($_POST['deliveryMethodId']);
    
            $totalPrice = 0;
            foreach($_SESSION['cart'] as $cartItem) {
                $totalPrice += $cartItem['price']*$cartItem['quantity'];
            }
            $totalPrice += $chosenDeliveryMethod->getPrice();
    
            $order = new Order($addressId, $_POST['info'], $_POST['newsletter'], $totalPrice);
            $order->addOrderToDb();
        }
    }
}

?>