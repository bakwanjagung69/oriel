<!-- Page Heading -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
              <input type="hidden" name="rules"  value="<?= session()->get('user_logged')['rules'] ?>">
               <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="uji-kelayakan-tab" data-toggle="tab" href="#uji-kelayakan" role="tab" aria-controls="uji-kelayakan" aria-selected="true">Uji Kelayakan Judul</a>
                  </li>
                  <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4', '5'])) { ?>
                  <li class="nav-item">
                    <a class="nav-link" id="bimbingan-tab" data-toggle="tab" href="#bimbingan" role="tab" aria-controls="bimbingan" aria-selected="false">Bimbingan</a>
                  </li>
                  <?php } ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="uji-kelayakan" role="tabpanel" aria-labelledby="uji-kelayakan-tab">
                      <div style="padding: 15px 0px;">
                          <div class="mb-10">
                                <div class="row">
                                   <div class="col-md-3">
                                        <select name="semester-surat-tugas" class="form-control" onchange="semesterFilter(this, 'tableSuratTugas');">
                                            <option value="">--Semester--</option>
                                            <?php foreach ($master_semester as $res) { ?>
                                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                           <br>
                           <table id="tableSuratTugas" class="table dt-responsive" style="width:100%">
                              <thead>
                                  <tr>
                                    <th>No</th>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4'])) { ?>
                                      <th>Nama Mahasiswa</th>
                                    <?php } ?>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['5'])) { ?>
                                      <th>Nama</th>
                                    <?php } ?>
                                    <th>NIM</th>
                                    <th>Judul</th>
                                    <th>Update Terakhir</th>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4'])) { ?>
                                      <th>Proposal</th>
                                    <?php } ?>
                                    <th>Surat Tugas</th>
                                    <th>Status</th>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4'])) { ?>
                                      <th>Action</th>
                                    <?php } ?>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['5'])) { ?>
                                      <th>Action</th>
                                    <?php } ?>
                                    <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                       </div>
                  </div>
                  <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4', '5'])) { ?>
                  <div class="tab-pane" id="bimbingan" role="tabpanel" aria-labelledby="bimbingan-tab">
                    <div style="padding: 15px 0px;">
                        <div style="padding: 15px 0px;">
                          <div class="mb-10">
                                <div class="row">
                                   <div class="col-md-3">
                                        <select name="semester-surat-tugas-bimbingan" class="form-control" onchange="semesterFilter(this, 'tableSuratTugasPembimbing');">
                                            <option value="">--Semester--</option>
                                            <?php foreach ($master_semester as $res) { ?>
                                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                          <br>
                          <table id="tableSuratTugasPembimbing" class="table dt-responsive" style="width:100%">
                              <thead>
                                  <tr>
                                    <th>No</th>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['3', '4'])) { ?>
                                      <th>Nama Mahasiswa</th>
                                    <?php } ?>
                                    <?php if (in_array(session()->get('user_logged')['rules'], ['5'])) { ?>
                                      <th>Nama</th>
                                    <?php } ?>
                                    <th>NIM</th>
                                    <th>Judul</th>
                                    <th>Update Terakhir</th>
                                    <th>Surat Tugas</th>
                                    <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                       </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <!-- [END] - Nav tabs -->
            </div>
        </div>
    </div>
</div>