<?php defined('BLUDIT') or die('Bludit CMS.');

// echo '<h1 class="text-center mb-5 mt-5 font-weight-normal" style="color: #839496;">'. $site->title() .'</h1>';
echo '<div style="text-align: center; margin-bottom: 3rem;"><a class="h1" href='.HTML_PATH_ROOT.'>'. $site->title() .'</a></div>';

echo Bootstrap::formOpen(array());

	echo Bootstrap::formInputHidden(array(
		'name'=>'tokenCSRF',
		'value'=>$security->getTokenCSRF()
	));

	echo '
	<div class="form-group">
		<input type="text" value="'.(isset($_POST['username'])?$_POST['username']:'').'" class="form-control form-control-lg" id="jsusername" name="username" placeholder="'.$L->g('Username').'" autofocus>
	</div>
	';

	echo '
	<div class="form-group">
		<input type="password" class="form-control form-control-lg" id="jspassword" name="password" placeholder="'.$L->g('Password').'">
	</div>
	';

	echo '
	<div class="custom-checkbox">
		<input class="custom-control-input" type="checkbox" value="true" id="jsremember" name="remember">
		<label class="custom-control-label" for="jsremember"><span style="margin-right: 1.5rem;">'.$L->g('Remember me').'</span></label>
	</div>


	<div class="form-group mt-4">
		<button type="submit" class="btn btn-primary btn-lg mr-2 w-100" name="save">'.$L->g('Login').'</button>
	</div>
	';

echo '</form>';

?>
