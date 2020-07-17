<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->title = 'Управление | Обратная связь';
$this->breadcrumbs[] = ['name' => 'Обратная связь'];

?>
<h1>Формы <a class="button" href="/content/manager-feedback/create"><span class="">+</span></a></h1>
<?
echo GridView::widget($model, [
    'columns' => [
        'id',
        'name',
        [
            'name' => 'Ответы',
            'value' => function($model)
            {
                $count = $model->getAnswersCount();
                $countNew = $model->getNewAnswersCount();

                if($count == 0) return 'Нет';
                else
                    return '<a href="/content/manager-feedback/answers/id/'.$model->getIdentity().'">'.$countNew.' / '.$count.'</a>';
            }
        ],
        'email_to',
        'email_from',
        'use_captcha',
        'save_results',
        'success_text',
        'success_url',
        [
            'name' => 'Поля',
            'value' => function($model)
            {
                $fields = $model->getFormFields();
                $st = '';

                if(empty($fields)) $st = 'Не добавлены';

                foreach ($fields as $field)
                {
                    $st .= '<p class="p10"><a href="/content/manager-feedback/update-field/id/'.$model->id.'">'.$field->label.'</a>('.$field->name.')</p>';

                }

                $st .= '<p><a href="/content/manager-feedback/add/id/'.$model->id.'">Добавить поле</a></p>';

                return $st;
            }
        ],
        [
            'name' => 'Действия',
            'columnClass' => '\\framework\\helpers\\grid\\ActiveColumn',
            'template' => '{view} {update}',
            'buttons' => [
                //'add_field' => function($model) {
                //        return '<a href="/content/manager-feedback/add/id/'.$model->id.'">Добавить поля</a>';
                //}
            ]
        ]
    ]
]);
?>
