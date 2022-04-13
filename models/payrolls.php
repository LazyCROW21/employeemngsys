<?php
class PRModel {
    public $conn;

    private $table = "payroll";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'UserId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'UserName', 'type' => 's', 'required' => true ],
        [ 'name' => 'Email', 'type' => 's', 'required' => true ],
        [ 'name' => 'Phone', 'type' => 's', 'required' => true ],
        [ 'name' => 'Department', 'type' => 's', 'required' => true ],
        [ 'name' => 'Designation', 'type' => 's', 'required' => true ],
        [ 'name' => 'PAN', 'type' => 's', 'required' => true ],
        [ 'name' => 'BAN', 'type' => 's', 'required' => true ],
        [ 'name' => 'Basic', 'type' => 'd', 'required' => true ],
        [ 'name' => 'HRA', 'type' => 'd', 'required' => true ],
        [ 'name' => 'DA', 'type' => 'd', 'required' => true ],
        [ 'name' => 'TA', 'type' => 'd', 'required' => true ],
        [ 'name' => 'IncomeTax', 'type' => 'd', 'required' => true ],
        [ 'name' => 'ProfessionalTax', 'type' => 'd', 'required' => true ],
        [ 'name' => 'PF', 'type' => 'd', 'required' => true ],
        [ 'name' => 'Overtime', 'type' => 'd', 'required' => true ],
        [ 'name' => 'Bonus', 'type' => 'd', 'required' => true ],
        [ 'name' => 'MA', 'type' => 'd', 'required' => true ],
        [ 'name' => 'ESI', 'type' => 'd', 'required' => true ],
        [ 'name' => 'Month', 'type' => 'i', 'required' => true ],
        [ 'name' => 'Year', 'type' => 'i', 'required' => true ],
    ];
    
    private $grantedBy = [ 'name' => 'GrantedBy', 'type' => 'i', 'required' => true ];
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

    public function findByUserId($id) {
        $query = "SELECT * FROM {$this->table} WHERE UserId = ?";
        $data = false;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $data = $result;
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
        
        if($this->grantedBy) {
            $columnList .= $this->grantedBy['name'].',';
            $params .= '?,';
            $paramType .= $this->grantedBy['type'];
            array_push($insertData, $data[$this->grantedBy['name']]);
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
