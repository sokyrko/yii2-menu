<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 28.11.16
 * Time: 10:47
 */

namespace sokyrko\yii2menu\widgets;

use sokyrko\yii2menu\models\Menu;
use sokyrko\yii2menu\models\MenuItem;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class MenuWidget
 * @package frontend\widgets\menu
 */
class MenuWidget extends Widget
{
    /**
     * @var string name of menu
     */
    public $menuName;

    /**
     * @var callable function for template building.
     * Function should return a string. You can use {children} tag for inserting sub menus there.
     */
    public $template;

    /**
     * @var string template to wrap menu parent items
     * {items} - html generated in template callable
     */
    public $menuWrapper = '<ul>{items}</ul>';

    /**
     * @var string template to wrap submenu items
     * {items} - html generated in template callable
     */
    public $subMenuWrapper = '<ul>{items}</ul>';

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @inheritdoc
     * @throws InvalidParamException
     */
    public function init()
    {
        if (!$this->menuName) {
            throw new InvalidParamException('"menuName" should be defined.');
        }

        if ($this->template && !is_callable($this->template)) {
            throw new InvalidParamException('"template" should be callable.');
        } else if (!$this->template) {
            $this->template = function (MenuItem $current) {
                return Html::tag('li', Html::a($current->title, $current->url));
            };
        }

        $this->menu = Menu::findOne(['name' => $this->menuName]);

        if (!$this->menu) {
            // throw new InvalidParamException(sprintf('Menu %s is not created.', $this->menuName));
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->menu) {
            return null;
        }

        return $this->appendWrapper($this->renderMenu($this->menu->items), $this->menuWrapper);
    }

    /**
     * @param MenuItem[] $items
     * @return string
     */
    private function renderMenu(array $items)
    {
        $totalHtml = '';

        foreach ($items as $item) {
            $itemHtml = call_user_func_array($this->template, [$item]);
            $childrenHtml = $item->children ? $this->appendWrapper($this->renderMenu($item->children), $this->subMenuWrapper) : '';
            $totalHtml .= $this->appendChildren($childrenHtml, $itemHtml);
        }

        return $totalHtml;
    }

    /**
     * @param $html string with menu items html
     * @param $wrapper string
     * @return string
     */
    private function appendWrapper($html, $wrapper)
    {
        return preg_replace('/{items}/', $html, $wrapper);
    }

    /**
     * @param $childrenHtml
     * @param $itemHtml
     * @return string
     */
    private function appendChildren($childrenHtml, $itemHtml)
    {
        return preg_replace('/{children}/', $childrenHtml, $itemHtml);
    }

}