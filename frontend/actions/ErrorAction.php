<?php

namespace frontend\actions;

use yii\web\ErrorAction as BaseErrorAction;
/**
 * Description of ErrorAction
 *
 * @author Serhii Filoniuk
 */
class ErrorAction extends BaseErrorAction
{
    public function renderHtmlResponse()
    {
        return $this->getViewRenderParams();
    }
}
