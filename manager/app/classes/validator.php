<?php

namespace App\Classes;

class Validator
{
	private $_errors = [];

	private $_current_control_name = null;
	private $_current_control_val  = null;

	/**
	 * Add control to validation. If no control_val is given, $_REQUEST['control_name']
	 * will be used automatically.
	 */
	public function control($control_name, $control_val=null)
	{
		$this->_current_control_name = $control_name;
		$this->_current_control_val  = $control_val ?? $_REQUEST[$control_name];
		return $this;
	}

	/**
	 * Custom option allowing any message to be set. Useful for when one of the
	 * other validation methods don't fit the need.
	 */
	public function custom($msg)
	{
		$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function ipAddress($options = [])
	{
		$msg = $options['msg'] ?? 'Please enter a valid ip address';

		if (!preg_match('/((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$/', $this->_current_control_val))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function option($options = [])
	{
		$msg = $options['msg'] ?? 'Please select an option';

		if ($this->_current_control_val == -1)
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function required($options = [])
	{
		$msg = $options['msg'] ?? 'This is a required field';

		if (empty($this->_current_control_val))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function number($options = [])
	{
		$msg = $options['msg'] ?? 'Please enter a valid number';

		if ($this->_current_control_val!='' && !is_numeric($this->_current_control_val))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function dirExists($options = [])
	{
		$msg = $options['msg'] ?? 'The specified directory does not exist';

		if (!is_dir($this->_current_control_val))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function positive($options = [])
	{
		$msg = $options['msg'] ?? 'Please enter a positive number';

		if (!(is_numeric($this->_current_control_val) && $this->_current_control_val>0))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public function regex($options = [])
	{
		$msg = $options['msg'] ?? 'Entered value does not match pattern: '. $options['pattern'];

		if (!preg_match($options['pattern'], $this->_current_control_val))
			$this->_add($this->_current_control_name, $msg);
		return $this;
	}

	public static function validEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public function _add($control, $error, $clear = false)
	{
		$this->_errors[] = ['name'=>$control, 'error'=>$error, 'clear'=>$clear];

		return $this;
	}

	public function validate()
	{
		if (count($this->_errors) > 0)
		{
			foreach ($this->_errors as $error)
			{
				?>
				render(<?= json_encode($error); ?>);
				<?php
			}
			?>
			submit_btn.text(existing_text).prop('disabled', false);
			<?php
			die();
		} else return true;
	}
}