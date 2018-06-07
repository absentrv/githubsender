<?php
namespace common\behaviors;

use common\models\ProductFilter;
use common\models\ProductUsedIn;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Description of ProductUsedInBehavior
 *
 * @author Sergiy Filonyuk <sf@32x32.com.ua>
 */
class ProductUsedInBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'setUsedIn',
            ActiveRecord::EVENT_AFTER_UPDATE => 'setUsedIn'
        ];
    }

    public function setUsedIn()
    {
        if (!$this->owner->isNewRecord) {
            $this->removeUsedIn();
        }
        if (!$this->owner->usedIn) {
            return;
        }

        foreach ($this->owner->usedIn as $one) {
            $usedInModel = new ProductUsedIn();
            foreach ($one as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $usedInModel->translate($language)->$attribute = $translation;
                }
            }
            if ($usedInModel->save()) {
                $this->owner->link('productUsedIn', $usedInModel);
                $this->createFilter($one);
            } else {
                $this->owner->addError('usedIn', $usedInModel->getErrors());
            }
        }
    }

    private function createFilter($one)
    {
        $first = array_values($one)[0];
        
        $parentFilter = ProductFilter::getParentByTitle($first['parent_title']) ?? new ProductFilter();
        
        if (!$parentFilter->isNewRecord) {
            $childFilter = ProductFilter::getChildByTitle($first['title'], $parentFilter->id) ?? new ProductFilter();
        } else {
            $childFilter = new ProductFilter();
        }
        foreach ($one as $language => $data) {
            $parentFilter->translate($language)->title = $data['parent_title'];
            $childFilter->translate($language)->title = $data['title'];
        }
        
        $parentFilter->save();
        $childFilter->parent_id = $parentFilter->id;
        if ($childFilter->save()) {
            $this->owner->link('filters', $childFilter);
        }
    }

    private function removeUsedIn()
    {
        $this->owner->unlinkAll('productUsedIn', true);
    }
}
