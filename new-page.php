<?php
require('template/temp-header.php');
?>

<section class="content-header">
	<h1>
		New Page
	</h1>
</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-9">
					<!--The main input box, and text field-->
					<?php add_metabox_top('Add new page', 'large')?>
					<?php add_form_start('nw_page_editor', 'nw_page_editor_name');?>
						<div class="col-md-12">
							<input type"text" id="nw_title_post" name="nw_title_page" class="form-control" placeholder="Enter title here"/></br>
							<?php echo add_editor('nw_page_editor', 'nw_page_editor_name', '')?>
						</div>
						
					<?php add_metabox_bottom()?>
					<!--/END The mian input box, and text field-->
				</div>

				<div class="col-md-3">
					<!--The publish box-->
					<?php add_metabox_top('Publish', 'large')?>
						<div class="col-md-12">
							<div class="col-md-6 text-left">
								<input type="submit" id="save_draft_page" name="save_draft_page" class="btn btn-default" value="Save Draft" /> 
							</div>
							<div class="col-md-6 text-right">
								<input type="submit" id="save_page" name="save_page" class="btn btn-primary" value="Publish" /> 
							</div>
						</div>
					<?php add_metabox_bottom();?>
					<!--/END The publish box-->

					<!--The category box-->
					<?php add_metabox_top('Template', 'large')?>
						<div class="col-md-12">
							<?php get_page_template();?>
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