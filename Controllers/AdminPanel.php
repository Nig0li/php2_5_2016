<?php

namespace Controllers;

use Exceptions\MultiException;
use Models\News;
use Templates\php\View;

class AdminPanel extends Basic
{

    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * action - Получение массива всех новостей
     */
    protected function actionNewsAll()
    {
        $this->view->news = \Models\News::findAll();
        $this->view->display(__DIR__ . '/../Templates/adminNews.php');
    }

    /**
     * action - Получение массива последних 2х новостей
     */
    protected function actionLimitNews()
    {
        $this->view->news = News::getThreeLastRecord(2);
        $this->view->display(__DIR__ . '/../Templates/adminNews.php');
    }

    /**
     * action - Редактирование новости (создать/обновить)
     */
    protected function actionEdit()
    {
        try {
            if (empty((int)$_POST['id'])) {
                $art = new News();
            } else {
                $art = News::findById((int)$_POST['id']);
            }
            $this->view->article = $art->fill($_POST);
        } catch (MultiException $e) {
            $this->view->errors = $e;
        }
        $this->view->display(__DIR__ . '/../Templates/editNews.php');
    }

    /**
     * action - Сохранение изменений
     */
    protected function actionSave()
    {
        try {
            if (empty((int)$_POST['id'])) {
                $art = new News();
            } else {
                $art = News::findById((int)$_POST['id']);
            }
            $art->fill($_POST);
            $art->save();
            header('Location: /../index.php?ctrl=AdminPanel');
        } catch (MultiException $e) {
            $this->view->errors = $e;
        }
        $this->view->display(__DIR__ . '/../Templates/editNews.php');
    }

    /**
     * action - Удаление новости по id
     */
    protected function actionDelete()
    {
        $art = News::findById((int)$_GET['id']);
        $art->delete();
        header('Location: /../index.php?ctrl=AdminPanel');
        exit(0);
    }
}