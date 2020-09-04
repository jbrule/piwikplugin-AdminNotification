<?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Notification;

/**
 */ 
class AdminNotification extends \Piwik\Plugin
{
    private static $hooks = array(
            'Login.authenticate.successful' => 'setNotificationV3', //Version 3.X Post login handler
            'SystemSettings.updated' => 'settingsChangedV3' //Version 3.X Setting updated handler
    );
    
    public function registerEvents()
    {
        return self::$hooks;
    }
            
    public function settingsChangedV3($settings){        
        if($settings->getPluginName() === 'AdminNotification'){
            $this->setNotificationV3();
        }
    }
    
    public function setNotificationV3(){
            //Known issue. The alert notification is not updated until login/logout on v3.x.        
        
            //2.X Compatibility. This method appears to be getting called in v2.X which I didn't believe would trigger the newer hooks.
            if(!class_exists('\Piwik\Settings\Plugin\SystemSettings')){ //If class doesn't exist just get out.
             return;
            }
        
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
