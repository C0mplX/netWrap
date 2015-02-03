<?php
require('template/temp-header.php');

$post_ID = @$_GET['post'];
?>

<section class="content-header">
	<h1>
		Edit-posts	
	</h1>
</section>

	<?php if($post_ID == ""):?>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<!--The main input box, and text field-->
					<?php add_metabox_top('Editpost', 'large')?>
						<?php get_all_posts();?>
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
							<?php add_metabox_top('Edit Post', 'large')?>
							<?php add_form_start('nw_post_editor_edit', 'nw_post_editor_name_edit');?>
								<div class="col-md-12">
									<input type"text" id="nw_title_post_edit" name="nw_title_post_edit" class="form-control" value="<?php  get_the_title($post_ID); ?>" placeholder="Enter title here"/></br>
									<?php echo add_editor('nw_post_editor_edit', 'nw_post_editor_name_edit', get_the_content($post_ID))?>
								</div>
								
							<?php add_metabox_bottom()?>
							<!--/END The mian input box, and text field-->
						</div>

						<div class="col-md-3">
							<!--The publish box-->
							<?php add_metabox_top('Publish', 'large')?>
								<div class="col-md-12">
									<div class"text-left">
										<input type="submit" id="update_draft" name="update_draft" class="btn btn-default" value="Save Draft" /> 
									</div>
									<br>
									<i class="fa fa-circle"></i> Status: <b><?php get_post_status($post_ID);?></b>
									<div class="text-right">
										<input type="submit" id="update_post" name="update_post" class="btn btn-primary" value="Update" /> 
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
	<?php endif;?>
<?php
require('template/temp-footer.php');
?>