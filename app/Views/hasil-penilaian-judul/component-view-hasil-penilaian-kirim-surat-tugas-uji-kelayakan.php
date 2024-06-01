<!-- Page Heading -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
               <button type="button" class="btn btn-outline-secondary" onclick="Back();">
                  <i class="fa fa-reply"></i> Kembali
                </button>
            </div>
            <div class="card-body">
               <div class="row">
                <input type="hidden" name="mhsId" value="<?= $mhsId; ?>">
                <input type="hidden" name="ujiKelayakanId" value="<?= $ujiKelayakanId; ?>">
                  <div class="col-md-12">
                     <div class="column-sideby-side">
                        <div Id="wrapper">
                          <section>
                            <ul class="wrapper-ul">
                              <li class="wrapper-li">
                                <img class="lazy-load-img avatar-disp" src="<?= base_url("/files/loaderImg?loader=loader-image"); ?>" data-src="<?= base_url("/files/images?q={$mahasiswa_images}"); ?>" width="180" height="180" alt="images" />
                                <div class="details">
                                  <p id="p1"><?= $mahasiswa_name; ?></p>
                                  <p id="p2"><?= $mahasiswa_nim; ?></p>
                                </div>
                              </li>
                            </ul>
                          </section>
                        </div>
                      </div>
                  </div>
                </div>
                <form id="formKirimSuratKelayakanJudul">
                  <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                        <label>Judul <small class="text-danger h6">*</small></label>
                        <input type="text" name="judul" class="form-control" value="<?= $mahasiswa_judul; ?>">
                      </div>
                    </div>
                  </div>
                   <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Surat Tugas Kelayakan Judul <small class="text-danger h6">*</small></label>
                          <div class="custom-file">
                            <input type="file" name="surat_tugas_kelayakan_judul" class="custom-file-input-surat-tugas-kelayakan-judul" id="customFileSuratTugasKelayakanJudul" accept="application/pdf">
                            <label class="custom-file-label custom-file-label-surat-tugas-kelayakan-judul" for="customFileSuratTugasKelayakanJudul">Choose file</label>
                          </div>
                          <small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="div-btn-action">
                          <button type="button" class="btn btn-primary btn-block btn-col-navy upload-surat-kelayakan-judul" onclick="kirimDataPenilaianUjiKelayakanJudulToKaprodi(event);">
                            Kirim Ke Kaprodi
                          </button>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>