<?php defined('BLUDIT') or die('Bludit CMS.');

echo Bootstrap::pageTitle(array('title'=>$L->g('Categories'), 'icon'=>'tags'));

echo Bootstrap::link(array(
	'title'=>$L->g('Add a new category'),
	'href'=>HTML_PATH_ADMIN_ROOT.'new-category',
	'icon'=>'plus'
));

if (empty($categories->keys())) {
	echo '<hr style="border-color: white;"><p class="mt-4 text-muted">'.$L->g('there-are-no-categories-at-this-moment').'</p>';
}
else{
	echo '
	<table class="table table-striped mt-3">
		<tbody>
			<tr>
				<th class="border-bottom-0" scope="col">'.$L->g('Name').'</th>
				<th class="border-bottom-0" scope="col">'.$L->g('URL').'</th>
			</tr>
	';
}

foreach ($categories->keys() as $key) {
	$category = new Category($key);
	echo '<tr>';
	echo '<td><a href="'.HTML_PATH_ADMIN_ROOT.'edit-category/'.$key.'">'.$category->name().'</a></td>';
	echo '<td><a href="'.$category->permalink().'">'.$url->filters('category', false).$key.'</a></td>';
	echo '</tr>';
}

echo '
	</tbody>
</table>
';
