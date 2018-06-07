<?php

namespace common\models;

use common\models\query\ProductCategoryQuery;
use common\models\translations\ProductCategoryTranslation;
use creocoder\translateable\TranslateableBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property int $position
 * @property int $parent_id
 * @property string $class
 * @property string $image_path
 * @property string $image_base_url
 * @property int $visible
 *
 * @property ProductCategory $parent
 * @property ProductCategory[] $productCategories
 * @property ProductCategoryTranslation[] $productCategoryTranslations
 */
class ProductCategory extends ActiveRecord {

    const STATUS_VISIBLE = 1;
    const STATUS_UNVISIBLE = 0;

    public static $catClass = [
        'spareParts',
        'combines',
        'press-pickers',
        'mountedTechnology'
    ];
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_category';
    }

    public function behaviors() {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'image_path',
                'baseUrlAttribute' => 'image_base_url'
            ],
            [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title', 'body', 'seo_title', 'seo_keywords', 'seo_description']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['class'], 'string', 'max' => 255],
            ['image', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('backend', 'ID'),
            'position' => Yii::t('backend', 'Position'),
            'parent_id' => Yii::t('backend', 'Parent ID'),
            'class' => Yii::t('backend', 'Class'),
            'image_path' => Yii::t('backend', 'Image Path'),
            'image_base_url' => Yii::t('backend', 'Image Base Url'),
            'visible' => Yii::t('backend', 'Visible'),
        ];
    }

    public function getOriginalImage() {
        return Yii::$app->glideHelper->createImage($this->image['path']);
    }

//    public static function getOriginalImage($path) {
//        return Yii::$app->glideHelper->createImage($path);
//    }
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
    public function getParent() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren() {
        return $this->hasMany(ProductCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslations() {
        return $this->hasMany(ProductCategoryTranslation::className(), ['product_category_id' => 'id']);
    }

    public function getLimitedProducts() {
        return $this->hasMany(Product::className(), ['category_id' => 'id'])
                        ->with(['translations', 'productAttachments'])
                        ->limit(rand(3, 5));
    }

    public function getProducts() {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
    
    public static function getAllChildIds($parentId, &$result = [])
    {        
        $res = self::find()
                ->select('id')       
                ->andWhere(['parent_id' => $parentId])
                ->visible()
                ->asArray()
                ->column();
        if(!empty($res)) {
            $result = array_merge($result, $res);
            self::getAllChildIds($res, $result);
        }
        return $result;
    }

    public static function getForSiteRandomCats() {
        return self::find()
                        ->select(ProductCategory::tableName() . '.*')
                        ->with('translations')
                        ->innerJoinWith('products', false)
                        ->visible()
                        ->limit(4)
                        ->orderBy(new Expression('rand()'))
                        ->groupBy('id')
                        ->all();
    }

    public static function getForSiteMainCats() {
        return self::find()
                        ->onlyParent()
                        ->visible()
                        ->with(['translations', 'children' => function($q){
                            $q->visible()
                                    ->with('translations')
                                    ->orderBy(['position'=> SORT_ASC]);
                        }])
                        ->orderBy(['position'=> SORT_ASC])
                        ->all();
    }

    public static function getOneForSite(string $slug) {
        return self::find()
                        ->with('translations')
                        ->visible()
                        ->bySlug($slug)
                        ->limit(1)
                        ->one();
    }

    public static function getOneForSiteById(int $id) {
        return self::find()
                        ->with('translations')
                        ->visible()
                        ->byId($id)
                        ->limit(1)
                        ->one();
    }

    public static function getOneForSiteFirst() {
        return self::find()
                        ->with('translations')
                        ->visible()
                        ->limit(1)
                        ->one();
    }

    public static function getForIndex() {
        return self::find()
                        ->select(ProductCategory::tableName() . '.*')
                        ->with(['translations'])
                        ->innerJoinWith(['products'], false)
                        ->visible()
                                        ->orderBy(new Expression('rand()'))

                        ->limit(4)
                        ->groupBy('id')
                        ->all();
    }

    public static function getAllStructure($parentid = null)
    {
        $res =  self::find()
                ->andWhere(['parent_id' => $parentid])
                ->asArray()
                ->all();
        foreach($res as &$one) {
//            if($parentid > 0) {
//                return [];
//            }
            $one['children'] = self::getAllStructure($one['id']);
//            if(empty($one['children'])) {
//                return [];
//            }
        }
        return $res;
                
    }
    /**
     * @inheritdoc
     * @return ProductCategoryQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProductCategoryQuery(get_called_class());
    }

}
