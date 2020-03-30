<?php

namespace Models\AccessibleModels\Tables;

class PostTable {

    const TABLE_NAME = "post";

    const COLUMNS = [
        "ID" => "id",
        "TITLE" => "title",
        "BODY" => "body",
        "CATEGORY_ID" => "category_id"
    ];
}
