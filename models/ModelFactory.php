<?php


namespace Models;

use Models\AccessibleModels\Category;
use Models\AccessibleModels\Post;
use Models\AccessibleModels\tables\CategoryTable;
use Models\AccessibleModels\Tables\PostTable;
use PDO;

/**
 * Created by PhpStorm - 2020-03-29
 * @author kevinteasdaledube
 */
class ModelFactory {

    /**
     * @param $model string
     * @param $pdo PDO database connection.
     * @return mixed return a Model
     */
    public static function getModel( $model , $pdo ) {
        switch ($model) {
            case PostTable::TABLE_NAME :
                return new Post( $pdo );
            case CategoryTable::TABLE_NAME :
                return new Category( $pdo );
        }
    }

}
