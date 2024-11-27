<?php
include_once 'src/utilities/header.php';
session_start();
?>
<?php // this block contains both login and logout.
include_once 'src/api/auth/authBlock.html';

?>
</div> <!-- Closing header --!>
<div id="main" class="container" style="display:none"></div>

<!-- Modal -->
<div class="modal fade" id="addRowFn" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addToRow">Insert new art details</h5>
      </div>
      <div class="modal-body">
        <form id="addToRowForm" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="form-name">Name of painting</label>
            <input type="text" maxlength="30" pattern="^(?:\b\w+\b[\s]*){1,}$" class="form-control formInput" id="form-name" placeholder="Enter name" required>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please enter a name for the art. Max length is 30.
            </div>
          </div>
          <div class="form-group">
            <label for="form-date">Date of completion</label>
            <input type="datetime" class="form-control formInput" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(19|20)\d{2}$" id="form-date" placeholder="Enter year" required>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please enter a valid date. Format is YYYY/MM/DD.
            </div>
          </div>
          <div class="form-group">
            <label for="form-width">Width</label>
            <input type="text" maxlength="15" pattern="^-?(0|[1-9]\d*)(\.\d+)?$" class="form-control formInput" id="form-width" placeholder="Enter width" required>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please enter a width value in mm. Must be a number, precision is 15.
            </div>
          </div>
          <div class="form-group">
            <label for="form-height">Height</label>
            <input type="text" maxlength="15" pattern="^-?(0|[1-9]\d*)(\.\d+)?$" class="form-control formInput" id="form-height" placeholder="Enter height" required>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please enter a height value in mm. Must be a number, precision is 15.

            </div>
          </div>
          <div class="form-group">
            <label for="form-price">Price</label>
            <input type="text" maxlength="15" pattern="^-?(0|[1-9]\d*)(\.\d+)?$" class="form-control formInput" id="form-price" placeholder="Enter price" required>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please enter a price. Must be a number, precision is 15.
            </div>
          </div>
          <div class="form-group">
            <label for="form-desc">Description</label>
            <textarea class="form-control formInput" maxlength="460" pattern="^(?:\b\w+\b[\s]*){10,}$" style="resize: none" id="form-desc" rows="3" required></textarea>
            <div class="valid-feedback">
              Looks ok!
            </div>
            <div class="invalid-feedback">
              Please write a short description of the art. Max 460 characters.
            </div>
          </div>
          <div class="form-group">
            <label for="form-file" class="form-label">Image upload</label>
            <input class="form-control" type="file" id="form-file" required>
            <div class="invalid-feedback">
              Please provide a valid image file.
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="modalCloseBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="addToRowForm" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>


</body>
<?php /* pass script, use is optional.*/
include_once 'src/api/auth/logoutAuto.php';
//if ($cleared) { TODO: ADD SUPPORT FOR LOGOUT ALERT
//  echo "cleared!"; checks need to more significant!!
//} else {
//  echo "no cleared!";
//}
include_once 'src/utilities/AJAXUtil.html';
include_once 'src/utilities/tableUtil.html'; // script for table gen
include_once 'src/api/auth/authScript.php';
?>

</html>
