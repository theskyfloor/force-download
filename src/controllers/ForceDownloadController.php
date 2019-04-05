<?php
/**
 * Force Download plugin for Craft CMS 3.x
 *
 * Simple action to force downloading of an asset by ID without any user/permissions checks.
 *
 * @link      http://www.theskyfloor.com
 * @copyright Copyright (c) 2019 Alan Miller
 */

namespace theskyfloor\forcedownload\controllers;

use theskyfloor\forcedownload\ForceDownload;

use Craft;
use craft\base\Volume;
use craft\elements\Asset;
use craft\errors\AssetException;
use craft\errors\AssetLogicException;
use craft\errors\UploadFailedException;
use craft\fields\Assets as AssetsField;
use craft\helpers\App;
use craft\helpers\Assets;
use craft\helpers\Db;
use craft\helpers\FileHelper;
use craft\helpers\Image;
use craft\image\Raster;
use craft\models\VolumeFolder;
use craft\web\Controller;
use craft\web\UploadedFile;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author    Alan Miller
 * @package   ForceDownload
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * Download a file.
     *
     * @return Response
     * @throws BadRequestHttpException if the file to download cannot be found.
     */
    public function actionIndex(): Response
    {
        $assetId = Craft::$app->getRequest()->getSegment(2);
        $assetId = Craft::$app->security->validateData($assetId);
        //$assetId = Craft::$app->getRequest()->getRequiredBodyParam('assetId');
        
        $assetService = Craft::$app->getAssets();
        $asset = $assetService->getAssetById($assetId);
        if (!$asset) {
            throw new BadRequestHttpException(Craft::t('app', 'The Asset you’re trying to download does not exist.'));
        }
        // All systems go, engage hyperdrive! (so PHP doesn't interrupt our stream)
        App::maxPowerCaptain();
        $localPath = $asset->getCopyOfFile();
        $response = Craft::$app->getResponse()
            ->sendFile($localPath, $asset->filename);
        FileHelper::unlink($localPath);
        return $response;
    }
    
}
