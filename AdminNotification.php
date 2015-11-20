<?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Notification;

/**
 */ 
class AdminNotification extends \Piwik\Plugin
{
    private static $hooks = array(
            'Login.initSession.end' => 'setNotification',
            'Settings.AdminNotification.settingsUpdated' => 'setNotification'
    );
    
    //2.15 includes a new function for registering hooks. 2.15 wi
    public function registerEvents()
    {
        return self::$hooks;
    }
    
    //Pre 2.15 hook registration. Will be removed in Piwik 3. Kept for backwards compatibility with 2.12.
    //Pre ver3 will still call this in addition to registerEvents.
    //From reviewing the Piwik source this shouldn't be an issue as the hooks are not additive and this call will just overwrite the registerEvents call.
    public function getListHooksRegistered()
    {
        return self::$hooks;
    }
    
    public function setNotification(){
        $settings = API::getInstance();
        
        $enabled  = $settings->isEnabled();

        if ($enabled) {
            $context  = $settings->getContext();
            $title  = $settings->getTitle();
            $message  = $settings->getMessage();
                        
            $notification = new Notification($message);
            if(!empty($title)){
                $notification->title = $title;
            }
            $notification->context = $context;
            $notification->type = Notification::TYPE_PERSISTENT;
            $notification->priority = Notification::PRIORITY_MAX;
            Notification\Manager::notify('admin_message', $notification);
        }else{
            Notification\Manager::cancel('admin_message');
        }
    }
}