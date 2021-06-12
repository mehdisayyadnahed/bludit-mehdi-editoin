<?php
/*
	This plugin uses the javascript library https://instagram.com/gionkunz/chartist-js
*/
class pluginSimpleStats extends Plugin {

	private $loadOnController = array(
		'dashboard'
	);

	public function init()
	{

		// Fields and default values for the database of this plugin
		$this->dbFields = array(
			'label'=>'بازدیدها',
			'numberOfDays'=>7,
			'excludeAdmins'=>false,
			'showContentStats'=>true
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="primary-style" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Label').'</label>';
		$html .= '<input id="jslabel" class="form-control" name="label" type="text" value="'.$this->getValue('label').'">';
		$html .= '<span class="tip">'.$L->get('This title is almost always used in the sidebar of the site').'</span>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Show Content Stats').'</label>';
		$html .= '<select name="showContentStats" class="form-control">';
		$html .= '<option value="true" '.($this->getValue('showContentStats')===true?'selected':'').'>'.$L->get('Enabled').'</option>';
		$html .= '<option value="false" '.($this->getValue('showContentStats')===false?'selected':'').'>'.$L->get('Disabled').'</option>';
		$html .= '</select>';
		$html .= '</div>';

		if (defined('BLUDIT_PRO')) {
			$html .= '<div>';
			$html .= '<label>'.$L->get('Exclude administrators users').'</label>';
			$html .= '<select name="excludeAdmins">';
			$html .= '<option value="true" '.($this->getValue('excludeAdmins')===true?'selected':'').'>'.$L->get('Enabled').'</option>';
			$html .= '<option value="false" '.($this->getValue('excludeAdmins')===false?'selected':'').'>'.$L->get('Disabled').'</option>';
			$html .= '</select>';
			$html .= '</div>';
		}

		return $html;
	}

	public function adminHead()
	{
		if (!in_array($GLOBALS['ADMIN_CONTROLLER'], $this->loadOnController)) {
			return false;
		}

		// Include plugin's CSS files
		$html  = $this->includeCSS('chartist.min.css');
		$html .= $this->includeCSS('style.css');

		// Include plugin's Javascript files
		$html .= $this->includeJS('chartist.min.js');

		return $html;
	}

	public function dashboard()
	{
		global $L;
		$label = $this->getValue('label');
		$currentDate = Date::current('Y-m-d');
		$visitsToday = $this->visits($currentDate);
		$uniqueVisitors = $this->uniqueVisitors($currentDate);

        $data['title'] = $L->get('Statistics');
        
		$html = '<div class="simple-stats-plugin">
			        <div class="my-4 pt-4 border-top">
        				<h4 class="pb-2">'.$data["title"].'</h4>
        				<div class="ct-chart ct-perfect-fourth"></div>
        				<p class="legends visits-today">'.$L->g('Visits today').': '. $visitsToday.'</p>
        				<p class="legends unique-today">'.$L->g('Unique visitors today').': '. $uniqueVisitors.'</p>
			        </div>
		        </div>';

		$numberOfDays = $this->getValue('numberOfDays');
		$numberOfDays = $numberOfDays - 1;
		for ($i=$numberOfDays; $i >= 0 ; $i--) {
			$dateWithOffset = Date::currentOffset('Y-m-d', '-'.$i.' day');
			$visits[$i] = $this->visits($dateWithOffset);
			$unique[$i] = $this->uniqueVisitors($dateWithOffset);
			$days[$i] = Date::format($dateWithOffset, 'Y-m-d', 'D');
		}

		$labels = "'" . implode("','", $days) . "'";
		$seriesVisits = implode(',', $visits);
		$seriesUnique = implode(',', $unique);

$script = <<<EOF
<script>
	var data = {
		labels: [$labels],
		series: [
			[$seriesVisits],
			[$seriesUnique]
		]
	};

	var options = {
		height: 250,
		axisY: {
			onlyInteger: true,
		}
	};

	new Chartist.Line('.ct-chart', data, options);
</script>
EOF;

		/**
		 * Optional Content Stats Feature
		 */
		if ($this->getValue('showContentStats'))  {
			global $pages, $categories, $tags;
			
			$data['tabTitleChart'] = $L->get('Chart');
			$data['tabTitleTable'] = $L->get('Table');
			$data['data'][$L->get('published')] 	= count($pages->getPublishedDB());
			$data['data'][$L->get('static')] 	= count($pages->getStaticDB());
			$data['data'][$L->get('sticky')] 	= count($pages->getStickyDB());
			$data['data'][$L->get('drafts')]	= count($pages->getDraftDB());
			// $data['data'][$L->get('scheduled')] 	= count($pages->getScheduledDB());
			$data['data'][$L->get('categories')]	= count($categories->keys());
			// $data['data'][$L->get('tags')] 		= count($tags->keys());
			$html .= $this->renderContentStatistics($data);
		}

		$this->deleteOldLogs();

		return $html.PHP_EOL.$script.PHP_EOL;
	}

	public function siteBodyEnd()
	{
		$this->addVisitor();
	}

	// Keep only 7 days of logs
	public function deleteOldLogs()
	{
		$logs = Filesystem::listFiles($this->workspace(), '*', 'log', true);
		$remove = array_slice($logs, 7);

		foreach ($remove as $log) {
			Filesystem::rmfile($log);
		}
	}

	// Returns the amount of visits by date
	public function visits($date)
	{
		$file = $this->workspace().$date.'.log';
		$handle = @fopen($file, 'rb');
		if ($handle===false) {
			return 0;
		}

		// The amount of visits are the number of lines on the file
		$lines = 0;
		while (!feof($handle)) {
			$lines += substr_count(fread($handle, 8192), PHP_EOL);
		}
		@fclose($handle);
		return $lines;
	}

	// Returns the amount of unique visitors by date
	public function uniqueVisitors($date)
	{
		$file = $this->workspace().$date.'.log';
		$lines = @file($file);
		if (empty($lines)) {
			return 0;
		}

		$tmp = array();
		foreach ($lines as $line) {
			$data = json_decode($line);
			$hashIP = $data[0];
			$tmp[$hashIP] = true;
		}
		return count($tmp);
	}

	// Add a line to the current log
	// The line is a json array with the hash IP of the visitor and the time
	public function addVisitor()
	{
		if (Cookie::get('BLUDIT-KEY') && defined('BLUDIT_PRO') && $this->getValue('excludeAdmins')) {
			return false;
		}
                $currentTime = Date::current('Y-m-d H:i:s');
		$ip = TCP::getIP();
		$hashIP = md5($ip);

		$line = json_encode(array($hashIP, $currentTime));
		$currentDate = Date::current('Y-m-d');
		$logFile = $this->workspace().$currentDate.'.log';

		return file_put_contents($logFile, $line.PHP_EOL, FILE_APPEND | LOCK_EX)!==false;
	}

	public function renderContentStatistics($data)
	{
		global $L;
		$diskUsage = Filesystem::bytesToHumanFileSize(Filesystem::getSize(PATH_ROOT));

		$html = '<div class="my-5 pt-4 border-top">';
		$html .= '
		<div class="tab-content my-2" id="nav-tabContent">
		
		  <div class="tab-pane fade active show" id="nav-stats-table" role="tabpanel" aria-labelledby="nav-stats-table-tab">
			<table class="table table-borderless table-sm table-striped mt-3">
			  <tbody>
			  <tr></tr>';
	global $login;
	if ($login->role()==='admin'){
		$html .= "<tr><th>{$L->get('disk-usage')}</th><td>$diskUsage</td></tr>";
	}
		foreach ($data['data'] as $th => $td) {
			$html .= "
				<tr>
					<th>$th</th>
					<td>$td</td>
				</tr>"; }

		$html .= '
			  </tbody>
			</table>
		  </div>
		</div>

		</div>';

		return $html;
	}
}
