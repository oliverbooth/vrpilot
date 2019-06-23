<?php
namespace VRPilot;

class DB {

    /**
     * The path to the database file.
     */
    const DB_FILE = "internal/config.db";

    private $dbh = null;
    private $depth = 0;

    public function __construct($depth = 0) {
        $this->depth = $depth;
    }

    /**
     * Determines if the database file exists.
     * @return bool Returns {@see TRUE} if the file exists, {@see FALSE} otherwise.
     */
    public function exists() {
        return file_exists(DB::DB_FILE);
    }

    /**
     * Performs a query on the database.
     */
    public function query($query, $preparedMappings = array()) {
        $db = $this->open();
        $stmt = $db->prepare($query);
        foreach ($preparedMappings as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        $res = $stmt->execute();
        return $res;
    }

    /**
     * Opens a connection to the database.
     */
    private function open() {
        if (is_null($this->dbh)) {
            $this->dbh = new \SQLite3(str_repeat("../", $this->depth) . DB::DB_FILE);
        }

        return $this->dbh;
    }

};
?>