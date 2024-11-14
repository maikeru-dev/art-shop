<?php 
$PASS_HASH = password_hash("WeKnowTheGame24", PASSWORD_DEFAULT);

  if (isset($_GET["page"])) {
    if (isset($_GET["pass"])) {
      $password = $_GET["pass"];
      if (password_verify($password, $PASS_HASH)) {
        echo "Success!";
        http_response_code(200);
      }else {
        echo "Bad password";
        http_response_code(401);
      }
    }else {
      http_response_code(500);
    }
    die(); // Die if page was passed, regardless of the code sent.
    // This means this was an API request.
  }

  include_once "header.php";


?>


<input id="pass" name="pass" type="text"><input onclick="sendField(pass, 0);" type="button" value="Login">

</div>


</body>
  <script>
  const pass = document.getElementById("pass");
  function sendField (pass, page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      // state 4 means http request has been completed.
      // see https://www.tutorialspoint.com/explain-the-different-ready-states-of-a-request-in-ajax
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("response").innerHTML = this.responseText;
      }
    }
    // TODO: ADD TIMESTAMP TO PREVENT CACHING!
    // NOTE: It doesn't get anymore insecure than this lol
    xhttp.open("GET", window.location.origin + "/admin.php?page=" + page + "&pass=" + pass.value);
       xhttp.send();

  }

</script>
</html>
