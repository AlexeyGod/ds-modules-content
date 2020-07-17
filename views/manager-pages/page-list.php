<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;


$this->title = 'Список страниц';
$this->breadcrumbs[] = ['name' => 'Список страниц'];
?>
<h1>Список страниц <a class="button" href="/content/manager-pages/create"><span class="">+</span></a></h1>
<?=$provider->searchWidget()?>
<div class="flex-container">

    <div class="main-box">

        <div class="">
            <?=GridView::widget($provider->getModels(),
                [
                    'draggable' => true,
                    'sort_field' => 'priority',
                    'action' => '/manager/content/manager-pages/ajax',

                    'columns' => [
                        [
                            'name' => 'Раздел',
                            'value' => function($model){
                                $section = $model->getSection();

                                if($section == null)
                                    return 'Не задан';
                                else
                                    return $section->name;
                            }
                        ],
                        [
                            'attribute' => 'name',
                            'value' => function($model) {
                                $st = $model->name;

                                if($model->type == 'block')
                                    $st .= ' <span class="badge">Текстовый блок</span>';

                                return $st;
                            }
                        ],
                        [
                            'name' => 'Ссылка (алиас)',
                            'attribute' => 'alias',
                            'value' => function ($model) {
                                if($model->type == 'block')
                                {
                                    $st = '<p><span class="color-grey">Page</span>::<span class="color-orange">getTextBlock(\'<span class="color-green">'.$model->alias.'</span>\')</span> Вернет содержимое</p>';
                                    $st .= '<p><span class="color-grey">Page</span>::<span class="color-orange">getBlock(\'<span class="color-green">'.$model->alias.'</span>\')</span> Вернет объект</p>';
                                }
                                else
                                    $st = '<a href="'.$model->link.'">'.$model->link.'</a>';

                                return $st;
                            }
                        ],
                        'priority',
                        [
                            'name' => 'Действия',
                            'columnClass' => '\\framework\\helpers\\grid\\ActiveColumn',
                            'template' => '{top} {bottom} {update} {delete}',
                            'buttons' => [
                                'top' => function ($model) {
                                    return '<a href="top/' . $model->getIdentity() . '"><span class="icon icon-arrow-up"></span></a>';
                                },
                                'bottom' => function ($model) {
                                    return '<a href="bottom/' . $model->getIdentity() . '"><span class="icon icon-arrow-down"></span></a>';
                                },
                            ]
                            /*'buttons' => [
                                'update' => function ($model) {
                                    return '<a href="/content/edit-page/id/' . $model->getIdentity() . '">Редактировать</a>';
                                },
                                'delete' => function ($model) {
                                    return '<a href="/content/manager-pages/delete/id/' . $model->getIdentity() . '">Удалить</a>';
                                },
                            ]*/
                        ]
                    ]])?>
        </div>
        <div>
            <?=$pager->widget()?>
        </div>
    </div>
    <div class="right-help-box">

        <div class="field">
            <form method="post" id="navigateForm">
                <select name="inSection" id="inSection" class="input navigate-input">
                    <?php
                    foreach ($sections as $idSection => $sectionName)
                        echo '<option value="'.$idSection.'"'.($idSection == $inSection ? ' selected' : '').'>'.$sectionName.'</option>';
                    ?>
                </select>
            </form>
        </div>
    </div>
</div>


<p><?=$provider->getNavigation()?></p>


<?
$jsCode = <<<JS
$(document).ready(function(){
    console.log("Navigater active");
    $("#inSection").on('change', function(){
        $("#navigateForm").submit();
    });
});
JS;

\framework\core\Application::app()->assetManager->setJsCode($jsCode, ['depend' => '\framework\assets\jquery\JqueryBundle']);


?>


