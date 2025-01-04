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
    public $message;

    /** @var Setting */
    public $type;

    /** @var Setting */
    public $priority;

    protected function init()
    {
        $this->enabled = $this->createEnabledSetting();

        $this->messageTitle = $this->createTitleSetting();

        $this->message = $this->createMessageSetting();

        $this->context = $this->createContextSetting();

        $this->type = $this->createTypeSetting();

        $this->priority = $this->createPrioritySetting();
    }

    private function createEnabledSetting()
    {
        return $this->makeSetting(
            'enabled',
            $default = false,
            FieldConfig::TYPE_BOOL,
            function (FieldConfig $field) {
                $field->title = $this->t('EnabledSettingTitle');
                $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
                $field->description = $this->t('EnabledSettingDescription');
            }
        );
    }

    private function createTitleSetting()
    {
        return $this->makeSetting(
            'title',
            $default = "Message from Matomo Administrator",
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
                $field->title = $this->t('TitleSettingTitle');
                $field->condition = 'enabled';
                $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
                $field->description = $this->t('TitleSettingDescription');
                $field->validate = function ($value) {
                    $value = trim($value);
                    if (strlen($value) == 0) {
                        throw new \Exception($this->t('TitleMissing'));
                    }
                };
            }
        );
    }

    private function createMessageSetting()
    {
        return $this->makeSetting(
            'message',
            $default = "",
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
            $field->title = $this->t('MessageSettingTitle');
            $field->condition = 'enabled';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            $field->description = $this->t('MessageSettingDescription');
            $field->inlineHelp = $this->t('MessageSettingHelp');
            $field->validate = function ($value) {
                $value = trim($value);
                if (strlen($value) == 0) {
                    throw new \Exception($this->t('MessageMissing'));
                }
            };
        });
    }

    private function createContextSetting()
    {
        return $this->makeSetting(
            'context',
            $default = Notification::CONTEXT_INFO,
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
                $field->title = $this->t('ContextSettingTitle');
                $field->condition = 'enabled';
                $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
                $field->description = $this->t('ContextSettingDescription');
                $field->availableValues = array(Notification::CONTEXT_INFO => Notification::CONTEXT_INFO,
                                                 Notification::CONTEXT_ERROR => Notification::CONTEXT_ERROR,
                                                 Notification::CONTEXT_SUCCESS => Notification::CONTEXT_SUCCESS,
                                                 Notification::CONTEXT_WARNING => Notification::CONTEXT_WARNING);
            }
        );
    }

    private function createTypeSetting()
    {
        return $this->makeSetting(
            'type',
            $default = Notification::TYPE_PERSISTENT,
            FieldConfig::TYPE_STRING,
            function (FieldConfig $field) {
                $field->title = $this->t('TypeSettingTitle');
                $field->condition = 'enabled';
                $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
                $field->description = $this->t('TypeSettingDescription');
                $field->availableValues = array(Notification::TYPE_PERSISTENT => Notification::TYPE_PERSISTENT,
                                                Notification::TYPE_TRANSIENT => Notification::TYPE_TRANSIENT,
                                                Notification::TYPE_TOAST => Notification::TYPE_TOAST);
            }
        );
    }

    private function createPrioritySetting()
    {
        return $this->makeSetting(
            'priority',
            $default = Notification::PRIORITY_MAX,
            FieldConfig::TYPE_FLOAT,
            function (FieldConfig $field) {
                $field->title = $this->t('PrioritySettingTitle');
                $field->condition = 'enabled';
                $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
                $field->description = $this->t('PrioritySettingDescription');
                $field->availableValues = array(Notification::PRIORITY_MIN => Notification::PRIORITY_MIN,
                                                Notification::PRIORITY_LOW => Notification::PRIORITY_LOW,
                                                Notification::PRIORITY_HIGH => Notification::PRIORITY_HIGH,
                                                Notification::PRIORITY_MAX => Notification::PRIORITY_MAX);
            }
        );
    }

    private function t($translate_token)
    {
        return Piwik::translate("AdminNotification_" . $translate_token);
    }
}
