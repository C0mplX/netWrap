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
					<!--The main input box, and text field-->
					<?php add_metabox_top('New post', 'large')?>
					<?php add_form_start('nw_post_editor', 'nw_post_editor_name');?>
						<div class="col-md-12">
							<input type"text" id="nw_title_post" name="nw_title_post" class="form-control" placeholder="Enter title here"/></br>
							<?php echo add_editor('nw_post_editor', 'nw_post_editor_name', '')?>
						</div>
						
					<?php add_metabox_bottom()?>
					<!--/END The mian input box, and text field-->
				</div>

				<div class="col-md-3">
					<!--The publish box-->
					<?php add_metabox_top('Publish', 'large')?>
						<div class="col-md-12">
							<div class"text-left">
								<input type="submit" id="save_draft" name="save_draft" class="btn btn-default" value="Save Draft" /> 
							</div>
							<div class="text-right">
								<input type="submit" id="save_post" name="save_post" class="btn btn-primary" value="Publish" /> 
							</div>
						</div>
					<?php add_metabox_bottom();?>
					<!--/END The publish box-->

					<!--The category box-->
					<?php add_metabox_top('Category', 'large')?>
						<div class="col-md-12">
							<?php get_post_category();?>
							
						</div>
						
					<?php add_metabox_bottom();?>
				</form>
			<!--/END The publish box-->
			</div>
		</div><!-- /.row -->
	</section><!-- /.content -->
<?php
require('template/temp-footer.php');
?>