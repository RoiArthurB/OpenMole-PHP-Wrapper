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
			|   VARIABLES   |
                    ========+
	 */
	
	protected $apiURL;
	protected $port;


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
	 *
	 * @param string $url URL of your OpenMole REST API
	 * @param int $port The port use for your OpenMole REST API (default 8080)
	 * 
	 * @return Singleton instance
	 */
	protected function __construct($url, [$port = 8080]) {
		$this->apiURL = $url;
		$this->port = $port;
	}

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
			|   API REFERENCE   |
                        ========+
	 */
 
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