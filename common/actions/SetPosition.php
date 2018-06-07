<?php

namespace common\actions;

use Yii;
use yii\base\Action;

/**
 * Description of SetPosition class
 *
 * @author Sergiy Filonyuk <sergiy.filonyuk@gmail.com>
 */
class SetPosition extends Action {

    public $className;
    public $attribute = 'position';

    public function run() {
        if (Yii::$app->request->isAjax) {
            $objects = Yii::$app->request->post('objects');
            $position = 1;
            foreach ($objects as $oneObject) {
                $obj = new $this->className();
                $model = $obj::findOne($oneObject);
                if ($model) {
                    $model->{$this->attribute} = $position++;
                    $model->update(false, [$this->attribute]);
                }
            }
        }
    }

}
