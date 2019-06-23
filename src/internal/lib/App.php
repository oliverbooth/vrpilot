<?php
namespace VRPilot;

require_once("DB.php");
require_once("BroadcastMode.php");

class App {

    private $db;

    public function __construct($depth = 0) {
        $this->db = new DB($depth);
    }

    /**
     * Get's the station's broadcast mode.
     */
    public function getBroadcastMode() {
        return intval($this->getVar("bc_mode"));
    }

    /**
     * Gets the name of this station.
     * @return string Returns the name of this station.
     */
    public function getStationName() {
        return $this->getVar("st_name");
    }

    /**
     * Gets the inverse refresh rate.
     * @return int Returns the inverse refresh rate.
     */
    public function getSecondsPerFrame()
    {
        return intval($this->getVar("spf"));
    }

    /**
     * Gets the image codec this station is using.
     * @return string Returns the codec of this station.
     */
    public function getTvCodec() {
        return $this->getVar("tv_codec");
    }

    /**
     * Gets the image quality this station is using.
     * @return int Returns the quality of this station.
     */
    public function getTvQuality() {
        return intval($this->getVar("tv_quality"));
    }

    /**
     * Gets the image width this station is using.
     * @return int Returns the width of this station.
     */
    public function getTvWidth() {
        return intval($this->getVar("tv_width"));
    }

    /**
     * Gets the image height this station is using.
     * @return int Returns the height of this station.
     */
    public function getTvHeight() {
        return intval($this->getVar("tv_height"));
    }

    /**
     * Gets a config variable from the database.
     */
    private function getVar($var) {
        $row = $this->db->query("SELECT value FROM vars WHERE key = :k LIMIT 1;", array(":k" => $var));
        if ($row) {
            return $row->fetchArray(SQLITE3_ASSOC)["value"];
        }
    }

};
?>