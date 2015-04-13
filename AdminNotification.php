<?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Notification;

/**
 */ 
class AdminNotification extends \Piwik\Plugin
{
    public function getListHooksRegistered()
    {
        $hooks = array(
            'Login.initSession.end' => 'setNotification',
            'Settings.AdminNotification.settingsUpdated' => 'setNotification'
        );
        return $hooks;
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