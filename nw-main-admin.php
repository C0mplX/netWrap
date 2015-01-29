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
					<p>Manage <a href="settings.php">Settings</a> or <a href="wp-pages/menus.php">Menus</a></p>
				</div>
			<?php add_metabox_bottom('Get started');?>
			<!--/END welcome box-->

			<!--Overview box-->
			<?php add_metabox_top('Overview', 'medium');?>
				
			<?php add_metabox_bottom();?>
			<!--/END Overview box-->

			<!--NetWrap News-->
			<?php add_metabox_top('About NetWrap', 'medium');?>
				<div class="col-sm-12">
					<h4>NetWrap 1.0</h4>
					<p>NetWrap is a content managing system that makes the webdesigners job easy! It comes with an well developed back-end, and admin panel for the end-user.
						All you have to do is to design the webpage, and we take care of the rest.</p>
					<p>For information on how to make your site "netWrap" compitable, see the <a href="nw_codec.text">codecs</a> and the <a href="http://www.netwrap.net/support.php">support page</a></p>
					<p>We are trying to keep NetWrap well-documented, but we need your help. If you want to contribute, or have any idee that makes NetWrap better <a href="http://www.netwrap.net/contact-us.php"> contact us</a></p>
				</div>
			<?php add_metabox_bottom();?>
			<!--/END NetWrap News-->
		</div><!-- /.row -->
	</section><!-- /.content -->
<?php
require('template/temp-footer.php');
?>