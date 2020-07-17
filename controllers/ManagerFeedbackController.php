<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\controllers;

use framework\components\Controller;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;
use modules\content\models\FeedBack;
use modules\content\models\FeedBackField;

class ManagerFeedbackController extends Controller
{
    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        $this->render('list', ['model' => FeedBack::findAll()]);
    }

    public function actionCreate()
    {
        $model = new FeedBack();

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'ормаФорма добавлена');
            return $this->redirect('/content/manager-feedback');
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = FeedBack::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Пункт меню с id=".$id." не найден");

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Форма изменена');
        }

        return $this->render('update', ['model' => $model]);
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

    // Добавить поле
    public function actionAdd($id)
    {
        $model = FeedBack::findOne($id);

        if($model == null)
            throw new NotFoundHttpException(" Форма #".$id." не найдена");

        $field = $model->getFormField();

        if($field->load(Application::app()->request->post()))
        {
            if($field->save())
            {
                Application::app()->request->setFlash('success', 'Поле добавлено');
                return $this->redirect('/content/manager-feedback');
            }

        }

        return $this->render('add_form', [
            'model' => $model,
            'formField' => $field
        ]);
    }

    // Обновить поле
    public function actionUpdateField($id)
    {
        $field = FeedBackField::findOne($id);

        if($field == null)
            throw new NotFoundHttpException(" Поле формы #".$id." не найдено");

        $model = $field->getForm();

        if($field->load(Application::app()->request->post()))
        {
            if($field->save())
            {
                Application::app()->request->setFlash('success', 'Поле обновлено');
                return $this->redirect('/content/manager-feedback');
            }

        }

        return $this->render('add_form', [
            'model' => $model,
            'formField' => $field
        ]);
    }

    // Обновить поле
    public function actionAnswers($id)
    {
        $model = FeedBack::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Формы #".$id." не найдена");


        return $this->render('answer_list', [
            'model' => $model,
        ]);
    }

}