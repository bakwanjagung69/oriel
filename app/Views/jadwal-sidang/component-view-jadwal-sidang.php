<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="sup-tab" data-toggle="tab" href="#sup" role="tab" aria-controls="sup" aria-selected="false">SUP</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="skripsi-tab" data-toggle="tab" href="#skripsi" role="tab" aria-controls="skripsi" aria-selected="false">SKRIPSI</a>
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="sup" role="tabpanel" aria-labelledby="sup-tab">
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
                        <div style="padding: 15px 0px;" class="table-responsive">
                           <table id="table-sup" class="table table-bordered hover" style="width:100%">
                                <thead style="font-size: 13px;">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">NO. REG</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Waktu Pelaksanaan Seminar</th>
                                        <th colspan="4" class="text-center">DEWAN PENGUJI</th>
                                        <th rowspan="2">DOSEN LUAR</th>
                                        <th rowspan="2">JUDUL MAKALAH</th>
                                        <th rowspan="2">KET</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                      <th>KETUA</th>
                                      <th>ANGGOTA</th>
                                      <th>PEMBIMBING 1</th>
                                      <th>PEMBIMBING 2</th>
                                      <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px;"></tbody>
                            </table>
                       </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="skripsi" role="tabpanel" aria-labelledby="skripsi-tab">
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
                          <div style="padding: 15px 0px;" class="table-responsive">
                            <table id="table-skripsi" class="table table-bordered hover" style="width:100%">
                                <thead style="font-size: 13px;">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">NO. REG</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Waktu Pelaksanaan Seminar</th>
                                        <th colspan="4" class="text-center">PENGUJI</th>
                                        <th rowspan="2">PENGUJI LUAR</th>
                                        <th rowspan="2">DOSEN AHLI</th>
                                        <th rowspan="2">JUDUL SKRIPSI</th>
                                        <th rowspan="2">KET</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                      <th>KETUA</th>
                                      <th>SEKRETARIS</th>
                                      <th>PEMBIMBING 1</th>
                                      <th>PEMBIMBING 2</th>
                                      <!-- <th class="none expanded-row"></th> --> <!-- uncomment if table use expand row -->
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px;"></tbody>
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