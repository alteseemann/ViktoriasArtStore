<?php
namespace App\Actions;
use TCG\Voyager\Actions\AbstractAction;

class Publish extends AbstractAction{
    public function getTitle()
    {
        // Название действия, которое отображается в кнопке
        // в зависимости от текущего состояния
        return $this->data->{'status'}=="PUBLISHED"?'Pending':'Publish';
    }
    public function getIcon()
    {
        // Значок действия, который отображается слева от кнопки
        // в зависимости от текущего состояния
        return $this->data->{'status'}=="PUBLISHED"?'voyager-x':'voyager-external';
    }
    public function getAttributes()
    {
        // Класс кнопки действия
        return [
            'class' => 'btn btn-sm btn-primary pull-left',
        ];
    }
    public function shouldActionDisplayOnDataType()
    {
        // Показывать или скрыть кнопку действия. Отображается только для модели Posts
        return $this->dataType->slug == 'posts';
    }
    public function getDefaultRoute()
    {
        // URL-адрес для кнопки действия при нажатии кнопки
        return route('posts.publish', array("id"=>$this->data->{$this->data->getKeyName()}));
    }
}
