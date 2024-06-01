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
                        <input type="text" name="tempat" class="form-control" placeholder="" value="<?= $data['tempat']; ?>" readonly="readonly">
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
                        <input type="text" name="tanggalAndWaktu" class="form-control" value="<?= $data['tanggal_dan_waktu']; ?>" readonly="readonly" aria-label="tanggalAndWaktu" placeholder="" aria-describedby="basic-addon1" disabled>
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
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>