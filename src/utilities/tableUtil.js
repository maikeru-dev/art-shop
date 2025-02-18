// Using this as an example https://stackoverflow.com/questions/5180382/convert-json-data-to-a-html-table
// I would have liked to avoid copying this solution so much, but it's hard to imagine
// doing it any other way due to my requirements.
var tableDOM = document.getElementById("main");

var __table = document.createElement("table");
var __tHead = document.createElement("thead");
var __tBody = document.createElement("tbody");
var __tableRow = document.createElement("tr");
var __tableHeader = document.createElement("th");
var __tableData = document.createElement("td");
var __btn = document.createElement("button");

const ACTION_ENABLED = 1; // at this rate, this whole file should be a class
const ACTION_DISABLED = 0;
var actionSet = ACTION_DISABLED;

// NOTE: https://getbootstrap.com/docs/4.0/content/tables/
__table.classList.add("table");
__btn.classList.add("btn", "btn-danger");
//__tHead.classList.add("thead-dark");
__tableHeader.setAttribute("scope", "col");

function onClickBtn(rowId) {
  // delete
  return function (event) {
    var __row = document.getElementById(rowId);
    var dbIdentification = rowId.split("_"); // [0] table, [1] id
    var xhttp = AJAXFetchObject(
      function (response) {
        // successFn
        // remove row
        __row.remove();
      },
      function (response) {
        // failureFn
        // report error
        alert("Something went horribly wrong: " + response.error);
      },
    );

    xhttp.open(
      "DELETE",
      window.location.origin +
        "/api.php/" +
        dbIdentification[0] +
        "/" +
        dbIdentification[1],
    );
    xhttp.send();
  };
}

function generateTable(arr) {
  var table = __table.cloneNode(false);
  var skipCols = ["img"];

  var skipColIndex = [];

  skipCols.forEach((element) => {
    skipColIndex.push(arr.indexOf(element));
  });

  if (arr.length == 0) {
    var container = document.createElement("div");
    container.classList.add("container", "mt-2");
    var msg = document.createElement("h3");
    msg.appendChild(document.createTextNode("Table is empty!"));
    container.appendChild(msg);
    return container;
  }
  var tBody = __tBody.cloneNode(false);
  var cols = generateColumnHeaders(arr[0], skipCols, table);
  for (var row = 0, maxRow = arr.length; row < maxRow; row++) {
    var tableRow = __tableRow.cloneNode(false);
    var parallelValues = Object.values(arr[row]);
    tableRow.id =
      (actionSet == ACTION_ENABLED ? "order_" : "art_") + parallelValues[0];
    for (var col = 0, maxCol = cols.length; col < maxCol; col++) {
      if (skipColIndex.includes(col)) continue;
      var cellValue = document.createTextNode(parallelValues[col] || ""); // Maybe type (value or default nothing)
      var tableData = __tableData.cloneNode(false);
      tableData.appendChild(cellValue);
      tableRow.appendChild(tableData);
    }
    if (true || actionSet == ACTION_ENABLED) {
      // unlock art
      var btn = __btn.cloneNode(false);
      var tableData = __tableData.cloneNode(false);
      btn.textContent = "Delete row";
      btn.addEventListener("click", onClickBtn(tableRow.id));
      tableData.append(btn);
      tableRow.appendChild(tableData);
    }
    tBody.appendChild(tableRow);
  }

  table.appendChild(tBody);
  // TABLE IS CONSTRUCTED! YIPEEEEE
  return table;
}

function generateColumnHeaders(arrItem, skipCols, table) {
  // var table is by ref
  var cols = [];
  tableRow = __tableRow.cloneNode(false);
  tHead = __tHead.cloneNode(false);

  if (arrItem.length == 0) {
    return [];
  }

  for (const key of Object.keys(arrItem)) {
    if (skipCols.includes(key)) continue;
    cols.push(key);
    var header = __tableHeader.cloneNode(false);
    header.appendChild(
      document.createTextNode(capitalize(key.replaceAll("_", " "))),
    );
    tableRow.appendChild(header);
  }
  if (true || actionSet == ACTION_ENABLED) {
    var header = __tableHeader.cloneNode(false);
    header.appendChild(document.createTextNode("Action"));
    tableRow.appendChild(header);
  }

  tHead.appendChild(tableRow);
  table.appendChild(tHead);
  return cols;
}

// https://stackoverflow.com/questions/1026069/how-do-i-make-the-first-letter-of-a-string-uppercase-in-javascript
function capitalize(val) {
  return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

function displayTable(SQLObject) {
  // Assume error handling has already happened.
  var tableElement = generateTable(SQLObject);
  tableDOM.textContent = "";
  tableDOM.appendChild(tableElement);
  tableDOM.style = "display:block";
}

function toggleAction() {
  if (actionSet == ACTION_ENABLED) {
    actionSet = ACTION_DISABLED;
  } else {
    actionSet = ACTION_ENABLED;
  }
}
