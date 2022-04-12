<?php
require_once 'projectEmp.php';

class ProjectModel {
    public $conn;

    private $table = "project";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'Title', 'type' => 's', 'required' => true ],
        [ 'name' => 'ClientId', 'type' => 'i', 'required' => false ],
        [ 'name' => 'LeadId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'Description', 'type' => 's', 'required' => true ],
        [ 'name' => 'Earning', 'type' => 'd', 'required' => false ],
        [ 'name' => 'Deadline', 'type' => 's', 'required' => false ],
        [ 'name' => 'StartedAt', 'type' => 's', 'required' => true ],
        [ 'name' => 'Completed', 'type' => 'i', 'required' => true ],
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
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($paramType, ...$insertData);
        $stmt->execute();
        $projectId = $stmt->insert_id;;
        $stmt->close();

        if (sizeof($_POST['Team']) > 0) {
            $project_emp_table = new ProjectEmpModel($this->conn);            
            $emp_add = $project_emp_table->insertByUserIdAndProjectId($_POST['Team'], $projectId);
        }


        if(!$result) {
            return 'error';
        }
        return 'success';
    }

    public function markComplete($id) {
        $query = "UPDATE {$this->table} SET Completed = 1 WHERE {$this->primaryKey['name']} = ?";
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
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

    public function markDropped($id) {
        $currDate = Date('Y-m-d H:i:s');
        $query = "UPDATE {$this->table} SET {$this->deletedAt['name']} = '$currDate' WHERE {$this->primaryKey['name']} = ?";
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id);
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
