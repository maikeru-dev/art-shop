//AJAX should be present.

// Inject shoppingCart
(function () {
  if (!isIndexPage) return;
  var headerContainer = document.getElementById("titleContainer");
  var shoppingCart = document.createElement("img");
  shoppingCart.classList.add("align-self-end", "mb-4", "hover-zoom");
  shoppingCart.style =
    "width:5rem; height:5rem; margin-left:auto; margin-right:1rem";
  shoppingCart.src = "assets/imgs/shopping-cart.png";
  shoppingCart.id = "shoppingCart";
  shoppingCart.setAttribute("data-bs-toggle", "modal");
  shoppingCart.setAttribute("data-bs-target", "#checkoutModal");
  shoppingCart.addEventListener("click", () => {
    var checkoutBody = document.getElementById("checkoutBody");
    checkoutBody.innerHTML = "";
    var rowArr = buildBasketModalBody(getBasket().itemIds);
    if (rowArr.length == 0) return;
    checkoutBody.append(...rowArr);
  });

  headerContainer.appendChild(shoppingCart);
})();

var allAddToCartBtns = document.getElementsByClassName("cardCheckoutBtn"); // see cardUtil, __btn

var storageKeys = ["basket"];

initSessionStorage();

function proceedToCheckoutButton() {
  solidifySessionStore();
  location.href = "order.php";
}
function addBasket_EListeners() {
  function attachListener(btn) {
    btn.addEventListener("click", (event) => {
      var btnElement = event.target;
      var id = btnElement.getAttribute("data-bs-galleryItem");
      if (doesItemExistInBasket(id)) {
        alert("Item already added!");
        return;
      }
      btnElement.textContent = "Item In Cart";
      btnElement.classList.add("btn-primary");
      btnElement.classList.remove("btn-success");

      // Add to basket (localstorage), report success message
      addItemId(id);
      alert("Added item: " + convertIdToArt([id])[0].name);
    });
  }
  Array.prototype.filter.call(allAddToCartBtns, attachListener);
}
function convertIdToArt(arrId) {
  var artArr = [];
  arrId.forEach((id) => {
    artArr.push(artTable[id]);
  });
  return artArr;
}
function clearItems() {
  var defaultBasket = JSON.stringify({
    itemIds: [],
  });
  sessionStorage.setItem("basket", defaultBasket);
}

function addItemId(id) {
  sessionStorage.setItem(
    "basket",
    (function () {
      var updatedObj = getBasket();
      updatedObj.itemIds.push(id);
      return JSON.stringify(updatedObj);
    })(),
  );
}

function doesItemExistInBasket(id) {
  return getBasket().itemIds.includes(id);
}

function removeItemOnce(arr, value) {
  var index = arr.indexOf(value);
  if (index > -1) {
    arr.splice(index, 1);
  }
  return arr;
}
function removeIdFromLocalBasket(id) {
  var updatedBasket = getLocalBasket();
  updatedBasket.itemIds = removeItemOnce(updatedBasket.itemIds, "" + id);
  localStorage.setItem("basket", JSON.stringify(updatedBasket));
}

function removeIdFromBasket(id) {
  var updatedBasket = getBasket();
  updatedBasket.itemIds = removeItemOnce(updatedBasket.itemIds, "" + id);
  sessionStorage.setItem("basket", JSON.stringify(updatedBasket));
}

function getBasket() {
  return JSON.parse(sessionStorage.getItem("basket"));
}
function getLocalBasket() {
  return JSON.parse(localStorage.getItem("basket"));
}
function clearLocalBasket() {
  localStorage.setItem("basket", null);
}

function initSessionStorage() {
  clearItems();
}

function solidifySessionStore() {
  storageKeys.forEach((item) => {
    localStorage.setItem(item, sessionStorage.getItem(item));
  });
}

function buildBasketModalBody(idArr) {
  var artArr = convertIdToArt(idArr);
  if (idArr.length == 0) return [];
  var rowArr = [];
  var __row = document.createElement("div"),
    __colImg = document.createElement("div"),
    __img = document.createElement("img"),
    __colMain = document.createElement("div"),
    __innerRowTop = __row.cloneNode(false),
    __innerRowBot = __row.cloneNode(false);

  var __button = document.createElement("button"),
    __h5Title = document.createElement("h5"),
    __h6Price = document.createElement("h6");

  __img.classList.add("container-sm");
  __img.style = "margin: 0px auto;";
  __row.classList.add("row", "mb-2", "d-flex");
  __colImg.classList.add("col-sm-6");
  __colMain.classList.add("col-sm-4", "d-flex", "flex-wrap");

  __innerRowTop.classList.add("row", "d-flex", "justify-content-end");
  __innerRowBot.classList.add("row", "d-flex", "justify-content-start");

  __h5Title.classList.add("mt-auto");
  __h6Price.classList.add("mb-auto");
  __button.classList.add(
    "btn",
    "mw-50",
    "mh-50",
    "btn-danger",
    "checkoutDeleteBtn",
  );
  __button.style = "margin-left:0.8rem;";

  function attachListener(rowId) {
    return function (event) {
      var row = document.getElementById("checkoutRow_" + rowId);
      var buttons = document.getElementsByClassName("cardCheckoutBtn");
      var rowBtn = Array.prototype.filter.call(
        buttons,
        (element) => element.getAttribute("data-bs-galleryitem") == rowId - 1,
      )[0]; // sql
      if (rowBtn != null) {
        // This happens because this function is used in order.php,
        // where checkout buttons do not exist.
        // index.php
        rowBtn.textContent = "Add to Cart";
        rowBtn.classList.add("btn-success");
        rowBtn.classList.remove("btn-primary");
        removeIdFromBasket(rowId - 1); // sql
      } else {
        // order.php
        removeIdFromLocalBasket(rowId - 1);
        if (getLocalBasket().itemIds.length == 0) {
          replaceEmptyBasket();
        }
      }
      // Assume no duplicates.
      row.remove();
    };
  }

  for (let i = 0; i < artArr.length; i++) {
    var obj = artArr[i];
    var row = __row.cloneNode(false),
      colImg = __colImg.cloneNode(false),
      img = __img.cloneNode(false),
      colMain = __colMain.cloneNode(false),
      innerRowTop = __innerRowTop.cloneNode(false),
      innerRowBot = __innerRowBot.cloneNode(false),
      title = __h5Title.cloneNode(false),
      price = __h6Price.cloneNode(false),
      button = __button.cloneNode(false);

    if (obj.img == null || obj.img == null) {
      img.src =
        "./assets/imgs/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg";
    } else {
      img.src = obj.img;
    }

    row.id = "checkoutRow_" + obj.id;
    title.innerHTML = obj.name;
    price.innerHTML = "£" + obj.price;
    button.textContent = "Delete";
    button.addEventListener("click", attachListener(obj.id)); // should be parallel

    colMain.appendChild(innerRowTop).appendChild(title);
    row.appendChild(colImg).appendChild(img);
    innerRowBot.appendChild(price);
    row.appendChild(colMain).appendChild(innerRowBot).appendChild(button);

    rowArr.push(row);
  }

  return rowArr;
}
