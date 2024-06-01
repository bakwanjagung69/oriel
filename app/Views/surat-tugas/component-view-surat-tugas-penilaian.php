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
              <input type="hidden" name="rules"  value="<?= session()->get('user_logged')['rules'] ?>">
              <input type="hidden" name="mahasiswa_id"  value="<?= $mhsId; ?>">
              <input type="hidden" name="dosen_id"  value="<?= $dosenId; ?>">
              <input type="hidden" name="uji_kelayakan_id"  value="<?= $ujiKelayakanId; ?>">
              <form id="penilaianKelayakanJudulForm">
                <div class="form-group">
                    <table class="table table-bordered">
                      <tr class="text-center">
                        <td>
                          <label>Catatan uraian penilaian kelayakan</label>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <textarea name="catatan-penilaian-kelayakan" class="form-control" rows="5" <?= (!empty($catatan_penilaian_kelayakan)) ? 'disabled="disabled"' : ''; ?>><?= $catatan_penilaian_kelayakan; ?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="form-group">
                    <label>*Kesimpulan</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="kesimpulan" id="Radios1" value="1" <?= ($kesimpulan == '1') ? 'checked="checked"' : ''; ?> <?= (!empty($kesimpulan)) ? 'disabled="disabled"' : ''; ?>>
                        <label class="form-check-label" for="Radios1">
                          Layak dilanjutkan ke Seminar Proposal
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="kesimpulan" id="Radios2" value="2" <?= ($kesimpulan == '2') ? 'checked="checked"' : ''; ?> <?= (!empty($kesimpulan)) ? 'disabled="disabled"' : ''; ?>>
                        <label class="form-check-label" for="Radios2" style="width: 100%;">
                          Layak dilanjutkan ke Seminar Proposal dengan Catatan:
                          <textarea name="kesimpulan-dengan-catatan" class="form-control" rows="2" <?= (!empty($kesimpulan_dengan_catatan)) ? 'disabled="disabled"' : 'disabled="disabled"'; ?>><?= $kesimpulan_dengan_catatan; ?></textarea>
                        </label>
                      </div>
                       <div class="form-check">
                          <input class="form-check-input" type="radio" name="kesimpulan" id="Radios3" value="3" <?= ($kesimpulan == '3') ? 'checked="checked"' : ''; ?> <?= (!empty($kesimpulan)) ? 'disabled="disabled"' : ''; ?>>
                          <label class="form-check-label" for="Radios3">
                            Tidak Layak harus ganti judul/tema baru
                          </label>
                      </div>
                  </div>
                  <br>
                  <?php if ($status !== '2') { ?>
                   <div class="div-btn-action">
                      <button type="button" class="btn btn-primary btn-col-navy pull-right btn-kirim-penilaian" onclick="kirimPenilaian(event);">
                        Kirim ke Admin dan Mahasiswa
                      </button>
                    </div>
                  <?php } ?>
              </form>
            </div>
        </div>
    </div>
</div>