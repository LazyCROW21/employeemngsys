<?php
class ClientModel {
    public $conn;

    private $table = "client";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'Name', 'type' => 's', 'required' => true ],
        [ 'name' => 'Email', 'type' => 's', 'required' => true ],
        [ 'name' => 'Phone', 'type' => 's', 'required' => true ],
        [ 'name' => 'Address', 'type' => 's', 'required' => true ],
        [ 'name' => 'City', 'type' => 's', 'required' => true ],
        [ 'name' => 'State', 'type' => 's', 'required' => true ],
        [ 'name' => 'Country', 'type' => 's', 'required' => true ]
    ];
    
    private $createdBy = [ 'name' => 'CreatedBy', 'type' => 'i', 'required' => false ];
    private $createdAt = [ 'name' => 'CreatedAt', 'type' => 's', 'required' => false ];
    private $updatedAt = [ 'name' => 'UpdatedAt', 'type' => 's', 'required' => false ];
    private $deletedAt = [ 'name' => 'DeletedAt', 'type' => 's', 'required' => false ];

    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT C.Id AS Id, C.Name AS Name, C.Email AS Email, C.Phone AS Phone, C.Address AS Address, C.City AS City, C.State AS State, C.Country AS Country, C.CreatedBy AS CreatedBy, C.CreatedAt AS CreatedAt, C.DeletedAt AS DeletedAt, IFNULL(P.NoOfProjects, 0) AS NoOfProjects FROM {$this->table} C LEFT JOIN (SELECT ClientId, COUNT(Id) AS NoOfProjects FROM project GROUP BY ClientId) P ON P.ClientId = C.Id;";
        return $this->conn->query($sql);
    }

    public function findAllActive() {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->deletedAt['name']} IS NOT NULL";
        return $this->conn->query($sql);
    }

    public function findById($id) {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey['name']} = ?";
        $data = false;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if($result->num_rows == 1) {
                $data = $result->fetch_assoc();
            }
        } catch (Exception $e)  {
            $data = false;
        }
        return $data;
    }

    public function insert($data)
    {
        $columnList = '(';
        $params = '(';
        $paramType = '';
        $insertData = array();
        foreach($this->columns as $column) {
            $columnList .= $column['name'].',';
            $params .= '?,';
            $paramType .= $column['type'];
            if(isset($data[$column['name']]) && $data[$column['name']] !== '') {
                array_push($insertData, $data[$column['name']]);
            } else {
                if($column['required']) {
                    return 'invalid';
                } else {
                    array_push($insertData, null);
                }
            }
        }

        if($this->createdBy) {
            $columnList .= $this->createdBy['name'].',';
            $params .= '?,';
            $paramType .= $this->createdBy['type'];
            array_push($insertData, 1);
        }
        if($this->createdAt) {
            $columnList .= $this->createdAt['name'].',';
            $params .= '?,';
            $paramType .= $this->createdAt['type'];
            array_push($insertData, Date('Y-m-d'));
        }
        if($this->updatedAt) {
            $columnList .= $this->updatedAt['name'].',';
            $params .= '?,';
            $paramType .= $this->updatedAt['type'];
            array_push($insertData, null);
        }
        if($this->deletedAt) {
            $columnList .= $this->deletedAt['name'].',';
            $params .= '?,';
            $paramType .= $this->deletedAt['type'];
            array_push($insertData, null);
        }
        
        $columnList[strlen($columnList)-1] = ')';
        $params[strlen($params)-1] = ')';
        $query = "INSERT INTO {$this->table} $columnList VALUES $params";
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($paramType, ...$insertData);
            $result = $stmt->execute();
        } catch (Exception $e)  {
            if($this->conn->errno == 1062) {
                return 'duplicate';
            }
            return 'error';
        }
        $stmt->close();
        if(!$result) {
            return 'error';
        }
        return 'success';
    }

    public function update($data)
    {
        $columnNames = "";
        $paramType = "";
        $insertData = array();
        foreach($this->columns as $column) {
            $columnNames .= " ".$column['name']." = ?,";
            $paramType .= $column['type'];
            if(isset($data[$column['name']]) && trim($data[$column['name']]) !== '') {
                array_push($insertData, trim($data[$column['name']]));
            } else {
                if($column['required']) {
                    return 'invalid';
                } else {
                    array_push($insertData, NULL);
                }
            }
        }
        if($this->updatedAt) {
            $columnNames .= " ".$this->updatedAt['name']." = ? ";
            $paramType .= $this->updatedAt['type'];
            array_push($insertData, Date('Y-m-d'));
        }

        $paramType .= $this->primaryKey['type'];
        array_push($insertData, trim($data[$this->primaryKey['name']]));

        $query = "UPDATE {$this->table} SET ";
        $query .= $columnNames;
        $query .= " WHERE {$this->primaryKey['name']} = ?";
        
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($paramType, ...$insertData);
            $result = $stmt->execute();
        } catch (Exception $e)  {
            if($this->conn->errno == 1062) {
                return 'duplicate';
            }
            return 'error';
        }
        $stmt->close();
        if(!$result) {
            return 'error';
        }
        return 'success';
    }

    function removeById($id) {
        $query = "DELETE FROM {$this->table} ";
        $query .= " WHERE {$this->primaryKey['name']} = ?";
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
            $result = $stmt->execute();
        } catch (Exception $e)  {
            return 'error';
        }
        $stmt->close();
        if(!$result) {
            return 'error';
        }
        return 'deleted';
    }
};
