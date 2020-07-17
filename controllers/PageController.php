<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\controllers;

use modules\content\models\Page;
use modules\content\models\Section;
use framework\components\Controller;
use framework\components\db\ActiveDataProvider;
use framework\core\Application;
use framework\exceptions\ErrorException;
use framework\exceptions\NotFoundHttpException;
use framework\helpers\Pager;

class PageController extends Controller
{
    public function actionView($alias)
    {
        //exit($alias);
        if(empty($alias))
            throw new NotFoundHttpException("Страница не найдена");

        $model = Page::findByAddress($alias);

        if($model== null)
            throw new NotFoundHttpException("Страница не найдена");

        return $this->render('view', [
            'model' => $model
            ,
            'editLink' => (Application::app()->identy->can('c-manager') ? '<a class="pull-right" href="'.$model->editLink.'"><i class="icon icon-pencil"></i></a>' : '')]);
    }

    public function actionViewSection($alias)
    {
        if(empty($alias))
            throw new NotFoundHttpException("Страница не найдена");


        $model = Section::findOne(['link' => $alias]);


        if($model == null)
            throw new NotFoundHttpException("Страница не найдена");

        return $this->render('view-section', [
            'model' => $model,
            'editLink' => (Application::app()->identy->can('c-manager') ? '<a class="pull-right" href="'.$model->editLink.'"><i class="icon icon-pencil"></i></a>' : '')
        ]);
    }



}