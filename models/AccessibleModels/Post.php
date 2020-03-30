<?php

namespace Models\AccessibleModels;

use Models\AccessibleModels\Tables\PostTable;
use Models\DataAccess;

class Post extends DataAccess {

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->_table_name = PostTable::TABLE_NAME;
        $this->_columns = PostTable::COLUMNS;
        $this->_id_column = PostTable::COLUMNS['ID'];
    }

}
