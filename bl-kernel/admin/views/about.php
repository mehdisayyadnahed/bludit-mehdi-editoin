<?php

echo Bootstrap::pageTitle(array('title'=>$L->g('درباره'), 'icon'=>'info-circle'));

echo '
<table class="table table-striped mt-3">
	<tbody>
';

echo '<tr>';
echo '<td>ویرایش بلودیت</td>';
if (defined('BLUDIT_PRO')) {
	echo '<td>PRO - '.$L->g('با سپاس از پشتیبانی بلودیت').' <span class="fa fa-heart" style="color: #ffc107"></span></td>';
} else {
	echo '<td>استاندارد - <a target="_blank" href="https://pro.bludit.com">'.$L->g('ارتقاء به بلودیت نسخه تجاری').'</a></td>';
}
echo '</tr>';

echo '<tr>';
echo '<td>نسخه بلودیت</td>';
echo '<td>'.BLUDIT_VERSION.'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>نام مستعار بلودیت</td>';
echo '<td>فریبا</td>';
echo '</tr>';

echo '<tr>';
echo '<td>شماره ساخت بلودیت</td>';
echo '<td>'.BLUDIT_BUILD.'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>استفاده از دیسک</td>';
echo '<td>'.Filesystem::bytesToHumanFileSize(Filesystem::getSize(PATH_ROOT)).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>ترجمه توسط</td>';
echo '<td><a target="_blank" href="http://www.pourdaryaei.ir">عبدالحلیم پوردریایی </a></td>';
echo '</tr>';

echo '<tr>';
echo '<td>آخرین ویرایش به فارسی</td>';
echo '<td>1399/05/10</td>';
echo '</tr>';

echo '<tr>';
echo '<td><a href="'.HTML_PATH_ADMIN_ROOT.'developers'.'">توسعه دهنده بلودیت</a></td>';
echo '<td></td>';
echo '</tr>';

echo '
	</tbody>
</table>
';
