<?php
namespace VRPilot;

require_once("DB.php");

/**
 * Represents a show.
 */
class Show {

    private $row;

    /**
     * Initializes a new instance of the {@see Show} class.
     */
    public function __construct($id) {
        $db = new DB();
        $this->row = $db->query("SELECT * FROM shows WHERE LOWER(id) = :id LIMIT 1;", array(":id" => strtolower($id)))->fetchArray(SQLITE3_ASSOC);
    }

    /**
     * Gets the show's ID.
     * @return string Returns the show's UUIDv4 compliant ID.
     */
    public function getId() {
        return $this->row["id"];
    }

    /**
     * Gets the show's name.
     * @return string Returns the show's name.
     */
    public function getName() {
        return $this->row["name"];
    }

    /**
     * Gets all shows.
     * @return Show[] An array of all shows.
     */
    public static function all() {
        $shows = array();
        $db = new DB();
        $res = $db->query("SELECT id FROM shows");

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $shows[] = new Show($row["id"]);
        }

        return $shows;
    }

};
?>