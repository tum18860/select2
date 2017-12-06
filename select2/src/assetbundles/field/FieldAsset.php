<?php
/**
 * Select2 plugin for Craft CMS 3.x
 *
 * Fieldtype that uses the popular Select2 jQuery plugin as a replacement to <select> fields.
 *
 * @link      http://bymayo.co.uk
 * @copyright Copyright (c) 2017 Jason Mayo
 */

namespace bymayo\select2\assetbundles\field;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Jason Mayo
 * @package   Select2
 * @since     2.0.0
 */
class FieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@bymayo/select2/assetbundles/field/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/.js',
        ];

        $this->css = [
            'css/.css',
        ];

        parent::init();
    }
}
