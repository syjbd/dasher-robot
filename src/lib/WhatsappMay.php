<?php
/**
 * @desc WhatsappMayt.php
 * @auhtor Wayne
 * @time 2023/10/31 16:21
 */
namespace dasher\robot\lib;

use dasher\robot\RobotException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsappMay{

    protected $api = "https://api.maytapi.com/api/{{product_id}}/{{phone_id}}/sendMessage";
    protected $token = "";
    protected $productId = "";
    protected $phoneId = "";

    public function __construct($productId="",$token="",$phoneId=""){
        if(!empty($productId)) $this->productId = $productId;
        if(!empty($token)) $this->token = $token;
        if(!empty($phoneId)) $this->phoneId = $phoneId;
        $this->api = str_replace("{{product_id}}", $this->productId, $this->api);
        $this->api = str_replace("{{phone_id}}", $this->phoneId, $this->api);
    }

    /**
     * @throws RobotException
     */
    public function sendMsg($chatIds, $msg){
        if(empty($chatIds)) return false;
        if(empty($msg)) return false;
        try {
            $client = new Client(['verify' =>false]);
            $headers = [
                "accept" => "application/json",
                "Content-Type"=>"application/json",
            ];
            if(!is_array($chatIds)){
                $chatIds = [$chatIds];
            }
            foreach ($chatIds as $chatId){
                $postData = [
                    "to_number" => $chatId,
                    'type' => 'text',
                    "message" => $msg
                ];
                $response = $client->post($this->api, [
                    'headers' => $headers,
                    "x-maytapi-key"=>"{$this->token}",
                    'json'    => $postData
                ]);
                $response->getBody();
            }
            return true;
        }catch (RequestException $e){
            throw new RobotException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

}