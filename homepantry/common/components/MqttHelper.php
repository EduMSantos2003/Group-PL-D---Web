<?php

namespace common\components;

class MqttHelper
{
    public static function publish($topic, $message)
    {
        $mosquittoPath = 'C:\Program Files\mosquitto\mosquitto_pub.exe';

        $cmd = "\"{$mosquittoPath}\" -t \"{$topic}\" -m \"{$message}\"";

        exec($cmd, $output, $returnCode);

        return $returnCode === 0;
    }
}
