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
class OpenMole {

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
     *                        	Every dic. key name (with POST method) starting by `up_` will be uploaded and rename without this header
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
	            break;

	    	//	DELETE 	========
	        case "DELETE":
	            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	            break;

	        //  PROPFIND =======
	        case "PROPFIND":
	            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PROPFIND");
	            break;

	    	//	GET 	========
	        // Never used for now, but ready to be used
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    // Set POST parameters inr request
        if ($data){
        	$postArray = [];
        	foreach ($data as $key => $value) {

        		if (explode("_", $key)[0] == "up"){	// File to upload in the POST request
					$cfile = curl_file_create($value); // Create CURLFile object with path value

					// Assign POST data
					$postArray[explode("_", $key)[1]] = $cfile;
        		}else{
        			$postArray[$key] = $value;
        		}
        	}
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postArray);
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
 		$result;
 		try {
			$result = json_decode($this->callAPI("GET", $this->url . "/job/"));
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
 	}

 	/**
 	 * List all user plugins loaded in OpenMOLE.
 	 * 
 	 * @return JSON 	List containing the name of the plugins and a boolean set to true if the plugin is properly loaded
 	 */
 	public function getPlugins(){
 		$result;
 		try {
			$result = json_decode($this->callAPI("GET", $this->url . "/plugin/"));
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
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
 		$result;
 		try {
			$result = json_decode($this->callAPI("GET", $this->url . "/job/" . $id . "/state"));
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
 	}

 	/**
 	 * Returns the output of a mole execution as a multi-dimensionnal Array (CSV export)
 	 * 
 	 * @param  string 		$id 	ID of your OpenMole task previously given by the server
 	 * @return Array[Array] 		Output grid of the job
 	 */
 	public function getJobOutput(string $id){
 		$result = [];

 		try {
	 		// Launch request
	 		$reqResult = $this->callAPI("GET", $this->url . "/job/" . $id . "/output");
	 		
	 		// Turn line in array
	 		$reqResult = explode("\n", $reqResult); 
	 		array_pop($reqResult); // Remove last buggy line

	 		// Turn every line in real array
	 		foreach ($reqResult as $key => $line) {
	 			$result[] = explode(",", $line);
	 		}
 			
 			// will Return Array[Array[string]]
 		
 		} catch (Exception $e) {
 			$result= $e;
 		}

 		return $result;
 	}

 	/**
 	 * Download a file or a directory from the server
 	 * WIP function
 	 * 
 	 * @param  string $id       ID of your OpenMole task previously given by the server
 	 * @param  string $fileName Name of the file you want to download
 	 * @return file 			Requested file
 	 */
 	public function getJobFile(string $id, string $fileName){
		//Have to talk with OpenMole staff for this one
 		$result;
 		try {
			$result = $this->callAPI("GET", $this->url . "/job/" . $id . "/workDirectory/" . $fileName);
 		} catch (Exception $e) {
 			$result= $e;
 		}
		return $result;
 	}

 	/*
		+========
		|   POST
 	 */
 	
 	/**
 	 * Start a mole execution
 	 * Will automatically compress the given workspace, upload it and send it to your OpenMole server
 	 * 
 	 * @param  string $workspacePath Absolute path to the OM work directory
 	 * @param  string $omsFileName   Relative path of the oms in the work directory
 	 * @return Array                 API result on success or fail
 	 */
 	public function postStartJob(string $workspacePath, string $omsFileName){

 		do { // Get random unique archive name
	 		$archivePath = $workspacePath . "/../archive" . rand() . ".tar";
 		} while ( file_exists($archivePath) );

 		$archive = new \PharData($archivePath);
 		$archive->buildFromDirectory($workspacePath);
		$archive->compress(\Phar::GZ);

 		$result;
 		try {
			$result = $this->callAPI("POST", $this->url . "/job", ["script" => $omsFileName, "up_workDirectory" => $archivePath . ".gz"]);
 		} catch (Exception $e) {
 			$result= $e;
 		}

		// Cleaning uncompressed archive
 		if (file_exists($archivePath)){
 			unlink($archivePath);

 			// Cleaning compressed archive
 			unlink($archivePath . ".gz");
 		}		

		return json_decode($result);

 	}

 	/**
 	 *  Load one plugin in OpenMOLE.
 	 * 
 	 * @param  string $omPluginFileName Relative path of the oms in the work directory
 	 * @return Array                 	API result on success or fail
 	 */
 	public function postUploadPlugin(string $omPluginFileName){

 		$result;
 		try {
			$result = $this->callAPI("POST", $this->url . "/plugin", ["up_file" => $omPluginFileName]);
 		} catch (Exception $e) {
 			$result= $e;
 		}

		return $result;
 	}
 	
 
 	/*
		+========
		|   DELETE
 	 */
 	
 	/**
 	 * Cancel and remove an execution from the server
 	 * 
 	 * @param  string $id The id of the mole execution
 	 * @return bool       If the request has been send or not
 	 */
 	public function deleteJob(string $id){
 		$result;
 		try {
 			$result= $this->callAPI("DELETE", $this->url . "/job/" . $id );
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
 	}
	 
	/**
	 * Unload (and remove) one or several plugins in OpenMOLE. Depending plugin are unloaded as well.
	 * 
	 * @param  string $pluginName 	The name of an OpenMOLE plugin
 	 * @return bool   			    If the request has been send or not
	 */
 	public function deletePlugin(string $pluginName){
 		$result;
 		try {
 			$result= $this->callAPI("DELETE", $this->url . "/plugin", ["name" => $pluginName] );
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
 	}

 	/*
		+========
		|   PROPFIND
 	 */
 	
	/**
	 * Get info of a file or a directory from the server.
	 * 
	 * @param  string      $id      The id of the mole execution
	 * @param  string      $path	The relative path to the directory to list in the workspace
	 * @param  int|integer $last    (optional) An integer to list only the last n files.
	 * 
	 * @return JSON                	Listing of every files in the folder with attributes [name, type, modified, size]
	 */
 	public function listDirectory(string $id, string $path, int $last = -1){
 		$result;
 		try {
 			if($last != -1){
 				$result= $this->callAPI("PROPFIND", $this->url . "/job/" . $id . "/workDirectory/" . $path, ["last" => $last] );
 			}else{
 				$result= $this->callAPI("PROPFIND", $this->url . "/job/" . $id . "/workDirectory/" . $path);
 			}
 		} catch (Exception $e) {
 			$result= $e;
 		}
 		return $result;
 	}
}