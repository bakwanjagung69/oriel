<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0" style="color: #0A3965; line-height:58px;"></h1>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="uji-kelayakan-tab" data-toggle="tab" href="#uji-kelayakan" role="tab" aria-controls="uji-kelayakan" aria-selected="true">Uji Kelayakan Judul</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="sup-tab" data-toggle="tab" href="#sup" role="tab" aria-controls="sup" aria-selected="false">SUP</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="skripsi-tab" data-toggle="tab" href="#skripsi" role="tab" aria-controls="skripsi" aria-selected="false">SKRIPSI</a>
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="uji-kelayakan" role="tabpanel" aria-labelledby="uji-kelayakan-tab">
                      <div style="padding: 15px 0px;">
                            <div class="mb-10">
                               <div class="row">
                                   <div class="col-md-3">
                                        <select name="semester-uji-kelayakan" class="form-control" onchange="semesterFilter(this, 'table-uji-kelayakan');">
                                            <option value="">--Semester--</option>
                                            <?php foreach ($master_semester as $res) { ?>
                                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                           <br>
                           <table id="table-uji-kelayakan" class="table dt-responsive hover" style="width:100%">
                                <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>NIM</th>
                                      <th>Judul</th>
                                      <th>Tanggal</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                       </div>
                  </div>
                  <div class="tab-pane" id="sup" role="tabpanel" aria-labelledby="sup-tab">
                    <div style="padding: 15px 0px;">
                        <div style="padding: 15px 0px;">
                            <div class="mb-10">
                               <div class="row">
                                   <div class="col-md-3">
                                        <select name="semester-sup" class="form-control" onchange="semesterFilter(this, 'table-sup');">
                                            <option value="">--Semester--</option>
                                            <?php foreach ($master_semester as $res) { ?>
                                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                           <br>
                           <table id="table-sup" class="table dt-responsive hover" style="width:100%">
                                <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>NIM</th>
                                      <th>Judul</th>
                                      <th>Tanggal</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                       </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
                      <div style="padding: 15px 0px;">
                          <div style="padding: 15px 0px;">
                            <div class="mb-10">
                               <div class="row">
                                   <div class="col-md-3">
                                        <select name="semester-skripsi" class="form-control" onchange="semesterFilter(this, 'table-skripsi');">
                                            <option value="">--Semester--</option>
                                            <?php foreach ($master_semester as $res) { ?>
                                              <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                            <?php } ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                           <br>
                           <table id="table-skripsi" class="table dt-responsive hover" style="width:100%">
                                <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>NIM</th>
                                      <th>Judul</th>
                                      <th>Tanggal</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                      <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                       </div>
                      </div>
                  </div>
                </div>
                <!-- [END] - Nav tabs -->
            </div>
        </div>
    </div>
</div>