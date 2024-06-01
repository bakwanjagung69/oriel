<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;">Formulir Pendaftaran</h1>
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
                          <button class="btn btn-outline-secondary" type="button" onclick='openfile("<?= base_url("/files/document?q={$data['files']}"); ?>")'>Buka File</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal & Waktu</label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                          </span>
                        </div>
                        <input type="text" name="tanggalAndWaktu" class="form-control" aria-label="tanggalAndWaktu" placeholder="" aria-describedby="basic-addon1">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="header-list-dosen">
                  <div class="label-list-dosen">
                    <div class="sub-1">Dosen Penguji</div>
                    <div class="sub-2">Nama - nama dosen penguji anda.</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul role="list" class="list-ul list-penugasan-dosen-penguji"></ul>
                    <div class="div-btn-action">
                      <?php if (session()->get('user_logged')['rules'] == '2') { ?>
                        <button type="button" class="btn btn-primary btn-block btn-col-navy" onclick="kirimJadwalSidang(event);">
                          Kirim Jadwal Sidang
                        </button>
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