<?php

$tabsConfig = [
  'items'=>$tabItems,
];
$tabsConfig = \yii\helpers\ArrayHelper::merge($tabsConfig,$tabsOptions) ;

echo \yii\bootstrap\Tabs::widget($tabsConfig);