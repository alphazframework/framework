<?php 
namespace Softhub99\Zest_Framework\Validation;

class InputRules extends StickyRules
{
	public function required($value)
	{
		return ($this->notBeEmpty($value)) ? true : false;
	}
	public function int($value)
	{
		if ($this->notBeEmpty($value)) {
			if (is_int($value)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function float($value)
	{
		if ($this->notBeEmpty($value)) {
			if (is_float($value)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}	
	public function string($value)
	{
		if ($this->notBeEmpty($value)) {
			if (is_string($value) && preg_match("/[A-Za-z]+/i", $value)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}	 	
	public function email ($value)
	{
		if ($this->notBeEmpty($value)) {
	        if(filter_var($value, FILTER_VALIDATE_EMAIL) !== false) {
	            return true;
	        } else {
	            return false;
	        }
		} else {
			return false;
		}
	}
	public function ip ($value) 
	{
		return ($this->notBeEmpty($value)) ? filter_var($value, FILTER_VALIDATE_IP) : false;
	}
}