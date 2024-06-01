<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;"></h1>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header">
              <div class="btn-save">
                <button type="button" class="btn btn-outline-secondary" onclick="Back();">
                  <i class="fa fa-reply"></i> Kembali
                </button>
              </div>
            </div>
            <div class="card-body">
              <form>
                <input type="hidden" name="ujiKelayakanId" value="<?= $data['uji_kelayakan_id']; ?>">
                <input type="hidden" name="kaprodiId" value="<?= $data['kaprodi_id']; ?>">
                <input type="hidden" name="prefixData" value="<?= $data['prefix_data']; ?>">
                <input type="hidden" name="status" value="<?= $data['status']; ?>">
                <input type="hidden" name="userRules" value="<?= session()->get('user_logged')['rules']; ?>">
                <div class="row">
                  <div class="col-md-12">
                     <div class="column-sideby-side">
                        <div Id="wrapper">
                          <section>
                            <ul class="wrapper-ul">
                              <li class="wrapper-li">
                                <img class="lazy-load-img avatar-disp" src="<?= base_url("/files/loaderImg?loader=loader-image"); ?>" data-src="<?= base_url("/files/images?q={$data['user_images']['images']}"); ?>" width="180" height="180" alt="images" />
                                <div class="details">
                                  <p id="p1"><?= $data['nama']; ?></p>
                                  <p id="p2"><?= $data['nim']; ?></p>
                                </div>
                              </li>
                            </ul>
                          </section>
                        </div>
                      </div>
                  </div>
                </div>
                <?php if (session()->get('user_logged')['rules'] == '2') { ?>
                  <?php if ($data['status'] !== '7') { ?>
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
                  <?php } ?>
                <?php } ?>
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" placeholder="" readonly="readonly" value="<?= $data['judul']; ?>">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <label>Jenis Ujian</label>
                        <input type="text" name="jenis_ujian" class="form-control" placeholder="" readonly="readonly" value="Uji Kelayakan">
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Laporan</label>
                      <div class="input-group mb-3">
                        <input type="text" name="laporan_file" class="form-control" placeholder="" readonly="readonly" value="<?= $data['files_name']; ?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick='openfile("<?= base_url("/files/document?q={$data['files']}".'&mode=view'); ?>")'>Buka File</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if (session()->get('user_logged')['rules'] == '2') { ?>
                  <?php if ($data['status'] !== '7') { ?>
                   <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Upload Surat Tugas Uji Kelayakan <small class="text-danger h6">*</small></label>
                          <div class="custom-file">
                            <input type="file" name="surat_tugas_file" class="custom-file-input-surat-tugas" id="customFileSuratTugas"  accept="application/pdf">
                            <label class="custom-file-label custom-file-label-surat-tugas" for="customFileSuratTugas">Choose file</label>
                          </div>
                          <small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                <?php } ?>
                <div class="header-list-dosen">
                  <div class="label-list-dosen">
                    <div class="sub-1">Dosen Penguji</div>
                    <div class="sub-2">Nama - nama dosen penguji anda.</div>
                  </div>
                   <?php if (session()->get('user_logged')['rules'] == '4') { ?>
                      <?php if ($data['status'] !== '7') { ?>
                        <div class="div-btn-penugasan-dosen">
                            <button type="button" class="btn btn-primary btn-col-navy" onclick="addPenugasanDosenPenguji(event);">
                              Tambah Penugasan Dosen
                            </button>
                        </div>
                      <?php } else { ?>
                        <div>&nbsp;</div>
                      <?php } ?>
                    <?php } ?>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul role="list" class="list-ul list-penugasan-dosen-penguji"></ul>
                    <div class="div-btn-action">
                      <?php if (session()->get('user_logged')['rules'] == '2') { ?>
                        <?php if ($data['status'] !== '7') { ?>
                          <button type="button" class="btn btn-primary btn-block btn-col-navy upload-surat-tugas-btn" onclick="UploadSuratTugas(event);">
                            <i class="fa fa-upload loadersAction"></i> Upload Surat Tugas
                          </button>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Penugasan Dosen Penguji  -->
<div class="modal fade" id="modalPenugasanDosen" tabindex="-1" role="dialog" aria-labelledby="modalPenugasanDosenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPenugasanDosenModalLabel">List Data Dosen</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                  <form action="void(0):javascript;" id="formPenugasanDosenPenguji" method="POST" enctype="multipart/form-data">
                    <div>
                      <div class="form-group">
                        <label>Dosen</label>
                         <select name="list-dosen" class="form-control">
                          <option value="">--Choose--</option>
                        </select>
                      </div>
                    </div>
                    <div>
                      <div class="form-group">
                        <label>Type Penugasan</label>
                        <select name="type-penugasan" class="form-control">
                            <option value="">--Choose--</option>
                            <option value="ketua">Ketua</option>
                            <option value="seketaris">Seketaris</option>
                            <option value="penguji">Penguji</option>
                            <option value="penguji ahli">Penguji Ahli</option>
                            <option value="penguji luar">Penguji Luar</option>
                            <option value="penguji kelayakan 1">Penguji Kelayakan 1</option>
                            <option value="penguji kelayakan 2">Penguji Kelayakan 2</option>
                            <option value="penguji kelayakan 3">Penguji Kelayakan 3</option>
                            <option value="pembimbing 1">Pembimbing 1</option>
                            <option value="pembimbing 2">Pembimbing 2</option>
                            <option value="pembimbing 3">Pembimbing 3</option>
                          </select>
                      </div>
                    </div>
                    <div style="margin-top: 15px;text-align: end;">
                        <button type="button" class="btn btn-primary btn-col-navy btn-sm" onclick="addDataToTablePenugasanDosen(event);">
                            <i class="fa fa-plus loadersAction"></i> Tambah data
                        </button>
                    </div>
                </div>
                </form>
                <hr>
                <table id="__tableAddDataDosenPengujiListItems" class="table hover" style="width: 100%;">
                  <thead>
                    <tr>
                        <th>Nama Dosen</th>
                        <th>Type Penugasan</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="saveDataPenugasanDosenPenguji();">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- [END] -  Modal Penugasan Dosen Penguji  -->