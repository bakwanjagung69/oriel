<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header"></div>
	        <div class="box-body">
		      	<div class="alert alert-warning" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		          </button>
		          <strong>Reminder!</strong> Maximum Mail Setting data is only allowed <b>1</b> data.
		        </div>
	        	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="<?= $data['id']; ?>">
	        		<div class="row">
	        			<div class="col-md-6">
        				 	<div class="main-mail">
	    				 		<div class="form-group">
		                        	<label for="main_email">Main Email</label>
		                        	<input type="text" name="main_email" class="form-control" required="required">
		                      	</div>  
        				 	</div> 
	        			</div>
	        			<div class="col-md-6"></div>
	        		</div>
	        		<hr>
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="form-group">
                            	<label for="subject_email">Subject Email</label>
                            	<input type="text" name="subject_email" class="form-control" required="required">
                          	</div>  
	        			</div>
	        			<div class="col-md-6">
	        				<div class="form-group">
		                        <label for="email_name">Email Name</label>
		                        <input type="text" name="email_name" class="form-control" required="required">
	                      	</div>
                          	<div class="form-group">
                            	<label for="subject_email">Body Email Received</label>
                            	<textarea id="_body_email_to" name="body_email_to" class="form-control" rows="5" cols="80" ></textarea>
                          	</div> 
	        			</div>
	        			<div class="col-md-6">
	        				<div class="form-group">
		                        <label for="email_received">Email Received</label>
		                        <input type="text" name="email_received" class="form-control" required="required">
	                      	</div>
                  	       	<div class="form-group">
                            	<label for="subject_email">Body Email Received</label>
                            	 <textarea id="_body_email_received" name="body_email_received" class="form-control" rows="5" cols="80" ></textarea>
                          	</div> 
	        			</div>
	        		</div>
	        		<hr>
	        		<div class="account">
	        			<div class="row">
		        			<div class="col-md-6">
		        				<div class="form-group">
			                        <label for="username">Username</label>
			                        <input type="text" name="username" class="form-control" required="required">
		                      	</div>
		        			</div>
		        			<div class="col-md-6">
		        				<div class="form-group has-feedback">
			                        <label for="password">Password</label>
			                        <input type="password" name="password" class="form-control" required="required">
			                        <i class="fa fa-eye-slash" id="iconEye" data-show="0"></i>
		                      	</div> 
		        			</div>
		        		</div>
	        		</div>
	        		<hr>
	        		<div class="replyToMail">
	        			<div class="row">
		        			<div class="col-md-6">
		        				<div class="form-group">
			                        <label for="reply_to_email">Email Reply To</label>
			                        <input type="email" name="reply_to_email" class="form-control" required="required">
		                      	</div>
		        			</div>
		        			<div class="col-md-6">
		        				<div class="form-group">
			                        <label for="reply_to_email_name">Reply To Email Name</label>
			                        <input type="email" name="reply_to_email_name" class="form-control" required="required">
		                      	</div> 
		        			</div>
		        		</div>
	        		</div>
	        		<hr>
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="row">
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>Email CC</label>
	                                  <input type="email" name="email_cc" class="form-control">
	                                </div>
	                                <div class="btn-add pull-right">
	                                    <button type="button" class="btn btn-primary" onclick="AddMailCC(event);">
	                                        <i class="fa fa-plus"></i>
	                                    </button>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label>List Email CC</label>
	                            <table id="__table" class="table table-bordered table-striped">
	                                <thead>
	                                <tr>
	                                  <th>Email</th>
	                                  <th>Action</th>
	                                </tr>
	                                </thead>
	                                <tbody></tbody>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <hr>
	        		<div class="connection">
	        			<div class="row">
		        			<div class="col-md-6">
		        				<div class="form-group">
			                        <label for="host">Host</label>
			                        <input type="text" name="host" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
			                        <label for="mail_type">Email Type</label>
			                        <input type="text" name="mail_type" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
			                        <label for="timeout">Timeout</label>
			                        <input type="number" min="1" name="timeout" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
		                          <label>Valdation</label>
		                          <select name="validation" class="form-control">
		                            <option value="">--Choose--</option>
		                            <option value="TRUE">TRUE</option>
		                            <option value="FALSE">FALSE</option>
		                          </select>
		                        </div>
		        			</div>
		        			<div class="col-md-6">
		        				<div class="form-group">
			                        <label for="port">Port</label>
			                        <input type="text" name="port" class="form-control" required="required">
		                      	</div>
		        				<div class="form-group">
			                        <label for="charset">Charset</label>
			                        <input type="text" name="charset" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
			                        <label for="protocol">Protocol</label>
			                        <input type="text" name="protocol" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
		                          <label>WordWrap</label>
		                          <select name="wordwrap" class="form-control">
		                            <option value="">--Choose--</option>
		                            <option value="TRUE">TRUE</option>
		                            <option value="FALSE">FALSE</option>
		                          </select>
		                        </div>
		        			</div>
		        		</div>
	        		</div>
	                <hr>
	        		<div class="logoAndSosmed">
	        			<div class="row">
		        			<div class="col-md-6">
                                <div class="form-group">
			                        <label for="sosmedName">Name</label>
			                        <input type="text" name="sosmedName" class="form-control" required="required">
		                      	</div>
                                <div class="form-group">
			                        <label for="urlSodmed">Url</label>
			                        <input type="url" name="urlSodmed" class="form-control" required="required">
		                      	</div>
		                      	<div class="form-group">
                                  <div class="form-group">
				                    <label for="icon">Icon</label>
				                    <select class="fa form-control icon" name="iconSosmed" required="required">
				                      <option value="">--Choose--</option>
				                      <?php foreach ($data['icon'] as $iconHex) { ?>
				                        <option class="fa" value="<?= $iconHex; ?>"><?= '&#x'.strtoupper($iconHex); ?></option>
				                      <?php } ?>
				                    </select>
				                  </div>
                                </div>
                                <div class="btn-add pull-right">
                                    <button type="button" class="btn btn-primary" onclick="AddSosmed(event);">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <br><br>
                                <br><br>
                                <div class="form-group">
		                            <table id="__tableSosmed" class="table table-bordered table-striped">
		                                <thead>
		                                <tr>
		                                  <th>Icon</th>
		                                  <th>Name</th>
		                                  <th>URL</th>
		                                  <th>Action</th>
		                                </tr>
		                                </thead>
		                                <tbody></tbody>
		                            </table>
		                        </div>
		        			</div>
		        			<div class="col-md-6">
		        				<div class="choose-logo">
		        					<div class="form-group">
			        					<label>Logo &nbsp;
					                  		<div class="pull-right __info" style="display: none;">
							                    <i class="fa fa-info-circle" data-placement="right" data-toggle="tooltip" class="btn btn-default" type="button" data-original-title="PERHATIAN! Jika Anda ingin mengubah logo Anda harus klik tombol browse dan jika Anda tidak mengubah logo maka biarkan logo input kosong." style="color: #f39c12;"></i> 
						                  	</div>
			        					</label>
					    				<div class="input-group form-group image-preview">
							                <input type="text" name="logo" class="form-control image-preview-filename" disabled="disabled">
							                <span class="input-group-btn">
							                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
							                        <span class="glyphicon glyphicon-remove"></span> Clear
							                    </button>
							                    <div class="btn btn-default image-preview-input">
							                        <span class="glyphicon glyphicon-folder-open"></span>
							                        <span class="image-preview-input-title">Browse</span>
							                        <input type="file" accept="image/png, image/jpeg, image/gif" name="logo" />
							                    </div>
							                </span>
							            </div>
			        				</div>
							        <div class="priview-img"></div>
		        				</div>
		        			</div>
		        		</div>
	        		</div>
	        		<hr>
	        		<div class="row">
	        			<div class="col-md-12">
        				 	<div class="form-group">
	                            <label for="status">Status</label>
	                            <select class="form-control" class="status" name="status" required="required">
	                              <option value="">--Choose--</option>
	                              <option value="active">Active</option>
	                              <option value="inactive">Inactive</option>
	                            </select>
                          	</div>
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