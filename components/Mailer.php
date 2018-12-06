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

class Mailer extends \yii\swiftmailer\Mailer implements MailerInterface
{
    private $message;

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
        $this->message = $this->createMessage();
        $content = $this->renderTemplate($model, $params, $layout);
        if ($model->content_type === MailTemplate::CONTENT_TYPE_HTML) {
            $this->message->setHtmlBody($content);
        } else {
            $this->message->setTextBody($content);
        }
        if ($model->from) {
            $this->message->setFrom($model->from);
        }
        if ($model->subject) {
            $this->message->setSubject($model->subject);
        }
        return $this->message;
    }

    /**
     * Отрендерить шаблон
     * если нужно использовать layout
     * @param MailTemplate $model
     * @param array $params
     * @param bool $layout
     * @return string
     */
    public function renderTemplate(MailTemplate $model, array $params = [], bool $layout = true): string
    {
        $content = $this->prepare($model->template, $params);
        if ($model->layout && $layout) {
            $content = $this->prepare($model->layout->template, [
                'content' => $content,
            ]);
        } elseif ($layout) {
            $content = $this->getView()->render(
                $model->content_type === MailTemplate::CONTENT_TYPE_HTML ? $this->htmlLayout : $this->textLayout,
                [
                    'content' => $content,
                    'message' => $this->message,
                ],
                $this
            );
        }
        return $content;
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
