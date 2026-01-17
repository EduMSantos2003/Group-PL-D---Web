<?php

namespace common\components;

class MqttHelper
{
    public static function publish(string $topic, string $message): void
    {
        $cmd = '"C:\Program Files\mosquitto\mosquitto_pub.exe" ' .
            '-h 172.22.21.242 ' .
            '-t ' . escapeshellarg($topic) . ' ' .
            '-m ' . escapeshellarg($message);

        shell_exec($cmd);
    }
}
