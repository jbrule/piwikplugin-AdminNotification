<?php

namespace Piwik\Plugins\AdminNotification;

class API extends \Piwik\Plugin\API
{
    /**
     * Returns true if the left menu is enabled for the current user.
     *
     * @return bool
     */
    
    private static $plugin_name = 'AdminNotification';
    
    public function isEnabled()
    {
        $settings = new Settings(self::$plugin_name);
        $enabled  = $settings->enabled->getValue();
        $message  = $this->getMessage();

        if ($enabled && !empty($message)) {
            return true;
        }

        return false;
    }
    
    public function getContext(){
        $settings = new Settings(self::$plugin_name);
        return $settings->context->getValue();
    }
    
    public function getTitle(){
        $settings = new Settings(self::$plugin_name);
        return $settings->title->getValue();
    }
    
    public function getMessage(){
        $settings = new Settings(self::$plugin_name);
        return $settings->message->getValue();
    }
}