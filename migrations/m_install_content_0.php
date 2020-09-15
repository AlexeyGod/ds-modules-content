<?php

namespace modules\content\migrations;


class m_install_content_0 extends \framework\migrations\Migration
{
    public $description = 'Install basic sql-tables';

    public function up(){

        $this->db->beginTransaction();

        try {
            // menu
            $this->db->query("CREATE TABLE IF NOT EXISTS content_menu ("
                . "id int not null auto_increment,"
                . "name text,"
                . "url text,"
                . "priority int DEFAULT 0,"
                . "id_parent int,"
                . "PRIMARY KEY(id))");

            $this->db->query("INSERT INTO content_menu (name, url, priority)"
                . "VALUES"
                . "('Главная', '/', 1),"
                . "('GitHub', 'https://github.com/alexeygod/ds-start-app', 1)");

            // sections
            $this->db->query("CREATE TABLE IF NOT EXISTS content_section ("
                . "id int not null auto_increment,"
                . "name text,"
                . "alias text,"
                . "link text,"
                . "public int,"
                . "access_filter text,"
                . "id_parent int default 0,"
                . "priority int,"
                . "PRIMARY KEY(id))");

            $this->db->query("INSERT INTO content_section(name, `alias`, link)"
                . "VALUES"
                . "('Раздел 1', 'section1', '/section1')");

            // pages
            $this->db->query("CREATE TABLE IF NOT EXISTS content_pages ("
                ."`id` int(11) NOT NULL AUTO_INCREMENT,"
                ."`name` text,"
                ."`alias` text,"
                ."`id_section` int(11) NOT NULL,"
                ."`short` text,"
                ."`content` text,"
                ."`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,"
                ."`author` int(11) DEFAULT NULL,"
                ."`public` int(11) DEFAULT NULL,"
                ."`link` text,"
                ."`type` text NOT NULL,"
                ."`priority` int(11) NOT NULL DEFAULT '0',"
                ."PRIMARY KEY (`id`))"
            );

            $this->db->query("INSERT INTO content_pages(name, `alias`, link, content)"
                . "VALUES"
                . "('Страница 1', 'page_1', 'page_1', 'Это тестовая страница')");

            // attachments
            $this->db->query("CREATE TABLE IF NOT EXISTS content_attachments ("
                ."`id` int(11) NOT NULL AUTO_INCREMENT,"
                ."`class` text,"
                ."`path` text,"
                ."`name` text,"
                ."`extension` text,"
                ."`flag` text,"
                ."`relation` int(11) DEFAULT NULL,"
                ."`created_at` datetime,"
                ."`updated_at` datetime,"
                ."`author` int(11),"
                ."PRIMARY KEY (`id`))"
            );


            $this->db->commit();
        }
        catch (\PDOException $e)
        {
            return 'Ошибка: '.$e->getMessage();
        }

        return "Created table: content_menu, content_section, content_pages, content_attachments";
    }

    public function down(){

        $this->db->beginTransaction();
        $this->db->query("DROP TABLE content_menu");
        $this->db->query("DROP TABLE content_section");
        $this->db->query("DROP TABLE content_pages");
        $this->db->commit();

        return "Deleted table: global_settings, global_modules";
    }
}