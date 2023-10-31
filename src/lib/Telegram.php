<?php
/**
 * @desc telegram.php
 * @auhtor Wayne
 * @time 2023/10/31 16:19
 */
namespace dasher\robot\lib;

use dasher\robot\RobotException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class Telegram extends Api{

    protected $token = "";


    public function __construct($key = null, $async = false, $http_client_handler = null)
    {
        if(!empty($key)) $this->token = $key;
        parent::__construct($this->token, $async,$http_client_handler);
    }

    /**
     * @throws RobotException
     */
    public function sendMsg($chatIds, $msg, $parseMode=""){
        if(empty($chatIds)) return false;
        if(empty($msg)) return false;
        try {
            if(is_array($chatIds)){
                foreach ($chatIds as $chatId) {
                    $this->sendMessage([
                        'chat_id' => $chatId,
                        'text' => $msg,
                        'parse_mode' => $parseMode
                    ]);
                }
            }
            return true;
        }catch (TelegramSDKException $e){
            throw new RobotException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

    }
}