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
use framework\helpers\ArrayHelper;

class ManagerPagesController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex($page =1)
    {
        $page = intval($page);
        if($page < 1) $page = 1;

        // Выбор раздела
        $inSection = Application::app()->request->post('inSection');
        if($inSection != '')
        {
            $inSection = intval($inSection);
            if($inSection > 0)
            {
                Application::app()->request->setVar('inSection', $inSection);
            }
            else
            {
                Application::app()->request->unSetVar('inSection');
            }
        }

        $currentInSection = intval(Application::app()->request->getVar('inSection'));
        if($currentInSection < 0) $currentInSection = 0;


        $sections = ArrayHelper::map(Section::find()->all(), 'id', 'name');

        $provider = new ActiveDataProvider([
            'class' => Page::class, // Указывается класс модели ActiveRecord
            'onPage' => 20, // Объектов на страницу
            'order' => ['priority' => 'asc'], // Сортировка
            'where' => ($currentInSection > 0 ? ['id_section' => $currentInSection] : false), // Условия
            'search' => [ //Поиск
                'query' => Application::app()->request->post('search'), //Строка поиска
                'fields' => ['name', 'alias'] // поля в которых ищем совпадение
            ]
        ]);


       $this->render('page-list', [
           'provider' => $provider,
           'pager' => $provider->pager,
           'sections' => array_merge([0 => 'Страницы во всех разделах'], $sections),
           'inSection' => $currentInSection
       ]);
    }

    public function actionCreate()
    {
        $model = new Page();
        $model->alias = 'page_'.mt_rand(1,999999);
        $model->public = 1;
        if($model->link == '') $model->link = $model->generateLink();

        $sections = ArrayHelper::map(Section::find()->all(), 'id', 'name');
        $sections[0] = 'Нет';

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
            {
                Application::app()->request->setFlash('success', 'Страница добавлена');
                $model->logoObject->upload();
                $model->logoObject->save();

                return $this->redirect('/manager/content/manager-pages/update/'.$model->getIdentity());
            }
            else
            {
                Application::app()->request->setFlash('error', 'Страница НЕ добавлена ('.var_export($model->getErrors(), true).')');
            }

        }


        $this->render('page-update', ['model' => $model, 'sections' => $sections]);
    }

    public function actionUpdate($id = false)
    {
        if(!$id)
            throw new NotFoundHttpException("Страница не найдена");

        $model = Page::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Страница не найдена");

        //$model->scenario = Page::SCENARIO_SYSTEM;

        $sections = ArrayHelper::map(Section::find()->all(), 'id', 'name');
        $sections[0] = 'Нет';

        if($model->load(Application::app()->request->post()))
        {
            if($model->save())
                Application::app()->request->setFlash('success', 'Страница сохранена');
        }

        if(!$model->isNewRecord)
        {
            $model->logoObject->upload();
            $model->logoObject->save();
        }

        if(trim($model->link) == '') {
            //exit('empty: '.$model->generateLink());
            $model->link = $model->generateLink();
            //exit(var_dump($model->link));
        }

        $this->render('page-update', ['model' => $model, 'sections' => $sections]);
    }

    public function actionTop($id = false)
    {
        if(!$id)
            throw new NotFoundHttpException("Страница не найдена");

        $model = Page::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Страница не найдена");

            $model->priority--;

            if($model->save())
                Application::app()->request->setFlash('success', 'Приоритет вывода изменен');


        $this->redirect('/content/manager-pages');
    }

    public function actionBottom($id = false)
    {
        if(!$id)
            throw new NotFoundHttpException("Страница не найдена");

        $model = Page::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Страница не найдена");

        $model->priority++;

        if($model->save())
            Application::app()->request->setFlash('success', 'Приоритет вывода изменен');


        $this->redirect('/content/manager-pages');
    }

    public function actionDelete($id = false)
    {
        if(!$id)
            throw new NotFoundHttpException("Страница не найдена");

        $model = Page::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Страница не найдена");

        $sections = ArrayHelper::map(Section::find()->all(), 'id', 'name');

        if(true)
        {
            if($model->delete())
                Application::app()->request->setFlash('success', 'Страница удалена');
        }

        $this->redirect('/content/manager-pages');
    }



}