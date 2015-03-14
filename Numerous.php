<?php
	// 这个是我自虐写的一个 Numerous Api 的 PHP 类.
	// GET method works and I don't know what's wrong with the POST/PUT method. 
	// email me iplus26@gmail.com if you know where the problem is. thx in advance.
	
	class Numerous {
		
		const API_BASE_URL = "https://api.numerousapp.com";
		
		private $_key = null;
		
		private $_auth_header = null;

		
		function __construct($key) {
			if(empty($key)){
				throw new Exception("Api key cannot be null. ");
			} else {
				$this->_key = $key;
				$this->_auth_header = "Authorization: Basic " . base64_encode($_key . ":");
			}
		}
		
		// Metrics
		
		
		// let the post method go...
		public function create_metric($label, $fields = array(), $private = true, $writeable = false) {
			// Merge supplied properties with default values
			$data = array_merge(array(
				"label" => (string)$label,            
				"private" => (bool)$private,
				"writeable" => (bool)$writeable
			), $fields);                
			$result = $this->post("/v2/metrics", $data);
			return $result;          
		}
		
		function post($url, array $data, $method = "POST", $endpoint = false) {
			$url = self::API_BASE_URL . $url;
			echo "POST " . $url . "\n";
			
			$data_string = json_encode($data);
			
			$headers = array(
				'Accept: application/json',
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string)
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$response = self::curl_exec($ch);
			
			return $response;
		}
		
		
		
		function list_user_metrics($user_id){
			return self::get("/v2/users/{$user_id}/metrics");
		}
		
		function list_most_popular_metrics(){
			return self::get("/v1/metrics/popular?count=3");
		}
		
		function get_user_self_info(){
			return self::get("/v1/users/self");
		}
		
		function update_metric() {
			// put
		}
		
		function retrieve_metric($metric_id) {
			return self::get("/v1/metrics/{$metric_id}");
		}
		
		function delete_metric($id){
			// delete
		}
		
		
		// If a metric has a photo (whether included or uploaded), the response will be an HTTP 302 redirect to the photo itself. 
		function fetch_metric_photo($metric_id){
			return self::get("/v1/metrics/{$metric_id}/photo");
		}
		
		function update_metric_photo() {
			// post
		}
		
		function delete_metric_photo() {
			// delete
		}
		
		function list_all_subscriptions($metric_id) {
			return self::get("/v2/metrics/{$metric_id}/subscriptions");
		}
		
		function retrieve_subscription($metric_id, $user_id) {
			return self::get("/v1/metrics/{$metric_id}/subscriptions/{$user_id}");
		}
		
		function update_subscription(){
			// post
		}
		
		function delete_subscription(){
			// delete
		}
		
		
		
		function get($url) {
			$url = self::API_BASE_URL . $url;
			
			echo "GET  " . $url . "\n";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$response = self::curl_exec($ch);
			
			return $response;
		}
		
		private function curl_exec($ch) {
			curl_setopt($ch, CURLOPT_HEADER, $this->_auth_header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);           
			// Authentication to the Numerous API occurs via Basic HTTP Auth.
			curl_setopt($ch, CURLOPT_USERPWD, $this->_key . ':');
			$result = curl_exec($ch);
			
			$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			$url = (string) curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
			if(curl_errno($ch)) { // Check if any error occurred
				throw new NumerousException(curl_error($ch), NumerousException::NET_ERROR);
			}
			curl_close($ch);
			
			$response = json_decode($result, false, 512, JSON_BIGINT_AS_STRING);
			
			if ($httpCode != 200 && $httpCode != 201) {     
				throw new NumerousException("HTTP error {$httpCode}, URL: {$url}", NumerousException::HTTP_ERROR);  
			}
			
			if ($response === null) { // Json can't be decoded
				throw new NumerousException("Invalid JSON response server: $response", NumerousException::JSON_ERROR);
			}
					
			return $response;        
		}
		
		
	}
	
	class NumerousException extends \Exception {

		const NET_ERROR = 1;
		const HTTP_ERROR = 2;
		const JSON_ERROR = 3;

		/**
		 * Returns exception information as JSON string
		 */
		public function toJson() {
			return json_encode(array(
				"exception" => array(
					"message" => $this->getMessage(),
					"code" => $this->code,
					"in" => get_class($this) . " {$this->file}:{$this->line}"
				)
			), JSON_PRETTY_PRINT);
		}

	}
	
	
?>