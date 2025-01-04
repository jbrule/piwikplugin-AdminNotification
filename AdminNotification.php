<?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Common;
use Piwik\Notification;

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

    public function settingsChangedV3($settings)
    {
        if ($settings->getPluginName() === 'AdminNotification') {
            self::cancel_notification();
            $this->setNotificationV3();
        }
    }

    public function setNotificationV3()
    {
        // Known issue. The alert notification is not updated until login/logout on v3.x.

        // 2.X Compatibility. This method appears to be getting called in v2.X which I didn't
        // believe would trigger the newer hooks.
        if (!class_exists('\Piwik\Settings\Plugin\SystemSettings')) { //If class doesn't exist just get out.
            return;
        }

        $settings = new SystemSettings();
        //print_r($settings->enabled->getValue());

        if ($settings->enabled->getValue()) {

            //Transform newlines to avoid removal in sanitization
            $message = str_replace(["\r\n","\r","\n"],"!nl",$settings->message->getValue());                                                   
                                                                                                                                    
            $sanitized_message = Common::sanitizeInputValue($message);                                                              
            
            //Reverse newline transform
            $sanitized_message = str_replace("!nl","\n",$sanitized_message);                                                     

            //Process markdown
            $markdowned_message = self::minimal_markdown($sanitized_message);   

            $notification = new Notification($markdowned_message);
            $notification->title = $settings->messageTitle->getValue();
            $notification->context = $settings->context->getValue();
            $notification->type = $settings->type->getValue();
            $notification->priority = $settings->priority->getValue();
            $notification->raw = true;

            //echo "NOTIFY";
            //print_r($notification);

            Notification\Manager::notify('AdminNotification_notice', $notification);
            Piwik::postEvent('AdminNotification.notice', [&$notification]);
        } else {
            self::cancel_notification();
        }
    }

    public function deactivate()
    {
        self::cancel_notification();
    }

    private static function cancel_notification(){
        Notification\Manager::cancel('AdminNotification_notice');
    }

    private static function minimal_markdown($escaped_input){

        //Replace with common Markdown markup
        $markdown_processed = preg_replace(
        [
          "/\*{3}([\w\s]*)\*{3}/im",
          "/\*{2}([\w\s]*)\*{2}/im",
          "/\*([\w\s]*)\*/im",
          "/^#\s(.*)$/im",
          "/^##\s(.*)$/im",
          "/^###\s(.*)$/im",
          "/^####\s(.*)$/im",
          "/\[(.*)\]\(((?:https?:\/\/.)?(?:www\.)?[-a-zA-Z0-9@%._\+~#=]{2,256}\.[a-z]{2,6}\b(?:[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*))\)/im",
          "/\n/m"
        ],
        [
          "<em><strong>$1</strong></em>",
          "<strong>$1</strong>",
          "<em>$1</em>",
          "<h1>$1</h1>",
          "<h2>$1</h2>",
          "<h3>$1</h3>",
          "<h4>$1</h4>",
          "<a target=\"_blank\" rel=\"noreferrer noopener\" href=\"$2\">$1</a>",
          "<br>\n"
        ],
        $escaped_input
        );
      
        //Remove break from headers
        return preg_replace("/<\/h(\d)><br>/m","</h$1>",$markdown_processed);
      
      }
}
