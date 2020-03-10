<?php 

namespace RoiArthurB\OpenMole;

/**
*  PHP wrapper to communicate easily with the OpenMole REST API
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
	protected $https;
	protected $url;


	/*
			+========
			|   SINGLETON   |
                    ========+
	 */

	/**
	 * Protected construtor to prevent the creation of a new instance with the "new" keyword
	 *
	 * @param string $url 	URL of your OpenMole REST API (eg. demo.openmole.org)
	 * @param int $port 	The port use for your OpenMole REST API (default `8080`)
	 * @param bool $https 	Set at `true` if the OpenMole REST API is using HTTPS (default `false`)
	 * 
	 * @return Singleton instance
	 */
	protected function __construct(string $url, int $port = 8080, bool $https = false ) {
		
		$this->apiURL = $url;
		$this->port = $port;
		$this->https = $https;

		// Pre-Construct full URL
		$this->url = "http";
		if ($https){ $this->url .= "s"; }
		$this->url .= "://" . $url . ":" . $port;
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

	/**
	 * Return instance of this class
	 *
	 * @static Singleton $instance var
	 *
	 * @param Array['url' => string, 'port' => int, 'https' => bool] $parameters URL is needed, Port and Https are optional
	 *
	 * @return Singleton instance
	 */
	public static function getInstance($parameters = null) {
		static $instance = null;
		if (null === $instance) {
			switch (sizeof($parameters)) {
				case 2:
					$instance = new static($parameters['url'], $parameters['port']);
					break;
				case 3:
					$instance = new static($parameters['url'], $parameters['port'], $parameters['https']);
					break;
				
				default:
					$instance = new static($parameters['url']);
					break;
			}
		}

		return $instance;
	}

	/*
			+========
			|   API REFERENCE   |
                        ========+
	 */
	
    /**
     * Helper to send request with libcurl
     * based on response here : https://stackoverflow.com/a/9802854/6284933
     * 
     * @param  string  $method 	"POST", "DELETE" or "GET"
     * @param  string  $url 	API REST endpoint
     * @param  Array   $data 	Array with all the stuff you want to send
     * 
     * @return Array?			REST API result
     */
	protected function callAPI($method, $url, $data = null)
	{
	    $curl = curl_init();

	    switch ($method)
	    {
	    	//	POST 	========
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;

	    	//	DELETE 	========
	        case "DELETE":
	            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	            break;

	    	//	GET 	========
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }
	    
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);

	    return $result;
	}
 
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