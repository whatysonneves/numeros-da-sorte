<?php

use \Ixudra\Curl\CurlService as Curl;

/**
 * Numeros da Sorte
 */
class numerosDaSorte
{

	protected $token;

	function __construct()
	{
		$this->token = getenv("LOTODICAS_TOKEN");
	}

	public function getEndpoint($endpoint = "lotofacil", $number = "last")
	{
		$url = "https://www.lotodicas.com.br/api/v2/:endpoint:/results/:number:?token=:token:";
		$url = str_ireplace([ ":token:", ":endpoint:", ":number:" ], [ $this->token, $endpoint, $number ], $url);
		return $url;
	}

	public function getFilename($endpoint = "lotofacil", $number = "last")
	{
		if($number == "last") { return false; }
		$filename = ":endpoint:-:number:.txt";
		$filename = str_ireplace([ ":endpoint:", ":number:" ], [ $this->token, $endpoint, $number ], $filename);
		return $filename;
	}

	public function get($endpoint = "lotofacil", $number = "last")
	{
		$curl = new Curl;
		$get = $curl->to($this->getEndpoint($endpoint, $number))->get();
		$get = $this->validadeJson($get);
		return $get;
	}

	/**
	 * Método extraído do blog https://codeblogmoney.com/validate-json-string-using-php/
	 * Adaptado para validar de acordo a aplicação.
	 */
	public function validadeJson($get = null)
	{
		$return = ["status" => false, "error" => "empty variable"];
		if(!empty($get)) {
			@json_decode($get);
			if(json_last_error() === JSON_ERROR_NONE) {
				$get = json_decode($get, true);
				$return = array_merge(["status" => true], $get, ["status" => true]);
				if($get["code"] !== 200) {
					$return = ["status" => false, "error" => "api error: ".$get["code"]];
				}
			} else {
				$return = ["status" => false, "error" => "json error: ".json_last_error()];
			}
		}
		return json_encode($return);
	}

}
