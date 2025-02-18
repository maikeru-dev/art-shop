// [start,end]
var currentRange = null;
var artTable = null;
var pageRange = [1, 1];
const __rowSize = 3;

getAllArt();
function checkForMax(btn, side) {
  if (pageRange[side] == page) {
    btn.setAttribute("disabled", "");
  } else {
    btn.removeAttribute("disabled");
  }
}
(function () {
  var leftBtn = document.getElementById("leftPage");
  var rightBtn = document.getElementById("rightPage");
  var pageH3 = document.getElementById("pageNumber");

  leftPage.addEventListener("click", (event) => {
    page -= 1;
    pageH3.innerText = page;
    checkForMax(event.target, 0);
    getAllArt();
  });
  rightPage.addEventListener("click", (event) => {
    page += 1;
    pageH3.innerText = page;
    checkForMax(event.target, 1);
    getAllArt();
  });
})();

function genRowCount(size, range) {
  // [rowStart, rowEnd];
  // where rowStart, rowEnd belongs to {rowCount: num, excess: num}

  if (size == 0) return [{ rowCount: 0, excess: 0 }];

  var genInfo = function (size) {
    var excess = size % __rowSize;
    var rowCount = (size - excess) / __rowSize;
    return { rowCount: rowCount, excess: excess };
  };

  var rowStart = genInfo(range[0]);
  var rowEnd = null;

  if (range[1] > size) {
    rowEnd = genInfo(size);
  } else {
    rowEnd = genInfo(range[1]);
  }
  if (rowStart.excess != 0) {
    rowStart.rowCount--;
    let rerse;
    if ((rerse = rowEnd.excess - rowStart.excess) < 0) {
      rowEnd.rowCount--;
      rowEnd.excess = Math.abs(rerse);
    } else {
      rowEnd.excess = rowStart.excess;
    }
  }
  return [rowStart, rowEnd];
}

function generateRows(table, range) {
  var rowChildren = [];
  var __row = document.createElement("div");
  var __col = document.createElement("div");
  var __card = document.createElement("div");
  var __cardImg = document.createElement("img");
  var __cardBody = document.createElement("div");

  var __h3 = document.createElement("h3");
  var __p = document.createElement("p");
  var __h4 = document.createElement("h4");

  var __btn = document.createElement("button");
  const modalInfoBtn = document.getElementById("modalInfoButton");

  __row.classList.add(
    "row",
    "flex-wrap",
    "flex-lg-nowrap",
    "align-items-stretch",
    "justify-content-center",
    "my-4",
  );
  __col.classList.add("col-lg-4", "d-flex");
  __card.classList.add("card", "container-fluid", "h-100", "mx-auto");
  __cardImg.classList.add(
    "card-img-top",
    "hover-zoom",
    "hover-shadow",
    "mt-2",
    "p-0",
  );
  __cardImg.style["object-fit"] = "cover";

  __cardBody.classList.add("card-body", "d-flex", "flex-column");
  __btn.classList.add("btn", "btn-success", "cardCheckoutBtn");
  __h3.classList.add("linkTitle");
  __h4.classList.add("mt-auto", "mb-3");
  // Modal Info
  __cardImg.setAttribute("data-bs-toggle", "modal");
  __cardImg.setAttribute("data-bs-target", "#infoModal");
  __h3.setAttribute("data-bs-toggle", "modal");
  __h3.setAttribute("data-bs-target", "#infoModal");

  var __placeholderImg = __cardImg.cloneNode(false);
  __placeholderImg.src =
    "./assets/imgs/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg";

  var generatedCount = genRowCount(table.length, range);
  var rowStart = generatedCount[0];
  var rowEnd = generatedCount[1];

  pageRange[1] = Math.ceil(table.length / 6);

  function setInfoModalButtonListener(id) {
    //NOTE: the attribute is what opens the modal, see __cardImg
    return function (event) {
      replaceInfoModalBody(id);
      modalInfoBtn.setAttribute("data-bs-galleryItem", id); // sql count starts at 1
    };
  }

  for (let j = rowStart.rowCount; j < rowEnd.rowCount; j++) {
    var row = __row.cloneNode(false);
    for (let i = 0; i < __rowSize; i++) {
      var col = __col.cloneNode(false),
        card = __card.cloneNode(false),
        cardBody = __cardBody.cloneNode(false),
        cardImg = __cardImg.cloneNode(false),
        h3Tag = __h3.cloneNode(false),
        h4Tag = __h4.cloneNode(false),
        pTag = __p.cloneNode(false),
        button = __btn.cloneNode(false);

      var curr = table[__rowSize * j + i]; // sneaky bug

      h3Tag.innerText = curr.name;
      h4Tag.innerText = "£" + curr.price;
      button.textContent = "Add to Cart";
      button.setAttribute("data-bs-galleryItem", __rowSize * j + i);
      pTag.innerText = curr.description;
      if (curr.img == null) {
        cardImg = __placeholderImg.cloneNode(false);
      } else {
        cardImg.src = curr.img;
      }
      h3Tag.addEventListener(
        "click",
        setInfoModalButtonListener(__rowSize * j + i),
      );
      cardImg.addEventListener(
        "click",
        setInfoModalButtonListener(__rowSize * j + i),
      );
      cardBody.appendChild(h3Tag); // title
      cardBody.appendChild(pTag); // desc
      cardBody.appendChild(h4Tag); // price
      cardBody.appendChild(button);
      card.appendChild(cardImg);
      card.appendChild(cardBody);
      row.appendChild(col).appendChild(card);
    }
    rowChildren.push(row);
  }

  if (rowEnd.excess) {
    var row = __row.cloneNode(false);
    for (let i = 0; i < rowEnd.excess; i++) {
      var col = __col.cloneNode(false),
        card = __card.cloneNode(false),
        cardBody = __cardBody.cloneNode(false),
        cardImg = __cardImg.cloneNode(false),
        h3Tag = __h3.cloneNode(false),
        h4Tag = __h4.cloneNode(false),
        pTag = __p.cloneNode(false),
        button = __btn.cloneNode(false);

      var curr = table[__rowSize * rowEnd.rowCount + i]; // sneaky bug

      h3Tag.innerText = curr.name;
      h4Tag.innerText = "£" + curr.price;
      button.textContent = "Add to Cart";
      button.setAttribute(
        "data-bs-galleryItem",
        __rowSize * rowEnd.rowCount + i,
      );
      pTag.innerText = curr.description;
      if (curr.img == null) {
        cardImg = __placeholderImg.cloneNode(false);
      } else {
        cardImg.src = curr.img;
      }
      h3Tag.addEventListener(
        "click",
        setInfoModalButtonListener(__rowSize * rowEnd.rowCount + i),
      );
      cardImg.addEventListener(
        "click",
        setInfoModalButtonListener(__rowSize * rowEnd.rowCount + i),
      );
      cardBody.appendChild(h3Tag); // title
      cardBody.appendChild(pTag); // desc
      cardBody.appendChild(h4Tag); // price
      cardBody.appendChild(button);
      card.appendChild(cardImg);
      card.appendChild(cardBody);
      row.appendChild(col).appendChild(card);
    }
    rowChildren.push(row);
  }

  return rowChildren;
}
function getAllArt() {
  var xhttp = AJAXFetchObject(
    (response) => {
      // FIXME: CHANGE THIS TO BE A BIT MORE PURE
      artTable = response.value;
      currentRange = generateRange(page);
      var gallery = document.getElementById("gallery");
      var leftBtn = document.getElementById("leftPage");
      var rightBtn = document.getElementById("rightPage");

      gallery.innerHTML = "";
      gallery.append(...generateRows(artTable, currentRange));
      addBasket_EListeners();

      checkForMax(leftBtn, 0);
      checkForMax(rightBtn, 1);
    },
    (response) => {
      alert("Failure to fetch table, reason: " + response.error);
    },
  );

  xhttp.open("GET", window.location.origin + "/api.php/art");
  xhttp.send();
}
function replaceInfoModalBody(id) {
  const modalBody = document.getElementById("infoModalBody");
  var item = artTable[id];

  modalBody.innerHTML = ""; //reset
  modalBody.appendChild(buildModalBody(item));
}

function buildModalBody(item) {
  var holdingDiv = document.createElement("div");
  var img = document.createElement("img"),
    header = document.createElement("div"),
    priceBody = document.createElement("div"),
    lastBody = document.createElement("div");

  var title = document.createElement("h4"),
    price = document.createElement("h5"),
    p = document.createElement("p");

  let desc = p.cloneNode(false),
    size = p.cloneNode(p),
    date = p.cloneNode(false);

  img.classList.add("container-fluid");
  img.style = "margin:0 auto;";

  var __placeholderImg = img.cloneNode(false);
  __placeholderImg.src =
    "./assets/imgs/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg";

  header.classList.add("my-3", "ml-4");
  priceBody.classList.add("mb-3", "ml-4");
  lastBody.classList.add("mb-3", "ml-4");

  if (item.img == null) {
    img = __placeholderImg;
  } else {
    img.src = item.img;
  }

  title.innerText = item.name;
  date.innerText = "Completed on: " + item.date_of_completion;
  desc.innerText = item.description;
  size.innerText = "Size: " + item.width + "x" + item.height + "mm";
  price.innerText = "£" + item.price;

  lastBody.appendChild(desc);
  lastBody.appendChild(size);
  holdingDiv.appendChild(img);
  holdingDiv.appendChild(header).appendChild(title);
  holdingDiv.appendChild(priceBody).appendChild(price);
  holdingDiv.appendChild(lastBody).appendChild(date);

  return holdingDiv;
}
