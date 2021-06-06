<?php

class pluginMaintenanceMode extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'enable'=>false,
			'message'=>'متأسفانه سایت مشکل پیدا کرده، ولی دارم روش کار میکنم :)'
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="primary-style" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Enable maintenance mode').'</label>';
		$html .= '<select name="enable" class="form-control">';
		$html .= '<option value="true" '.($this->getValue('enable')===true?'selected':'').'>فعال</option>';
		$html .= '<option value="false" '.($this->getValue('enable')===false?'selected':'').'>غیرفعال</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Message').'</label>';
		$html .= '<input name="message" id="jsmessage" class="form-control" type="text" value="'.$this->getValue('message').'">';
		$html .= '</div>';

		return $html;
	}

	public function beforeAll()
	{
		if ($this->getValue('enable')) {
			exit('<h2 style="padding-top: 20%; direction: rtl; text-align: right; text-align: center; ">' . $this->getValue('message') . '</h2>' );
		}
	}
}