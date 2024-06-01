<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="<?= base_url('/files/favicon'); ?>" type="image/x-icon" rel="icon">
<meta name="description" content="Pengisian Nilai">
<meta name="author" content="Iryanda Syamputra">
<title><?= SITE_NAME; ?></title>
<link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
<?php $lib = json_decode(SYSTEM_LIBRARIES); foreach ($lib->frontend->style as $libPath) { ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?= base_url($libPath->path); ?>">
<?php } ?>