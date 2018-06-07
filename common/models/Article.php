<?php

namespace common\models;

use common\models\query\ArticleQuery;
use common\models\translations\ArticleTranslation;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property array $attachments
 * @property integer $category_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property User $updater
 * @property ArticleCategory $category
 * @property ArticleAttachment[] $articleAttachments
 */
class Article extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true
            ],
//            [
//                'class' => UploadBehavior::className(),
//                'attribute' => 'attachments',
//                'multiple' => true,
//                'uploadRelation' => 'articleAttachments',
//                'pathAttribute' => 'path',
//                'baseUrlAttribute' => 'base_url',
//                'orderAttribute' => 'order',
//                'typeAttribute' => 'type',
//                'sizeAttribute' => 'size',
//                'nameAttribute' => 'name',
//            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ],
            [
                'class' => \creocoder\translateable\TranslateableBehavior::class,
                'translationAttributes' => ['title', 'seo_title', 'body', 'seo_keywords', 'seo_description']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug'], 'unique'],           
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['status'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['thumbnail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => "ЧПУ",
            'thumbnail' => "Картинка",
            'status' =>"Статус",
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Author'),
            'updated_by' => Yii::t('common', 'Updater'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public static function getOneForSite($slug)
    {
        return self::find()
                ->with(['translations'])
                ->published()
                ->bySlug($slug)
                ->limit(1)
                ->one();
    }
    public static function getLastNews(int $without)
    {
        return self::find()
                ->with(['translations'])
                ->published()
                ->andWhere(['!=','id', $without])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(3)
                ->all();
    }
    public static function getNextNewsSlug(int $createdAt) {
        return self::find()
                ->select('slug')
                ->where(['>','created_at', $createdAt])
                ->limit(1)
                ->asArray()
                ->scalar();
    }
    public static function getPrevNewsSlug(int $createdAt) {
        return self::find()
                ->select('slug')
                ->where(['<','created_at', $createdAt])
                ->limit(1)
                ->asArray()
                ->scalar();
    }
     public function getListImage() {       
        return self::getGlideImage($this->thumbnail['path'], 341, 181);
    }
     public function getLastNewsImage() {       
        return self::getGlideImage($this->thumbnail['path'], 179, 119);
    }
   public function getOriginalImage() {
        return Yii::$app->glideHelper->createImage($this->thumbnail['path']);
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
//    public function getArticleAttachments()
//    {
//        return $this->hasMany(ArticleAttachment::className(), ['article_id' => 'id']);
//    }
    
    public function getTranslations()
    {
        return $this->hasMany(ArticleTranslation::class, ['article_id' => 'id']);
    }
}
