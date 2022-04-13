<?php
class ProjectEmpModel {
    public $conn;

    private $table = "project_emp";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'ProjectId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'UserId', 'type' => 'i', 'required' => true ],
    ];
    
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

    public function findTeam($projectId) {
        $query = "SELECT PR.UserId AS UserId, U.Name AS UserName, DP.Name AS Department, DG.Name AS Designation";
        $query .= " FROM {$this->table} PR";
        $query .= " INNER JOIN user U ON U.Id = PR.UserId";
        $query .= " INNER JOIN department DP ON DP.Id = U.DepartmentId";
        $query .= " INNER JOIN designation DG ON DG.Id = U.DesignationId";
        $query .= " WHERE ProjectId = ?";
        $data = false;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $projectId);
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

    public function insertByUserIdAndProjectId($userIds, $projectId) {
        $query = "INSERT INTO {$this->table} (ProjectId, UserId, CreatedAt) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $d = Date('Y-m-d');

        foreach ($userIds as $user) {
            $stmt->bind_param('iis', $projectId, $user, $d);
            $stmt->execute();
        }
        $stmt->close();

        return 'success';
    }
};
