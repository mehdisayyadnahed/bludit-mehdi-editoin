<?php

	class PluginNumbers extends Plugin{
		public function beforeSiteLoad(){
			ob_start();
		}

		public function afterSiteLoad(){
			$content = ob_get_contents();
			ob_end_clean();

			// Numbers Array
			$replace = array(
				"0" => '۰', "1" => '١', "2" => '٢', "3" => '٣', "4" => '۴',
				"5" => '۵', "6" => '۶', "7" => '٧', "8" => '٨', "9" => '٩'
			);

			// Convert Content
			$content = explode(">", $content);
			foreach($content AS &$inner){
				$inner = explode("<", $inner, 2);
				$inner[0] = strtr($inner[0], $replace);
				$inner = implode("<", $inner);
			}
			$content = implode(">", $content);
			print($content);
		}
	}
