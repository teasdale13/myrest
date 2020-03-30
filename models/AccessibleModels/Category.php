<?php

namespace Models\AccessibleModels;

use Models\AccessibleModels\tables\CategoryTable;
use Models\DataAccess;

/**
 * Created by PhpStorm - 2020-03-29
 * @author kevinteasdaledube
 */
class Category extends DataAccess {

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->_table_name = CategoryTable::TABLE_NAME;
        $this->_columns = CategoryTable::COLUMN;
        $this->_id_column = CategoryTable::COLUMN['ID'];
    }

}
