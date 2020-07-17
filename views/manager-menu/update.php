<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Меню | '.($model->isNewRecord ? 'Создать пункт' : 'Изменить пункт');
$this->breadcrumbs[] = ['url' => '/manager/content/manager-menu/', 'name' => 'Меню'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать пункт' : 'Изменить пункт')];

echo '<div class="p10">';
$form = ActiveForm::begin();

    foreach ($model->fields as $field)
    {
        if(in_array($field, ['id'])) continue;

        echo '<div class="field">'
            .'  '.$form->input($model, $field)
            .'</div>';
    }

echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
ActiveForm::end();
echo '</div>';
?>


