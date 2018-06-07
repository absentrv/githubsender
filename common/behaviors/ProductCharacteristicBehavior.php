<?php

namespace common\behaviors;

use common\models\ProductCharacteristic;
use common\models\ProductFilter;
use InvalidArgumentException;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Description of ProductCharacteristicBehavior
 *
 * @author Sergiy Filonyuk <sf@32x32.com.ua>
 */
class ProductCharacteristicBehavior extends Behavior {

    public $attribute;

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'setCharacteristics',
            ActiveRecord::EVENT_AFTER_UPDATE => 'setCharacteristics'
        ];
    }

    public function init() {
        parent::init();
        if (!$this->attribute) {
            throw new InvalidArgumentException('Property Attribute should be set');
        }
    }

    public function setCharacteristics() {
        if (!$this->owner->isNewRecord) {
            $this->removeCharacteristics();
            $this->removeFilters();
        }
       
        if (!$this->owner->{$this->attribute}) {
            return;
        }

        foreach ($this->owner->{$this->attribute} as $oneCharacteristic) {
            if (COUNT($oneCharacteristic) < 2) {
                continue;
            }
            $success = $this->linkToFilter($oneCharacteristic);
            
            if(!$success) {
                continue;
            }
            $first = array_values($oneCharacteristic)[0];
            $characteristicModel = ProductCharacteristic::getOneByTitleAndMeasurement($first['title'], $first['value'], $first['measurement']) ?? new ProductCharacteristic();
            foreach ($oneCharacteristic as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $characteristicModel->translate($language)->$attribute = $translation;
                }
            }
            if ($characteristicModel->save()) {
                $this->owner->link('productCharacteristics', $characteristicModel);
            } else {
                $this->owner->addError('characteristics', $characteristicModel->getErrors());
            }
        }
    }
    private function removeFilters() {
        $this->owner->unlinkAll('filters', true);
    }
    private function removeCharacteristics() {
        $this->owner->unlinkAll('productCharacteristics', true);
    }
    private function linkToFilter(Array $characteristic) {   
        $save = true;
        $first = array_values($characteristic)[0];
        $parentFilter = ProductFilter::getParentByTitle($first['title']) ?? new ProductFilter();
        if(!$parentFilter->isNewRecord) {
            $childFilter = ProductFilter::getChildByTitle($first['value'] . $first['measurement'], $parentFilter->id) ?? new ProductFilter();
        } else {
            $childFilter = new ProductFilter();            
        }
        foreach ($characteristic as $language => $data) {
            if (empty($data['title']) || empty($data['value'])) {
                $save = false;
                break;
            }
            $parentFilter->translate($language)->title = $data['title'];
            $childFilter->translate($language)->title = $data['value'] . $data['measurement'];
        }
        if ($save) {
            $parentFilter->save();

            $childFilter->parent_id = $parentFilter->id;
            if ($childFilter->save()) {
                $this->owner->link('filters', $childFilter);
               
            }
        }
        return $save;
    }

}
