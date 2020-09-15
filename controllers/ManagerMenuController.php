<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\controllers;

use framework\exceptions\ErrorException;
use framework\helpers\ArrayHelper;
use modules\content\models\Menu;
use framework\components\Controller;
use framework\components\Model;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;

class ManagerMenuController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        $this->render('list-dynamic', ['models' => Menu::find()->orderBy(['priority' => 'asc'])->all()]);
    }

    public function actionCreate()
    {
        $model = new Menu();

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Пункт меню добавлен');
            return $this->redirect('/content/manager-menu/');
        }

        return $this->render('update', [
            'model' => $model,
            'items' => ArrayHelper::map(Menu::findAll(), 'id', 'name')
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Menu::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Пункт меню с id=".$id." не найден");

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Пункт меню изменен');
        }

        return $this->render('update', [
            'model' => $model,
            'items' => ArrayHelper::map(Menu::findAll(), 'id', 'name')
        ]);
    }

    public function actionDelete($id)
    {
        $model = Menu::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Пункт меню с id=".$id." не найден");


            $model->delete();
            Application::app()->request->setFlash('success', 'Пункт меню удален');


        return $this->redirect('/content/manager-menu/');
    }

    public function actionAjax($action, $element1, $element2){
        //exit('polucheny: a:'.$action.', e1: '.$element1.', e2: '.$element2);

        switch($action)
        {
            case 'sort':
                $el1 = Menu::findOne($element1);
                $el2 = Menu::findOne($element2);
                if($el1 == null) throw new ErrorException('Не найден элемент 1');
                if($el2 == null) throw new ErrorException('Не найден элемент 2');

                $oldNumber = $el1->priority;
                $el1->priority = $el2->priority;
                $el2->priority = $oldNumber;

                $el1->save();
                $el2->save();

                exit('ok');

                break;
        }

    }
}