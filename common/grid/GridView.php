<?php

namespace common\grid;

use yii\grid\GridView as BaseGridView;

/**
 * Description of GridView class
 *
 * @author Sergiy Filonyuk <sergiy.filonyuk@gmail.com>
 */
class GridView extends BaseGridView{
    public $showHeader = true;
    public $layout = '{items}';
    
    public $title       = 'title';
    public $primaryKey  = 'id';
    public $parentKey   = 'parent_id';
    
    public $htmlPlus  = '<i class="fa fa-plus-circle text-info"></i>&nbsp;';
    public $htmlSpace = '<div class="tree-space">&nbsp;</div>';
    
    public $css = '.tree-space{width: 10px; margin-right: 20px; display: inline-block; border-right: 1px dashed Silver;}';
    
    /**
     * 
     * @return type
     */
    private function checkParent(array $objects, $id = 0) {
        
        foreach ($objects as $value) {
            if ($value->{$this->parentKey} == $id) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param array $objects
     * @param array $result
     * @param type $parent
     * @param type $depth
     * @return array
     */
    public function parentSort(array $objects, array &$result = array(), $parent = 0, $depth = 0) {
        
        foreach ($objects as $key => $object) {
            if ($object->{$this->parentKey} == $parent) {
                
                $parented = $this->checkParent($objects, $object->{$this->primaryKey});
                $plus = ($parented) ? $this->htmlPlus : '';
                $tag = ($parented || $object->{$this->parentKey} == 0) ? 'b' : 'span';
                
                $object->{$this->title} = \yii\helpers\Html::tag($tag, implode(' ', [
                    str_repeat($this->htmlSpace, $depth),
                    $plus, 
                    $object->{$this->title}
                ]));
                
                $result[] = $object;
                unset($objects[$key]);
                $this->parentSort($objects, $result, $object->{$this->primaryKey}, $depth + 1);
            }
        }

        return $result;
    }

    /**
     * Initialization 
     */
    public function init() {
        parent::init();
        
        $this->dataProvider->sort = false;
        $this->dataProvider->pagination = false;
        
        $this->view->registerCss($this->css);
    }
    
    /**
     * renderTableBody()
     * @return type
     */
    public function renderTableBody() {
        
        $tree = [];
        $models = $this->dataProvider->getModels();

        $this->parentSort($models, $tree);
        
        $rows = [];
        foreach ($tree as $index => $model) {
            
            $key = $model->{$this->primaryKey};
            
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows) && $this->emptyText !== false) {
            $colspan = count($this->columns);

            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        } else {
            return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
        }
    }
}
