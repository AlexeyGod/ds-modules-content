<?php

use framework\helpers\ActiveForm;
$this->breadcrumbs[] = ['name' => 'Список страниц', 'url' => '/manager/content/manager-pages'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];

$this->title = ($model->isNewRecord ? 'Создать' : 'Изменить').' страницу';

/*<h1><?=($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->name)?></h1>*/
?>

<?php
// Старт форм
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
<!-- Вкладки -->
<ul class="nav nav-tabs">
    <li>
        <a data-toggle="tab" href="#card"><span class="icon icon-profile"></span> Карточка</a>
    </li>
    <li class="active">
        <a data-toggle="tab" href="#content"><span class="icon icon-file-text2"></span></span> Контент</a>
    </li>
    <li>
      <a target="_blank" href="<?=$model->link?>"><span class="icon icon-eye"></span> Открыть страницу</a>
    </li>
</ul>
<div class="tab-content">
    <div id="card" class="tab-pane">
        <?
        // Загрузка превью
        echo $form->field($model->logoObject, 'file', ['theme' => 'white']);
        // +++ use $model->logo

        foreach($model->fields as $field)
        {
            if(in_array($field, ['id', 'password', 'last_visit', 'created_at',  'content', 'short'])) continue;

            switch($field):

                case 'link':

                    echo $form->field($model, $field);
                    break;

                case 'public':
                    echo $form->field($model, $field)->checkbox();
                    break;
                /*
                case 'short':
                    echo '<div class="field">'.$form->textarea($model, $field).'</div>';
                    break;


                case 'content':
                    echo '<div class="field">'.$form->widget('framework\\widgets\\redactor\\RedactorWidget', $model, 'content').'</div>';
                    break;
                */
                case 'id_section':
                    echo $form->field($model, 'id_section')->select($sections);
                    break;

                case 'type':
                    echo $form->field($model, $field)->select($model->types);
                    break;


                case 'author':
                    continue;
                    //    if(!$model->isNewRecord)
                    //        echo '<div class="field">'.$form->readonlyInput($model, 'authorName').'</div>';
                    break;

                case 'priority':
                    echo $form->field($model, $field)->number();
                    break;

                default:
                    echo $form->field($model, $field);
                    break;

            endswitch;
        }

        ?>
    </div>
    <div id="content" class="tab-pane  active">
        <?php
            echo $form->field($model, 'short')->widget('framework\\widgets\\redactor\\RedactorWidget');
            //echo $form->field($model, 'content')->widget('framework\\widgets\\ckeditor\\CkeditorWidget');
        ?>
    </div>
</div>

<?php

    echo ActiveForm::submit(['class' => 'btn btn-success', 'value' => 'Сохранить']);

    ActiveForm::end();
?>
