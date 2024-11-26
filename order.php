<?php include_once './header.php';
include_once "./src/utilities/AJAXUtil.html";
include_once "./src/utilities/basketUtil.html"
?>
<div class="container-fluid mt-4 w-50 border  rounded">
  <h3 style="margin-left:1rem;" class="mt-3 ml-3">Order items </h3>

  <form class="needs-validation" novalidate>
    <div class="form-group">
      <div id="basketContainer" style="max-height: 20rem !important; max-width:40rem !important;" class="mt-2 mx-auto bt-2 border-bottom form-control border-top overflow-y-scroll overflow-x-hidden ">
      </div>
      <div class="invalid-feedback">
        Please go back to the index page to add items to your cart.
      </div>
    </div>
    <div class="p-3">
      <div class="form-group mb-2">
        <label for="inputName">Full name</label>
        <input type="text" class="form-control w-75" id="inputName" placeholder="Enter full name" required>
        <div class="invalid-feedback">
          Please provide a full name.
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="inputPhoneNumber">Phone number</label>
        <input type="tel" class="form-control w-50" id="inputPhoneNumber" placeholder="Enter phone number" required>
        <div class="invalid-feedback">
          Please provide a valid phone number.
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control w-50" id="inputEmail" placeholder="Enter email" required>
        <div class="invalid-feedback">
          Please provide a valid email.
        </div>
      </div>
      <div class="form-group mb-4 ">
        <label for="inputAddress">Postal Address</label>
        <input type="text" class="form-control w-75" id="inputAddress" placeholder="Enter address" required>
        <div class="invalid-feedback">
          Please provide a postal address.
        </div>
      </div>
      <div class="d-flex align-items-end justify-content-end">
        <button type="button" onclick="window.location.href = 'index.php';" class="btn btn-secondary">Go back to shopping</button>
        <button type="submit" style="margin:0 0 0 0.5rem;" class="btn btn-primary">Send order</button>
      </div>
    </div>
  </form>
</div>
<?php

include_once "./src/utilities/orderUtil.html";

?>
