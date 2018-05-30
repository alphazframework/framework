<?php 

namespace Softhub99\Zest_Franewir\Interfaces\Validator;

interface ValidatorInterface {

	public function compile($rules);

	public function makeItRequired($inputName);

	public function max($inputName, $value);

	public function min($inputName, $value);

	public function cleanHtml($inputName);

	public function typeof($type, $inputName, $inputValue);
}