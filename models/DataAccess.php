<?php

namespace Models;

/**
 * Class DataAccess
 * @author Kevin Teasdale-Dubé
 * @package Models
 */
class DataAccess {

    private $_db;
    protected $_table_name;
    protected $_id_column;
    protected $_columns;


    public function __construct($pdo) {
        $this->_db = $pdo;
    }

    /* ---- Read ----*/
    /**
     * Return all the records from a table.
     * @return mixed
     */
    public function getAll() {
        $statement = $this->_db->prepare("SELECT * FROM " . $this->_table_name);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Return a record by his id.
     * @param $id int The id of the specific record
     * @return mixed
     */
    public function getById( $id ) {
        $statement = $this->_db->prepare("SELECT * FROM " . $this->_table_name . " WHERE " . $this->_id_column . " = ?");
        $statement->execute([$id]);
        return $statement->fetchObject();
    }

    /* ---- Create ---- */

    /**
     * Create a new record in the database.
     * @param array $data All the required data to create a record in the database.
     * @return bool|mixed If the record is created, the new inserted record is return and false if something goes wrong.
     */
    public function insert( array $data ) {
        $sql = "INSERT INTO {$this->_table_name}("
            . implode(",", array_keys($data))
            . ") VALUES (:"
            . implode(",:", array_keys($data))
            . ");";

        $statement = $this->_db->prepare($sql);
        $response = $statement->execute($data);
        return $response ? $this->getById( $this->_db->lastInsertId() )  : false ;
    }

    /* ---- Update ---- */

    /**
     * Update a record by his id.
     * @param array $data All the updated data.
     * @param $id int The id of the record we want to update.
     * @return bool|mixed If the record is updated, the updated object is return, and false if something goes wrong.
     */
    public function update( array $data, $id ) {
        $copy_data = $data;
        foreach ($data as $key => &$value) {
            $value = $key . " = :" . $key;
        }
        $sql = "UPDATE ". $this->_table_name . " SET "
            . implode(", ", $data)
            . " WHERE " . $this->_id_column." =:id";
        $statement = $this->_db->prepare($sql);
        $response = $statement->execute(array_merge(["id" => $id], $copy_data));
        return $response ? $this->getById( $id ) : false;
    }

    /* ---- Delete ---- */

    /**
     * Delete a record by his id
     * @param $id int The id of the record we want to delete.
     * @return mixed
     */
    public function delete( $id ) {
        $statement = $this->_db->prepare( "DELETE FROM " . $this->_table_name . " WHERE " . $this->_id_column . " =?" );
        return $statement->execute([ $id ]);
    }
}
