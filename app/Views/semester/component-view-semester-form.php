<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #0F0F10;">Form Semester</h6>
            </div>
            <div class="card-body">
        	 	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="<?= $data['id']; ?>">
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="form-group">
			                  <label>Angkatan <small class="text-danger h6">*</small></label>
			                  <input type="text" name="angkatan" class="form-control">
			                </div>
	        				<div class="form-group">
			                  <label>Dari Tahun <small class="text-danger h6">*</small></label>
			                  <input type="text" name="dari_tahun" class="form-control">
			                </div>
			                <div class="form-group">
			                  <label>Sampai <small class="text-danger h6">*</small></label>
			                  <input type="text" name="sampai_tahun" class="form-control">
			                </div>
		    				<div class="form-group">
			                  <label>Semester <small class="text-danger h6">*</small></label>
			                  <input type="text" name="semester" class="form-control">
			                </div>
                            <div class="form-group">
                              <label>Status <small class="text-danger h6">*</small></label>
                              <select name="status" class="form-control">
                                <option value="">--Choose--</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                              </select>
                            </div>
	        			</div>
	        		</div>
	        	</form>
            </div>
            <div class="card-footer">
            	<div class="btn-save">
        			<button type="button" class="btn btn-outline-secondary" onclick="Save(event);">
        				<i class="fa fa-floppy-o loaders"></i> Simpan
        			</button>
        			<button type="button" class="btn btn-outline-secondary" onclick="Back();">
        				<i class="fa fa-reply"></i> Kembali
        			</button>
        		</div>
            </div>
        </div>
    </div>
</div>