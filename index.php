<?php include_once 'header.php';  // This has the inital body and html tags. 
?>
</div>
<div id="gallery" class="container text-center">
</div>
</body>
<script>
  const isIndexPage = true;
  var page = 1;

  function generateRange(page) {
    return [7 * (page - 1), (page * 7) - 1]
  }
</script>




<footer class="d-flex flex-wrap justify-content-center align-items-center py-4 my-4 border-top">
  <div class="col-md-4 d-flex align-items-center justify-content-center">
    <button id="leftPage" class="font-weight-bold btn btn-primary page-button">&lt</button>
    <h3 id="pageNumber" class="border-bottom mx-2 mb-0">1</h3>
    <button id="rightPage" class="font-weight-bold btn btn-primary page-button"
      data-pg-dir="1">&gt</button>
    <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
    </a>

  </div>
</footer>



<div class="modal fade" id="checkoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Leave page</h5>
      </div>
      <div class="modal-body">
        <p>Is this everything you have added to cart?</p>
        <div id="checkoutBody" style="max-height: 30rem !important;" class="overflow-y-scroll overflow-x-hidden ">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue shopping</button>
        <button type="button" onclick="proceedToCheckoutButton();" class="btn btn-success">Proceed to Order</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Art piece details</h5>
      </div>
      <div id="infoModalBody" class="modal-body">
        <!-- stuff will be here --!>
      </div>
      <div class="modal-footer">
        <button id="modalInfoButton"  type="button" class="btn btn-success cardCheckoutBtn">Add to Cart</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include_once "./src/utilities/AJAXUtil.html";
include_once "./src/utilities/basketUtil.html";
include_once "./src/utilities/cardUtil.html"; ?>
</html>
