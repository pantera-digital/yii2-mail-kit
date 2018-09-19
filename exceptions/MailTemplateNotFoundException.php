<?php
/**
 * Created by PhpStorm.
 * User: singletonn
 * Date: 9/19/18
 * Time: 4:38 PM
 */

namespace pantera\mail\exceptions;

class MailTemplateNotFoundException extends \yii\base\Exception
{
    public function getName(): string
    {
        return 'Mail template not found';
    }
}