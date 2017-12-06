<?php
/**
 * Select2 plugin for Craft CMS 3.x
 *
 * Fieldtype that uses the popular Select2 jQuery plugin as a replacement to <select> fields.
 *
 * @link      http://bymayo.co.uk
 * @copyright Copyright (c) 2017 Jason Mayo
 */

namespace bymayo\select2\fields;

use bymayo\select2\Select2;
use bymayo\select2\assetbundles\field\FieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Jason Mayo
 * @package   Select2
 * @since     2.0.0
 */
class  extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('Select2', '');
    }

    // Public Methods
    // =========================================================================


    public function getJsonFolderPath()
    {
	    
	    $config = craft()->config->get('select2'); // Make Global
	    
		$templateFolderPath = craft()->path->getSiteTemplatesPath(); // Make Global
		
		$jsonFolder = ($config['jsonFolder']) ? $config['jsonFolder'] : 'select2';
		
		return $jsonFolderPath = $templateFolderPath . $jsonFolder . '/';
	    
    }
    
    public function getJsonFiles()
    {
	    
	    $jsonFolderPath = $this->getJsonFolderPath();

		$jsonFiles = [];
				
		if (IOHelper::folderExists($jsonFolderPath)) {
			foreach(glob($jsonFolderPath . '*.json', GLOB_BRACE) as $jsonFile) {
				//array_push($jsonFiles, str_replace($jsonFolderPath, "", $jsonFile));
				$jsonFileName = str_replace($jsonFolderPath, "", $jsonFile);
				$jsonFiles[$jsonFileName] = $jsonFileName;
			}
			return $jsonFiles;
		}
	    
    }
    
    public function getJsonFileOptions($list, $json = null)
    {
	    
        // Get List	    
	    if ($list === 'json') {
	        $jsonList = $this->getJsonFolderPath() . $json;		    
	    }
	    else {
	        $jsonList = UrlHelper::getResourceUrl('select2/json/' . $list . '.json');
	    }

        // Get List Contents
        $json = file_get_contents($jsonList);
        
        // Decode to Array
		return json_decode($json, TRUE);
	    
    }
    
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'select2/_components/fields/_settings',
            [
                'field' => $this,
	            'list' => array(AttributeType::String),
	            'jsonFile' => array(AttributeType::String),
	            'placeholder' => array(AttributeType::String),
	            'multiple' => array(AttributeType::String),
	            'limit' => array(AttributeType::String),
	            'jsonFiles' => $this->getJsonFiles()
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
	    
		if (!$value) $value = new Select2Model();

		// Get Field Settings
		$settings = $this->getSettings();

		// Reformat the input name into something that looks more like an ID
        $id = craft()->templates->formatInputId($name);
        
        // Figure out what that ID is going to look like once it has been namespaced
        $namespacedId = craft()->templates->namespaceInputId($id);
        
        // Options to pass to fieldtype jQuery plugin
        $pluginOptions = array(
            'namespaceId' => $namespacedId,
            'limit' => ($settings->limit) ? $settings->limit : 1,
            'placeholder' => ($settings->placeholder) ? $settings->placeholder : 'Select an Option',
		);

        $pluginOptions = json_encode($pluginOptions);
        
        craft()->templates->includeCssResource('select2/vendor/select2/css/select2.css');
        craft()->templates->includeJsResource('select2/vendor/select2/js/select2.full.js');
        
        // Include field CSS & JS
        craft()->templates->includeCssResource('select2/css/style.css');
        craft()->templates->includeJsResource('select2/js/field.js');

		// Initialise jQuery plugin and pass options
        craft()->templates->includeJs("$('#{$namespacedId}').Select2FieldType(".$pluginOptions.");");

		// Options to pass to field
        $fieldOptions = array(
            'id' => $id,
            'name' => $name,
            'namespaceId' => $namespacedId,
            'prefix' => craft()->templates->namespaceInputId(""),
            'settings' => $settings,
            'value' => $value,
            'options' => $this->getJsonFileOptions($settings->list, $settings->jsonFile)
		);

        return craft()->templates->render('select2/field/field.twig', $fieldOptions);
	    
/*
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(FieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').Select2(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'select2/_components/fields/_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
*/
    }
}
