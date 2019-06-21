# yii2-mail-kit

### Установка
```
composer require pantera-digital/yii2-mail-kit "@dev"
```
Добавить в консольный конфиг путь до миграций
```
'controllerMap' => [
    'migrate' => [
        'class' => yii\console\controllers\MigrateController::className(),
        'migrationPath' => [
            '@pantera/mail/migrations',
        ],
    ],
],
```
Запустить миграции
```
php yii migrate
```
### Настройка
Модуль зависит от https://github.com/yiisoft/yii2-twig нужно сконфигурировать это расширение

Подключить модуль в конфиг для доступы к управлению
```
'modules' => [
    'mail' => [
        'class' => \pantera\mail\Module::class,
        'permissions' => ['admin'],
    ],
],
```
### Использование
Yii::$app->mailer->composeTemplate(strign $template, array $params = [])
    ->setTo($to)
    ->send();
* $template Алиас шаблона
* $params Массив параметров которые будут переданны в twig
