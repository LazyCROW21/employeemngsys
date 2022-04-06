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
        $sql = "SELECT * FROM {$this->table}";
        return $this->conn->query($sql);
    }

    public function checkLogin($email, $pwd) { 
        $query = "SELECT Id, Name, DepartmentId, DesignationId  FROM {$this->table} WHERE Email = ? AND Pwd = ? AND DeletedAt IS NULL";
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
            $paramType .= $this->createdAt['type'];
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
};
