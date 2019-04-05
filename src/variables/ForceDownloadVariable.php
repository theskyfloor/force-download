<?php
/**
 * Force Download plugin for Craft CMS 3.x
 *
 * Simple action to force downloading of an asset by ID without any user/permissions checks.
 *
 * @link      http://www.theskyfloor.com
 * @copyright Copyright (c) 2019 Alan Miller
 */

namespace theskyfloor\forcedownload\variables;

use theskyfloor\forcedownload\ForceDownload;

use Craft;
use craft\helpers\Template;

/**
 * @author    Alan Miller
 * @package   ForceDownload
 * @since     1.0.0
 */
class ForceDownloadVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function downloadUrl($optional = null)
    {
        $hashed = Craft::$app->security->hashData($optional);
        $result = '<a href="/force-download/'.$hashed.'">Download</a>';
        return Template::raw($result);
    }

    /**
     * @param null $optional
     * @return string
     */
    public function download($optional = null)
    {
        $hashed = Craft::$app->security->hashData($optional);
        $result = '/force-download/'.$hashed;
        return $result;
    }
}
