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
			|   DEFAULT FUNCTION   |
                           ========+
	 */

	/**
	 * Construtor
	 *
	 * @param string $url 	URL of your OpenMole REST API (eg. demo.openmole.org)
	 * @param int $port 	The port use for your OpenMole REST API (default `8080`)
	 * @param bool $https 	Set at `true` if the OpenMole REST API is using HTTPS (default `false`)
	 * 
	 * @return Singleton instance
	 */
	public function __construct(string $url, int $port = 8080, bool $https = false ) {
		
		$this->apiURL = $url;
		$this->port = $port;
		$this->https = $https;

		// Pre-Construct full URL
		$this->url = "http";
		if ($https){ $this->url .= "s"; }
		$this->url .= "://" . $url . ":" . $port;
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
 
 	/*
		+========
		|   GET Server
 	 */
 	
 	/**
 	 * Return the state of a mole execution.
 	 * 
 	 * @param  string $id 	ID of your OpenMole task previously given by the server
 	 * @return JSON 		REST API result
 	 */
 	public function getJobs(){
 		return json_decode($this->callAPI("GET", $this->url . "/job/"));
 	}

 	/**
 	 * List all user plugins loaded in OpenMOLE.
 	 * 
 	 * @return JSON 	List containing the name of the plugins and a boolean set to true if the plugin is properly loaded
 	 */
 	public function getPlugins(){
 		return json_decode($this->callAPI("GET", $this->url . "/plugin/"));
 	}
 
 	/*
		+========
		|   GET Job
 	 */
 	
 	/**
 	 * Return the state of a mole execution.
 	 * 
 	 * @param  string $id 	ID of your OpenMole task previously given by the server
 	 * @return JSON 		REST API result
 	 */
 	public function getJobState(string $id){
 		return json_decode($this->callAPI("GET", $this->url . "/job/" . $id . "/state"));
 	}

 	/**
 	 * Returns the output of a mole execution as a multi-dimensionnal Array (CSV export)
 	 * 
 	 * @param  string 		$id 	ID of your OpenMole task previously given by the server
 	 * @return Array[Array] 		Output grid of the job
 	 */
 	public function getJobOutput(string $id){
 		$result = [];

 		// Launch request
 		$reqResult = $this->callAPI("GET", $this->url . "/job/" . $id . "/output");
 		
 		// Turn line in array
 		$reqResult = explode("\n", $reqResult); 
 		array_pop($reqResult); // Remove last buggy line

 		// Turn every line in real array
 		foreach ($reqResult as $key => $line) {
 			$result[] = explode(",", $line);
 		}

 		// Return Array[Array[string]]
 		return $result;
 	}

	// GET /job/:id/output - returns the output of a mole execution as a string. It has the following parameters: 
	// GET /job/:id/workDirectory/:file - download a file or a directory from the server. It returns the gunziped content of the file or a tar.gz archive of the directory. It has the following parameters: 

 	/*
		+========
		|   POST
 	 */
 	
 
 	/*
		+========
		|   DELETE
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