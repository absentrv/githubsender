<?php

namespace common\models\query;

use common\models\ProductCategory;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\ProductCategory]].
 *
 * @see ProductCategory
 */
class ProductCategoryQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function byId($id)
    {
        return $this->andWhere([ProductCategory::tableName().'.id' => $id]);
    }
    
    public function bySlug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }
    public function onlyParent()
    {
        return $this->andWhere(['parent_id' => null]);
    }
    
    public function visible()
    {
        return $this->andWhere(['visible' => ProductCategory::STATUS_VISIBLE]);
    }
}
