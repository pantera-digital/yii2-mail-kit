<?php
/**
 * Created by PhpStorm.
 * User: singletonn
 * Date: 9/19/18
 * Time: 4:29 PM
 */

namespace pantera\mail\components;

use mikehaertl\tmp\File;
use pantera\mail\exceptions\MailTemplateNotFoundException;
use pantera\mail\models\MailTemplate;
use Yii;
use yii\mail\MessageInterface;
use function is_null;

class Mailer extends \yii\swiftmailer\Mailer implements MailerInterface
{
    /**
     * Создание нового сообщения
     * @param string $alias Ключ шаблона
     * @param array $params Массив параметров для использования
     * @param bool $layout Флаг что нужно отрендерить шаблон
     * @return MessageInterface
     * @throws MailTemplateNotFoundException
     * @throws \yii\base\InvalidConfigException
     */
    public function composeTemplate(string $alias, array $params = [], bool $layout = true): MessageInterface
    {
        $model = $this->findTemplate($alias);
        $content = $this->prepare($model->template, $params);
        $message = $this->createMessage();
        if ($layout) {
            $content = $this->getView()->render(
                $model->content_type === MailTemplate::CONTENT_TYPE_HTML ? $this->htmlLayout : $this->textLayout,
                [
                    'content' => $content,
                    'message' => $message,
                ],
                $this
            );
        }
        if ($model->content_type === MailTemplate::CONTENT_TYPE_HTML) {
            $message->setHtmlBody($content);
        } else {
            $message->setTextBody($content);
        }
        if ($model->from) {
            $message->setFrom($model->from);
        }
        if ($model->subject) {
            $message->setSubject($model->subject);
        }
        return $message;
    }

    /**
     * Подготовить тело сообщения
     * @param string $template Сообщение
     * @param array $params Параметры
     * @return string Преобразованное через twig сообщение
     */
    protected function prepare(string $template, array $params): string
    {
        $file = new File($template, '.twig');
        $result = Yii::$app->view->renderFile($file->getFileName(), $params);
        return $result;
    }

    /**
     * Найти шаблон по ключу
     * @param string $alias Ключ шаблона
     * @return MailTemplate
     * @throws \yii\base\InvalidConfigException
     * @throws MailTemplateNotFoundException
     */
    protected function findTemplate(string $alias): MailTemplate
    {
        $object = Yii::createObject(MailTemplate::class);
        $model = $object::find()
            ->andWhere(['=', $object::tableName() . '.alias', $alias])
            ->one();
        if (is_null($model)) {
            throw new MailTemplateNotFoundException();
        }
        return $model;
    }
}
