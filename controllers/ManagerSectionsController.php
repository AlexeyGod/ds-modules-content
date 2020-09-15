<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\controllers;

use modules\content\models\Section;
use framework\components\Controller;
use framework\components\db\ActiveDataProvider;
use framework\core\Application;
use framework\exceptions\ErrorException;
use framework\exceptions\NotFoundHttpException;
use framework\helpers\ArrayHelper;
use framework\helpers\Pager;

class ManagerSectionsController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex($page =1)
    {
        $page = intval($page);
        if($page < 1) $page = 1;

        $provider = new ActiveDataProvider([
            'class' => Section::class,
            'where' => ['id_parent' => 0],
            'onPage' => 15,
            'page' => $page,
            'order' => ['priority' => 'asc'],
            'search' => [
                'query' => Application::app()->request->post('search'),
                'fields' => ['name', 'alias']
            ]
        ]);

        $pager = new Pager([
            'pages' => $provider->pages,
            'page' => $page
        ]);


       $this->render('section-list', [
           'provider' => $provider,
           'pager' => $pager
       ]);
    }

    public function actionCreate()
    {
        $model = new Section();

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
            {
                Application::app()->request->setFlash('success', 'Раздел добавлен');
                $this->redirect('/manager/content/manager-sections');
            }
        }

        $sections = array_merge([0 => 'Не вкладывать'], ArrayHelper::map(Section::find()->all(), 'id', 'name'));

        $this->render('section-update', ['model' => $model, 'sections' => $sections]);
    }

    public function actionUpdate($id = false)
    {
        if(!$id)
            throw new NotFoundHttpException("Раздел не найден");

        $model = Section::findOne($id);

        $sections = array_merge([0 => 'Не вкладывать'], ArrayHelper::map(Section::find()->all(), 'id', 'name'));

        if($model == null)
            throw new NotFoundHttpException("Раздел не найден");

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
                Application::app()->request->setFlash('success', 'Раздел сохранен');
        }

        $this->render('section-update', ['model' => $model, 'sections' => $sections]);
    }



}