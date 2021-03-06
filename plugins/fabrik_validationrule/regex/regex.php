<?php
/**
* @package fabrikar
* @author Rob Clayburn
* @copyright (C) Rob Clayburn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

//require the abstract plugin class
require_once(COM_FABRIK_FRONTEND.DS.'models'.DS.'plugin.php');
require_once(COM_FABRIK_FRONTEND.DS.'models'.DS.'validation_rule.php');

class plgFabrik_ValidationruleRegex extends plgFabrik_Validationrule
{

	var $_pluginName = 'regex';

	/** @param string classname used for formatting error messages generated by plugin */
	var $_className = 'notempty regex';
	
	/** @var bool if true uses icon of same name as validation, otherwise uses png icon specified by $icon */
	protected $icon = 'notempty';

	/**
	 * validate the elements data against the rule
	 * @param string data to check
	 * @param object element
	 * @param int plugin sequence ref
	 * @return bol true if validation passes, false if fails
	 */

	function validate($data, &$element, $c)
	{
		//for multiselect elements
		if (is_array($data)) {
			$data = implode('', $data);
		}
		$params = $this->getParams();
		$domatch = $params->get('regex-match');
		$domatch = $domatch[$c];
		if ($domatch) {
			$v = $params->get('regex-expression');
			$found = preg_match($v[$c], $data, $matches);
			return $found;
		}
		return true;
	}

 	function replace($data, &$element, $c)
 	{

 		$params = $this->getParams();
		$domatch = $params->get('regex-match', '_default','array', $c);
		$domatch = $domatch[$c];
		if (!$domatch) {
	 		$v = $params->get($this->_pluginName .'-expression', '_default','array', $c);
			$replace = $params->get('regex-replacestring', '_default','array', $c);
			$return = preg_replace($v[$c], $replace[$c], $data);
			return $return;
		}
		return $data;
 	}
}
?>