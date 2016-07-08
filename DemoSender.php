<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 08.07.2016
 * Time: 21:33
 */

namespace Demo\Driver;

use Filipac\TwoFactor\Interfaces\SenderInterface;
use Filipac\TwoFactor\Models\Settings;
use Maknz\Slack\Client;

class DemoSender implements SenderInterface
{
    public function send($to, $message)
    {
        $driver = $this->getDriver();
        $channel = Settings::get('slack_channel');
        $url = Settings::get('slack_url');
        if($channel AND $url)
            return $driver->send($message);
    }

    public function getDriver()
    {
        $channel = Settings::get('slack_channel');
        $url = Settings::get('slack_url');
        $settings = [
            'channel' => $channel,
            'name' => 'October Demo',
            'link_name' => true
        ];
        $slack = new Client($url, $settings);
        return $slack;
    }

}