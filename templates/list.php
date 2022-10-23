<?php
/*
Templates For: Listing vendors for admin
Version: 1.0.0
Author: Arif
Author URI: https://in.linkedin.com/in/arif-ca-59840847
Copyright: © 2020 Arif. All rights reserved.
*/

/* --- Static initializer for Wordpress hooks --- */

global $wpdb;
?>
<div class="currency_container">
	<div class="cfe_container">
		<div class="list-container" style="width:90%; margin: auto;">
			<div class="d-block p-2 bg-primary text-white text-center" style="margin: 10px 0px;"><h3>Added Pages</h3></div>
			<div class="row">
				<div class="col-md-12">
					<form class="form-inline" method="post" id="form-add-page">
					  <div class="form-group mx-sm-3 mb-2">
					    <label for="inputPassword2" class="sr-only">url</label>
					    <input type="text" class="form-control" placeholder="Full URL" name="page">
					  </div>
					  <input type="hidden" name="action" value="dm_create_page">
					  <button type="button" class="btn btn-primary" onclick="createPageEntry()">Add entry</button>
					</form>
				</div>	
			</div>
			<table class="display" id="listVendorsTable">
				<thead class="listing-table-head">
				<tr>
					<th>No</th>
					<th>Page</th>
					<th>Title Tag</th>
					<th>Description</th>
					<th>Keywords</th>
					<th>Action</th>
				</tr>
				</thead>
	        	<tbody>
				<?php
				if(!empty($savedPages))
				{	
					$i=0;
					foreach ($savedPages as $savedPage) { 
						$i++;
						?>
						<tr>
							<td><?=$i?></td>
							<td><?=$savedPage->page?></td>
							<td><?=$savedPage->title?></td>
							<td><?=$savedPage->description?></td>
							<td><?=$savedPage->keyword?></td>
							<td>
								<button type="button" class="btn btn-secondary" onclick="editPage('<?=$savedPage->id?>')"><span class="dashicons dashicons-edit"></span></button>
								<button type="button" class="btn btn-danger" onclick="deletePage('<?=$savedPage->id?>')"><span class="dashicons dashicons-trash"></span></button>
								<div class="modal fade" id="editDmPageModal_<?=$savedPage->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-scrollable" role="document">
										<div class="modal-content">
										  <div class="modal-header">
										    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit <span class="badge badge-pill badge-success"><?=$savedPage->page?></span></h5>
										    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										      <span aria-hidden="true">&times;</span>
										    </button>
										  </div>
										  <div class="modal-body">
										    <form id="update-db-form-<?=$savedPage->id?>">
										    	<div class="form-row">
												    <div class="col-md-12 mb-3">
														<label for="validationServer01">Page URL</label>
														<input type="text" class="form-control" id="validationServer01" placeholder="Page URl" value="<?=$savedPage->page?>" name="page">
													</div>
													<div class="col-md-12 mb-3">
														<label for="validationServer01">Title</label>
														<input type="text" class="form-control" id="validationServer01" placeholder="Page Tiltle" name="title" value="<?=$savedPage->title?>">
													</div>
												  	<div class="col-md-12 mb-3">
													    <label for="validationTextarea">Description</label>
													    <textarea name="description" class="form-control" id="validationTextarea" placeholder="Description"><?=$savedPage->description?></textarea>
												  	</div>
												  	<div class="col-md-12 mb-3">
													    <label for="validationTextarea">Keywords</label>
													    <textarea name="keyword" class="form-control" id="validationTextarea" placeholder="Keywords" required><?=$savedPage->keyword?></textarea>
												  	</div>
												  	<input type="hidden" name="action" value="dm_save_page">
												  	<input type="hidden" name="id" value="<?=$savedPage->id?>">
												</div>
											 </form>
										  </div>
										  <div class="modal-footer">
										    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										    <button type="button" class="btn btn-primary" onclick="updateDmData('<?=$savedPage->id?>')">Save changes</button>
										  </div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<?php						
					}
				}
				?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready( function () {
    	jQuery('#listVendorsTable').DataTable();
	} );
	//Open modal for edit
	function editPage(pageId) {
		$('#editDmPageModal_'+pageId).modal('show');
	}
	function updateDmData(formId) {
		var form = $('#update-db-form-'+formId);
		var data = form.serialize();
		$.post(ajaxurl, data, function(response) {
			var data = jQuery.parseJSON(response);
			if(data.id && data.id != '')
			{
				$('#editDmPageModal_'+formId).modal('hide');
				swal("Updated the details.", {
			      icon: "success",
			    }).then((value) => {
				  location.reload();
				});
			}
			else {
				alert('Something went wrong, please try later');
			}
		});
	}
	function createPageEntry() {
		var form = $('#form-add-page');
		var data = form.serialize();
		$.post(ajaxurl, data, function(response) {
			var data = jQuery.parseJSON(response);
			if(data.id && data.id != '')
			{
				//alert('Created the entry, please use edit button to add details');
				swal("Created the entry, please use edit button to add details.", {
			      icon: "success",
			    }).then((value) => {
				  location.reload();
				});
			}
			else {
				alert('Something went wrong, please try later');
			}
		});
	}
	function deletePage(formId) {
		var data = {
				action: 'dm_delete_page',
				id: formId
			};
		$.post(ajaxurl, data, function(response) {
			var data = jQuery.parseJSON(response);
			if(data.status && data.status != '')
			{
				swal("Entry deleted.", {
			      icon: "success",
			    }).then((value) => {
				  location.reload();
				});
			}
			else {
				alert('Something went wrong, please try later');
			}
		});
	}
</script>
