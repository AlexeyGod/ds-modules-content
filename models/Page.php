<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\models;


use framework\components\db\ActiveRecord;
use framework\core\Application;

class Page extends ActiveRecord
{
    protected $_section = false;
    protected $_editLink = '/manager/content/manager-pages/update/';
    protected $_userClass;

    protected $_logoObject;

    public $types = [
        'page' => 'Страница',
        'block' => 'Текстовый блок',
    ];

    public function __construct(array $options = [])
    {
        $this->_userClass = get_class(Application::app()->identy);
        parent::__construct($options);
    }

    public function getAuthorName()
    {
        $class = $this->_userClass;

        $user = $class::findOne($this->getIdentity());
        if(is_object($user))
        return $user->getShortName();
        else
            return NULL;
    }

    public function attributeLabels()
    {
        return array_merge([
            'name' => 'Название',
            'alias' => 'Алиас',
            'id_section' => 'Раздел',
            'short' => 'Краткий текст (превью)',
            'content' => 'Содержимое',
            'created_at' => 'Создан',
            'author' => 'Автор',
            'public' => 'Опубликован',
            'link' => 'URL',
            'authorName' => 'Автор',
            'type' => 'Тип записи',
            'priority' => 'Приоритет'
        ], parent::attributeLabels()); // TODO: Change the autogenerated stub
    }

    public static function findByAddress($address)
    {
        if(substr($address, 0, 1) != '/')
            $address = '/'.$address;

        return self::findOne([
            ['link' => $address],
            ['public' => 1],
            ['type' => 'page']
        ]);
    }

    public static function getTextBlock($alias){
        $block = self::findOne([
            ['alias' => $alias],
            ['public' => 1],
            ['type' => 'block']
        ]);

        if($block  == null)
        {
            return '(Блок $alias не найден)';
        }
        else
        {
            return $block->content;
        }
    }

    public static function getBlock($alias){

       return self::findOne([
            ['alias' => $alias],
            ['public' => 1],
            ['type' => 'block']
        ]);
    }

    public static function findByAlias($alias)
    {
        return static::findOne(['alias' => $alias]);
    }

    public function getEditLink()
    {
        return $this->_editLink.$this->getIdentity();
    }

    public function getSection()
    {
        if(is_object($this->_section))
            return $this->_section;
        else
            return $this->hasOne(Section::class, ['id' => 'id_section']);
    }

    public function getSectionLink()
    {
        if(is_object($this->getSection()))
            return strtolower($this->getSection()->link);
        else
            return '';
    }

    public function getLogoObject()
    {
        if(!is_object($this->_logoObject))
        {
            $object = $this->hasOne(PageImage::className(), ['relation' => 'id']);

            if($object == null)
            {
                $object = new PageImage();
                $object->relation = $this->getIdentity();
            }

            $this->_logoObject = $object;
        }

        return $this->_logoObject;
    }

    public function getLogo()
    {
        return $this->getLogoObject()->getWebPath();
    }


    public function generateLink()
    {
        return $this->getSectionLink().'/'.$this->alias;
    }

    public function getBreadCrumbs(){
        $breadcrumbs = [];
        $section = $this->getSection();
        if($section != null)
            $breadcrumbs = $section->getBreadCrumbs(false);

        $breadcrumbs[] = [
            'name' => $this->name
        ];

        return $breadcrumbs;
        //return [
        //    ['name' => $this->section->name, 'url' => $this->section->link],
        //    ['name' => $this->name],
        //];
    }

    public function beforeSave($attributes)
    {
        $attributes = parent::beforeSave($attributes); // TODO: Change the autogenerated stub

        if($this->type == 'page') $attributes['link'] = $this->generateLink();
        if($this->isNewRecord OR $this->author == '') $attributes['author'] = Application::app()->identy->getIdentity();

        return $attributes;
    }

    public function rules()
    {
        return parent::rules(); // TODO: Change the autogenerated stub
    }
}