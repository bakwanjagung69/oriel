<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #0F0F10;">Ubah Password</h6>
            </div>
            <div class="card-body">
        	 	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="<?= $userId; ?>">
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="form-group">
			                  	<label>Password Lama <small class="text-danger h6">*</small></label>
			                  	<div class="input-group form-group">
						          <input type="password" name="password_lama" class="form-control pwdLama" autocomplete="off">
						          <span class="input-group-append">
						            <button class="btn btn-outline-secondary showPassLama" type="button">
						            	<i class="fa fa-eye-slash"></i>
						            </button>
						          </span>          
						        </div>
			                </div>
			                <div class="form-group">
			                  	<label>Password Baru <small class="text-danger h6">*</small></label>
			                  	<div class="input-group form-group">
						          <input type="password" name="password_baru" class="form-control pwdBaru" autocomplete="off">
						          <span class="input-group-append">
						            <button class="btn btn-outline-secondary showPassBaru" type="button">
						            	<i class="fa fa-eye-slash"></i>
						            </button>
						          </span>          
						        </div>
			                </div>
			                <div class="form-group">
			                  	<label>Password Konfirmasi <small class="text-danger h6">*</small></label>
			                  	<div class="input-group form-group">
						          <input type="password" name="password_konfirmasi" class="form-control pwdKonfirmasi" autocomplete="off">
						          <span class="input-group-append">
						            <button class="btn btn-outline-secondary showPassKonfirmasi" type="button">
						            	<i class="fa fa-eye-slash"></i>
						            </button>
						          </span>          
						        </div>
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
        		</div>
            </div>
        </div>
    </div>
</div>