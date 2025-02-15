// Example starter JavaScript for disabling form submissions if there are invalid fields

var artTable = [];
function postOrder() {
  var __name = document.getElementById("inputName"),
    __tel = document.getElementById("inputPhoneNumber"),
    __email = document.getElementById("inputEmail"),
    __address = document.getElementById("inputAddress");

  // itemIds should be valid and non-null at this point.
  var sqlIds = getLocalBasket().itemIds;
  var xhttp = AJAXFetchObject(
    (response) => {
      alert("Success! Sent order through!");
    },
    (response) => {
      alert("failure!");
      console.log(response.error);
    },
  );

  var obj = {
    name: __name.value,
    phone_number: __tel.value,
    email: __email.value,
    postal_address: __address.value,
    ids: sqlIds,
  };

  xhttp.open("POST", window.location.origin + "/api.php/order");
  xhttp.send(JSON.stringify(obj));
}
function replaceEmptyBasket() {
  var link = document.createElement("a");
  var text = document.createElement("p");
  text.innerHTML = "Your basket is empty. ";
  text.style.whitespace = "pre";
  text.classList.add("m-0");
  link.href = "index.php";
  link.innerHTML = "Link back to index page";
  link.classList.add("pl-2");
  basketContainer.classList.add(
    "d-flex",
    "flex-wrap",
    "justify-content-center",
    "align-items-center",
  );
  basketContainer.classList.remove(
    "overflow-y-scroll",
    "border-top",
    "border-bottom",
  );
  basketContainer.style.height = "2.5rem";
  basketContainer.appendChild(text).appendChild(link);
}
getAllArtGeneric(function () {
  var basket = getLocalBasket();
  var basketContainer = document.getElementById("basketContainer");

  if (basket == null || basket.itemIds.length == 0) {
    replaceEmptyBasket();
  } else {
    var rowArr = buildBasketModalBody(basket.itemIds);
    basketContainer.append(...rowArr);
    if (rowArr.length == 0) {
      alert("rowArr");
    }
  }
});
(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            var itemsExist = getLocalBasket().itemIds.length > 0;
            event.preventDefault();
            event.stopPropagation();
            if (form.checkValidity() === false || !itemsExist) {
              if (!itemsExist) {
                document
                  .getElementById("basketContainer")
                  .classList.add("is-invalid");
              }
            } else {
              postOrder();
            }

            form.classList.add("was-validated");
          },
          false,
        );
      });
    },
    false,
  );
})();
