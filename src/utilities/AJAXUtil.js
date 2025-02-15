function AJAXFetchObject(successFn, failureFn) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    // state 4 means http request has been completed.
    // see https://www.tutorialspoint.com/explain-the-different-ready-states-of-a-request-in-ajax
    if (this.readyState == 4) {
      if (this.status == 200 || this.status == 201) {
        successFn(tryParseJSONObject(this.response));
      } else {
        failureFn(tryParseJSONObject(this.response));
      }
    }
  };
  return xhttp;
}
// https://stackoverflow.com/questions/3710204/how-to-check-if-a-string-is-a-valid-json-string
function tryParseJSONObject(jsonString) {
  try {
    var o = JSON.parse(jsonString);

    // Handle non-exception-throwing cases:
    // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
    // but... JSON.parse(null) returns null, and typeof null === "object",
    // so we must check for that, too. Thankfully, null is falsey, so this suffices:
    if (o && typeof o === "object") {
      return o;
    }
  } catch (e) {
    console.log("Response recieved not JSON, got: " + jsonString);
  }

  return false;
}
function getAllArtGeneric(fn) {
  var xhttp = AJAXFetchObject(
    (response) => {
      artTable = response.value;
      currentRange = [0, artTable.length];
      fn();
    },
    (response) => {
      alert("Failure to fetch table, reason: " + response.error);
    },
  );

  xhttp.open("GET", window.location.origin + "/api.php/art");
  xhttp.send();
}
