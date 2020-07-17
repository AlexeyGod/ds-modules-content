<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\widgets\BreadCrumbsWidget;

$this->title = $model->name;
$this->breadcrumbs = $model->breadCrumbs;
?>
<div class="page">
    <div class="page-header">
        <h1><?=$model->name?> <?=$editLink?></h1>
    </div>
    <div class="page-body">
        <?=$model->content?>
    </div>
</div>