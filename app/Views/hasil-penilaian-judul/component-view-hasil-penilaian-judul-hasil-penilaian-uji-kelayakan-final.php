<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;">Hasil Penilaian Kelayakan Judul</h1>
</div>
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
              <input type="hidden" name="ujiKelayakanId" value="<?= $ujiKelayakanId ?>" />
              <input type="hidden" name="mhsId" value="<?= $mhsId ?>" />
              <div class="row">
                <div class="col-md-12">
                   <div class="column-sideby-side">
                      <div Id="wrapper">
                        <section>
                          <ul class="wrapper-ul">
                            <li class="wrapper-li">
                              <img class="lazy-load-img avatar-disp" src="<?= base_url("/files/loaderImg?loader=loader-image"); ?>" data-src="<?= base_url("/files/images?q={$mahasiswa_image}"); ?>" width="180" height="180" alt="images" />
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
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label>Upload Surat Tugas & Lembar Konsultasi <small class="text-danger h6">*</small></label>
                      <div class="custom-file">
                        <input type="file" name="surat_tugas_file" class="custom-file-input-surat-tugas" id="customFileSuratTugas" accept="application/pdf">
                        <label class="custom-file-label custom-file-label-surat-tugas" for="customFileSuratTugas">Choose file</label>
                      </div>
                      <small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <ul role="list" class="list-ul list-penugasan-dosen-penguji"></ul>
                </div>
              </div>
              <hr>
              <br>
              <?php foreach ($listDataPenilaianDosenForMahasiswa as $items) { ?>
              <div class="form-group">
                  <table class="table table-bordered">
                    <tr class="text-center">
                      <td>
                        <label>Catatan uraian penilaian kelayakan</label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Hasil Penilaian Dosen <b><?= $items['dosen_name']; ?></b></label>
                        <textarea name="catatan-penilaian-kelayakan" class="form-control" rows="5" disabled="disabled"><?= $items['catatan_penilaian_kelayakan']; ?></textarea>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="form-group">
                  <label><b>*Kesimpulan</b></label>
                  <div class="keismpulan-flag" data-flag="<?= $items['kesimpulan_flag'] ?>" <?= ($items['kesimpulan_flag'] == 3) ? 'style="background-color: #FFEB3B;width: fit-content;padding: 3px 10px;"' : ''; ?>><?= $items['kesimpulan']; ?></div>
                </div>
                <?php if ($items['kesimpulan_dengan_catatan'] !== '') { ?>
                <div class="form-group">
                  <label><b>Kesimpulan Dengan Catatan:</b></label>
                  <div><?= $items['kesimpulan_dengan_catatan']; ?></div>
                </div>
                <?php } ?>
                <hr>
                <?php } ?>
            </div>
            <div class="card-footer">
              <div class="div-btn-action">
                  <button type="button" class="btn btn-primary btn-block btn-col-navy upload-surat-tugas-btn" onclick="UploadSuratTugasDosenPembimbingAndMahasiswa(event);">
                    <i class="fa fa-upload loadersAction"></i> Upload Surat Tugas
                  </button>
              </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
  .form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
  }
</style>