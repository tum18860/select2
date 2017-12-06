<?php
/**
 * Select2 plugin for Craft CMS 3.x
 *
 * Fieldtype that uses the popular Select2 jQuery plugin as a replacement to <select> fields.
 *
 * @link      http://bymayo.co.uk
 * @copyright Copyright (c) 2017 Jason Mayo
 */

namespace bymayo\select2;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Select2
 *
 * @author    Jason Mayo
 * @package   Select2
 * @since     2.0.0
 *
 */
class Select2 extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Select2
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'select2',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
