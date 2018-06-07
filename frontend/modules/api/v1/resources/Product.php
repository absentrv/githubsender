<?php

namespace frontend\modules\api\v1\resources;

/**
 * Description of Product
 *
 * @author Sergiy Filonyuk <sf@32x32.com.ua>
 */
class Product extends \common\models\Product {

    public $characteristics;
    public $analogs;
    public $usedIn;

    public function fields() {
        return [
            'id',
            '1c_id',
            'articul',
            'position',
            'status',
            'category_id',
            'availability',
            'price',
            'price_usd',
            'oem',
            'image',
            'productAttachments',
            'translations' => 'selectTranslations',
            'analogs' => 'selectAnalogProducts',
            'characteristics' => 'selectProductCharacteristics',
            'usedIn' => 'selectProductUsedIn'
        ];
    }

    public function rules() {
        return [
            [['category_id'], 'required'],
            [['1c_id', 'articul'], 'string', 'max' => 50],
            [['oem'], 'string', 'max' => 255],
            [['description', 'short_description'], 'string'],
            [['price', 'availability', 'price_usd'], 'number'],
            ['1c_id', \frontend\components\validators\MyUniqueValidator::class],
            [['position', 'category_id', 'status'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\ProductCategory::class, 'targetAttribute' => 'id'],
            [['analogs'], 'each', 'rule' => ['exist', 'targetClass' => self::class, 'targetAttribute' => 'id'], 'skipOnEmpty' => true],
            [['characteristics', 'usedIn'], 'safe']
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    public function getSelectTranslations() {
        return $this->hasMany(\common\models\translations\ProductTranslation::class, ['product_id' => 'id'])
                        ->select(['title', 'description', 'language', 'short_description'])
                        ->indexBy('language');
    }

    public function getSelectProductCharacteristics() {
        return $query = (new \yii\db\Query())
                ->select(['language', 'title', 'measurement', 'value'])
                ->from('product_characteristic_translation')
                ->innerJoin('product_characteristic', 'product_characteristic.id = product_characteristic_translation.product_characteristic_id')
                ->where(['product_characteristic.product_id' => $this->id])
                ->all();
    }
    public function getSelectProductUsedIn() {
        return $query = (new \yii\db\Query())
                ->select(['language', 'title', 'parent_title'])
                ->from('product_used_in_translation')
                ->innerJoin('product_used_in', 'product_used_in.id = product_used_in_translation.product_used_in_id')
                ->where(['product_used_in.product_id' => $this->id])
//                ->indexBy('language')
                ->all();
    }

    /**
     * @return ActiveQuery
     */
    public function getSelectAnalogProducts() {
        return $query = (new \yii\db\Query())
                ->select('analog_product_id')
                ->from('product_analog')
                ->where(['main_product_id' => $this->id])
                ->column();
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        array_push($behaviors, [
            'class' => \common\behaviors\ProductCharacteristicBehavior::class,
            'attribute' => 'characteristics'
        ]);        
        array_push($behaviors, [
            'class' => \common\behaviors\ManyToManyBehavior::class,
            'attribute' => 'analogs',
            'relation' => 'analogProducts'
        ]);
        array_push($behaviors, [
            'class' => \common\behaviors\ProductUsedInBehavior::class,
        ]);
           
        return $behaviors;
    }

        
}
