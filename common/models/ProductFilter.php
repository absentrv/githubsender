<?php
namespace common\models;

use common\models\translations\ProductFilterTranslation;
use creocoder\translateable\TranslateableBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_filter".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $status
 * @property int $position
 * @property string $slug
 * @property int $filter_type
 *
 * @property ProductFilter $parent
 * @property ProductFilter[] $productFilters
 * @property ProductFilterProduct[] $productFilterProducts
 * @property Product[] $products
 * @property ProductFilterTranslation[] $productFilterTranslations
 */
class ProductFilter extends ActiveRecord
{

    const FILTER_CHECK = 0;
    const FILTER_RADIO = 1;
    const STATUS_UNVISIBLE = 0;
    const STATUS_VISIBLE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'status', 'position', 'filter_type'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductFilter::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'translateable' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => ['title'],
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => Yii::t('frontend', 'Parent ID'),
            'status' => Yii::t('frontend', 'Status'),
            'position' => Yii::t('frontend', 'Position'),
            'slug' => Yii::t('frontend', 'Slug'),
            'filter_type' => Yii::t('frontend', 'Filter Type'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductFilter::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(ProductFilter::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
                ->viaTable('product_filter_product', ['filter_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProductFilterTranslation::className(), ['product_filter_id' => 'id']);
    }

    public static function getParentByTitle(string $title)
    {
        return self::find()
                ->joinWith('translations')
                ->andWhere([
                    'title' => $title,
                    'parent_id' => null
                ])
                ->limit(1)
                ->one();
    }

    public static function getChildByTitle(string $title, int $parentId)
    {
        $res = self::find()
            ->joinWith('translations')
            ->andWhere([
                'title' => $title,
                'parent_id' => $parentId
            ])
            ->andWhere(['>', 'parent_id', '0'])
//            ->andWhere(['>', 'parent_id', '0'])
            ->limit(1)
            ->one();
        return $res;
    }
}
