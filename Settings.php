<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Notification;
use Piwik\Settings\SystemSetting;
use Piwik\Settings\UserSetting;

/**
 * Defines Settings for ExampleSettingsPlugin.
 *
 * Usage like this:
 * $settings = new Settings('ExampleSettingsPlugin');
 * $settings->autoRefresh->getValue();
 * $settings->metric->getValue();
 *
 */
class Settings extends \Piwik\Plugin\Settings
{
    public $enabled;
    public $message;
    
    protected function init()
    {
        $this->setIntroduction($this->t('PluginDescription'));
        
        $this->createEnabledSetting();
        
        $this->createContextSetting();
        
        $this->createTitleSetting();
        
        $this->createMessageSetting();

    }

    private function createEnabledSetting()
    {
        $this->enabled        = new SystemSetting('enabled', $this->t('EnabledSettingTitle'));
        $this->enabled->type  = static::TYPE_BOOL;
        $this->enabled->uiControlType = static::CONTROL_CHECKBOX;
        $this->enabled->description   = $this->t('EnabledSettingDescription');
        $this->enabled->readableByCurrentUser = true;
        $this->enabled->defaultValue  = false;

        $this->addSetting($this->enabled);
    }
    
    private function createContextSetting()
    {
        $this->context        = new SystemSetting('context', $this->t('ContextSettingTitle'));
        $this->context->type  = static::TYPE_STRING;
        $this->context->uiControlType = static::CONTROL_SINGLE_SELECT;
        $this->context->availableValues  = array(Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_ERROR => Notification::CONTEXT_ERROR,
                                                 Notification::CONTEXT_INFO => Notification::CONTEXT_INFO,
                                                 Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_WARNING => Notification::CONTEXT_WARNING);
        $this->context->description   = $this->t('ContextSettingDescription');
        $this->context->readableByCurrentUser = true;
        $this->context->defaultValue  = "info";

        $this->addSetting($this->context);
    }
    
     private function createTitleSetting()
    {
        $this->title        = new SystemSetting('title', $this->t('TitleSettingTitle'));
        $this->title->type  = static::TYPE_STRING;
        $this->title->uiControlType = static::CONTROL_TEXT;
        $this->title->uiControlAttributes = array("size"=> 65);
        $this->title->description   = $this->t('TitleSettingDescription');
        $this->title->readableByCurrentUser = true;
        $this->title->defaultValue  = "Message from Piwik Administrator";

        $this->addSetting($this->title);
    }
    
    private function createMessageSetting()
    {
        $this->message = new SystemSetting('message', $this->t('MessageSettingTitle'));
        $this->message->uiControlType = static::CONTROL_TEXTAREA;
        $this->message->description   = $this->t('MessageSettingDescription');
        $this->message->readableByCurrentUser = true;
        $this->message->defaultValue  = "";

        $this->addSetting($this->message);
    }
    
    private function t($key)
    {
        return Piwik::translate('AdminNotification_' . $key);
    }
}