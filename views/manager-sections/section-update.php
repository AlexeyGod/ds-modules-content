<?php

use framework\helpers\ActiveForm;
$this->breadcrumbs[] = ['name' => 'Список разделов', 'url' => '/manager/content/manager-sections'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];
?>
<h1><?=($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->name)?></h1>
<div style="padding: 10px;">
    <div class="field">
        Адрес раздела: <a href="<?=$model->link?>"><?=$model->link?></a>
    </div>
    <?
    $form = ActiveForm::begin();

    foreach($model->fields as $field)
    {
        if(in_array($field, ['id', 'access_filter', 'class', 'priority'])) continue;

        switch ($field):

            case 'link':
                echo '<div class="field">'.$form->input($model, $field).'</div>';

                $urlPath = $model->getUrlPath();
                if($model->link != '' AND $model->link != $urlPath)
                {
                    echo '<div class="field">'
                        .'Адрес не соответствует сформированному: <code>'.$urlPath.'</code>'
                        .'</div>';
                }

                break;

            case 'public':
                echo '<div class="field">'.$form->checkbox($model, $field).'</div>';
                break;

            case 'id_parent':
                echo '<div class="field">'.$form->select($model, $field, $sections).'</div>';
                break;

            default:
                echo '<div class="field">'.$form->input($model, $field).'</div>';
                break;

        endswitch;
    }

    echo '<div class="field">';
        ActiveForm::submit(['class' => '', 'value' => 'Сохранить']);
    echo '</div>';

    ActiveForm::end();
    ?>
</div>