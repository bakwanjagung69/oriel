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
                <input type="hidden" name="dosenId" value="<?= $data['dosen_id']; ?>">
                <input type="hidden" name="input_nilai_id" value="<?= $data['input_nilai_id']; ?>">
                <input type="hidden" name="mahasiswaId" value="<?= $data['mahasiswa_id']; ?>">
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
                <div class="row">
                  <div class="col-md-12">
                    <form id="formIsiNilai">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Komponent</th>
                            <th scope="col" class="text-center">Bobot (B)</th>
                            <th scope="col">Nilai (N)</th>
                            <th scope="col">Nilai x Bobot</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row" class="text-center">1</th>
                            <td>Struktur/logika penulisan</td>
                            <td class="text-center">1</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="truktur_logika_penulisan" data-bobot="1" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                 <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-truktur_logika_penulisan" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">2</th>
                            <td>Kedalaman dan keluasan teori keilmuan yang relevan</td>
                            <td class="text-center">1,5</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="kediaman_dan_keluasan" data-bobot="1.5" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1,5 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-kediaman_dan_keluasan" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">3</th>
                            <td>Relevansi teori dengan masalah</td>
                            <td class="text-center">1</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="relevansi_teori" data-bobot="1" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                 <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-relevansi_teori" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">4</th>
                            <td>Argumentasi teoritis dalam penyusunan kerangka berfikir</td>
                            <td class="text-center">1,5</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="argumentasi_teoritis" data-bobot="1.5" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1,5 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-argumentasi_teoritis" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">5</th>
                            <td>Teknik pengumpulan/keabsahan instrument analisis data</td>
                            <td class="text-center">2</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="teknik_pengumpulan" data-bobot="2" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 2 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-teknik_pengumpulan" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">6</th>
                            <td>Orisinalitas</td>
                            <td class="text-center">1</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="orisinalitas" data-bobot="1" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-orisinalitas" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">7</th>
                            <td>Pembatasan & penjabaran /penarikan kesimpulan/rincian saran</td>
                            <td class="text-center">1</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="pembatasan_penjabaran" data-bobot="1" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-pembatasan_penjabaran" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-center">8</th>
                            <td>Penyajian dan bahasa</td>
                            <td class="text-center">1</td>
                            <td>
                              <div class="form-group-disabled">
                                <input type="text" name="penyajian_dan_bahasa" data-bobot="1" class="form-control only-number text-center sum-input" placeholder="">
                              </div>
                            </td>
                            <td>
                              <div class="form-group-disabled">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                      X 1 = 
                                    </span>
                                  </div>
                                  <input type="text" name="nilaiXbobot-penyajian_dan_bahasa" class="form-control text-center disp-final-val" aria-describedby="basic-addon1" readonly="readonly">
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <hr>
                      <div class="total-nilai-ujian-NU">
                        <div class="total-nilai-ujian-NU-child">
                          <div class="total-nilai-ujian-NU-child-title">NILAI UJIAN (NU)</div>
                          <div class="ml-4">
                            <div class="text-size-18 sum-value-nilaiXbobot text-center">0</div>
                            <div class="divider"></div>
                            <div class="text-size-18 text-center">10</div>
                          </div>
                          <div class="equal-sparator">=</div>
                          <div class="total-nilai-fix">-</div>
                        </div>
                      </div>
                      <br><br>
                      <div class="catatan-section">
                        <div class="form-group">
                          <label>*Catatan perbaikan dari dosen penguji/pembimbing</label>
                          <input type="text" name="catatan" class="form-control">
                        </div>
                      </div>
                      <div class="kesimpulan-section">
                        <div class="form-group">
                          <label>*Kesimpulan</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="kesimpulan" id="Radios1" value="Mengulang ujian pada tanggal yang di tentukan" checked="checked">
                              <label class="form-check-label" for="Radios1">
                                Mengulang ujian pada tanggal yang di tentukan
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="kesimpulan" id="Radios2" value="Memperbaiki skripsi sampai tanggal yang di tentukan">
                              <label class="form-check-label" for="Radios2">
                                Memperbaiki skripsi sampai tanggal yang di tentukan
                              </label>
                            </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="div-btn-action">
                              <button type="button" class="btn btn-primary btn-block btn-col-navy" onclick="simpanNilaiSKripsi(event);">
                                Simpan Nilai
                              </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
