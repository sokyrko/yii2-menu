Yii2 menu module
================
Yii2 module for menu creation.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sokyrko/yii2-menu "*"
```

or add

```
"sokyrko/yii2-menu": "*"
```

to the require section of your `composer.json` file.

Run migration
```
./yii migrate/up --migrationPath=@vendor/sokyrko/yii2-menu/migrations
```

Usage
-----

Minimal configuration:

```php
<?= MenuWidget::widget([
    'menuName' => 'main_footer',
    'menuWrapper' => '<ul class="bottom-nav">{items}</ul>',
]) ?>
```

Also you can define other settings:

```php
<?= MenuWidget::widget([
    'menuName' => 'main_header',
    'template' => function (MenuItem $current) {
        return Html::tag('li', Html::a($current->title, $current->url) . '{children}', [
            'class' => ($current->url == Url::to([''])) ? 'active' : '',
        ]);
    },
    'menuWrapper' => '<nav class="nav-holder"><ul id="nav">{items}</ul></nav>',
    'subMenuWrapper' => '<div class="drop"><ul>{items}</ul></div>',
]) ?>
```