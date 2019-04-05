<?php
/**
 * Force Download plugin for Craft CMS 3.x
 *
 * Simple action to force downloading of an asset by ID without any user/permissions checks.
 *
 * @link      http://www.theskyfloor.com
 * @copyright Copyright (c) 2019 Alan Miller
 */

namespace theskyfloor\forcedownload;

use theskyfloor\forcedownload\variables\ForceDownloadVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class ForceDownload
 *
 * @author    Alan Miller
 * @package   ForceDownload
 * @since     1.0.0
 *
 */
class ForceDownload extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ForceDownload
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.1';

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
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                //$event->rules['siteActionTrigger1'] = 'force-download';
                $event->rules['force-download/<any:\w+>'] = 'force-download';
            }
        );


        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('forceDownload', ForceDownloadVariable::class);
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
                'force-download',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
