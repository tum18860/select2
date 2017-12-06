<?php
/**
 * Select2 plugin for Craft CMS 3.x
 *
 * Fieldtype that uses the popular Select2 jQuery plugin as a replacement to <select> fields.
 *
 * @link      http://bymayo.co.uk
 * @copyright Copyright (c) 2017 Jason Mayo
 */

namespace bymayo\select2\models;

use bymayo\select2\Select2;

use Craft;
use craft\base\Model;

/**
 * Select2Model Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Jason Mayo
 * @package   Select2
 * @since     2.0.0
 */
class Select2Model extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
