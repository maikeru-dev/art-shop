<?php include_once "../../utilities/AJAXUtil.html"; ?>
<script>
  var loggedIn = <?php if (isset($_SESSION['auth']) && $_SESSION['auth'])
                    echo "true";
                  else echo "false";
                  ?>;
  var loginTimestamp = <?php if (isset($_SESSION['auth_timestamp']) && $_SESSION['auth_timestamp'])
                          echo $_SESSION['auth_timestamp'];
                        else echo 0; ?>;
  var loginButton = document.getElementById("loginButton");
  var passwordLabel = document.getElementById("passwordLabel");
  var passwordAuth = document.getElementById("passwordAuth");
  var logoutButton = document.getElementById("logoutButton");
  var addRowButton = document.getElementById("addRowButton");
  var seeOrdersButton = document.getElementById("seeOrdersButton");
  var seeArtButton = document.getElementById("seeArtButton");

  var widthInput = document.getElementById("form-width");
  var heightInput = document.getElementById("form-height");
  var descInput = document.getElementById("form-desc");
  var nameInput = document.getElementById("form-name");
  var priceInput = document.getElementById("form-price");
  var dateInput = document.getElementById("form-date");
  var fileInput = document.getElementById("form-file");

  const TABLE_ART = 0;
  const TABLE_ORDER = 1;
  var showTable = TABLE_ART;

  if (!loginButton || !passwordAuth) {
    console.log("authBlock is missing?!");
  }

  (function() { //https://getbootstrap.com/docs/4.0/components/forms/
    'use strict';
    window.addEventListener('load', function() {

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false || fileInput.files.input === 0) {
            if (fileInput.files.input === 0) {
              fileInput
                .classList.add("is-invalid");
            }
            event.preventDefault();
            event.stopPropagation();
          } else {
            // AJAX here! This code runs when the form is valid.
            event.preventDefault();
            var xhttp = AJAXFetchObject(
              (response) => { // successFn
                // Send OK message!
                loginOK(null);
                alert("Successfully added new row!");
                document.getElementById("modalCloseBtn").dispatchEvent(new Event("click")); // Hides the Modal on success
                //  I couldn't figure out how to import the module, sorry.
              }, (response) => { // failureFn
                // Something went wrong :/
                alert("Something went wrong: " + response.error);
              });

            var reader = new FileReader(); // Step 1
            var fileContents = fileInput.files[0]; // should be one
            var base64img = null;

            reader.onload = function(event) {
              base64img = reader.result;
              var request = {
                'width': widthInput.value,
                'height': heightInput.value,
                'price': priceInput.value,
                'name': nameInput.value,
                'description': descInput.value,
                'date_of_completion': dateInput.value,
                'img': base64img
              };

              xhttp.open("POST", window.location.origin + "/api.php/art");
              xhttp.send(JSON.stringify(request)); // Step 3
            }

            reader.readAsDataURL(fileContents); // Step 2

          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  loginButton.addEventListener("click", login);
  logoutButton.addEventListener("click", logout);
  seeOrdersButton.addEventListener("click", function() {
    switchTable(false);
  });
  seeArtButton.addEventListener("click", function() {
    switchTable(true);
  })

  if (!loggedIn) { // if not logged in
    hideLogin(false);
  } else {
    hideLogin(true);
    document.body.addEventListener("onload", loginOK(null));
  }

  function switchTable(boolVal) {
    if (boolVal == true) {
      showTable = TABLE_ART;
    } else {
      showTable = TABLE_ORDER;
    }
    toggleAction(); // This toggles your delete button.
    hideLogin(true);
    loginOK(null);
  }

  function loginGroupStyle(value) {
    loginButton.style = value;
    passwordAuth.style = value;
    passwordLabel.style = value;
  }

  function hideLogin(boolVal) {
    // I am doing it like this because I do not have enough time to figure out how css works
    if (boolVal == false) {
      loginGroupStyle("display:block");
      logoutButton.style = "display:none";
      addRowButton.style = "display:none";
      seeOrdersButton.style = "display:none";
      seeArtButton.style = "display:none";
    } else {
      loginGroupStyle("display:none");
      logoutButton.style = "display:inline";
      if (showTable == TABLE_ART) {
        seeOrdersButton.style = "display:inline";
        addRowButton.style = "display:inline";
        seeArtButton.style = "display:none";
      } else { // TABLE_ORDER
        seeArtButton.style = "display:inline";
        seeOrdersButton.style = "display:none";
        addRowButton.style = "display:none";
      }
    }
  }


  function loginBAD(response) {
    // TODO: IMPLEMENT
  }

  function loginOK(response) {
    loginGroupStyle("display:none");
    if (response !== null) {
      alert("Logged in! Welcome.");
    }

    // Now fetch your bloody table.
    var xhttp = AJAXFetchObject(function(response) {
      // successFn, should run only on 200
      if (response.error === null) {
        displayTable(response.value);
        hideLogin(true);
      } else {
        console.log(response);
        alert("Something went wrong!");
      }
    }, function(response) {
      // failureFn, runs only when not 200
      if (response.error === null) {
        alert("Something went horribly wrong");
      } else {
        alert("Login failed due to: " + response.error);
      }
    });


    xhttp.open("GET", window.location.origin + "/api.php/" + (showTable == 0 ? "art" : "order"));

    xhttp.send();
  }


  function logoutOK(response) {
    // TODO: IMPLEMENT
    alert("Logged out!");
    tableDOM.style = "display:none";
    hideLogin(false);
  }

  function logout() {
    var xhttp = AJAXFetchObject(logoutOK, (response) => {
      console.log(response);
    });

    xhttp.open("POST", window.location.origin + "/src/api/auth/logout.php");
    xhttp.send();
  }

  function login() {
    var xhttp = AJAXFetchObject(loginOK, (response) => {
      console.log(response);
    });

    // TODO: ADD TIMESTAMP TO PREVENT CACHING!
    // NOTE: It doesn't get anymore insecure than this lol
    xhttp.open("POST", window.location.origin + "/src/api/auth/login.php");
    xhttp.setRequestHeader(
      "Authorization",
      "Basic " + window.btoa(passwordAuth.value),
    );
    xhttp.send();
  }
</script>
