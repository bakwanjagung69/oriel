<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header"></div>
	        <div class="box-body">
	        	<form action="void(0):javascript;" id="formID" method="POST" enctype="multipart/form-data" autocomplete="off">
        			<input type="hidden" name="uuid" value="<?= $data['uuid']; ?>">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name...">
                  </div>
                </div>
              </div>
			        <div class="row">
                <div class="col-md-12">
                   <div class="container-input-mail">
                      <div class="form-group input-mailTo">
                        <input type="email" name="mailTo" id="_mailTo" class="form-control" placeholder="To:" autocomplete="off">
                      </div>
                      <div class="form-group input-mailCc">
                        <input type="email" class="form-control" id="_mailCc" name="mail_cc" placeholder="Cc:" autocomplete="off">
                      </div>
                   </div>
                  <div class="form-group">
                    <input type="text" name="subject" class="form-control" placeholder="Subject:">
                  </div>
                  <div class="form-group">
                    <textarea id="_message" name="message" class="form-control" rows="20" cols="80" required="required"></textarea>
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