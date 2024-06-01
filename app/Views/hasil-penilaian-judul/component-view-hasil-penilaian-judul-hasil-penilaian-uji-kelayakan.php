<div class="row">
    <input type="hidden" name="ujiKelayakanId" value="<?= $ujiKelayakanId ?>" />
    <input type="hidden" name="mhsId" value="<?= $mhsId ?>" />
    <input type="hidden" name="status" value="<?= $status ?>" />
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
              <?php if (!empty($listDataPenilaianDosenForMahasiswa)) { ?>
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
                  <div class="keismpulan-flag" data-flag="<?= ($items['kesimpulan_flag'] == 3) ? 1 : 0; ?>" <?= ($items['kesimpulan_flag'] == 3) ? 'style="background-color: #FFEB3B;width: fit-content;padding: 3px 10px;"' : ''; ?>><?= $items['kesimpulan']; ?></div>
                </div>
                <?php if ($items['kesimpulan_dengan_catatan'] !== '') { ?>
                <div class="form-group">
                  <label><b>Kesimpulan Dengan Catatan:</b></label>
                  <div><?= $items['kesimpulan_dengan_catatan']; ?></div>
                </div>
                <?php } ?>
                <hr>
                <?php } ?>
                <?php } else { ?>
                  <div class="empty-data">
                    <div class="alert alert-info" role="alert">
                      Belum ada hasil penilaian.
                    </div>
                  </div>
                <?php } ?>
                <?php if (in_array(session()->get('user_logged')['rules'], ['2']) && $status == '4') { ?>
                  <div class="div-btn-action">
                    <button type="button" class="btn btn-primary btn-col-navy pull-right btn-approve" onclick="approveKeFormKirimSuratTugasKelayakanJudul(event, '<?= $mhsId ?>', '<?= $ujiKelayakanId ?>');">
                      Approve
                    </button>
                    <button type="button" class="btn btn-danger pull-right btn-not-approve" onclick="notApproveDataHasilPenilaianKelayakanJudul(event, '<?= $mhsId ?>', '<?= $ujiKelayakanId ?>');" style="margin-right: 10px;">
                      Not Approve
                    </button>
                  </div>
                <?php } ?>
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