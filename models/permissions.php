<?php
class PermissionModel {
    public $conn;

    private $table = "permissions";
    private $primaryKey = [ 'name' => 'UserId', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'Department', 'type' => 's', 'required' => true ],
        [ 'name' => 'Designation', 'type' => 's', 'required' => true ],
        [ 'name' => 'User', 'type' => 's', 'required' => true ],
        [ 'name' => 'Payroll', 'type' => 's', 'required' => true ],
        [ 'name' => 'Project', 'type' => 's', 'required' => true ],
        [ 'name' => 'Leaves', 'type' => 's', 'required' => true ],
        [ 'name' => 'Client', 'type' => 's', 'required' => true ],
        [ 'name' => 'Admin', 'type' => 's', 'required' => true ],
    ];
    
    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT P.UserId AS UserId, U.Name AS Name, D.Name AS DepartmentName, DESG.Name AS DesignationName, P.Department AS Department, P.Designation AS Designation, P.User AS User, P.Payroll AS Payroll, P.Project AS Project, P.Leaves AS Leaves, P.Client AS Client, Admin FROM {$this->table} P INNER JOIN User U ON U.Id = P.UserId INNER JOIN Department D ON D.Id = U.DepartmentId INNER JOIN Designation DESG ON DESG.Id = U.DesignationId";
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
        
        $columnList .= $this->primaryKey['name'].',';
        $params .= '?,';
        $paramType .= $this->primaryKey['type'];
        array_push($insertData, $data[$this->primaryKey['name']]);
        
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
