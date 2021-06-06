<?php

class pluginAbout extends Plugin {

	public function init()
	{
		global $L;
		
		$this->dbFields = array(
			'label'=>'',
			'text'=>$L->get('this-is-a-brief-description-of-yourself-our-your-site'),
			"position"=>1
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
		$html .= '<input class="form-control" name="label" type="text" value="'.$this->getValue('label').'">';
		$html .= '<span class="tip">'.$L->get('This title is almost always used in the sidebar of the site').'</span>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('About').'</label>';
		$html .= '<textarea class="form-control" name="text" id="jstext">'.$this->getValue('text').'</textarea>';
		$html .= '</div>';

		return $html;
	}

	public function siteSidebar()
	{
		$html  = '<div class="plugin plugin-about">';
		$html .= '<h2 class="plugin-label">'.$this->getValue('label').'</h2>';
		$html .= '<div class="plugin-content" style="text-align: center;">';
		$html .= html_entity_decode(nl2br($this->getValue('text')));
 		$html .= '</div>';
 		$html .= '</div>';

		return $html;
	}
}