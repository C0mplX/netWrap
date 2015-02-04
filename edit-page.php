<?php
require('template/temp-header.php');

$post_ID = @$_GET['page'];
?>

<section class="content-header">
	<h1>
		Edit page	
	</h1>
</section>

	<?php if($post_ID == ""):?>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<!--The main input box, and text field-->
					<?php add_metabox_top('Edit page', 'large')?>
						<?php get_all_posts('page');?>
					<?php add_metabox_bottom()?>
				</div>
			</div><!-- /.row -->
		</section><!-- /.content -->
	<?php endif;?>
	<?php if($post_ID != ""): ?>
		<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-md-9">
							<!--The main input box, and text field-->
							<?php add_metabox_top('Edit Page', 'large')?>
							<?php add_form_start('nw_page_editor_edit', 'nw_page_editor_name_edit');?>
								<div class="col-md-12">
									<input type"text" id="nw_title_post_edit" name="nw_title_page_edit" class="form-control" value="<?php  get_the_title($post_ID); ?>" placeholder="Enter title here"/></br>
									<?php echo add_editor('nw_page_editor_edit', 'nw_page_editor_name_edit', get_the_content($post_ID))?>
								</div>
								
							<?php add_metabox_bottom()?>
							<!--/END The mian input box, and text field-->
						</div>

						<div class="col-md-3">
							<!--The publish box-->
							<?php add_metabox_top('Publish', 'large')?>
								<div class="col-md-12">
									<div class="col-md-6 text-left">
										<input type="submit" id="update_draft" name="update_draft_page" class="btn btn-default" value="Save Draft" /> </br></br>
										<i class="fa fa-circle"></i> Status: <b><?php get_post_status($post_ID);?></b>
									</div>
									
									<div class="col-md-6 text-right">
										<input type="submit" id="delete_post" name="delete_page" class="btn btn-default text-right" value="Delete post" /></br></br>	
										<input type="submit" id="update_post" name="update_page" class="btn btn-primary" value="Update"/> 
									</div>
								</div>
							<?php add_metabox_bottom();?>
							<!--/END The publish box-->

							<!--The category box-->
							<?php add_metabox_top('Category', 'large')?>
								<div class="col-md-12">
									<?php get_page_template_edit($post_ID);?>
									
								</div>
								
							<?php add_metabox_bottom();?>
						</form>
					<!--/END The publish box-->
					</div>
				</div><!-- /.row -->
			</section><!-- /.content -->
	<?php endif;?>
<?php
require('template/temp-footer.php');
?>