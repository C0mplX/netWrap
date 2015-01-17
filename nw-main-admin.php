<?php
require('template/temp-header.php');
?>

<section class="content-header">
	<h1>
		Blank page
		<small>Control panel</small>
	</h1>
</section>

	<!-- Main content -->
	<section class="content">
		<div class="col-md-6">
		<textarea>Type here!</textarea>
		<iframe id="form_target" name="form_target" style="display:none"></iframe>
		<form id="my_form" action="/upload/" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
		    <input name="image" type="file" onchange="$('#my_form').submit();this.value='';">

		</form>	
		</div>
		<?php echo  $_SERVER['DOCUMENT_ROOT'];?>
	</section><!-- /.content -->
<?php
require('template/temp-footer.php');
?>