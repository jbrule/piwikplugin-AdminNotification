<?php

namespace Piwik\Plugins\AdminNotification;

class API extends \Piwik\Plugin\API
{
    private static $plugin_name = 'AdminNotification';

    public function isEnabled()
    {
        $settings = new SystemSettings();
        $enabled  = $settings->enabled->getValue();
        $message  = $this->getMessage();

        if ($enabled && !empty($message)) {
            return true;
        }

        return false;
    }

    public function getContext()
    {
        $settings = new SystemSettings();
        return $settings->context->getValue();
    }

    public function getTitle()
    {
        $settings = new SystemSettings();
        return $settings->title->getValue();
    }

    public function getMessage()
    {
        $settings = new SystemSettings();
        return $settings->message->getValue();
    }
}
