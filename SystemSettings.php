<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Notification;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for AdminNotification.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $enabled;

    /** @var Setting */
    public $context;
    
    /** @var Setting */
    public $messageTitle;

    /** @var Setting */
    public $description;

    /** @var Setting */
    public $password;

    protected function init()
    {

        $this->enabled = $this->createEnabledSetting();

        $this->context = $this->createContextSetting();
        
        $this->messageTitle = $this->createTitleSetting();

        $this->message = $this->createMessageSetting();

    }
    
    private function createEnabledSetting()
    {
        return $this->makeSetting('enabled', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = $this->t('EnabledSettingTitle');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
            $field->description = $this->t('EnabledSettingDescription');
            $field->readableByCurrentUser = true;
        });
    }
    
    private function createContextSetting()
    {
        return $this->makeSetting('context', $default = "info", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('ContextSettingTitle');
            $field->condition = 'enabled';
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->description = $this->t('ContextSettingDescription');
            $field->availableValues = array(Notification::CONTEXT_INFO => Notification::CONTEXT_INFO,
                                                 Notification::CONTEXT_ERROR => Notification::CONTEXT_ERROR,
                                                 Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_WARNING => Notification::CONTEXT_WARNING);
        });
    }
    
    private function createTitleSetting()
    {
        return $this->makeSetting('title', $default = "Message from Piwik Administrator", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('TitleSettingTitle');
            $field->condition = 'enabled';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            //$field->uiControlAttributes = array("size"=> 65);
            $field->description = $this->t('TitleSettingDescription');
        });
    }
    
    private function createMessageSetting()
    {
        return $this->makeSetting('message', $default = "", FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = $this->t('MessageSettingTitle');
            $field->condition = 'enabled';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            $field->description = $this->t('MessageSettingDescription');
        });
    }
    
    private function t($translate_token){
        return Piwik::translate("AdminNotification_".$translate_token);
    }
}
