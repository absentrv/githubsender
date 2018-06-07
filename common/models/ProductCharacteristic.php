<?php
namespace common\models;

use common\models\translations\ProductCharacteristicTranslation;
use creocoder\translateable\TranslateableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_characteristic".
 *
 * @property int $id
 * @property int $product_id
 *
 * @property Product $product
 */
class ProductCharacteristic extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_characteristic';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'value', 'measurement']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProductCharacteristicTranslation::className(), ['product_characteristic_id' => 'id']);
    }

    public static function getOneByTitleAndMeasurement($title, $value, $measurement)
    {
        return self::find()
                ->joinWith('translations')
                ->andWhere([
                    'title' => $title,
                    'value' => $value,
                    'measurement' => $measurement
                ])
                ->limit(1)
                ->one();
    }
}
