<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\widgets\BreadCrumbsWidget;

$pages = $model->pages;
$this->breadcrumbs = $model->breadCrumbs;
$this->title = $model->name;
//echo var_dump($pages);
?>
<div class="page">
    <div class="page-header">
        <h1><?=$model->name?>  <?=$editLink?></h1>
    </div>
    <div class="page-body">
        <?
        // Разделы
        $children = $model->children;

        if(!empty($children)){
            echo '<div class="table-block">'
                .'  <div class="row-item">';
                //.'<h2>Разделы</h2>';

            foreach ($children as $page)
            {
                echo '<div class="block-section">'
                    .'<a class="name" href="'.$page->link.'"><span class="icon icon-folder color-grey"></span>  '.$page->name.'</a>'
                    .'</div>';
                    //.'        <p><i>'.$page->description.'</i></p>'

            }

            echo '  </div>'
            .'</div>';
        }
        // Страницы
        if(!empty($pages)){
            foreach ($pages as $page)
            {
                echo '<div class="table-block">'
                    .'  <div class="row-item">'
                    .'    <div class="image">'
                    .'      <img src="'.$page->logo.'" alt="'.$page->name.'">'
                    .'    </div>'
                    .'      <div class="text">'
                    .'        <a class="name" href="'.$page->link.'">'.$page->name.'</a>'
                    .'        <p>'.$page->short.'</p>'
                    .'      </div>'
                    .'  </div>'
                    .'</div>';
            }
        }
        ?>
    </div>
</div>
