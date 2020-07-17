<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Обратная связь | '.($model->isNewRecord ? 'Создать' : 'Изменить');
$this->breadcrumbs[] = ['url' => '/content/manager-feedback/', 'name' => 'Формы'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];

echo '<div class="p10">';
$form = ActiveForm::begin();

    foreach ($model->fields as $field)
    {
        if(in_array($field, ['id'])) continue;

        switch ($field):
            case 'use_captcha':
            case 'save_results':
                echo '<div class="field">'
                    .'  '.$form->checkbox($model, $field)
                    .'</div>';
                break;

            default:
                echo '<div class="field">'
                    .'  '.$form->input($model, $field)
                    .'</div>';
                break;

        endswitch;
    }

echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
ActiveForm::end();
echo '</div>';
?>


