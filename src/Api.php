<?php
/**
 * @desc Api.php
 * @auhtor Wayne
 * @time 2023/10/31 16:42
 */
namespace dasher\robot;

use dasher\robot\lib\Telegram;
use dasher\robot\lib\WhatsappMay;
use dasher\robot\lib\WhatsappMe;
use Telegram\Bot\Exceptions\TelegramSDKException;

class Api{

    /**
     * @throws RobotException
     * @throws TelegramSDKException
     */
    public static function sendMsg($chatIds, $msg, $type, $config){
        if(!is_array($chatIds)){
            $chatIds = explode(',', $chatIds);
        }
        switch ($type){
            case "telegram";
                $obj = new Telegram($config['key']);
                return $obj->sendMsg($chatIds, $msg);
            case "whatsappMay";
                $obj = new WhatsappMay($config['product_id'],$config['token'],$config['phone_id']);
                return $obj->sendMsg($chatIds, $msg);
            case "whatsappMe";
                $obj = new WhatsappMe($config['session'],$config['api']);
                return $obj->sendMsg($chatIds, $msg);
            default:
                throw new RobotException('sorry! This type of robot is not supported',-100);
        }
    }
}