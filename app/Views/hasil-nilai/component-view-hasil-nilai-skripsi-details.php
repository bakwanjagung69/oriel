<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;">INSTRUMENT PENILAIAN SKRIPSI</h1>
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
                <input type="hidden" name="formulir_skripsi_id" value="<?= $data['formulir_skripsi_id']; ?>">
                <input type="hidden" name="jadwalInputNilaiId" value="<?= $data['jadwalInputNilaiId']; ?>">
                <input type="hidden" name="mahasiswaId" value="<?= $data['mahasiswa_id']; ?>">
                <input type="hidden" name="prefixData" value="<?= $data['prefix_data']; ?>">
                <div class="row">
                  <div class="col-md-10">
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
                  <?php if (in_array(session()->get('user_logged')['rules'], ['3'])) { ?>
                  <div class="col-md-2" style="display: flex;justify-content: center;">
                    <div class="borders">
                      <div class="title-total-nilai">Total Nilai</div>
                      <div class="disp-grade"><?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][8]['nilai_akhir_nu']; ?></div>
                    </div>
                  </div>
                  <?php } ?>
                 <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4', '5'])) { ?>
                  <div class="col-md-2" style="display: flex;justify-content: center;">
                    <div class="borders" style="border-color: #acadb3">
                      <div class="title-total-nilai">Total Nilai</div>
                      <div class="disp-grade" style="color: #000;"><?= $data['resultGradeAndCatatanKesimpulan']['resultGrade']; ?></div>
                    </div>
                  </div>
                  <?php } ?>
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
                        <input type="text" name="laporan_file" class="form-control" placeholder="" readonly="readonly" value="<?= $data['skripsi_files_name']; ?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick='openfile("<?= base_url("/files/document?q={$data['skripsi_files']}"); ?>&mode=view")'>Buka File</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" placeholder="" value="<?= $data['tempat']; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                              </span>
                            </div>
                            <input type="text" name="tanggal" class="form-control" aria-label="tanggal" placeholder="" value="<?= $data['tanggal']; ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fa fa-clock" aria-hidden="true"></i>
                              </span>
                            </div>
                            <input type="text" name="waktuMulai" class="form-control" aria-label="waktuMulai" placeholder="" aria-describedby="basic-addon1" readonly value="<?= $data['waktu_mulai']; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Waktu Akhir</label>
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fa fa-clock" aria-hidden="true"></i>
                              </span>
                            </div>
                            <input type="text" name="waktuAkhir" class="form-control" aria-label="waktuAkhir" placeholder="" aria-describedby="basic-addon1" readonly value="<?= $data['waktu_akhir']; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
               <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="instument-penilaian-tab" data-toggle="tab" href="#instument-penilaian" role="tab" aria-controls="instument-penilaian" aria-selected="false">Instrument Penilaian</a>
                  </li>
                  <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4'])) { ?>
                  <li class="nav-item">
                    <a class="nav-link" id="detail-dosen-tab" data-toggle="tab" href="#detail-dosen" role="tab" aria-controls="detail-dosen" aria-selected="false">Details Dosen</a>
                  </li>
                  <?php } ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="instument-penilaian" role="tabpanel" aria-labelledby="instument-penilaian-tab">
                    <div style="padding: 15px 0px;">
                      <div class="text-center">
                        <div class="label-list-dosen">
                          <div class="sub-1">Keterangan Nilai</div>
                          <div class="sub-2"></div>
                        </div>
                      </div>
                        <div class="section-info-nilai">
                          <div class="section-info-nilai-child">
                            <div class="row">
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">A</span> :86-100
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">A-</span> :81-85
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">B+</span> :76-80
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">B</span> :71-75
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">B-</span> :66-70
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">C+</span> :61-65
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">C</span> :56-60
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">C-</span> :51-55
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">D+</span> :50-46
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">D</span> :45-41
                              </div>
                              <div class="col-md-2 divider-right-padding">
                                <span class="info-nilai-disp">E</span> :40-0
                              </div>
                            </div>
                          </div>
                        </div>
                      <br>
                      <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4'])) { ?>
                      <div class="total-score">
                        <span>SCORE : </span> <?= $data['resultGradeAndCatatanKesimpulan']['resultScore']; ?>
                      </div>
                      <br>
                      <?php } ?>
                      <div class="row">
                        <div class="col-md-12">
                          <?php if (in_array(session()->get('user_logged')['rules'], ['3'])) { ?>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" class="text-center">Score</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row" class="text-center">1</th>
                                <td>Tata Tulis Laporan</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="tata_tulis_laporan text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][0]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">2</th>
                                <td>Kedalaman dan keluasan teori keilmuan yang relevan</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="kediaman_dan_keluasan text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][1]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">3</th>
                                <td>Relevansi teori dengan masalah</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="relevansi_teori text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][2]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">4</th>
                                <td>Argumentasi teoritis dalam penyusunan kerangka berfikir</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="argumentasi_teoritis text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][3]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">5</th>
                                <td>Instrumen penelitian</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="argumentasi_teoritis text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][4]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">6</th>
                                <td>Orisinalitas</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="orisinalitas text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][5]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">7</th>
                                <td>Penguasaan proposal penelitian</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="penugasaan_proposal_penelitian text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][6]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-center">8</th>
                                <td>Penyajian Materi Dan Pengunaan bahasa pada saat seminar</td>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="penyajian_materi_penggunaan_bahasa text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][7]['element_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row" class="text-right" colspan="2">Total Score</th>
                                <td>
                                  <div class="form-group-disabled">
                                    <div class="total-score-disp text-center">
                                      <?= $data['resultGradeAndCatatanKesimpulan']['instrumentData'][8]['total_nilai_value']; ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <hr>
                          <?php } ?>
                          <div class="catatn-perbaikan-dosen">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col" class="text-left">Catatan Perbaikan dari dosen penguji/pembimbing</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="text-center">
                                   <?php if (in_array(session()->get('user_logged')['rules'], ['3'])) { ?>
                                      <div class="text-left" style="border-bottom: 1px solid #cecece;">
                                          <div><b>Nama Dosen :</b> <span><?= $data['resultGradeAndCatatanKesimpulan']['dosenNamePerDosen']; ?></span></div>
                                          <div><?= $data['resultGradeAndCatatanKesimpulan']['catatanPerDosen']; ?></div>
                                      </div>
                                    <?php } ?>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4', '5'])) { ?>
                                       <?php if (count($data['resultGradeAndCatatanKesimpulan']['catatanAndKesimpulan']) !== '') { ?>
                                        <?php foreach ($data['resultGradeAndCatatanKesimpulan']['catatanAndKesimpulan'] as $value) { ?>
                                          <div class="text-left" style="border-bottom: 1px solid #cecece;">
                                            <div><b>Nama Dosen :</b> <span><?= $value['catatan']['dosenName']; ?></span></div>
                                            <div><?= $value['catatan']['text']; ?></div>
                                          </div>
                                        <?php } ?>
                                      <?php } else { ?>
                                        <span>-</span>
                                      <?php } ?>
                                    <?php } ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <br>
                          <div class="kesimpulan-section">
                            <div class="form-group">
                              <label style="font-weight: 700;">*Kesimpulan</label>
                                <div class="kesimpulan">
                                  <?php if (in_array(session()->get('user_logged')['rules'], ['3'])) { ?>
                                     <div class="text-left" style="border-bottom: 1px solid #cecece;">
                                        <div><b>Nama Dosen :</b> <span><?= $data['resultGradeAndCatatanKesimpulan']['dosenNamePerDosen']; ?></span></div>
                                        <div><?= $data['resultGradeAndCatatanKesimpulan']['kesimpulanPerDosen']; ?></div>
                                      </div>
                                  <?php } ?>
                                  <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4', '5'])) { ?>
                                      <?php if (count($data['resultGradeAndCatatanKesimpulan']['catatanAndKesimpulan']) !== '') { ?>
                                      <?php foreach ($data['resultGradeAndCatatanKesimpulan']['catatanAndKesimpulan'] as $value) { ?>
                                        <div class="text-left" style="border-bottom: 1px solid #cecece;">
                                          <div><b>Nama Dosen :</b> <span><?= $value['kesimpulan']['dosenName']; ?></span></div>
                                          <div><?= $value['kesimpulan']['text']; ?></div>
                                        </div>
                                      <?php } ?>
                                    <?php } else { ?>
                                      <span>-</span>
                                    <?php } ?>
                                  <?php } ?>
                                </div>
                            </div>
                          </div>
                          <br>
                          <?php if (in_array(session()->get('user_logged')['rules'], ['5'])) { ?>
                          <div class="btn-print pull-right">
                            <button type="button" class="btn btn-primary btn-col-navy" onclick="printDokument(event);">
                              <i class="fa fa-print" aria-hidden="true"></i> 
                              Cetak Dokument
                            </button>
                          </div>
                           <?php } ?>
                           <?php if (in_array(session()->get('user_logged')['rules'], ['3'])) { ?>
                             <div class="btn-print pull-right">
                                <button type="button" class="btn btn-primary btn-col-navy" onclick="editInputNilaiSkripsi(event);">
                                  <i class="fa fa-pencil" aria-hidden="true"></i> 
                                  Edit Input Nilai
                              </button>
                            </div>
                           <?php } ?>
                           <?php if (in_array(session()->get('user_logged')['rules'], ['2'])) { ?>
                             <div class="btn-print pull-right">
                                <button type="button" class="btn btn-primary btn-col-navy" onclick="printDokument(event);">
                                  <i class="fa fa-print" aria-hidden="true"></i> 
                                  Cetak Hasil Nilai
                              </button>
                            </div>
                           <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if (in_array(session()->get('user_logged')['rules'], ['1', '2', '4'])) { ?>
                  <div class="tab-pane" id="detail-dosen" role="tabpanel" aria-labelledby="detail-dosen-tab">
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
                            <li class="list-li-dospem" onclick="viewsDataNilaiPerDosen('<?= $item['dosen_id'] ?>');">
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
                    <div style="padding: 15px 0px;">
                      <ul role="list" class="list-ul list-penugasan-dosen-penguji"></ul>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
