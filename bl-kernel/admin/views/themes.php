<?php

echo Bootstrap::pageTitle(array('title'=>$L->g('Themes'), 'icon'=>'picture-o'));

if (count($themes) > 0){
	echo '
	<table class="table table-striped mt-3">
		<tbody>
			<tr>
				<th class="border-bottom-0 w-25" scope="col">'.$L->g('Name').'</th>
				<th class="border-bottom-0 d-none d-sm-table-cell" scope="col">'.$L->g('Description').'</th>
				<th class="text-center border-bottom-0 d-none d-lg-table-cell" scope="col">'.$L->g('Version').'</th>
				<th class="text-center border-bottom-0 d-none d-lg-table-cell" scope="col">'.$L->g('Author').'</th>
			</tr>
	';

	foreach ($themes as $theme) {
		echo '
		<tr '.($theme['dirname']==$site->theme()?'class="bg-light"':'').'>
			<td class="align-middle pt-3 pb-3">
				<div>'.$theme['name'].'</div>
				<div class="mt-1">
		';

		if ($theme['dirname']!=$site->theme()) {
			echo '<a href="'.HTML_PATH_ADMIN_ROOT.'install-theme/'.$theme['dirname'].'">'.$L->g('Activate').'</a>';
		}
		if ($theme['dirname']==$site->theme()) {
			echo '<p style="margin-bottom: 0; color: #40aaa2;">'.$L->g('is-active').'</p>';
		}

		echo '
				</div>
			</td>
		';

		echo '<td class="align-middle d-none d-sm-table-cell">';
		echo $theme['description'];
		echo '</td>';

		echo '<td class="text-center align-middle d-none d-lg-table-cell">';
			echo '<span>'.$theme['version'].'</span>';
		echo '</td>';

		echo '<td class="text-center align-middle d-none d-lg-table-cell">
			<a target="_blank" href="'.$theme['website'].'">'.$theme['author'].'</a>
		</td>';

		echo '</tr>';
	}

	echo '
		</tbody>
	</table>
	';
}

if (count($themes) < 1){
	echo "<hr style='border-color: #dee2e6; '>";
	echo '<p class="mt-4 text-muted">';
	echo $L->g('there-are-no-theme-at-this-momment');
	echo '</p>';
}