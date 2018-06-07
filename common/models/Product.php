<?php

namespace common\models;

use common\models\ProductUsedIn;
use common\models\query\ProductQuery;
use common\models\translations\ProductCharacteristicTranslation;
use common\models\translations\ProductTranslation;
use creocoder\translateable\TranslateableBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionProviderInterface;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $position
 * @property string $slug
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $category_id
 * @property string $price
 * @property int $availability
 * @property string $image_path
 * @property string $image_base_url
 * @property int $factory_logo_id
 *
 * @property Logo $factoryLogo
 * @property ProductCategory $category
 * @property ProductAnalog[] $productAnalogs
 * @property ProductAnalog[] $productAnalogs0
 * @property Product[] $mainProducts
 * @property Product[] $analogProducts
 * @property ProductAttachment[] $productAttachments
 * @property ProductCharacteristic[] $productCharacteristics
 * @property ProductCharacteristicTranslation[] $productCharacteristicTranslations
 * @property ProductTranslation[] $productTranslations
 */
class Product extends ActiveRecord implements CartPositionProviderInterface {

    const STATUS_VISIBLE = 1;
    const STATUS_UNVISIBLE = 0;

    public $image;
    public $attachments;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
                'ensureUnique' => true
            ],
            [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'short_description', 'description', 'seo_title', 'seo_keywords', 'seo_description']
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'baseUrlAttribute' => 'image_base_url',
                'pathAttribute' => 'image_path'
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'productAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'position' => Yii::t('frontend', 'Position'),
            'slug' => Yii::t('frontend', 'Slug'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
            'status' => Yii::t('frontend', 'Status'),
            'category_id' => Yii::t('frontend', 'Category ID'),
            'price' => Yii::t('frontend', 'Price'),
            'availability' => Yii::t('frontend', 'Availability'),
            'image_path' => Yii::t('frontend', 'Image Path'),
            'image_base_url' => Yii::t('frontend', 'Image Base Url'),
            'factory_logo_id' => Yii::t('frontend', 'Factory Logo ID'),
        ];
    }

    public function getOriginalImage() {
        return Yii::$app->glideHelper->createImage($this->image['path']);
    }

    public function getSliderImage() {
        $filePath = Yii::getAlias('@storage/web/source/' . $this->image['path']);
        if (!$this->image || !file_exists($filePath)) {
            $path = '1/default_image.jpg';
        } else {
            $path = $this->image['path'];
        }
        return self::getGlideImage($path, 80, 75);
    }

    public function getInnerImage() {
        $filePath = Yii::getAlias('@storage') . '/web/source/' . $this->image['path'];
        if (!$this->image || !file_exists($filePath)) {
            $path = '1/default_image.jpg';
        } else {
            $path = $this->image['path'];
        }
        return self::getGlideImage($path, 490, 459);
    }

    public function getCatalogImage() {
        $filePath = Yii::getAlias('@storage/web/source/' . $this->image['path']);
        if (!$this->image || !file_exists($filePath)) {
            $path = '1/default_image.jpg';
        } else {
            $path = $this->image['path'];
        }
        return self::getGlideImage($path, 283, 213);
    }
    public function getCartImage() {
        $filePath = Yii::getAlias('@storage/web/source/' . $this->image['path']);
        if (!$this->image || !file_exists($filePath)) {
            $path = '1/default_image.jpg';
        } else {
            $path = $this->image['path'];
        }
        return self::getGlideImage($path, 88, 88);
    }

    public function getIndexImage() {
        $filePath = Yii::getAlias('@storage/web/source/' . $this->image['path']);
        if (!$this->image || !file_exists($filePath)) {
            $path = '1/default_image.jpg';
        } else {
            $path = $this->image['path'];
        }
        return self::getGlideImage($path, 296, 222);
    }

    public static function getGlideImage($path, $width, $height, $crop = true) {
        return Yii::$app->glideHelper->createImage($path, [
                    'w' => $width,
                    'h' => $height,
                    'fit' => $crop ? 'crop' : 'contain'
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getFactoryLogo() {
        return $this->hasOne(Logo::className(), ['id' => 'factory_logo_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMainProducts() {
        return $this->hasMany(Product::className(), ['id' => 'main_product_id'])
                        ->viaTable('product_analog', ['analog_product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAnalogProducts() {
        return $this->hasMany(Product::className(), ['id' => 'analog_product_id'])->viaTable('product_analog', ['main_product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFilters() {
        return $this->hasMany(ProductFilter::className(), ['id' => 'filter_id'])->viaTable('product_filter_product', ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductAttachments() {
        return $this->hasMany(ProductAttachment::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductCharacteristics() {
        return $this->hasMany(ProductCharacteristic::className(), ['product_id' => 'id']);
//            ->orderBy(['parent_title', 'SORT_ASC']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslations() {
        return $this->hasMany(ProductTranslation::className(), ['product_id' => 'id']);
    }

    public function getProductUsedIn() {
        return $this->hasMany(ProductUsedIn::class, ['product_id' => 'id']);
    }

    public function removeCharacteristics() {
        $this->unlinkAll('productCharacteristics', true);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProductQuery(get_called_class());
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['product_id' => 'id']);
    }
    
    public static function getOneForSiteBySlug(string $slug) {
        return self::find()
                        ->with(['translations', 'productAttachments', 'productCharacteristics.translations', 'analogProducts' => function($q) {
                                $q->with(['translations', 'productCharacteristics.translations']);
                            }, 'productUsedIn' => function($q) {
                                $q->joinWith('translations')
                                    ->orderBy(['product_used_in_translation.parent_title' => SORT_ASC]);
                            }, 'comments.children'])
                        ->visible()
                        ->bySlug($slug)
                        ->limit(1)
                        ->one();
    }

    
    public static function getIndexRecomended()
    {
        return self::find()
                ->with(['translations', 'productAttachments', 'productCharacteristics.translations'])
                ->visible()
                ->orderBy([new \yii\db\Expression('rand()')])
                ->limit(10)
                ->all();
    }
    public function getFormattedAvailability() {
        return $this->availability >= 10 ? 3 :
                ($this->availability >= 5 ? 2 :
                ($this->availability > 0 ? 1 : 0));
    }

    public function getCartPosition($params = array()): CartPositionInterface {
        return \Yii::createObject([
                    'class' => 'frontend\models\ProductCartPosition',
                    'id' => $this->id,
        ]);
    }
    
    public static function getAnalogsByProductIds(Array $ids) {
//        $ids = [1229, 1228];
        $result = self::find()
                ->innerJoin('product_analog', 'product_analog.analog_product_id=product.id')
                ->with(['translations','productAttachments', 'productCharacteristics' => function($q) {
                    $q->with('translations');
                }])
                ->where(['and', 'product.status='.self::STATUS_VISIBLE, ['in', 'main_product_id', $ids], 'product.availability > 0'])
                ->all();
        return $result;
    }
}
