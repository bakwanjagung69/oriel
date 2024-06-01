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
                <input type="hidden" name="supId" value="<?= $data['sup_id']; ?>">
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
                        <input type="text" name="jenis_ujian" class="form-control" placeholder="" readonly="readonly" value="Uji SUP">
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Laporan</label>
                      <div class="input-group mb-3">
                        <input type="text" name="laporan_file" class="form-control" placeholder="" readonly="readonly" value="<?= $data['proposal_files_name']; ?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick='openfile("<?= base_url("/files/document?q={$data['proposal_files']}"); ?>&mode=view")'>Buka File</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Surat Tugas & Lembar Konsultasi</label>
                      <div class="input-group mb-3">
                        <input type="text" name="surat_tugas_file" class="form-control" placeholder="" readonly="readonly" value="<?= $data['lembar_tugas_or_konsultasi_files_name']; ?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick='openfile("<?= base_url("/files/document?q={$data['lembar_tugas_or_konsultasi_files']}"); ?>&mode=view")'>Buka File</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="header-list-dosen">
                  <div class="label-list-dosen">
                    <div class="sub-1">Dosen Pembimbing</div>
                    <div class="sub-2">Nama - nama dosen pembimbing <b><?= $data['nama']; ?> [<?= $data['nim']; ?>]</b>.</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="list-dospem">
                      <ul role="list" class="list-ul list-penugasan-dosen-pembimbing">
                        <?php foreach ($data['dosenData'] as $item) { ?>
                        <li class="list-li-dosen">
                          <div class="parent-section-list-dosen">
                            <div class="section-list-item">
                              <div>
                                <img class="lazy-load-img avatar-disp" src="<?= base_url("/files/loaderImg?loader=loader-image"); ?>" data-src="<?= base_url("/files/images?q={$item['dosen_picture']}"); ?>" width="60" height="60" alt="images" />
                              </div>
                              <div class="section-list-item-name"><?= $item['dosen_name'] ?></div>
                            </div>
                            <div class="section-list-item-jabatan"><?= $item['type_penugasan'] ?></div>
                          </div>
                        </li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="header-list-dosen">
                  <div class="label-list-dosen">
                    <div class="sub-1">Dosen Penguji</div>
                    <div class="sub-2">Nama - nama dosen penguji</div>
                  </div>
                   <?php if (session()->get('user_logged')['rules'] == '4') { ?>
                      <div class="div-btn-penugasan-dosen">
                          <button type="button" class="btn btn-primary btn-col-navy" onclick="addPenugasanDosenPenguji(event);">
                            Tambah Penugasan Dosen
                          </button>
                      </div>
                    <?php } ?>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul role="list" class="list-ul list-penugasan-dosen-penguji"></ul>
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
                            <option value="dosen ahli">Dosen Ahli</option>
                            <option value="penguji luar">Penguji Luar</option>
                            <option value="anggota">Anggota</option>
                            <option value="pembimbing 1">Pembimbing 1</option>
                            <option value="pembimbing 2">Pembimbing 2</option>
                            <option value="penguji kelayakan 1">Penguji Kelayakan 1</option>
                            <option value="penguji kelayakan 2">Penguji Kelayakan 2</option>
                            <option value="penguji kelayakan 3">Penguji Kelayakan 3</option>
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