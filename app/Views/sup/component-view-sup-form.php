<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #0F0F10;">Formulir SUP</h6>
            </div>
            <div class="card-body">
        	 	<form action="void(0):javascript;" id="formSUP" method="POST" enctype="multipart/form-data">
	        		<input type="hidden" name="id" value="">
	        		<div class="row">
	        			<div class="col-md-6">
	        				<div class="form-group">
			                  <label>Nama <small class="text-danger h6">*</small></label>
			                  <input type="text" name="nama" class="form-control" placeholder="" readonly="readonly" value="<?= $data['nama']; ?>">
			                </div>
	        			</div>
	        			<div class="col-md-6">
		     				<div class="form-group">
			                  <label>NIM <small class="text-danger h6">*</small></label>
			                  <input type="text" name="nim" class="form-control" placeholder="" readonly="readonly" value="<?= $data['nim']; ?>">
			                </div>
	        			</div>
	        		</div>
	        		<div class="row">
	                    <div class="col-md-3">
	                      <div class="form-group">
	                          <label>Semester <small class="text-danger h6">*</small></label>
	                          <select name="semester" class="form-control">
	                            <option value="">--Pilih--</option>
	                            <?php foreach ($master_semester as $res) { ?>
	                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
	                            <?php } ?>
	                          </select>
	                        </div>
	                    </div>
                  	</div>
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="form-group">
			                  <label>Judul <small class="text-danger h6">*</small></label>
			                  <input type="text" name="judul" class="form-control" placeholder="">
			                </div>
	        			</div>
	        			<div class="col-md-12">
			                <div class="form-group">
			                  	<label>Upload File Proposal <small class="text-danger h6">*</small></label>
		                      	<div class="custom-file">
								    <input type="file" name="proposal_file" class="custom-file-input" id="customFile" accept="application/pdf">
								    <label class="custom-file-label" for="customFile">Choose file</label>
							  	</div>
							  	<small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>
			                </div>
	        			</div>
	        			<div class="col-md-12">
			                <div class="form-group">
			                  	<label>Upload Surat Tugas & Lembar Konsultasi <small class="text-danger h6">*</small></label>
		                      	<div class="custom-file">
								    <input type="file" name="surat_tugas_file" class="custom-file-input" id="customFile" accept="application/pdf">
								    <label class="custom-file-label" for="customFile">Choose file</label>
							  	</div>
							  	<small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>
			                </div>
	        			</div>
	        		</div>
	        	</form>
            </div>
            <div class="card-footer">
            	<div class="btn-save">
        			<button type="button" class="btn btn-primary btn-block btn-col-navy" onclick="Save(event);">
        				<i class="fa fa-floppy-o loadersAction"></i> Simpan
        			</button>
        		</div>
            </div>
        </div>
    </div>
</div>