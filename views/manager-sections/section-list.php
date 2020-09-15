<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;


$this->breadcrumbs[] = ['name' => 'Список разделов'];
$this->title =  'Управление | Контент | Список разделов';
?>

<h1>Список разделов <a class="btn btn-success pull-right" href="/content/manager-sections/create">+</a></h1>
<hr>
<div class="row">
    <div class="col-xs-12">
        <?=$provider->searchWidget()?>
    </div>
</div>

<p><?=$provider->getNavigation()?></p>
<br>
<div>
    <?=GridView::widget($provider->getModels(), [
        'treeView' => [
            'function' => 'getChildren',
            'relation_field' => 'id_parent',
        ],
        'columns' =>
            [
                //[
                //    'attribute' => 'id',
                //    'name' => 'Id',
                //],
                [
                    'attribute' => 'name',
                    'name' => 'Название',
                ],
                //[
                //    'attribute' => 'alias',
                //    'name' => 'Алиас',
                //],
                [
                    'attribute' => 'link',
                    'value' => function($model)
                    {
                        return '<a href="'.$model->link.'">'.$model->link.'</a>';
                    }
                ],
                [
                    'attribute' => 'public',
                    'name' => 'Опубликован',
                    'value' => function($model){
                        return '<span class="icon icon-eye'.($model->public == 1 ? '' : '-blocked').'"></span>';
                    }
                ],
                //[
                //    'attribute' => 'access_filter',
                //    'name' => 'Access_filter',
                //],
                //[
                //    'attribute' => 'id_parent',
                //    'name' => 'Родительский раздел',
                //],
                //[
                //    'attribute' => 'priority',
                //    'name' => 'Приоритет',
                //],
                [
                    'name' => 'Действия',
                    'columnClass' => '\framework\helpers\grid\ActiveColumn',
                    'template' => '{update} {delete}'
                ],
            ]
        //'develop' => true,

    ])?>
</div>
<div>
    <?=$pager->widget()?>
</div>
</div>


