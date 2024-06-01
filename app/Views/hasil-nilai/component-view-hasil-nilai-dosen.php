<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;">INSTRUMENT PENILAIAN SUP</h1>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header">
              <div class="btn-save">
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.go(-1); return false;">
                  <i class="fa fa-reply"></i> Kembali
                </button>
              </div>
            </div>
            <div class="card-body">
              <form>
                <input type="hidden" name="dosenId" value="<?= $data['dosen_id']; ?>">
                <input type="hidden" name="jadwalId" value="<?= $data['input_jadwal_id']; ?>">
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
                                  <p id="p1"><?= $data['dosen_name']; ?></p>
                                  <p id="p2">
                                    <?php 
                                      if ($data['dosen_rules'] == 1) {
                                        echo "Administrator";
                                      } else if ($data['dosen_rules'] == 2) {
                                        echo "Admin";
                                      } else if ($data['dosen_rules'] == 3) {
                                        echo "Dosen";
                                      } else if ($data['dosen_rules'] == 4) {
                                        echo "Kaprodi";
                                      } else if ($data['dosen_rules'] == 5) {
                                        echo "Mahasiswa";
                                      }
                                    ?>    
                                  </p>
                                </div>
                              </li>
                            </ul>
                          </section>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-2" style="display: flex;justify-content: center;">
                    <div class="borders">
                      <div class="title-total-nilai">Total Nilai</div>
                      <div class="disp-grade"><?= $data['total_nilai_akhir']->nilai_akhir_nu; ?></div>
                    </div>
                  </div>
                </div>
                <hr>
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
                  <div class="total-score">
                    <span>SCORE : </span> <?= $data['total_nilai_akhir']->total_nilai_value; ?>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
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
                                  <?= $data['instrument_data'][0]->element_value ?>
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
                                  <?= $data['instrument_data'][1]->element_value ?>
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
                                  <?= $data['instrument_data'][2]->element_value ?>
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
                                  <?= $data['instrument_data'][3]->element_value ?>
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
                                  <?= $data['instrument_data'][4]->element_value ?>
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
                                  <?= $data['instrument_data'][5]->element_value ?>
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
                                  <?= $data['instrument_data'][6]->element_value ?>
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
                                  <?= $data['instrument_data'][7]->element_value ?>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="text-right" colspan="2">Total Score (<?= $data['total_nilai_akhir']->total_all_instrument_iput ?>/10)</th>
                            <td>
                              <div class="form-group-disabled">
                                <div class="total-score-disp text-center">
                                  <?= $data['total_nilai_akhir']->total_nilai_value ?>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <hr>
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
                                <div class="text-left">
                                  <div><?= $data['catatan']; ?></div>
                                </div>
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
                              <div class="text-left">
                                <div><?= $data['kesimpulan']; ?></div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
