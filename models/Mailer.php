<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\content\models;

use framework\core\Application;

class Mailer
{
    public $sendMethod;


    public static function simpleSend($to, $from, $subject, $text)
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From: $from\r\n";

        return mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $text, $headers);
    }
}