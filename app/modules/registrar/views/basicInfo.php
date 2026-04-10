<div id="basicInfo">
  <div class="row g-3">

    <div class="col-md-4">
      <label class="form-label">First Name</label>
      <input type="text"
        class="form-control"
        name="firstname"
        value="<?php echo $firstname ?>"
        placeholder="<?php echo $firstname ?>"
        id="firstname">
    </div>

    <div class="col-md-4">
      <label class="form-label">Middle Name</label>
      <input type="text"
        class="form-control"
        name="middlename"
        value="<?php echo $middlename ?>"
        placeholder="<?php echo $middlename ?>"
        id="middlename">
    </div>

    <div class="col-md-4">
      <label class="form-label">Last Name</label>
      <input type="text"
        class="form-control"
        name="lastname"
        value="<?php echo $lastname ?>"
        placeholder="<?php echo $lastname ?>"
        id="lastname">
    </div>

  </div>
</div>

<!-- Hidden Fields -->
<input type="hidden" id="pos" value="<?php echo $pos ?>">
<input type="hidden" id="st_user_id" value="<?php echo $st_user_id ?>">
<input type="hidden" id="rowid" value="<?php echo $user_id ?>">
<input type="hidden" id="name_id" value="<?php echo $name_id ?>">

<!-- Buttons -->
<div class="d-flex justify-content-end gap-2 mt-3">

  <button class="btn btn-danger btn-sm"
    data-bs-dismiss="popover">
    Cancel
  </button>

  <button class="btn btn-success btn-sm"
    onclick="editBasicInfo()"
    data-bs-dismiss="popover">
    Save
  </button>

</div>