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

echo '<div class="container-fluid">';
$form = ActiveForm::begin()->setTheme('bootstrap');
//$form->setTheme('bootstrap');

    foreach ($model->fields as $field)
    {
        if(in_array($field, ['id'])) continue;
        switch($field):
            default:
                echo $form->field($model, $field);
                break;

            case 'priority':
                echo $form->field($model, $field)->number();
                break;

            case 'id_parent':
                echo $form->field($model, $field)->select($items, 'Нет');
                break;

        endswitch;
    }

echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
ActiveForm::end();
echo '</div>';



