<?php

namespace common\behaviors;

use InvalidArgumentException;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Description of ManyToManyBehavior class
 *
 * @author Sergiy Filonyuk <sergiy.filonyuk@gmail.com>
 */
class ManyToManyBehavior extends Behavior {

    public $attribute;
    public $relation;

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveRelations',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveRelations',
        ];
    }

    public function init() {        
        parent::init();  
   
        if (!$this->relation) {
            throw new InvalidArgumentException("Wrong relation!");
        }
    }

    public function saveRelations() {                  
        $this->owner->unlinkAll($this->relation, true);        
        if (!empty($this->owner->{$this->attribute})) {
            foreach ($this->owner->{$this->attribute} as $oneAttribute) {
                $relation = $this->owner->getRelation($this->relation);                
                $relatedModel = $relation->modelClass::findOne($oneAttribute);                
                if($relatedModel) {
                    $this->owner->link($this->relation, $relatedModel);
                }               
            }
        }
    }    
}
