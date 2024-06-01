<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= SITE_NAME; ?></title>
<link href="<?= base_url('/files/favicon'); ?>" type="image/x-icon" rel="icon">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php $lib = json_decode(SYSTEM_LIBRARIES); foreach ($lib->cms->js as $libPath) { ?>
	<?php
		$arr = explode('/', $libPath->path); 
	    $fileName = $arr[count($arr)-1];
	?>
	<?php if ($fileName !== 'lib.config.js') { ?>
  		<script src="<?= base_url($libPath->path); ?>"></script>	
	<?php } else { ?>
		<script src="<?= base_url('files/libs?f='.rawurlencode(base64_encode($libPath->path))); ?>"></script>	
	<?php } ?>
<?php } ?>
<?php $lib = json_decode(SYSTEM_LIBRARIES); foreach ($lib->cms->style as $libPath) { ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?= base_url($libPath->path); ?>">
<?php } ?>