<?php
/**
 * Created by PhpStorm.
 * User: Алексей-дом
 * Date: 23.05.2020
 * Time: 18:23
 */

namespace modules\content\route;


use framework\components\db\SqlBuilder;
use framework\components\routing\BaseUrlRule;
use modules\content\models\Page;
use modules\content\models\Section;

class UrlRule extends BaseUrlRule
{
    public function parseUrl($route, $pathInfo)
    {
        $route = $this->_parseUrl($route, $pathInfo);

        if($route === false) // Если маска не подошла
            return false;
        else
        {
            $url = isset($this->params['page']) ? $this->params['page'] : $this->params['section'];
            // Нормализуем адрес
            $link = trim($url, '/');
            if(substr($link, 0, 1) != '/')
                $link = '/'.$link;

            // Проверяем существует ли объект в БД
            $tableName =  isset($this->params['page']) ? Page::tableName() : Section::tableName();

            $sql = new SqlBuilder();
            $rows = $sql->select($tableName)->fields('id')->where(['link' => $link])->row();
            if(count($rows) > 0)
            {
                if(isset($this->params['page'])) unset($this->params['page']);
                if(isset($this->params['section'])) unset($this->params['section']);
                $this->params['alias'] = $link;
                //exit('route to: '.$route.', params: '.var_export($this->params, true));
                return $route;
            }
            else
                return false;
        }
    }

    public function createUrl($route, $params)
    {
        return false;
    }
}