<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #0F0F10;">Form Users</h6>
            </div>
            <div class="card-body">
        	 	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="<?= $data['id']; ?>">
	        		<div class="row">
	        			<div class="col-md-6">
	        				<div class="form-group">
			                  <label>NIM/NIP/NIDN <small class="text-danger h6">*</small></label>
			                  <input type="text" name="nim" class="form-control">
			                </div>
	        				<div class="form-group">
			                  <label>Full Name <small class="text-danger h6">*</small></label>
			                  <input type="text" name="full_name" class="form-control">
			                </div>
			                <div class="form-group">
			                  <label>Username <small class="text-danger h6">*</small></label>
			                  <input type="text" name="username" class="form-control">
			                </div>
		    				<div class="form-group">
			                  <label>Email <small class="text-danger h6">*</small></label>
			                  <input type="email" name="email" class="form-control">
			                </div>
			                <div class="form-group">
			                  	<label>Password <small class="text-danger h6">*</small>&nbsp;
			                  		<div class="pull-right __info" style="display: none;">
					                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" class="btn btn-secondary" type="button" title="ATTENTION! If you want to change the password you must enter the password input and if you do not change the password then leave the input password blank." style="color: #f39c12;"></i> 
				                  	</div>
			                  	</label>
			                	<div class="input-group form-group">
						          <input type="password" name="pass" class="form-control pwd" autocomplete="off">
						          <span class="input-group-append">
						            <button class="btn btn-outline-secondary showPass" type="button">
						            	<i class="fa fa-eye-slash"></i>
						            </button>
						          </span>          
						        </div>
			                </div>
			                <div class="form-group">
			                  <label>Status <small class="text-danger h6">*</small></label>
			                  <select name="status" class="form-control">
			                  	<option value="">--Choose--</option>
			                  	<option value="1">Active</option>
			                  	<option value="0">Inactive</option>
			                  </select>
			                </div>
			                <div class="form-group">
			                  <label>Rules <small class="text-danger h6">*</small></label>
			                  <select name="rules" class="form-control">
			                  	<option value="">--Choose--</option>
			                  	<option value="1">Superuser</option>
			                  	<option value="2">Admin TU</option>
			                  	<option value="3">Dosen</option>
			                  	<option value="4">Kaprodi</option>
			                  	<option value="5">Mahasiswa</option>
			                  </select>
			                </div>
	        			</div>
	        			<div class="col-md-6">
	        				<div class="form-group">
	        					<label>Picture &nbsp;
			                  		<div class="pull-right __info" style="display: none;">
					                    <i class="fa fa-info-circle" data-placement="right" data-toggle="tooltip" class="btn btn-default" type="button" title="PERHATIAN! Jika Anda ingin mengubah gambar Anda harus klik tombol browse dan jika Anda tidak mengubah gambar maka biarkan gambar input kosong." style="color: #f39c12;"></i> 
				                  	</div>
	        					</label>
			    				<div class="input-group form-group image-preview" style="margin: 0;">
					                <input type="text" name="images" class="form-control image-preview-filename" disabled="disabled">
					                <span class="input-group-append">
					                    <button type="button" class="btn btn-outline-secondary image-preview-clear" style="display:none;">
					                        <span class="glyphicon glyphicon-remove"></span> Clear
					                    </button>
					                    <div class="btn btn-default image-preview-input">
					                        <span class="glyphicon glyphicon-folder-open"></span>
					                        <span class="image-preview-input-title">Browse</span>
					                        <input type="file" accept="image/png, image/jpeg, image/gif" name="images" />
					                    </div>
					                </span>
					            </div>
	        				</div>
					        <div class="priview-img"></div>
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