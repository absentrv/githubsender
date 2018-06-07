<?php

namespace common\grid;

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;


class ActionColumn extends BaseActionColumn
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', [
            'class' => 'btn btn-xs btn-default',
        ]);
        $this->initDefaultButton('update', 'pencil', [
            'class' => 'btn btn-xs btn-default',
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'class' => 'btn btn-xs btn-default',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', [
                    'class' => "glyphicon glyphicon-$iconName text-primary",
                ]);
                return Html::a($icon, $url, $options);
            };
        }
    }
    protected function renderFilterCellContent() {
        return Html::a(Yii::t('backend', 'Reset'), Url::toRoute(''), ['class' => 'btn btn-warning btn-reset']);
    }
}