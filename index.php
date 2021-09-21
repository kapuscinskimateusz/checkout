<?php

session_start();

require_once "Database.php";

require_once "Models/Product.php";
require_once "Models/DeliveryMethod.php";
require_once "Models/PaymentMethod.php";

$_SESSION['cart'] = [];

$product = new Product();

$firstProduct = $product->getProductById(1);
$_SESSION['cart'][] = [
  "id" => $firstProduct->getId(),
  "name" => $firstProduct->getName(),
  "price" => $firstProduct->getPrice(),
  "imageUrl" => $firstProduct->getImageUrl(),
  "quantity" => 1
];

$secondProduct = $product->getProductById(2);
$_SESSION['cart'][] = [
  "id" => $secondProduct->getId(),
  "name" => $secondProduct->getName(),
  "price" => $secondProduct->getPrice(),
  "imageUrl" => $secondProduct->getImageUrl(),
  "quantity" => 3
];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/04c1dfb18a.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="popup-background" id="popupBackground">
      <div class="popup">
        <button class="close" id="closePopup">X</button>
        <div>
          <input type="text" placeholder="Nazwa użytkownika">
          <input type="password" placeholder="Hasło">
          <button>Zaloguj się</button>
        </div>
      </div>
    </div>
    <form action="" method="POST">
      <div class="col-1 col">
        <section>
          <h2><i class="fas fa-user"></i>1. Twoje dane</h2>
          <div class="login-demo">
            <button type="button">Logowanie</button>
            <p>Masz już konto? Kliknij żeby się zalogować.</p>
          </div>
          <div class="form-control">
            <input type="checkbox" id="newAccount" />
            <label for="newAccount">Stwórz nowe konto</label>
          </div>
          <div id="registration" class="registration">
            <div class="form-control">
              <input type="text" placeholder="Nazwa użytkownika *" id="login" />
              <p class="error">Error</p>
            </div>
            <div class="form-control">
              <input type="password" placeholder="Hasło *" id="password" />
              <p class="error">Error</p>
            </div>
            <div class="form-control">
              <input type="password" placeholder="Potwierdź hasło *" id="passwordConfirmation" />
              <p class="error">Error</p>
            </div>
          </div>
          <div class="form-control">
            <input type="text" placeholder="Imię *" id="firstname" />
            <p class="error">Error</p>
          </div>
          <div class="form-control">
            <input type="text" placeholder="Nazwisko *" id="lastname" />
            <p class="error">Error</p>
          </div>
          <div class="form-control">
            <select name="country" id="country">
              <option value="Polska" selected>Polska</option>
            </select>
          </div>
          <div class="form-control">
            <input type="text" placeholder="Adres *" id="address" />
            <p class="error">Error</p>
          </div>
          <div class="form-control">
            <input type="text" placeholder="Kod pocztowy *" id="zipCode" />
            <p class="error">Error</p>
          </div>
          <div class="form-control">
            <input type="text" placeholder="Miasto *" id="city" />
            <p class="error">Error</p>
          </div>
          <div class="form-control">
            <input type="tel" placeholder="Telefon *" id="phone" />
            <p class="error">Error</p>
          </div>
          <div class="form-control hidden">
            <input type="checkbox" id="otherAddressCheckbox" />
            <label for="otherAddressCheckbox">Dostawa pod inny adres</label>
          </div>
          <div class="other-address-panel" id="otherAddressPanel">
            <div class="form-control">
              <input type="text" placeholder="Adres *" id="otherAddress">
              <p class="error">Error</p>
            </div>
            <div class="form-control">
              <input type="text" placeholder="Kod pocztowy *" id="otherZipCode">
              <p class="error">Error</p>
            </div>
            <div class="form-control">
              <input type="text" placeholder="Miasto *" id="otherCity">
              <p class="error">Error</p>
            </div>
          </div>
        </section>
      </div>
      <div class="col-2 col">
        <section>
          <h2><i class="fas fa-truck"></i>2. Metoda dostawy</h2>
          <fieldset class="form-control" id="deliveryMethods">
            <?php
            $deliveryMethod = new DeliveryMethod();
            $deliveryMethods = $deliveryMethod->getDeliveryMethods();
            foreach($deliveryMethods as $deliveryMethod) {
            ?>
            <div>
              <input type="radio" id="deliveryMethod<?= $deliveryMethod->getId(); ?>" data-id=<?= $deliveryMethod->getId(); ?> name="deliveryMethod">
              <img src=<?= $deliveryMethod->getImageUrl(); ?> alt="logo <?= $deliveryMethod->getName(); ?>">
              <label for="deliveryMethod<?= $deliveryMethod->getId(); ?>"><?= $deliveryMethod->getName(); ?></label>
              <span><?= $deliveryMethod->getPrice(); ?> zł</span>
            </div>
            <?php
            }
            ?>
            <p class="error">Error</p>
          </fieldset>
        </section>
        <section>
          <h2><i class="fas fa-credit-card"></i>3. Metoda płatności</h2>
          <fieldset class="form-control" id="paymentMethods">
            <?php
            $paymentMethod = new PaymentMethod();
            $paymentMethods = $paymentMethod->getPaymentMethods();
            foreach($paymentMethods as $paymentMethod) {
            ?>
            <div>
              <input type="radio" id="paymentMethod<?= $paymentMethod->getId(); ?>" data-id=<?= $paymentMethod->getId(); ?> name="paymentMethod">
              <img src=<?= $paymentMethod->getImageUrl(); ?> alt="logo <?= $paymentMethod->getName(); ?>">
              <label for="paymentMethod<?= $paymentMethod->getId(); ?>"><?= $paymentMethod->getName(); ?></label>
            </div>
            <?php
            }
            ?>
            <p class="error">Error</p>
          </fieldset>
          <button type="button">Dodaj kod rabatowy</button>
        </section>
      </div>
      <div class="col-3 col">
        <section>
          <h2><i class="fas fa-clipboard-list"></i>4. Podsumowanie</h2>
          <div class="products">
            <?php
            foreach($_SESSION['cart'] as $cartItem) {
            ?>
            <div class="product">
              <div class="img">
              <img src="<?= $cartItem['imageUrl'] ?>" alt="<?= $cartItem['name'] ?> image">
              </div>
              <div class="product-about">
                <div>
                  <p><?= $cartItem['name']; ?></p>
                  <span><?= $cartItem['price']; ?> zł</span>
                </div>
                <p>Ilość: <?= $cartItem['quantity']; ?></p>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="summary">
            <div>
              <p>Suma częściowa:</p>
              <span>139,96 zł</span>
            </div>
            <div>
              <p>Łącznie:</p>
              <span id="totalPrice">150.95 zł</span>
            </div>
          </div>
          <div class="form-control">
            <textarea id="info" placeholder="Komentarz" rows="3"></textarea>
          </div>
          <div class="form-control">
            <input type="checkbox" id="newsletter" />
            <label for="newsletter">Zapisz się, aby otrzymywać newsletter</label>
          </div>
          <div class="form-control">
            <input type="checkbox" id="rules" required />
            <label for="rules">Zapoznałam/em się z <a href="#">Regulaminem</a> zakupów *</label>
            <p class="error">Error</p>
          </div>
          <button type="submit" id="confirmPurchase">Potwierdź zakup</button>
        </section>
      </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/main.js"></script>
  </body>
</html>
