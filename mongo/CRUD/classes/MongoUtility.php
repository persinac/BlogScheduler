<?php

/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 5/26/2016
 * Time: 1:03 PM
 */

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root . '/connections/mongo_connection.php';
require_once $root . '/mongo/CRUD/classes/CreateCollection.php';

class MongoUtility extends CreateCollection
{
    public $connection;
    public $db;
    public $collection;

    function __construct($id = -1)
    {
        $this->NewConnection(MONGO_HOST, MONGO_PORT, MONGO_DB);
    }

    function NewConnection($host, $port, $database) {
        $connecting_string =  sprintf('mongodb://%s:%d/%s', $host, $port, $database);
        $this->connection = new MongoDB\Driver\Manager($connecting_string);
    }
    function CloseConnection() {
        //no idea how to close mongo db connection
    }

    function CreateNewDatabase() {
        //$this->connection->
        //TBD
    }

    function CreateNewCollection($newCollectionName) {
        $createColl = new CreateCollection($newCollectionName);
        $createColl->setCappedCollection(false);
        $command = $createColl->getCommand();
        $cursor = $this->connection->executeCommand($this->db, $command);
        $result = $cursor;
        return $result;
    }

    function SelectDBToUse($dbToUse) {
        $this->db = $dbToUse;
    }

    function SelectCollection($collectionToUse) {
        $this->collection = $this->db . "." . $collectionToUse;
    }

    function ListAllCollections() {
        // listCollections: 1
        $command = new MongoDB\Driver\Command( ['listCollections' => 1] );
        $response = array();
        try {
            $cursor = $this->connection->executeCommand($this->db, $command);
            foreach($cursor as $var) {
                if($var->type == "collection") {
                    $response[] = $var->name;
                }
            }
        } catch(MongoDB\Driver\Exception $e) {
            $response[] = $e->getMessage() . '<br/>';
            exit;
        }
        return $response;
    }

    /*
     * CREATE
     * */

    function InsertIntoCollection($items) {
        $bulk = new MongoDB\Driver\BulkWrite;
        foreach($items as $var) {
            $bulk->insert($var);
        }
        $result = $this->connection->executeBulkWrite($this->collection, $bulk);
        return $result;
    }

    /*
     * READ
     */
    function FindAll() {
        $query = new MongoDB\Driver\Query( [] );
        return $this->connection->executeQuery($this->collection, $query);
    }

    function FindSpecific($filter, $options) {
        $query_com = new MongoDB\Driver\Query( $filter, $options );
        return $this->connection->executeQuery($this->collection, $query_com);
    }

    function ProjectSpecific($query) {
        return $this->collection->find(array(),$query);
    }

    function AggregateMatch($match, $options = array()) {
        $this->collection->aggregate($match);
    }

    /***
     * UPDATE
     */

    function UpdateSpecific($filter, $update) {
        $this->collection->update($filter, $update);
    }

    /****
     * Delete
     */
    function DeleteAllInCollection() {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        $result = "";
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        try {
            $result = $this->connection->executeBulkWrite($this->collection, $bulk, $writeConcern);
        } catch(MongoDB\Driver\Exception $e) {
            $result = $e->getMessage() . '<br/>';
        }
        return $result;
    }
}