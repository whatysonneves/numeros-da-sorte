
<?php

use \Ixudra\Curl\CurlService as Curl;

/**
 * Numeros da Sorte
 */
class numerosDaSorte
{

	protected $token;
	protected $tokens = 10; // quantidade de tokens no .env
	protected $user_agent;

	function __construct()
	{
		$this->setToken();
		$this->user_agent = "Mozilla/5.0 (compatible; NumerosDaSorte/1.3.3; +https://whatysonneves.com/numeros-da-sorte/)";
	}

	public function setToken()
	{
		return $this->token = getenv("LOTODICAS_TOKEN_".$this->token());
	}

	public function getEndpoint($endpoint = "lotofacil", $number = "last")
	{
		$url = "https://www.lotodicas.com.br/api/v2/:endpoint:/results/:number:?token=:token:";
		$url = str_ireplace([ ":token:", ":endpoint:", ":number:" ], [ $this->token, $endpoint, $number ], $url);
		return $url;
	}

	public function get($endpoint = "lotofacil", $number = "last")
	{
		$curl = new Curl;
		$get = $curl->to($this->getEndpoint($endpoint, $number))->withOption("USERAGENT", $this->user_agent)->get();
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
				if($get["code"] !== 200) {
					$return = ["status" => false, "error" => "api error: ".$get["code"]];
				} else {
					$return = $this->prepareJson($get);
				}
			} else {
				$return = ["status" => false, "error" => "json error: ".json_last_error()];
			}
		}
		return json_encode($return);
	}

	public function prepareJson($get = null)
	{
		return [
			"status" => true,
			"numero" => (int) $get["data"]["draw_number"],
			"sorteio" => (array) $get["data"]["drawing"]["draw"],
		];
	}

	protected function getCookie()
	{
		$_SESSION["NDS_Token"] = ( array_key_exists("NDS_Token", $_SESSION) ? $_SESSION["NDS_Token"] : 1 );
		return $_SESSION["NDS_Token"];
	}

	protected function token()
	{
		$token = $this->getCookie();
		if($_SESSION["NDS_Token"] == $this->tokens) {
			$_SESSION["NDS_Token"] = 1;
		} else {
			$_SESSION["NDS_Token"]++;
		}
		return ( $token < $this->tokens ? "0".$token : $token );
	}

}
