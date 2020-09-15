<?php

use framework\helpers\ActiveForm;
$this->breadcrumbs[] = ['name' => 'Список разделов', 'url' => '/manager/content/manager-sections'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];
?>
<h1><?=($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->name)?></h1>

    <?
    $form = ActiveForm::begin();

    foreach($model->fields as $field)
    {
        if(in_array($field, ['id', 'access_filter', 'class', 'priority'])) continue;

        switch ($field):

            case 'public':
                echo $form->field($model, $field)->checkbox();
                break;

            case 'id_parent':
                echo $form->field($model, $field)->select($sections);
                break;

            default:
                echo $form->field($model, $field);
                break;

        endswitch;
    }

    echo ActiveForm::submit(['class' => '', 'value' => 'Сохранить']);

    ActiveForm::end();
    ?>
</div>