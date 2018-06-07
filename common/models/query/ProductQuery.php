<?php

namespace common\models\query;

use common\models\Product;
use frontend\modules\api\v1\resources\Product as Product2;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Product]].
 *
 * @see Product
 */
class ProductQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Product|array|null
     */
    public function visible()
    {
        return $this->andWhere(['status' => Product::STATUS_VISIBLE]);
    }
    /**
     * @inheritdoc
     * @return Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function byId($id)
    {
        return $this->andWhere(['product.id' => $id]);
    }
    public function byCategoryId($id)
    {
        return $this->andWhere(['product.category_id' => $id]);
    }
    public function bySlug(string $slug)
    {
        return $this->andWhere([Product2::tableName().'.slug' => $slug]);
    }
    
}
