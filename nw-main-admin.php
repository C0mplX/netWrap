<?php
require('template/temp-header.php');
?>

<section class="content-header">
	<h1>
		Dashboard
	</h1>
</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!--welcome box-->
			<?php add_metabox_top('Welcome to NetWrap', 'large');?>
				<div class="col-sm-4">
					<h4>Get Started</h4>
					<a href="new-page.php"><input type="submit" class="btn btn-primary" value="Add Page"/></a>
				</div>
				<div class="col-sm-4">
					<h4>Next Step</h4>
					<a href="new-post.php"><input type="submit" class="btn btn-primary" value="Add Post"/></a>
				</div>
				<div class="col-sm-4">
					<h4>More actions</h4>
					<p>Manage <a href="nw_settings.php">Settings</a> or <a href="nw_menus.php">Menus</a></p>
				</div>
			<?php add_metabox_bottom('Get started');?>
			<!--/END welcome box-->

			<!--Overview box-->
			<?php add_metabox_top('Overview', 'medium');?>
				<div class="col-md-12">
					<div class="col-md-6 text-left">
						<i class="fa fa-pencil fa-4x"></i> <a href="edit-post.php"><h3><?php get_post_count();?> posts</h3></a>
					</div>
					<div class="col-md-6">
						<i class="fa fa-file fa-4x"></i> <a href="edit-post.php"><h3><?php get_page_count();?> pages</h3></a>
					</div>
				</div>
			<?php add_metabox_bottom();?>
			<!--/END Overview box-->

			<!--NetWrap News-->
			<?php add_metabox_top('About NetWrap', 'medium');?>
				<div class="col-sm-12">
					<h4>NetWrap 1.0</h4>
					<p>NetWrap is a content managing system that makes the webdesigners job easy! It comes with an well developed back-end, and admin panel for the end-user.
						All you have to do is to design the webpage, and we take care of the rest.</p>
					<p>For information on how to make your site "netWrap" compitable, see the <a href="nw_codec.text" target="_blank">codecs</a> and the <a href="http://www.netwrap.net/support.php" target="_blank">support page</a></p>
					<p>We are trying to keep NetWrap well-documented, but we need your help. If you want to contribute, or have any idee that makes NetWrap better <a href="http://www.netwrap.net/contact-us.php" target="_blank"> contact us</a></p>
				</div>
			<?php add_metabox_bottom();?>
			<!--/END NetWrap News-->
		</div><!-- /.row -->
	</section><!-- /.content -->
<?php
require('template/temp-footer.php');
?>