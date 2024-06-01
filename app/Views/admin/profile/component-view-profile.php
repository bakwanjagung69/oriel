<div class="row">
	<div class="col-md-3">
		<div class="box box-primary">
	        <div class="box-header"></div>
	        <div class="box-body box-profile">
	        	<input type="hidden" id="userId" value="<?= $profileData['id']; ?>">
	        	<img class="profile-user-img img-responsive img-circle lazy-load-img-avatar" src="<?= base_url('/files/loaderImg?loader=loader-image') ?>" data-src="<?= base_url('/files/images?q='.$profileData['images']); ?>" alt="User profile picture">
	        	<h3 class="profile-username text-center"><?= ucfirst($profileData['full_name']); ?></h3>
	        	<p class="text-muted text-center"><?= ($profileData['rules'] == '1') ? 'SuperUser' : 'Content'; ?></p>
	        	<ul class="list-group list-group-unbordered">
		          <li class="list-group-item">
		            <b>Email</b> <a class="pull-right">
		              <?= $profileData['email']; ?>
		            </a>
		          </li>
		          <li class="list-group-item">
		            <b>Browser Name</b> <a class="pull-right">
		              <?= $profileData['browser_name']; ?>
		            </a>
		          </li>
		          <li class="list-group-item">
		            <b>Status</b> <a class="pull-right">
		              <?= ($profileData['status'] == '1') ? 'Active' : 'Inactive'; ?>
		            </a>
		          </li>
		        </ul>
		        <a href="javascript:void(0);" onclick="showModal();" class="btn btn-primary btn-block"><b>Change Password</b></a>
	        </div>
	        <div class="box-footer"></div>
      	</div>
	</div>
	<div class="col-md-9">
	    <div class="box box-primary">
	      <div class="box-body">
	        <form class="form-horizontal" action="void(0):javascript;" id="formProfile" method="POST" enctype="multipart/form-data">
	          <div class="form-group">
	            <label for="inputName" class="col-sm-2 control-label">Full Name</label>
	            <div class="col-sm-10">
	              <input type="text" name="full_name" class="form-control" id="fullName" placeholder="Full Name">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="inputName" class="col-sm-2 control-label">Username</label>
	            <div class="col-sm-10">
	              <input type="text" class="form-control" id="userName" placeholder="Username" readonly="readonly">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
	            <div class="col-sm-10">
	              <input type="email" name="email" class="form-control" id="Email" placeholder="Email">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="inputEmail" class="col-sm-2 control-label">
	              Photo&nbsp;
	              <div class="pull-right __info">
	                <i class="fa fa-info-circle" data-placement="right" data-toggle="tooltip" class="btn btn-default" type="button" data-original-title="PERHATIAN! Jika Anda ingin mengubah gambar Anda harus klik tombol browse dan jika Anda tidak mengubah gambar maka biarkan gambar input kosong." style="color: #f39c12;"></i> 
	              </div>
	            </label>
	            <div class="col-sm-10">
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
	          </div>
	          <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	              <div class="checkbox">
	                <label>
	                  <input type="checkbox" id="agreement"> I agree to the <a href="javascript:void(0);">update data</a>
	                </label>
	              </div>
	            </div>
	          </div>
	          <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	              <button type="button" class="btn btn-danger" onclick="updateData();">
	                <i class="fa fa-floppy-o loaders-update"></i> Update
	              </button>
	            </div>
	          </div>
	        </form>
	      </div>
	    </div>
  	</div>
</div>

<!-- /.modal -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
        <form action="void(0):javascript;" id="formChangePassword" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>
                  New Password&nbsp;
                </label>
                <div class="pull-right">
                  <span class="showHide" data-showHide="0">show</span>
                </div>
                <input type="password" name="new_password" class="form-control">
              </div>
              <div class="form-group">
                <label>
                  Confirm Password&nbsp;
                </label>
                <div class="pull-right">
                  <span class="showHide" data-showHide="0">show</span>
                </div>
                <input type="password" name="confirm_password" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="changePassword();">
          <i class="fa fa-floppy-o loaders-changePass"></i> Save
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->