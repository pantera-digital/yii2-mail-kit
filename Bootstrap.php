<?php
/**
 * Created by PhpStorm.
 * User: singletonn
 * Date: 9/19/18
 * Time: 5:15 PM
 */

namespace pantera\mail;


use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\swiftmailer\Mailer;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Yii::$container->set(Mailer::class, \pantera\mail\components\Mailer::class);
    }
}