<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\AdvancedNotifications;

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
        $this->enabledLocal = new SystemSetting('enabledLocal', $this->t('EnabledLocalSettingTitle'));
        $this->enabledLocal->type  = static::TYPE_BOOL;
        $this->enabledLocal->uiControlType = static::CONTROL_CHECKBOX;
        $this->enabledLocal->description   = $this->t('EnabledLocalSettingDescription');
        $this->enabledLocal->readableByCurrentUser = true;
        $this->enabledLocal->defaultValue  = false;

        $this->addSetting($this->enabledLocal);
        
        $this->enabledRemote = new SystemSetting('enabledRemote', $this->t('EnabledRemoteSettingTitle'));
        $this->enabledRemote->type  = static::TYPE_BOOL;
        $this->enabledRemote->uiControlType = static::CONTROL_CHECKBOX;
        $this->enabledRemote->description   = $this->t('EnabledRemoteSettingDescription');
        $this->enabledRemote->readableByCurrentUser = true;
        $this->enabledRemote->defaultValue  = false;

        $this->addSetting($this->enabledRemote);
    }
    
    private function createContextSetting()
    {
        $this->contextLocal        = new SystemSetting('contextLocal', $this->t('ContextSettingTitle'));
        $this->contextLocal->type  = static::TYPE_STRING;
        $this->contextLocal->uiControlType = static::CONTROL_SINGLE_SELECT;
        $this->contextLocal->availableValues  = array(Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_ERROR => Notification::CONTEXT_ERROR,
                                                 Notification::CONTEXT_INFO => Notification::CONTEXT_INFO,
                                                 Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_WARNING => Notification::CONTEXT_WARNING);
        $this->contextLocal->description   = $this->t('ContextLocalSettingDescription');
        $this->contextLocal->readableByCurrentUser = true;
        $this->contextLocal->defaultValue  = "info";

        $this->addSetting($this->contextLocal);
        
        $this->contextRemote        = new SystemSetting('contextRemote', $this->t('ContextSettingTitle'));
        $this->contextRemote->type  = static::TYPE_STRING;
        $this->contextRemote->uiControlType = static::CONTROL_SINGLE_SELECT;
        $this->contextRemote->availableValues  = array(Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_ERROR => Notification::CONTEXT_ERROR,
                                                 Notification::CONTEXT_INFO => Notification::CONTEXT_INFO,
                                                 Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_WARNING => Notification::CONTEXT_WARNING);
        $this->contextRemote->description   = $this->t('ContextRemoteSettingDescription');
        $this->contextRemote->readableByCurrentUser = true;
        $this->contextRemote->defaultValue  = "info";

        $this->addSetting($this->contextRemote);
    }
    
     private function createTitleSetting()
    {
        $this->titleLocal        = new SystemSetting('titleLocal', $this->t('TitleLocalSettingTitle'));
        $this->titleLocal->type  = static::TYPE_STRING;
        $this->titleLocal->uiControlType = static::CONTROL_TEXT;
        $this->titleLocal->uiControlAttributes = array("size"=> 65);
        $this->titleLocal->description   = $this->t('TitleLocalSettingDescription');
        $this->titleLocal->readableByCurrentUser = true;
        $this->titleLocal->defaultValue  = "Message from Piwik Administrator";

        $this->addSetting($this->titleLocal);
        
        $this->titleRemote        = new SystemSetting('titleRemote', $this->t('TitleRemoteSettingTitle'));
        $this->titleRemote->type  = static::TYPE_STRING;
        $this->titleRemote->uiControlType = static::CONTROL_TEXT;
        $this->titleRemote->uiControlAttributes = array("size"=> 65);
        $this->titleRemote->description   = $this->t('TitleRemoteSettingDescription');
        $this->titleRemote->readableByCurrentUser = true;
        $this->titleRemote->defaultValue  = "Message from Website Administrator";

        $this->addSetting($this->title);
    }
    
    private function createMessageSetting()
    {
        $this->messageLocal = new SystemSetting('messageLocal', $this->t('MessageLocalSettingTitle'));
        $this->messageLocal->uiControlType = static::CONTROL_TEXTAREA;
        $this->messageLocal->description   = $this->t('MessageLocalSettingDescription');
        $this->messageLocal->readableByCurrentUser = true;
        $this->messageLocal->defaultValue  = "";

        $this->addSetting($this->messageLocal);
        
        $this->messageRemote = new SystemSetting('messageRemote', $this->t('MessageRemoteSettingTitle'));
        $this->messageRemote->uiControlType = static::CONTROL_TEXTAREA;
        $this->messageRemote->description   = $this->t('MessageRemoteSettingDescription');
        $this->messageRemote->readableByCurrentUser = true;
        $this->messageRemote->defaultValue  = "";

        $this->addSetting($this->messageRemote);
    }
    
    private function t($key)
    {
        return Piwik::translate('AdvancedNotifications_' . $key);
    }
}
