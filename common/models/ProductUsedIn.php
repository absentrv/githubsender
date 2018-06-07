<?php

namespace common\models;

use common\models\translations\ProductUsedInTranslation;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "product_used_in".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $product_id
 * @property int $visible
 * @property int $position
 * @property int $crated_at
 * @property int $updated_at
 *
 * @property ProductUsedIn $parent
 * @property ProductUsedIn[] $productUsedIns
 * @property Product $product
 * @property ProductUsedInTranslation[] $productUsedInTranslations
 */
class ProductUsedIn extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_used_in';
    }

    public function behaviors() {
        return [
            [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'parent_title']
            ],
            TimestampBehavior::class
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
//            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
            'crated_at' => Yii::t('frontend', 'Crated At'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductUsedIn::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductUsedIns()
    {
        return $this->hasMany(ProductUsedIn::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getFilterUrl()
    {
        $catSlug = 'zapchastini';
        $parent = ProductFilter::getParentByTitle($this->parent_title);
        if(!$parent) {
            return 'javascript:void(0)';
        }
        $productFilter = ProductFilter::getChildByTitle($this->title, $parent->id);
        if(!$productFilter) {
            return 'javascript:void(0)';
        }
        return Url::to(['catalog/index', 'slug' => $catSlug, $parent->slug => $productFilter->id]);
    }
    /**
     * @return ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProductUsedInTranslation::className(), ['product_used_in_id' => 'id']);
    }
    
    
}

