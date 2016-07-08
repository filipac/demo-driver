<?php namespace Demo\Driver;

use Backend;
use System\Classes\PluginBase;

/**
 * Driver Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Driver',
            'description' => 'No description provided yet...',
            'author'      => 'Demo',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        \Event::listen('filipac.twofactor.drivers', function () {
            return [ 'class' => 'Demo\Driver\DemoSender', 'name' => 'Slack Gateway' ];
        });
        \Event::listen('filipac.twofactor.fields', function () {
            return static::class;
        });
    }

    public static function fields() {
        $arr                 = [ ];
        $arr['slack_url']      = [
            'label' => 'Webhook url',
            'tab'   => 'Slack',
            'span'  => 'full'
        ];
        $arr['slack_channel'] = [
            'label' => 'Channel to post in',
            'tab'   => 'Slack',
            'span'  => 'left'
        ];
        return $arr;
    }
    
    public static function validation() {
        return [
            'rules' => [
                'slack_url' => 'required_if:driver,'.DemoSender::class,
                'slack_channel' => 'required_if:driver,'.DemoSender::class.'|regex:/^([#]).+$/',
            ],
            'messages' => [
                'slack_url.required_if' => 'Slack url is required.',
                'slack_channel.required_if' => 'Slack channel is required.',
                'slack_channel.regex' => 'Slack channel must start with # (hashtag).'
            ]
        ];
    }
}
