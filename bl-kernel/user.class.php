<?php defined('BLUDIT') or die('Bludit CMS.');

class User {
	protected $vars;

	function __construct($username)
	{
		global $users;

		$this->vars['username'] = $username;

		if ($username===false) {
			$row = $users->getDefaultFields();
		} else {
			if (Text::isEmpty($username) || !$users->exists($username)) {
				$errorMessage = 'User not found in the database by username ['.$username.']';
				Log::set(__METHOD__.LOG_SEP.$errorMessage);
				throw new Exception($errorMessage);
			}
			$row = $users->getUserDB($username);
		}

		foreach ($row as $field=>$value) {
			$this->setField($field, $value);
		}
	}

	public function getValue($field)
	{
		if (isset($this->vars[$field])) {
			return $this->vars[$field];
		}
		return false;
	}

	public function setField($field, $value)
	{
		$this->vars[$field] = $value;
		return true;
	}

	public function getDB()
	{
		return $this->vars;
	}

	public function username()
	{
		return $this->getValue('username');
	}

	public function description()
	{
		return $this->getValue('description');
	}

	public function nickname()
	{
		return $this->getValue('nickname');
	}

	public function firstName()
	{
		return $this->getValue('firstName');
	}

	public function lastName()
	{
		return $this->getValue('lastName');
	}

	public function tokenAuth()
	{
		return $this->getValue('tokenAuth');
	}

	public function role()
	{
		return $this->getValue('role');
	}

	public function password()
	{
		return $this->getValue('password');
	}

	public function enabled()
	{
		$password = $this->getValue('password');
		return $password != '!';
	}

	public function salt()
	{
		return $this->getValue('salt');
	}

	public function email()
	{
		return $this->getValue('email');
	}

	public function date($format=false, $value)
	{
		$dateRaw = $this->getValue($value);
		$format = "H:i:s - Y/m/d";

		if(!function_exists("jdate")){
			require_once PATH_KERNEL . "jdate.func.php";
		}

		$output = jdate($format, strtotime($dateRaw));
		return ($output);
		
		return Date::format($dateRaw, DB_DATE_FORMAT, $format);
	}

	public function registered($format = false)
	{
		return $this->date($format, "registered");
	}

	public function twitter()
	{
		return $this->getValue('twitter');
	}

	public function soroush()
	{
		return $this->getValue('soroush');
	}

	public function rubika()
	{
		return $this->getValue('rubika');
	}

	public function rss()
	{
		return $this->getValue('rss');
	}

	public function facebook()
	{
		return $this->getValue('facebook');
	}

	public function virgool()
	{
		return $this->getValue('virgool');
	}

	public function youtube()
	{
		return $this->getValue('youtube');
	}

	public function instagram()
	{
		return $this->getValue('instagram');
	}

	public function eitaa()
	{
		return $this->getValue('eitaa');
	}

	public function telegram()
	{
		return $this->getValue('telegram');
	}

	public function aparat()
	{
		return $this->getValue('aparat');
	}

	public function github()
	{
		return $this->getValue('github');
	}

	public function profilePicture()
	{
		$filename = $this->getValue('username').'.png';
		if (!file_exists(PATH_UPLOADS_PROFILES.$filename)) {
			return false;
		}
		return DOMAIN_UPLOADS_PROFILES.$filename;
	}

	public function json($returnsArray=false)
	{
		$tmp['username'] 	= $this->username();
		$tmp['firstName'] 	= $this->firstName();
		$tmp['lastName'] 	= $this->lastName();
		$tmp['nickname'] 	= $this->nickname();
		$tmp['description'] 	= $this->description();
		$tmp['twitter'] 	= $this->twitter();
		$tmp['soroush'] 	= $this->soroush();
		$tmp['rubika'] 	= $this->rubika();
		$tmp['rss'] 	= $this->rss();
		$tmp['facebook'] 		= $this->facebook();
		$tmp['virgool'] 	= $this->virgool();
		$tmp['youtube'] 		= $this->youtube();
		$tmp['instagram'] 		= $this->instagram();
		$tmp['eitaa'] 		= $this->eitaa();
		$tmp['telegram'] 	= $this->telegram();
		$tmp['aparat']	= $this->aparat();
		$tmp['email']	= $this->email();
		$tmp['github']		= $this->github();
		$tmp['profilePicture']	= $this->profilePicture();

		if ($returnsArray) {
			return $tmp;
		}

		return json_encode($tmp);
	}

}