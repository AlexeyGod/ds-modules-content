<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\models;


use framework\core\Application;
use framework\exceptions\ErrorException;

class FeedBackDynamicForm
{
    protected $_feedBack;
    protected $_fields;
    public $slug;
    public $errors = [];

    public function __construct($id_form)
    {
        $this->_feedBack = FeedBack::findOne($id_form);
        if($this->_feedBack == null) throw new ErrorException("Форма #".$id_form." не существует");

        $this->_fields = $this->_feedBack->getFormFields();
        $this->slug = 'dForm'.$this->_feedBack->getIdentity();
    }


    public function listener()
    {
        $data = Application::app()->request->post($this->slug);
        $return = true;


        if(!empty($data))
        {
            // Если в форме есть поля
            if(!empty($this->_fields))
            {
                if($this->_feedBack->use_captcha == 1)
                {
                    $captcha = Application::createObject('framework\helpers\captcha\Captcha');

                    if(!$captcha->check(Application::app()->request->post('captcha')))
                    {
                        $return = false;
                        $this->errors[] = 'Не верный код с картинки';
                    }
                }

                //$data['__verify'] = $verify;
                //$data['__debug'] = $this->_feedBack->use_captcha." | ".Application::app()->request->post('captcha');
                if($return)
                {
                    // Создаем новый объект ответа на форму
                    $answer = new FeedBackAnswer($this->_feedBack->getIdentity());

                    // Перебор полей
                    foreach ($this->_fields as $field)
                    {
                        if(isset($data[$field->name]))
                            $json[$field->name] = $data[$field->name];
                    }

                    if(!empty($json))
                    {
                        // Сохранение
                        if($this->_feedBack->save_results == 1)
                        {
                            $answer->answer = json_encode($json);
                            $answer->save();
                        }
                    }

                }

                return [
                    'return' => $return,
                    'errors' => $this->errors
                ];
            }


            exit("Data detected: <pre>".var_export($data, true)."</pre>");
        }
    }
    public function widget()
    {
        ob_start();

        echo '<div id="dynamic-'.$this->slug.'">';
        echo '<form method="post" enctype="multipart/form-data">';

        if(!empty($this->_fields))
        {
            foreach ($this->_fields as $field)
            {
                // Формируем данные
                $input = [
                    'name' => $this->slug.'['.$field->name.']',
                    'label' => $field->label,
                    'placeholder' => $field->placeholder,
                    'value' => $field->value,
                    'required' => ($field->required == 1 ? 'required' : ''),
                ];

                // Блок и подписи
                echo '<div class="dymanic input">';
                echo '<label>'.$input['label'].($field->required == 1 ? '<b class="color-red">*</b>' : '').'</label>';

                // Перебор полей
                switch ($field->type):

                    case 'textarea':
                        echo '<textarea name="'.$input['name'].'" placeholder="'.$input['placeholder'].'" cols=20 rows=5 '.$input['required'].'>'.$input['value'].'</textarea>';
                        break;

                    default:
                        echo '<input type="text" name="'.$input['name'].'" placeholder="'.$input['placeholder'].'" value="'.$input['value'].'" '.$input['required'].'>';
                        break;

                endswitch;

                // Блок и подписи
                echo '</div>';
            }
        }

        // Согласие
        echo '<div class="dymanic input">';
        echo '<div class="dymanic capthca">';
        echo '<img src="/captcha" alt="code"/>';
        echo '</div>';
        echo '<input type="text" name="captcha" placeholder="Введите код с картинки" value="">';
        echo '</div>';

        // Согласие
        echo '<div class="dymanic input">';
        echo '<label>'
            .'<input type="checkbox" readonly checked> Продолжая я даю свое согласие на <a href="/">обработку моих персональных данных</a>'
            .'</label>';
        echo '</div>';

        // Отправка
        echo '<div class="dymanic input">';
        echo '<button id="'.$this->slug.'-submit" class="">Отправить</button>';
        echo '</div>';

        echo '</form>';
        echo '</div>';

        return ob_get_clean();
    }
}