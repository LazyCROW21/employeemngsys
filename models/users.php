<?php
class UserModel {
    public $conn;

    private $table = "user";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'Name', 'type' => 's', 'required' => true ],
        [ 'name' => 'Email', 'type' => 's', 'required' => true ],
        [ 'name' => 'Phone', 'type' => 's', 'required' => true ],
        [ 'name' => 'DateOfBirth', 'type' => 's', 'required' => true ],
        [ 'name' => 'Gender', 'type' => 's', 'required' => true ],
        [ 'name' => 'Address', 'type' => 's', 'required' => true ],
        [ 'name' => 'City', 'type' => 's', 'required' => true ],
        [ 'name' => 'State', 'type' => 's', 'required' => true ],
        [ 'name' => 'Basic', 'type' => 'd', 'required' => true ],
        [ 'name' => 'DateOfJoining', 'type' => 's', 'required' => true ],
        [ 'name' => 'DepartmentId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'DesignationId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'PAN', 'type' => 's', 'required' => true ],
        [ 'name' => 'BAN', 'type' => 's', 'required' => true ],
    ];
    
    private $createdBy = [ 'name' => 'CreatedBy', 'type' => 'i', 'required' => true ];
    private $createdAt = [ 'name' => 'CreatedAt', 'type' => 's', 'required' => false ];
    private $updatedAt = [ 'name' => 'UpdatedAt', 'type' => 's', 'required' => false ];
    private $deletedAt = [ 'name' => 'DeletedAt', 'type' => 's', 'required' => false ];

    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT ";
        $sql .= "U.Id AS Id, U.Name AS Name, U.Email AS Email, U.Phone AS Phone, U.DateOfBirth AS DateOfBirth,";
        $sql .= " U.Gender AS Gender, U.Address AS Address, U.City AS City, U.State AS State, U.Basic AS Basic,";
        $sql .= " U.DateOfJoining AS DateOfJoining, U.DepartmentId AS DepartmentId, U.DesignationId AS DesignationId,";
        $sql .= " U.PAN AS PAN, U.BAN AS BAN, U.CreatedBy AS CreatedBy, U.CreatedAt AS CreatedAt, U.DeletedAt AS DeletedAt,";
        $sql .= " DP.Name AS DepartmentName, DG.Name AS DesignationName";
        $sql .= " FROM {$this->table} U";
        $sql .= " INNER JOIN department DP ON DP.Id = U.DepartmentId";
        $sql .= " INNER JOIN designation DG ON DG.Id = U.DesignationId";
        return $this->conn->query($sql);
    }

    public function findAllActive() {
        $sql = "SELECT";
        $sql .= " U.Id AS Id, U.Name AS Name, U.Email AS Email, U.Phone AS Phone, U.DateOfBirth AS DateOfBirth,";
        $sql .= " U.Gender AS Gender, U.Address AS Address, U.City AS City, U.State AS State, U.Basic AS Basic,";
        $sql .= " U.DateOfJoining AS DateOfJoining, U.DepartmentId AS DepartmentId, U.DesignationId AS DesignationId,";
        $sql .= " U.PAN AS PAN, U.BAN AS BAN, U.CreatedBy AS CreatedBy, U.CreatedAt AS CreatedAt, U.DeletedAt AS DeletedAt,";
        $sql .= " DP.Name AS DepartmentName, DG.Name AS DesignationName";
        $sql .= " FROM {$this->table} U";
        $sql .= " INNER JOIN department DP ON DP.Id = U.DepartmentId";
        $sql .= " INNER JOIN designation DG ON DG.Id = U.DesignationId";
        $sql .= " WHERE U.{$this->deletedAt['name']} IS NULL";
        return $this->conn->query($sql);
    }

    public function checkLogin($email, $pwd) { 
        $query = 
        "SELECT U.Id AS Id, U.Name AS Name, U.DepartmentId AS DepartmentId, U.DesignationId AS DesignationId, DESG.Name As Designation, DEPT.Name AS Department 
        FROM {$this->table} U 
        INNER JOIN designation DESG ON DESG.Id = U.DesignationId 
        INNER JOIN department DEPT ON DEPT.Id = U.DepartmentId 
        WHERE U.Email = ? AND U.Pwd = ? AND U.DeletedAt IS NULL";
        $data = false;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $email, $pwd);
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

    public function findById($id) { 
        $query = 
        "SELECT U.Id AS Id, U.Name AS Name, U.DepartmentId AS DepartmentId, U.DesignationId AS DesignationId, DESG.Name As Designation, U.Address AS Address, U.Gender AS Gender, U.DateOfBirth AS DateOfBirth, U.City AS City, DEPT.Name AS Department, U.Basic AS Basic, U.PAN AS PAN, U.BAN AS BAN, U.State AS State, U.Phone AS Phone, U.DateOfJoining AS DateOfJoining, U.Email AS Email 
        FROM {$this->table} U 
        INNER JOIN designation DESG ON DESG.Id = U.DesignationId 
        INNER JOIN department DEPT ON DEPT.Id = U.DepartmentId 
        WHERE U.Id = ? AND U.DeletedAt IS NULL";
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
            array_push($insertData, $data[$this->createdBy['name']]);
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
};
