<?php
/**
 * Created by PhpStorm.
 * User: singletonn
 * Date: 9/19/18
 * Time: 4:40 PM
 */

namespace pantera\mail\components;

use yii\mail\MessageInterface;

interface MailerInterface extends \yii\mail\MailerInterface
{
    /**
     * Создание нового сообщения
     * @param string $alias Ключ шаблона
     * @param array $params Массив параметров для использования
     * @return MessageInterface
     */
    public function composeTemplate(string $alias, array $params = []): MessageInterface;
}
