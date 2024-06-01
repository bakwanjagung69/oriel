<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header"></div>
	        <div class="box-body">
	        	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="<?= $data['id']; ?>">
	        		<div class="row">
	        			<div class="col-md-6">
	        				<div class="form-group">
			                  <label>Full Name</label>
			                  <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name...">
			                </div>
			                <div class="form-group">
			                  <label>Username</label>
			                  <input type="text" name="username" class="form-control" placeholder="Enter Username...">
			                </div>
		    				<div class="form-group">
			                  <label>Email</label>
			                  <input type="email" name="email" class="form-control" placeholder="Enter Email...">
			                </div>
			                <div class="form-group">
			                  	<label>Password &nbsp;
			                  		<div class="pull-right __info" style="display: none;">
					                    <i class="fa fa-info-circle" data-placement="right" data-toggle="tooltip" class="btn btn-default" type="button" data-original-title="ATTENTION! If you want to change the password you must enter the password input and if you do not change the password then leave the input password blank." style="color: #f39c12;"></i> 
				                  	</div>
			                  	</label>
			                	<div class="input-group form-group">
						          <input type="password" name="pass" class="form-control pwd" placeholder="Enter Password...">
						          <span class="input-group-btn">
						            <button class="btn btn-default reveal" type="button">
						            	<i class="glyphicon glyphicon-eye-close"></i>
						            </button>
						          </span>          
						        </div>
			                </div>
			                <div class="form-group">
			                  <label>Status</label>
			                  <select name="status" class="form-control">
			                  	<option value="">--Choose--</option>
			                  	<option value="1">Active</option>
			                  	<option value="0">Inactive</option>
			                  </select>
			                </div>
			                <div class="form-group">
			                  <label>Rules</label>
			                  <select name="rules" class="form-control">
			                  	<option value="">--Choose--</option>
			                  	<option value="1">Administrator</option>
			                  	<option value="2">Admin</option>
			                  	<option value="3">Employee</option>
			                  	<option value="4">Owner</option>
			                  </select>
			                </div>
	        			</div>
	        			<div class="col-md-6">
	        				<div class="form-group">
	        					<label>Picture &nbsp;
			                  		<div class="pull-right __info" style="display: none;">
					                    <i class="fa fa-info-circle" data-placement="right" data-toggle="tooltip" class="btn btn-default" type="button" data-original-title="PERHATIAN! Jika Anda ingin mengubah gambar Anda harus klik tombol browse dan jika Anda tidak mengubah gambar maka biarkan gambar input kosong." style="color: #f39c12;"></i> 
				                  	</div>
	        					</label>
			    				<div class="input-group form-group image-preview">
					                <input type="text" name="images" class="form-control image-preview-filename" disabled="disabled">
					                <span class="input-group-btn">
					                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
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
	        <div class="box-footer">
	        	<div class="btn-save">
        			<button type="button" class="btn btn-default" onclick="Save(event);">
        				<i class="fa fa-floppy-o loaders"></i> Simpan
        			</button>
        			<button type="button" class="btn btn-default" onclick="Back();">
        				<i class="fa fa-reply"></i> Kembali
        			</button>
        		</div>
	        </div>
      	</div>
	</div>
</div>