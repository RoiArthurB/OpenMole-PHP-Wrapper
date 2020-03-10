<?php 

namespace RoiArthurB\OpenMole;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author RoiArthurB
*/
class OpenMole{

	/*
			+========
			|   SINGLETON   |
                    ========+
	 */

	/**
	 * Return instance of this class
	 *
	 * @static var Singleton $instance
	 *
	 * @return Singleton instance
	 */
	public static function getInstance() {
		static $instance = null;
		if (null === $instance) {
				$instance = new static();
		}

		return $instance;
	}

	/**
	 * Protected construtor to prevent the creation of a new instance with the "new" keyword
	 */
	protected function __construct() {}

	/**
	 * Private clone function to prevent cloning the singleton instance
	 *
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Private unserialize function to prevent cloning the singleton instance
	 *
	 * @return void
	 */
	private function __wakeup() {}


	/*
			+========
			|      API      |
                    ========+
	 */

	 /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
	 private $m_SampleProperty = '';
 
	/**
	* Sample method 
	*
	* Always create a corresponding docblock for each method, describing what it is for,
	* this helps the phpdocumentator to properly generator the documentation
	*
	* @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
	*
	* @return string
	*/
	 public function method1($param1){
			return "Hello World";
	 }
}