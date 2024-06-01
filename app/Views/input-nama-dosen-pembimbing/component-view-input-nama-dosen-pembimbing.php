<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div style="padding: 15px 0px;">
                <div class="mb-10">
                    <div class="row">
                       <div class="col-md-3">
                            <select name="semester-input-nama-dosen-pembimibing" class="form-control" onchange="semesterFilter(this, 'tableInputNamaDosenPembimbing');">
                                <option value="">--Semester--</option>
                                <?php foreach ($master_semester as $res) { ?>
                                  <option value="<?= $res->id ?>"><?= $res->angkatan.' '.$res->semester.' '.$res->dari_tahun.'/'.$res->sampai_tahun;  ?></option>
                                <?php } ?>
                            </select>
                       </div>
                   </div>
               </div>
               <br>
                   <table id="tableInputNamaDosenPembimbing" class="table dt-responsive" style="width:100%">
                      <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Judul</th>
                            <th>Update Terakhir</th>
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
</div>