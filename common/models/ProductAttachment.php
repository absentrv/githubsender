<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_attachment".
 *
 * @property int $id
 * @property int $product_id
 * @property string $path
 * @property string $base_url
 * @property int $created_at
 * @property int $updated_at
 * @property int $order
 *
 * @property Product $product
 */
class ProductAttachment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attachment';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class
        ];
}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'created_at', 'updated_at', 'order'], 'integer'],
            [['path', 'base_url'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'product_id' => Yii::t('frontend', 'Product ID'),
            'path' => Yii::t('frontend', 'Path'),
            'base_url' => Yii::t('frontend', 'Base Url'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
            'order' => Yii::t('frontend', 'Order'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    public function getSliderImage()
    {
        $path = '';                   
        if(!file_exists('../../storage/web/source/' . $this->path)) {
            $path = '1/default_image.jpg';            
        } else {                       
            $path = $this->path;
        }
        return self::getGlideImage($path, 80, 75);
    }
    public function getInnerImage()
    {
        $path = '';                   
        if(!file_exists('../../storage/web/source/' . $this->path)) {
            $path = '1/default_image.jpg';            
        } else {                       
            $path = $this->path;
        }
        return self::getGlideImage($path, 490, 459);
    }

    public static function getGlideImage($path, $width, $height, $crop = true) {
        return Yii::$app->glideHelper->createImage($path, [
                    'w' => $width,
                    'h' => $height,
                    'fit' => $crop ? 'crop' : 'contain'
        ]);
    }
    
}
