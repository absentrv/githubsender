<?php

namespace backend\controllers;

use backend\controllers\BaseController;

class FileManagerController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
