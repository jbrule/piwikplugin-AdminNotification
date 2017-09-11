<?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Notification;

/**
 */ 
class AdminNotification extends \Piwik\Plugin
{
    private static $hooks = array(
            'Login.initSession.end' => 'setNotification', //Version 2.X Post login handler
            'Login.authenticate.successful' => 'setNotificationV3', //Version 3.X Post login handler
            'Settings.AdminNotification.settingsUpdated' => 'setNotification', //Version 2.X Setting updated handler
            'SystemSettings.updated' => 'settingsChangedV3' //Version 3.X Setting updated handler
    );
    
    //2.15 includes a new function for registering hooks.
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
    
    function postLoad()
    {
        //Piwik::addAction('SystemSettings.updated', array($this, 'settingsChangedV3'));
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
            Notification\Manager::notify('AdminNotification_notice', $notification);
        }else{
            Notification\Manager::cancel('AdminNotification_notice');
        }
    }
    
    public function settingsChangedV3($settings){        
        if($settings->getPluginName() === 'AdminNotification'){
            $this->setNotificationV3();
        }
    }
    
    public function setNotificationV3(){
            //Known issue. The alert notification is not updated until login/logout on v3.x.        
        
            $settings = new SystemSettings();
            //print_r($settings->enabled->getValue());
            
            if($settings->enabled->getValue()){
                
                $notification = new Notification($settings->message->getValue());
                $notification->title = $settings->messageTitle->getValue();
                $notification->context = $settings->context->getValue();
                $notification->type = Notification::TYPE_PERSISTENT;
                //$notification->priority = Notification::PRIORITY_MAX;
                
                //echo "NOTIFY";
                //print_r($notification);
                
                Notification\Manager::notify('AdminNotification_notice', $notification);
            
            }else{
                //echo "NOTIFY CANCEL";
                Notification\Manager::cancel('AdminNotification_notice');
            }
    }
}