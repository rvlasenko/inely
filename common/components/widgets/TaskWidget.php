<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 */

namespace common\components\widgets;

use backend\models\Task;
use DateTime;
use IntlDateFormatter;
use Yii;
use yii\base\InvalidCallException;
use yii\base\Widget;
use yii\helpers\Html;

class TaskWidget extends Widget
{
    public $model;
    public $layout;

    public function init()
    {
        parent::init();

        if ($this->layout === null) {
            throw new InvalidCallException('Option "layout" must be set');
        }
    }

    /**
     * Select layout to render
     * @return string
     */
    public function run()
    {
        switch ($this->layout) {
            case 'sectionAll':
                return $this->sectionAll(); break;
            case 'navTabs':
                return $this->navTabs(); break;
            case 'sectionsOwn':
                return $this->sectionsOwn(); break;
        }
    }

    /**
     * Return tasks categories as navigation tabs
     * If the field userId IS NULL then the category is public
     * @return string
     */
    protected function navTabs()
    {
        $navTabs = '';

        if (count($this->model)) {
            $navTabs = '<li><a href="#section-bar"><span>Home</span></a></li>';
            foreach ($this->model as $list):
                $navTabs .= <<<LAYOUT
                <li>
                    <a href="#section-{$list['listName']}" class="user-list" id="{$list['id']}">
                        <span>{$list['listName']}</span>
                    </a>
                </li>
LAYOUT;
            endforeach;
        }

        return $navTabs;
    }

    protected function sectionsOwn()
    {
        $sections = '';
//        if ($this->model['id'] != $section['list']) {
//            $youHaveNoTasks = Yii::t('backend', 'You have no incomplete tasks in this list. Woohoo!');
//            echo "<tr class='message'><td>$youHaveNoTasks</td></tr>";
//        } else
//        1 работа        2 lolllllllll
//    ляля       лоло
        $model = Task::find()
            ->select('list')->distinct()
            ->where([ 'author' => Yii::$app->user->id ])
            ->andWhere([ 'not', [ 'list' => null ] ])
            ->joinWith('tasks_cat')->asArray()->all();

        foreach ($model as $section):
            //if ($this->model['id'] !== $section['list'])
            $sections .= <<<LAYOUT
            <section id="section-{$section['tasks_cat']['listName']}">
                <div class="tray tray-center h27m pn va-t bg-light">
                    <div class="panel">
                        <table id="message-table" class="table tc-checkbox-1 admin-form theme-warning br-t">
                            <tbody data-key="{$section['list']}"></tbody>
                        </table>
                    </div>
                </div>
            </section>
LAYOUT;
        endforeach;

        return $sections;
    }

    public function sectionAll()
    {
        $model = Task::find()
            ->where([ 'author' => Yii::$app->user->id ])
            ->joinWith('tasks_cat')->asArray()->all();

        // All tasks will be here
        $items = '';

        if (count($model)) {

            // Init timestamp to language date format
            $formatter = new IntlDateFormatter(Yii::$app->language, IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'UTC');
            $formatter->setPattern('dd MMMM');
            $format = new DateTime();

            $checkboxId = 0;

            foreach ($model as $task):
                $checkboxId++;

                // The definition of some useful variables
                $isDone   = $task[ 'isDone' ] ? 'done' : 'undone';
                $taskName = Html::tag('span', $task[ 'name' ]);
                $taskTag  = isset($task[ 'tagName' ])
                    ? Html::tag('span', '#' . $task[ 'tasks_cat' ][ 'tagName' ], [ 'class' => 'badge badge-info mr10 fs11' ])
                    : false;

                $dateTime = $task[ 'isDone' ]
                    ? false
                    : Yii::t('backend', 'until ') . $formatter->format($format->setTimestamp((int)$task[ 'due' ]));

                $items .= <<<TASK
                <tr class="message $isDone pr {$task['priority']}">
                    <td class="text-center w90">
                        <label class="option block mn">
                            <input type="checkbox" class="checkbox" id="checkbox$checkboxId" data-task-id="{$task['id']}" />
                            <label for="checkbox$checkboxId"></label>
                        </label>
                    </td>
                    <td class="fw600">
                        $taskTag $taskName
                    </td>
                    <td class="text-right">$dateTime</td>
                </tr>
TASK;
            endforeach;
        } else {
            $youHaveNoTasks = Yii::t('backend', 'You have no incomplete tasks in this list. Woohoo!');

            $items = "<tr class='message'><td>$youHaveNoTasks</td></tr>";
        }

        return $items;
    }
}