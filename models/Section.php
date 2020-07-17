<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\models;


use framework\components\db\ActiveRecord;
use framework\components\db\SqlBuilder;
use framework\core\Application;

class Section extends ActiveRecord
{
    protected $_editLink = '/manager/content/manager-sections/update/';

    public function isParent()
    {
        if ($this->id_parent != 0)
            return false;
        else
            return true;
    }


    public function getPages()
    {
        return Page::find([['id_section' => $this->getIdentity()], ['public' => 1]])->orderBy(['priority' => 'asc'])->all();
    }

    public function getChildren()
    {
        return static::find(['id_parent' => $this->getIdentity()])->orderBy(['priority' => 'asc'])->all();
    }


    public function getParent()
    {
        return static::find(['id' => $this->id_parent])->one();
    }

    public function getEditLink()
    {
        return $this->_editLink.$this->getIdentity();
    }

    public function getUrlPath()
    {
        $alias = '';

        if($this->id_parent > 0)
            $alias = $this->parent->getUrlPath();

        return $alias.'/'.$this->alias;

    }

    protected function _getLink()
    {
        return $this->getUrlPath();
    }

    public function getBreadCrumbs($disabledLast = true){

        $ex = explode ('/', $this->link);

        $count = count($ex);

        if($count == 1)
        return [
            ['name' => $this->name],
        ];
        else
        {
            $breadcrumbs = [];
            $path = '';

            foreach($ex as $i => $item)
            {
                if(empty($item)) continue;

                $sectionUrl = $path.'/'.$item;
                $path .= '/'.$item;

                // Название раздела
                $sql = new SqlBuilder();
                $sectionName = $sql->select(Section::tableName())->fields('name')->where(['link' => $path])->column();

                $breadcrumbs[] = [
                    'url' => (($count-1 == $i AND $disabledLast) ? '' : $sectionUrl),
                    'name' => $sectionName
                ];
            }

            return $breadcrumbs;
        }
    }

    public function attributeLabels()
    {
        return array_merge([
            'name' => 'Название',
            'alias' => 'Алиас',
            'link' => 'URL',
            'public' => 'Опубликован',
            'flag_main_menu' => 'Показывать в меню',
            'class' => 'Полный путь к классу',
            'id_parent' => 'Родительский раздел',
            'priority' => 'Приоритет'
        ], parent::attributeLabels());
    }

    public function getLogo()
    {
        return '/';
    }

    public function beforeSave($changes = [])
    {
        if(!$this->isNewRecord)
        {
            if(isset($changes['alias']) OR $this->link == '')
            {
                $changes['link'] = $this->_getLink();
                Application::app()->request->setFlash("info", "Адрес страницы изменен на ".$changes['link']);
            }
        }

        return parent::beforeSave($changes); // TODO: Change the autogenerated stub
    }
}