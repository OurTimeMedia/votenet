<?php

class voter_reminder extends common
{
    //Property
    protected $tableName = 'voter_reminder';

    protected $id;
    protected $voter_id;
    protected $created_at;
    protected $notified;
    protected $notified_at;
    protected $pdf_id;



    public function __construct()
    {
        $this->setVoterId(0);
        $this->setNotified(0);
        $this->setPdfId(mt_rand(1000000, 9999999));
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return DB_PREFIX . $this->tableName;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * @param mixed $notified
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifiedAt()
    {
        return $this->notified_at;
    }

    /**
     * @param mixed $notified_at
     */
    public function setNotifiedAt($notified_at)
    {
        $this->notified_at = $notified_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPdfId()
    {
        return $this->pdf_id;
    }

    /**
     * @param mixed $pdf_id
     */
    protected function setPdfId($pdf_id)
    {
        $this->pdf_id = $pdf_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoterId()
    {
        return $this->voter_id;
    }

    /**
     * @param mixed $voter_id
     */
    public function setVoterId($voter_id)
    {
        $this->voter_id = $voter_id;
        return $this;
    }

    //Function to add record into table
    function add()
    {
        $query = "INSERT INTO `%s` (voter_id, pdf_id, created_at) VALUES (%d, %d, NOW())";

        $query = sprintf($query, $this->getTableName(), $this->getVoterId(), $this->getPdfId());

        $this->runquery($query);

        $this->id = mysql_insert_id();

        return $this->getId();
    }

    function loadByVoterId($voterId)
    {
        $query = "SELECT * FROM `%s` WHERE voter_id = %d";
        $query = sprintf($query, $this->getTableName(), $voterId);

        $result = $this->runQuery($query);

        while($row = mysql_fetch_assoc($result)) {
            foreach ($row as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    //Function to delete record from table
    function delete($id)
    {
        $query = "DELETE FROM `%s`  WHERE id = %d";
        $query = sprintf($query, $this->getTableName(), $id);

        $this->runquery($query);
    }

    function loadReminders()
    {
        $reminders = array();

        $query = "SELECT * FROM `%s` WHERE created_at < DATE_SUB(NOW(), INTERVAL %s) AND notified = 0";
        $query = sprintf($query, $this->getTableName(), OURTIME_REMINDER_PERIOD);

        $result = $this->runQuery($query);

        while($row = mysql_fetch_assoc($result)) {
            $reminders[] = $row;
        }

        return $reminders;
    }
}
