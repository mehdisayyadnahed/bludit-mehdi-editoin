<script charset="utf-8">
	function showAlert(text) {
		console.log("[INFO] Function showAlert() called.");
		$("#alert").html(text);
		$("#alert").slideDown().delay(<?php echo ALERT_DISAPPEAR_IN*2000 ?>).slideUp();
	}

	<?php if (Alert::defined()): ?>
	setTimeout(function(){ showAlert("<?php echo Alert::get() ?>") }, 500);
	<?php endif; ?>

	$(window).click(function() {
		$("#alert").hide();
	});
</script>

<div id="alert" style="border-radius: 5px;" class="alert <?php echo (Alert::status()==ALERT_STATUS_FAIL)?'alert-danger':'alert-success' ?>"></div>
