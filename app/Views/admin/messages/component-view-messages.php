<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header">
	          <!-- <button type="button" class="btn btn-default" onclick="formNewData();">
	          	<i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
	          </button> -->
	        </div>
	        <div class="box-body">
    			<table id="table" class="table table-striped table-bordered dt-responsive" style="width:100%">
			        <thead>
			            <tr>
		                  	<th style="width: 1px;">No</th>

		                  	<?php if (isset($_GET['q'])) { ?>
							<th><?= ($_GET['q'] == 'inbox' ? 'Name of the sender' : 'Recipient\'s name'); ?></th>
							<?php } ?>

							<?php if (isset($_GET['q'])) { ?>
							<th>Email <?= ($_GET['q'] == 'sent' ? 'To' : ''); ?></th>
							<?php } ?>

							<?php if (isset($_GET['q']) && $_GET['q'] == 'inbox') { ?>
								<th>Messages</th> 
							<?php } ?>

							<th>Date</th> 
							<th>Status</th>                               
		                    <th style="width: 128px;">Action</th>

		                    <?php if (isset($_GET['q'])) { ?>
			                    <?php if ($_GET['q'] == 'sent') { ?>
			                    <th class="none expanded-row"></th>
			                	<?php } ?>
		                	<?php } ?>

			            </tr>
			        </thead>
			        <tbody></tbody>
			    </table>
	        </div>
      	</div>
	</div>
</div>