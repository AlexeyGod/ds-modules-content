<?php

use framework\helpers\ActiveForm;
$this->breadcrumbs[] = ['name' => 'Список страниц', 'url' => '/manager/content/manager-pages'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];

$this->title = ($model->isNewRecord ? 'Создать' : 'Изменить').' страницу';

/*<h1><?=($model->isNewRecord ? 'Создать' : 'Редактировать: '.$model->name)?></h1>*/
?>
<div style="padding: 10px;">
    <?php
    // Старт форм
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <!-- Вкладки -->

    <div class="tabs">
        <input id="tab_1" type="radio" name="tabs"<?=(($editType == 'edit') ? ' checked' : '')?>>
        <label for="tab_1"><span class="icon icon-profile"></span> <span class="text">Карточка</span></label>

        <input id="tab_2" type="radio" name="tabs" <?=(($editType == 'text' OR empty($editType)) ? ' checked' : '')?>>
        <label for="tab_2"><span class="icon icon-file-text2"></span>  <span class="text">Текст</span></label>
        <label><span class="icon icon-eye"></span>  <a class="color-grey" target="_blank" href="<?=$model->link?>">Открыть страницу</a></span></label>

        <section id="tab_content_1">

            <div class="field">
                <div class="image" style="height: 100px;">
                    <img src="<?=$model->logo?>" alt="Logotype" style="max-height: 100%">
                </div>
            </div>

            <?
            // Загрузка превью
            echo '<div class="field">'.$form->inputFile($model->logoObject, 'file', ['theme' => 'white']).'</div>';

            foreach($model->fields as $field)
            {
                if(in_array($field, ['id', 'password', 'last_visit', 'created_at',  'content', 'short'])) continue;

                switch($field):

                    case 'link':

                        echo '<div class="field">'.$form->input($model, $field).'</div>';
                        $address = $model->generateLink();
                        if(!$model->isNewRecord AND $model->link != $address)
                        {
                            echo '<div class="field"><b class="color-red">Адрес страницы не совпадает с сформсированным: '.$address.'</b> </div>';
                        }
                        break;

                    case 'public':
                        echo '<div class="field">'.$form->checkbox($model, $field).'</div>';
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
                        echo '<div class="field">'.$form->select($model, 'id_section', $sections).'</div>';
                        break;

                    case 'type':
                        echo '<div class="field">'.$form->select($model, $field, $model->types).'</div>';
                        break;


                    case 'author':
                        continue;
                        //    if(!$model->isNewRecord)
                        //        echo '<div class="field">'.$form->readonlyInput($model, 'authorName').'</div>';
                        break;

                    default:
                        echo '<div class="field">'.$form->input($model, $field).'</div>';
                        break;

                endswitch;
            }

            ?>
        </section>
        <section id="tab_content_2">
            <?php

                echo '<div class="field">'.$form->widget('framework\\widgets\\redactor\\RedactorWidget', $model, 'short').'</div>';
                echo '<div class="field">'.$form->widget('framework\\widgets\\redactor\\RedactorWidget', $model, 'content').'</div>';

            ?>
        </section>
    </div>
    <?php
        echo '<div class="field">';
        ActiveForm::submit(['class' => 'btn btn-success', 'value' => 'Сохранить']);
        echo '</div>';
        ActiveForm::end();
    ?>
</div>
