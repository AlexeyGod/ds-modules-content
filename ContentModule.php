<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content;


use framework\components\module\ModuleComponent;
use framework\components\module\ModuleInstall;
use framework\core\Application;
use framework\exceptions\ErrorException;
use modules\content\migrations\m_install_content_0;

class ContentModule extends ModuleComponent
{
    public $normalize = true;
    //deprecated: public $modules = ['user'];

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

    //protected $_generalMenu = [];

    public function __construct(array $options = [])
    {
        Application::setAlias('@modules/content', __DIR__);
        parent::__construct($options);
       
        // Формирование меню
        //$this->_generalMenu[] = $this->contextMenu();
    }

    public static function install()
    {
        $migration = new m_install_content_0();

        $data = $migration->up();

        return [
            'status' => ModuleInstall::INSTALL_SUCCESS,
            'msg' => $data
        ];
    }

}