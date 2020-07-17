<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\grid\GridView;
use framework\helpers\grid\ActiveColumn;
use framework\helpers\grid\DnDColumn;

$this->title = 'Меню';
$this->breadcrumbs[] = ['name' => 'Управление меню'];

?>
<h1>Список пунктов меню <a class="button" href="/content/manager-menu/create"><span class="">+</span></a></h1>

<?=GridView::widget($models, [
    'draggable' => true,
    'action' => '/manager/content/manager-menu/ajax',
    'sort_field' => 'priority',
    'columns' =>
        [
            [
                'name' => '',
                'columnClass' => DnDColumn::class
            ],
            'id',
            'name',
            'url',
            //'priority',
            'id_parent',
            'access',
            [
                'name' => 'Действия',
                'columnClass' => ActiveColumn::class
            ]
        ],
]);?>


<?//=var_dump($models[0]->getFields());
//echo '<div class="dragAndDrop">';
//foreach ($models as $model)
//{
//    echo '<div class="item"
//    draggable="true"
//    data-identy="'.$model->getIdentity().'">'
//        .htmlspecialchars($model->name)
//        .'<span class="move icon icon-enlarge"></span>'
//        .'</div>';

//    //echo '<div class="delimiter" data-position="'.($model->position-1).'"></div>';
//}
//echo '</div>';




?>
<script>

</script>
