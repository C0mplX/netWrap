<?php
require('template/temp-header.php');
?>

<section class="content-header">
	<h1>
		New Post	
	</h1>
</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-9">
				<!--The mian input box, and text field-->
				<?php add_metabox_top('New post', 'large')?>
					<div class="col-md-12">
						<input type"text" class="form-control" placeholder="Enter title here"/></br>
						<?php echo add_editor('post_editor', 'post_editor_name')?>
					</div>
					
				<?php add_metabox_bottom()?>
				<!--/END The mian input box, and text field-->
			</div>
			<div class="col-md-3">
				<!--The publish box-->
				<?php add_metabox_top('Publish', 'large')?>
					<div class="col-md-12">
						<div class"text-left">
							<input type="submit" id="save_post" class="btn btn-default" value="Save Draft" /> 
						</div>
					</br>
						<i class="fa fa-circle"></i> <b>Status: </b> default draft
						
						<div class="text-right">
							<input type="submit" id="save_post" class="btn btn-primary" value="Publish" /> 
						</div>
					</div>
				<?php add_metabox_bottom();?>
				<!--/END The publish box-->

				<!--The category box-->
				<?php add_metabox_top('Category', 'large')?>

				<?php add_metabox_bottom();?>
			<!--/END The publish box-->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
<?php
require('template/temp-footer.php');
?>