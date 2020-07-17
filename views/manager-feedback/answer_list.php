<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->title = 'Управление | Обратная связь | '.$model->name.' | Ответы';
$this->breadcrumbs[] = ['name' => 'Обратная связь'];
$this->breadcrumbs[] = ['name' => $model->name];
$this->breadcrumbs[] = ['name' => 'Ответы'];

?>
<h1>Ответы</h1>
<?
echo GridView::widget($model->answers, [
    'columns' => [
        //'id',
        'id_form',
        [
            //'answer',
            'name' => 'Ответ',
            'value' => function ($model)
            {
                $st = '<table class="table">';
                foreach(json_decode($model->answer) as $key => $value)
                {
                    $st .= '<tr><td>'.$key.' </td><td>'.$value.'</td></tr>';
                }

                return $st.'</table>';
            }
        ],
        'bw',
        'ip',
        'created_at',
        'unread',
    ]
]);
?>
