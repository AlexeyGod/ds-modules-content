<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Обратная связь | '.$model->name.' | Добавить поле';
$this->breadcrumbs[] = ['url' => '/content/manager-feedback/', 'name' => 'Формы'];
$this->breadcrumbs[] = ['url' => '/content/manager-feedback/update/id/'.$model->id, 'name' => $model->name];
$this->breadcrumbs[] = ['name' => ($formField->isNewRecord ? 'Добавить поле' : 'Изменить поле')];

echo '<div class="p10">';
$form = ActiveForm::begin();

    foreach ($formField->fields as $field)
    {
        if(in_array($field, ['id', 'id_form'])) continue;

        switch ($field):
            case 'type':
                echo '<div class="field">'
                    .'  '.$form->select($formField, $field, $formField->getTypes())
                    .'</div>';
                break;

            case 'required':
            case 'hidden':
                echo '<div class="field">'
                    .'  '.$form->checkbox($formField, $field)
                    .'</div>';
                break;

            default:
                echo '<div class="field">'
                    .'  '.$form->input($formField, $field)
                    .'</div>';
                break;

        endswitch;
    }

echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
ActiveForm::end();
echo '</div>';
?>


