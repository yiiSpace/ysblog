<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/30
 * Time: 14:35
 */

namespace my\admin\widgets;


use yii\base\Widget;
use yii\db\ActiveRecord;

/**
 * 设计思路参考 ActionColumn
 *
 * Class AdminView
 * @package my\admin\widgets
 */
class AdminView extends Widget
{


    /**
     * @var string
     */
    public $template = '{index} {create} {update} {delete} {view} ';

    /**
     * @var array
     */
    public $tabItems = [

    ];

    /**
     * 传递给底层对应的Tabs 组件的选项
     *
     * @var array
     */
    public $tabsOptions = [

    ];

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->initDefault();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->handleTabItems();
        return $this->render('admin-view', [
            'tabItems' => $this->tabItems,
            'tabsOptions' => $this->tabsOptions,
        ]);
    }

    /**
     * @var ActiveRecord
     */
    public $model = null;

    /**
     * @param ActiveRecord $model
     * @return $this
     */
    public function setModel(ActiveRecord $model)
    {
        $this->model = $model ;
        return $this ;
    }
    /**
     * default template is [['{index} {create} {update} {delete} {view} ']]
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template ;
        return $this ;
    }
    /**
     * 为了链式调用而存在
     *
     * @param $id
     * @param array|\Closure $itemConfig
     * @return $this
     */
    public function setTabItem($id, $itemConfig=[])
    {
        $this->tabItems[$id] = $itemConfig;
        return $this ;
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefault()
    {
        if (!isset($this->tabItems ['index'])) {
            $this->tabItems ['index'] = function () {
                return [
                    'label' => 'Index',
                    'headerOptions' => [],
                    'options' => ['id' => 'tab_action_index'],
                    'url' => ['index']
                ];
            };
        }
        if (!isset($this->tabItems ['create'])) {
            $this->tabItems ['create'] = function () {
                return [
                    'label' => 'Create',
                    'headerOptions' => [],
                    'options' => ['id' => 'tab_action_create'],
                    'url' => ['create']
                ];
            };
        }
        if (!isset($this->tabItems ['view'])) {
            $this->tabItems ['view'] = function () {
                return [
                    'label' => 'View',
                    'headerOptions' => [],
                    'options' => ['id' => 'tab_action_view'],
                    'url' => ['view','id'=>$this->model->primaryKey],
                    'linkOptions' => [
                        'class' => 'btn btn-info',
                    ],
                ];
            };
        }
        if (!isset($this->tabItems ['update'])) {
            $this->tabItems ['update'] = function () {
                return [
                    'label' => 'Update',
                    'headerOptions' => [],
                    'options' => ['id' => 'tab_action_update'],
                    'url' => ['update','id'=>$this->model->primaryKey],
                    'linkOptions' => [
                        'class' => 'btn btn-primary',
                    ],
                ];
            };
        }

        if (!isset($this->tabItems ['delete'])) {
            $this->tabItems ['delete'] = function () {
                return [
                    'label' => 'Delete',
                    'headerOptions' => [],
                    'options' => ['id' => 'tab_action_delete'],
                    'url' => ['delete','id'=>$this->model->primaryKey],
                    'linkOptions' => [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ],
                ];
            };
        }
    }

    /**
     * @return array
     */
    protected function handleTabItems()
    {
        $items = [];
        preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use (&$items) {
            $name = $matches[1];

            /*
            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }
            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
             */
            if (isset($this->tabItems[$name])) {

                $tabItem =  is_callable($this->tabItems[$name])?  call_user_func( $this->tabItems[$name] ) : $this->tabItems[$name];

                $items[] = $tabItem;
            }
        }, $this->template);
        // return $items;
        $this->tabItems = $items ;
    }
}