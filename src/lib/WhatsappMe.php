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

class WhatsappMe{

    protected $api = "";
    protected $session = 'default';

    public function __construct($session="", $api=""){
        if(!empty($session)) $this->session = $session;
        if(!empty($api)) $this->api = $api;
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
                    "chatId"    => $chatId,
                    "session"   => $this->session,
                    "text"      => $msg
                ];
                $response = $client->post($this->api, [
                    'headers' => $headers,
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