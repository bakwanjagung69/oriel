<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?= date('Y',strtotime("-1 year", strtotime(date('Y')))); ?>-<?= date('Y'); ?> <a href="<?= base_url(); ?>"><?= SITE_NAME; ?></span>
        </div>
    </div>
</footer>
<?php $lib = json_decode(SYSTEM_LIBRARIES); foreach ($lib->frontend->js as $libPath) { ?>
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
<script type="text/javascript">
  var baseURL = '<?= base_url(); ?>';
</script>
