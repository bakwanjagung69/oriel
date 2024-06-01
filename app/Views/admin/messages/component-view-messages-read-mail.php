<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header">
	          	<h3>
	          		<?= $data['response']['subject']; ?><br>
	          		<small class="mailToDisp">To: <?= $data['mailTo']; ?></small> 		
	          	</h3>
	          	<div class="_date"><?= date('F j, Y, g:i a',strtotime($data['response']['sendDate'])); ?></div>
	          	<div class="btn-save">
        			<button type="button" class="btn btn-default pull-right" onclick="Reply('<?= $data['response']['uuid'] ?>');">
        				<i class="fa fa-reply"></i> Reply
        			</button>
        		</div>
	        </div>
	        <div class="box-body">
	        	<hr style="margin: -19px 2px 14px;">
    			<div class="disp-messages"><?= $data['response']['message']; ?></div>
	        </div>
         	<div class="box-footer">
	        	<button type="button" class="btn btn-default" onclick="Back(event);">
    				<i class="fa fa-arrow-left loaders"></i> Back
    			</button>
	        </div>
      	</div>
	</div>
</div>

<style type="text/css">
	.disp-messages {
		padding: 15px;
		border: 1px solid #ccc;
		border-radius: 5px;
		background-color: #fdfdfd;
	    height: 700px;
    	overflow: auto;
	}

	.mailToDisp {
		font-size: 12px;
	}

	._date {
		float: right;
		position: absolute;
		right: 7px;
		top: 3px;
	}
</style>

<script type="text/javascript">
	function Back(event) {
		var url = baseURL +'/admin/messages' + window.location.search;
		window.location.href = url;
		return false;
	}

	function Reply(uuid) {
		var url = baseURL +'/admin/messages/reply/'+ uuid + window.location.search;
		window.location.href = url;
		return false;
	}
</script>