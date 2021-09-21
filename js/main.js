const DeliveryMethods = () => {
  const deliveryMethod1 = document.getElementById("deliveryMethod1");
  deliveryMethod1.checked = true;
  const paymentMethod1 = document.getElementById("paymentMethod1");
  paymentMethod1.checked = true;

  const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');

  $('input[name="deliveryMethod"]').click(function () {
    const chosenDeliveryMethodId = $(this).data("id");

    $.ajax({
      url: "router.php", //gdzie się łączymy
      method: "post", //typ połączenia, domyślnie get
      data: {
        //dane do wysyłki
        functionName: "getAvailablePayments",
        chosenDeliveryMethodId,
      },
    }).done((data) => {
      const dataArray = data.split("|");
      const priceOfProducts = dataArray[0];
      const priceOfDeliveryMethod = dataArray[1];
      const availablePayments = dataArray[2].split(";");

      const totalPrice = (Number(priceOfProducts) + Number(priceOfDeliveryMethod)).toFixed(2);

      $("span#totalPrice").html(totalPrice + " zł");

      paymentMethods.forEach((elem) => {
        elem.disabled = false;
        if (!availablePayments.includes(elem.dataset.id)) {
          elem.disabled = true;
        } else {
          elem.checked = true;
        }
      });
    });
  });
};

const PanelsVisibility = () => {
  const newAccount = document.getElementById("newAccount");
  const registration = document.getElementById("registration");

  const otherAddressCheckbox = document.getElementById("otherAddressCheckbox");
  const otherAddressPanel = document.getElementById("otherAddressPanel");

  newAccount.addEventListener("change", function () {
    if (newAccount.checked) {
      registration.classList.add("active");
      otherAddressCheckbox.parentElement.classList.remove("hidden");
    } else {
      registration.classList.remove("active");
      otherAddressCheckbox.parentElement.classList.add("hidden");
      otherAddressCheckbox.checked = false;
      otherAddressPanel.classList.remove("active");
    }
  });

  otherAddressCheckbox.addEventListener("change", function () {
    if (otherAddressCheckbox.checked) {
      otherAddressPanel.classList.add("active");
    } else {
      otherAddressPanel.classList.remove("active");
    }
  });
};

const FormSubmit = () => {
  function checkInputs(
    newAccountIsChecked,
    loginValue,
    passwordValue,
    passwordConfirmationValue,
    firstnameValue,
    lastnameValue,
    addressValue,
    zipCodeValue,
    cityValue,
    phoneValue,
    otherAddressCheckboxIsChecked,
    otherAddressValue,
    otherZipCodeValue,
    otherCityValue,
    rulesIsChecked
  ) {
    if (newAccountIsChecked) {
      if (loginValue === "") {
        setErrorFor(login, "Login jest wymagany.");
      } else {
        setSuccessFor(login);
      }

      if (passwordValue === "") {
        setErrorFor(password, "Hasło jest wymagane.");
      } else {
        setSuccessFor(password);
      }

      if (passwordConfirmationValue === "") {
        setErrorFor(passwordConfirmation, "Powtórz hasło.");
      } else {
        setSuccessFor(passwordConfirmation);
      }
    } else {
      setSuccessFor(login);
      setSuccessFor(password);
      setSuccessFor(passwordConfirmation);
    }

    if (otherAddressCheckboxIsChecked) {
      if (otherAddressValue === "") {
        setErrorFor(otherAddress, "Adres jest wymagany.");
      } else {
        setSuccessFor(otherAddress);
      }

      if (otherZipCodeValue === "") {
        setErrorFor(otherZipCode, "Kod pocztowy jest wymagany.");
      } else {
        setSuccessFor(otherZipCode);
      }

      if (otherCityValue === "") {
        setErrorFor(otherCity, "Miasto jest wymagane.");
      } else {
        setSuccessFor(otherCity);
      }
    } else {
      setSuccessFor(otherAddress);
      setSuccessFor(otherZipCode);
      setSuccessFor(otherCity);
    }

    if (firstnameValue === "") {
      setErrorFor(firstname, "Imię jest wymagane.");
    } else {
      setSuccessFor(firstname);
    }

    if (lastnameValue === "") {
      setErrorFor(lastname, "Nazwisko jest wymagane.");
    } else {
      setSuccessFor(lastname);
    }

    if (addressValue === "") {
      setErrorFor(address, "Adres jest wymagany.");
    } else {
      setSuccessFor(address);
    }

    if (zipCodeValue === "") {
      setErrorFor(zipCode, "Kod pocztowy jest wymagany.");
    } else if (!isZipCode(zipCodeValue)) {
      setErrorFor(zipCode, "Wprowadzono błędny kod pocztowy. Poprawny format to np. 45-013.");
    } else {
      setSuccessFor(zipCode);
    }

    if (cityValue === "") {
      setErrorFor(city, "Miasto jest wymagane.");
    } else {
      setSuccessFor(city);
    }

    if (phoneValue === "") {
      setErrorFor(phone, "Numer telefonu jest wymagany.");
    } else if (!isPhoneNumber(phoneValue)) {
      setErrorFor(phone, "Wprowadzono błędny numer telefonu. Poprawny format to np. 330622986");
    } else {
      setSuccessFor(phone);
    }

    if (!rulesIsChecked) {
      setErrorFor(rules, "Nie zapoznano się z regulaminem.");
    } else {
      setSuccessFor(rules);
    }
  }

  function isZipCode(str) {
    return /^[0-9]{2}-[0-9]{3}$/.test(str);
  }

  function isPhoneNumber(str) {
    return /^[0-9]{9}$/.test(str);
  }

  function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const pError = formControl.querySelector("p.error");

    pError.textContent = message;
    formControl.classList.add("error");
  }

  function setSuccessFor(input) {
    const formControl = input.parentElement;

    formControl.classList.remove("error");
  }

  $("#confirmPurchase").click(function (e) {
    e.preventDefault();

    const newAccount = $("input#newAccount").is(":checked");
    const login = $("input#login").val();
    const password = $("input#password").val();
    const passwordConfirmation = $("input#passwordConfirmation").val();
    const firstname = $("input#firstname").val();
    const lastname = $("input#lastname").val();
    const country = $("select#country").val();
    const address = $("input#address").val();
    const zipCode = $("input#zipCode").val();
    const city = $("input#city").val();
    const phone = $("input#phone").val();
    const otherAddressCheckbox = $("input#otherAddressCheckbox").is(":checked");
    const otherAddress = $("input#otherAddress").val();
    const otherZipCode = $("input#otherZipCode").val();
    const otherCity = $("input#otherCity").val();
    const info = $("textarea#info").val();
    const newsletter = $("input#newsletter").is(":checked");
    const rules = $("input#rules").is(":checked");
    const deliveryMethodId = $('input[name="deliveryMethod"]:checked').data("id");

    checkInputs(
      newAccount,
      login,
      password,
      passwordConfirmation,
      firstname,
      lastname,
      address,
      zipCode,
      city,
      phone,
      otherAddressCheckbox,
      otherAddress,
      otherZipCode,
      otherCity,
      rules
    );

    $.ajax({
      url: "router.php", //gdzie się łączymy
      method: "post", //typ połączenia, domyślnie get
      data: {
        //dane do wysyłki
        functionName: "confirmPurchase",
        newAccount,
        login,
        password,
        passwordConfirmation,
        firstname,
        lastname,
        country,
        address,
        zipCode,
        city,
        phone,
        otherAddressCheckbox,
        otherAddress,
        otherZipCode,
        otherCity,
        info,
        newsletter,
        rules,
        deliveryMethodId,
      },
    }).done((data) => {
      if (data !== null && data !== "") {
        alert(data);

        $("#newAccount").prop("checked", false);
        $("#registration").removeClass("active");
        $("#login").val("");
        $("#password").val("");
        $("#passwordConfirmation").val("");
        $("#firstname").val("");
        $("#lastname").val("");
        $("#country").val("Polska");
        $("#address").val("");
        $("#zipCode").val("");
        $("#city").val("");
        $("#phone").val("");
        $("#otherAddressCheckbox").prop("checked", false);
        $("#otherAddressCheckbox").parent().addClass("hidden");
        $("#otherAddressPanel").removeClass("active");
        $("#otherAddress").val("");
        $("#otherZipCode").val("");
        $("#otherCity").val("");
        $("#info").val("");
        $("#newsletter").prop("checked", false);
        $("#rules").prop("checked", false);
      }
    });
  });
};

const Popup = () => {
  const loginDemoBtn = document.querySelector(".login-demo button");
  const popupBackground = document.getElementById("popupBackground");
  const closePopupBtn = document.getElementById("closePopup");

  loginDemoBtn.addEventListener("click", function () {
    popupBackground.classList.add("active");
  });

  closePopupBtn.addEventListener("click", function () {
    popupBackground.classList.remove("active");
  });
};

DeliveryMethods();
PanelsVisibility();
FormSubmit();
Popup();
