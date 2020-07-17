<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\models;


use framework\components\db\ActiveRecord;
use framework\core\Application;

class FeedBackField extends ActiveRecord
{
    public static function tableName()
    {
        return "content_feedback_fields"; // TODO: Change the autogenerated stub
    }

    public function getForm()
    {
        return FeedBack::findOne($this->id_form);
    }

    public function attributeLabels()
    {
        return array_merge([
            'id' => '#',
            'id_form' => '# Формы',
            'name' => 'Название (англ)',
            'label' => 'Подпись',
            'type' => 'Тип',
            'required' => 'Обязательное поле',
            'hidden' => 'Скрытое поле',
            'value' => 'Значение по умолчанию',
            'maxlength' => 'Максимум символов',
            'extensions' => 'Разрешенные расширения (через запятую)',
            'maxfilesize' => 'Макс. размер файла (байт)',
            'html_size' => 'HTML: размер поля (size)',
            'html_style' => 'HTML: CSS-Стиль',
            'html_class' => 'HTML: Class',
        ],
            parent::attributeLabels());
    }

    public function getTypes()
    {
        return [
            'text' => 'Текстовое поле',
            'textarea' => 'Текстовый блок',
            'email' => 'E-Mail',
            'mphone' => 'Мобильный телефон',
            'numeric' => 'Цифры',
        ];
    }
}