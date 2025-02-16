<?php


namespace Core;


use Core\Db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}