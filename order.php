<?php require_once 'src/utilities/header.php';
?>
<script src="./src/utilities/AJAXUtil.js"></script>
<script src="./src/utilities/basketUtil.js"></script>

<div class="container-md mt-4 border rounded">
  <h3 style="margin-left:1rem;" class="mt-3 ml-3">Order items </h3>

  <form id="orderForm" class="needs-validation border-bottom mb-2" novalidate>
    <div class="form-group">
      <div id="basketContainer" style="max-height: 20rem !important; max-width:40rem !important;" class="mt-2 mx-auto bt-2 border-bottom form-control border-top overflow-y-scroll overflow-x-hidden ">
      </div>
      <div class="invalid-feedback">
        Please go back to the index page to add items to your cart.
      </div>
    </div>
    <div class="p-3 mx-auto" style="max-width:40rem">
      <div class="form-group mb-2">
        <label for="inputName">Full name</label>
        <input type="text" class="form-control" style="max-width:75%" id="inputName" placeholder="Enter full name" required>
        <div class="invalid-feedback">
          Please provide a full name.
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="inputPhoneNumber">Phone number</label>
        <input type="tel" class="form-control" style="max-width:50%" id="inputPhoneNumber" placeholder="Enter phone number" required>
        <div class="invalid-feedback">
          Please provide a valid phone number.
        </div>
      </div>
      <div class="form-group mb-2">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" style="max-width:50%" id="inputEmail" placeholder="Enter email" required>
        <div class="invalid-feedback">
          Please provide a valid email.
        </div>
      </div>
      <div class="form-group mb-4 ">
        <label for="inputAddress">Postal Address</label>
        <input type="text" class="form-control " style="max-width:75%" id="inputAddress" placeholder="Enter address" required>
        <div class="invalid-feedback">
          Please provide a postal address.
        </div>
      </div>
    </div>
  </form>
  <div class="d-flex my-4 align-items-end justify-content-end">
    <button type="button" onclick="window.location.href = 'index.php';" class="btn btn-secondary">Go back to shopping</button>
    <button type="submit" form="orderForm" style="margin:0 0 0 0.5rem;" class="btn btn-primary">Send order</button>
  </div>
</div>

<script src="./src/utilities/orderUtil.js"></script>
