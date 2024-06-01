<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data-Jadwal-Sidang-SUP-".date("Y-m-d").".xls");
	header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Export To Xls</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<!-- <div class="headers" style="margin: auto;width: 50%;padding: 15px 15px;">
				<div>
					<table>
						<tr>
							<td style="padding-right: 30px;">
								<img src="<#?= base_url('assets/frontend/system/logo.png'); ?>" width="100" height="110" class="rounded lazy-load-img-avatar" alt="image-logo">
							</td>
							<td>
								<div style="text-align: center;">
									<div style="text-align: center;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
									<div style="text-align: center;">RISTEK DAN TEKNOLOGI</div>
									<div style="text-align: center;">UNIVERSITAS NEGERI JAKARTA</div>
									<div style="text-align: center;">FAKULTAS TEKNIK</div>
									<div style="text-align: center;">Gedung L1 Kampus A Universitas Negeri Jakarta, Jalan Rawamangun Muka, Jakarta 13220</div>
									<div style="text-align: center;">Telepon : (021) 4751523 Laman: ft@unj.ac.id </div>
									<div style="text-align: center;">Email: elektro.unj1@gmail.com / teknik_elektro@unj.ac.id / elektrounj@unj.ac.id</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div> -->
			<div class="body-content">
				<div>
					<table class="table" border="1">
						<thead style="font-size: 13px;">
							<tr>
	                            <th rowspan="2" class="text-center">NO</th>
	                            <th rowspan="2">NO. REG</th>
	                            <th rowspan="2">NAMA</th>
	                            <th rowspan="2">WAKTU PELAKSANAAN SEMINAR</th>
	                            <th colspan="4" class="text-center">DEWAN PENGUJI</th>
	                            <th rowspan="2">DOSEN LUAR</th>
	                            <th rowspan="2">JUDUL MAKALAH</th>
	                            <th rowspan="2">KET</th>
	                        </tr>
	                        <tr>
	                          <th>KETUA</th>
	                          <th>ANGGOTA</th>
	                          <th>PEMBIMBING 1</th>
	                          <th>PEMBIMBING 2</th>
	                        </tr>
						</thead>
						<tbody>
							<?php for ($i = 0; $i < count($data); ++$i) { ?>
								<td class="text-center"><?= ($i + 1); ?></td>
								<td class="text-center"><?= $data[$i]['nim']; ?></td>
								<td class="text-center"><?= $data[$i]['nama']; ?></td>
								<td class="text-center">
									<div><?= $data[$i]['disp_hari_idn']; ?></div>
									<div><?= $data[$i]['tanggal']; ?></div>
									<div><?= $data[$i]['waktu_mulai']; ?> - <?= $data[$i]['waktu_akhir']; ?> WIB</div>
									<div><?= $data[$i]['tempat']; ?></div>
								</td>
								<td class="text-center">
									<?php foreach ($data[$i]['dospemSUPData'] as $item) { ?>
										<?php if ($item['type_penugasan'] == 'ketua') { ?>
											<div><?= ucfirst($item['dosen_name']); ?></div>
										<?php } ?>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php foreach ($data[$i]['dospemSUPData'] as $item) { ?>
										<?php if ($item['type_penugasan'] == 'anggota') { ?>
											<div><?= ucfirst($item['dosen_name']); ?></div>
										<?php } ?>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php foreach ($data[$i]['dospemUjiKelatakanData'] as $item) { ?>
										<?php if ($item['type_penugasan'] == 'pembimbing 1') { ?>
											<div><?= ucfirst($item['dosen_name']); ?></div>
										<?php } ?>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php foreach ($data[$i]['dospemUjiKelatakanData'] as $item) { ?>
										<?php if ($item['type_penugasan'] == 'pembimbing 2') { ?>
											<div><?= ucfirst($item['dosen_name']); ?></div>
										<?php } ?>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php foreach ($data[$i]['dospemSUPData'] as $item) { ?>
										<?php if ($item['type_penugasan'] == 'penguji luar') { ?>
											<div><?= ucfirst($item['dosen_name']); ?></div>
										<?php } ?>
									<?php } ?>
								</td>
								<td class="text-center"><?= ucfirst($data[$i]['judul']); ?></td>
								<td class="text-center"><?= $data[$i]['keterangan']; ?></td>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<style>
	.text-center {
		text-align: center;
	}

	.font-12 {
		font-size: 12px;
	}

	.headers {
	    margin: auto;
	    width: 50%;
	    padding: 15px 15px;
	}

	.body-content {
		margin-top: 10px;
	}

	.table {
	  font-family: arial, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	}

	.table td, th {
	  border: 1px solid #dddddd;
	  padding: 8px;
	}

	tr:nth-child(even) {
/*	  background-color: #dddddd;*/
	}
</style>