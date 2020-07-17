<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->title = 'Меню';
$this->breadcrumbs[] = ['name' => 'Управление меню'];

?>
<h1>Список пунктов меню <a class="button" href="/content/manager-menu/create"><span class="">+</span></a></h1>
<?
echo GridView::widget($model);
?>
