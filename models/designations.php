<?php
class DesgModel {
    public $conn;

    private $table = "designation";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'Name', 'type' => 's', 'required' => true ],
        [ 'name' => 'DepartmentId', 'type' => 'i', 'required' => true ],
    ];
    
    private $createdAt = [ 'name' => 'CreatedAt', 'type' => 's', 'required' => false ];
    private $updatedAt = [ 'name' => 'UpdatedAt', 'type' => 's', 'required' => false ];
    private $deletedAt = [ 'name' => 'DeletedAt', 'type' => 's', 'required' => false ];

    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT designation.Id, department.Name AS Department, designation.Name as Designation, designation.CreatedAt, designation.DeletedAt FROM `designation` JOIN department ON designation.DepartmentId = department.Id WHERE 1 ORDER BY `department`.`Name` ASC , `designation`.`Name` ASC";
        return $this->conn->query($sql);
    }

    public function findAllActive() {
        $sql = "SELECT DG.Id AS Id, DP.Name AS DepartmentName, DG.Name AS Name,";
        $sql .= " DG.CreatedAt AS CreatedAt, DG.DepartmentId AS DepartmentId";
        $sql .= " FROM {$this->table} DG";
        $sql .= " INNER JOIN department DP ON DG.DepartmentId = DP.Id";
        $sql .= " WHERE DG.{$this->deletedAt['name']} IS NULL";
        $sql .= " ORDER BY DP.Name ASC, DG.Name ASC";
        return $this->conn->query($sql);
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
                    array_push($insertData, NULL);
                }
            }
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
                array_push($insertData, $data[$column['name']]);
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
        array_push($insertData, trim($data['Id']));

        // $query = "UPDATE {$this->table} SET $columnList VALUES $params WHERE {$this->primaryKey['name']} = ?";
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

    public function getDesignationById($id) {
        $sql = $this->conn->prepare("SELECT designation.Id, department.Name AS Department, designation.Name as Designation, designation.CreatedAt, designation.DeletedAt FROM `designation` JOIN department ON designation.DepartmentId = department.Id WHERE designation.Id = ?");
        
        $sql->bind_param('i', $id);

        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $sql->close();

        return $row;

    }

    function removeById($id) {
        $currDate = Date('Y-m-d H:i:s');

        $query = "UPDATE {$this->table} SET {$this->deletedAt['name']} = '$currDate'";
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

    function removeByDept($id) {
        $currDate = Date('Y-m-d H:i:s');

        $query = "UPDATE {$this->table} SET {$this->deletedAt['name']} = '$currDate'";
        $query .= " WHERE DepartmentId = ?";

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

