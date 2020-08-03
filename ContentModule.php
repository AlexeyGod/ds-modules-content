<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content;


use framework\components\module\ModuleComponent;
use framework\core\Application;
use framework\exceptions\ErrorException;

class ContentModule extends ModuleComponent
{
    public $normalize = true;
    public $modules = ['user'];

    public  $routes = [
        // Пользовательские
        // Разделы
        [
            'class' => __NAMESPACE__.'\route\UrlRule',
            'pattern' => '<section:[A-Za-z0-9+_\./-]+>',
            'url' => 'content/page/view-section'

        ],
        // Страницы
        [
            'class' => __NAMESPACE__.'\route\UrlRule',
            'pattern' => '<page:[A-Za-z0-9+_\./-]+>',
            'url' => 'content/page/view'

        ],
        // Меню
        'manager/content/menu' => 'content/manager-menu',
        'manager/content/menu/create' => 'content/manager-menu/create',
        'manager/content/menu/<action:view|update|delete>/<id:\d+>' => 'content/manager-menu/<action>',
        // Разделы
        'manager/content/sections' => 'content/manager-sections',
        'manager/content/sections/create' => 'content/manager-sections/create',
        'manager/content/sections/<action:\w+>/<id:\d+>' => 'content/manager-sections/<action>',
    ];

    protected $_menu = [
        'accept' => 'c-manager',
        'name' => 'Контент',
        'icon' => 'icon icon-folder-plus',
        'links' => [
            [
                'name' => 'Меню',
                'url' => '/manager/content/manager-menu',
            ],
            [
                'name' => 'Разделы',
                'url' => '/manager/content/manager-sections',
            ],
            [
                'name' => 'Страницы',
                'url' => '/manager/content/manager-pages',
            ],
            [
                'name' => 'Обратная связь',
                'url' => '/manager/content/manager-feedback',
            ],
        ]
    ];

    protected $_generalMenu = [];

    public function __construct(array $options = [])
    {
        Application::setAlias('@modules/content', __DIR__);
        parent::__construct($options);
       
        // Формирование меню
        $this->_generalMenu[] = $this->contextMenu();
        /* deprecated
         Подгрузка всех модулей
        if(!empty($this->modules))
        {
            foreach($this->modules as $module)
            {
                $object = Application::app()->getModule($module);
                if(!method_exists($object, 'contextMenu'))
                    throw new ErrorException("ManagerModule: Указанный как плагин модуль $module не содержит необходимого метода contextMenu()");

                $this->_generalMenu[] = $object->contextMenu();
                unset($object);
            }
        }
        */
    }


    public function stringNormalize($str)
    {
        if($this->normalize)
            $str = htmlspecialchars(stripslashes($str));

        return $str;
    }

    public function mailer()
    {
        return 'test';
    }

    public function menu()
    {
        $output = "<!-- Module Menu widget -->\n";

        foreach($this->_generalMenu as $item)
        {
            $output .= '<div class="module-menu">'."\n";
            $output .= "\t".'<div class="module-name">'."\n"
                .'<a href="#"><span class="'.$item['icon'].'"> '.$this->stringNormalize($item['name']).'</a>'."\n"
                .'</div>'."\n";
                $output .= "\t".'<div class="module-menu">'."\n\t\t<ul>\n";

                foreach($item['links'] as $link)
                {
                    $output .= "\t\t\t".'<li><a href="'.$link['url'].'">'.$this->stringNormalize($link['name']).'</a></li>'."\n";
                }

                $output .= "\t\t</ul>\n\t".'</div>'."\n";
            $output .= '</div>';
            $output .= "\n<!--/ Module Menu widget -->\n";
        }

        return $output;
    }
}