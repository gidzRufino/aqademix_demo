<!-- Edit Address Modal -->
<div class="modal fade" id="addressInfoModal" tabindex="-1" aria-labelledby="addressInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">

      <!-- Header -->
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="addressInfoLabel">Edit Address</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <div class="row g-3">

          <!-- Street -->
          <div class="col-md-12">
            <label class="form-label">Street</label>
            <input class="form-control"
              type="text"
              name="street"
              value=""
              placeholder=""
              id="street">
          </div>

          <!-- Barangay -->
          <div class="col-md-12">
            <label class="form-label">Barangay</label>
            <input class="form-control"
              type="text"
              name="barangay"
              value=""
              id="barangay">
          </div>

          <!-- City -->
          <div class="col-md-12">
            <label class="form-label">City / Municipality</label>
            <select class="form-select"
              id="city"
              name="inputCity"
              onclick="getProvince(this.value)">
              <?php
              $cities = Modules::run('main/getCities');
              foreach ($cities as $cit):
              ?>
                <option value="<?= $cit->cid ?>">
                  <?= $cit->mun_city . ' [ ' . $cit->province . ' ]' ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Province -->
          <div class="col-md-12">
            <label class="form-label">Province</label>
            <input class="form-control mb-2"
              value=""
              name="inputProvince"
              type="text"
              id="inputProvince"
              placeholder="State / Province"
              required>

            <input type="hidden"
              value=""
              name="inputPID"
              id="inputPID">
          </div>

          <!-- Zip Code -->
          <div class="col-md-12">
            <label class="form-label">Zip Code</label>
            <input class="form-control"
              type="text"
              name="zip_code"
              value=""
              placeholder=""
              id="zip_code">
          </div>

        </div>

        <!-- Hidden Fields -->
        <input type="hidden" id="address_id" value="">
        <input type="hidden" id="address_user_id" value="">

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>

        <button class="btn btn-sm btn-success"
          onclick="editAddressInfo()"
          data-bs-dismiss="modal">
          Save
        </button>
      </div>

    </div>
  </div>
</div>