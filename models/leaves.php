<?php
class LeaveModel {
    public $conn;

    private $table = "leaves";
    private $primaryKey = [ 'name' => 'Id', 'type' => 'i', 'required' => true ];
    private $columns = [
        [ 'name' => 'UserId', 'type' => 'i', 'required' => true ],
        [ 'name' => 'StartedAt', 'type' => 's', 'required' => true ],
        [ 'name' => 'StartHalf', 'type' => 's', 'required' => true ],
        [ 'name' => 'EndedAt', 'type' => 's', 'required' => true ],
        [ 'name' => 'EndHalf', 'type' => 's', 'required' => true ],
        [ 'name' => 'LeaveType', 'type' => 's', 'required' => true ],
        [ 'name' => 'EffectOnPay', 'type' => 's', 'required' => true ],
        [ 'name' => 'Reason', 'type' => 's', 'required' => true ],
        [ 'name' => 'Status', 'type' => 's', 'required' => true ]
    ];
    
    private $respondedBy = [ 'name' => 'RespondedBy', 'type' => 'i', 'required' => false ];
    private $respondedAt = [ 'name' => 'RespondedAt', 'type' => 's', 'required' => false ];
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

    public function findPendingLeaves() {
        $sql = "SELECT L.Id AS Id, L.UserId AS UserId, L.StartedAt AS StartedAt, L.StartHalf AS StartHalf, L.EndedAt AS EndedAt, L.EndHalf AS EndHalf, L.LeaveType AS LeaveType, L.EffectOnPay AS EffectOnPay, L.Reason AS Reason, L.Status AS Status, L.CreatedAt AS CreatedAt, U.Name AS UserName, U.Id as UserId FROM {$this->table} L JOIN user U ON U.Id = L.UserId WHERE Status = 'Pending'";
        return $this->conn->query($sql);
    }

    public function findPastLeaves() {
        $sql = "SELECT leaves.Id, leaves.StartedAt, leaves.EndedAt, leaves.LeaveType, leaves.EffectOnPay, leaves.Reason, leaves.Status, leaves.RespondedBy, leaves.RespondedAt, leaves.CreatedAt, user.Name FROM {$this->table} JOIN user ON user.Id = leaves.UserId WHERE Status != 'Pending'";
        // $sql = "SELECT * FROM {$this->table} WHERE Status != 'Pending'";
        return $this->conn->query($sql);
    }

    public function findPastLeavesByUserId($userId) {
        $sql = "SELECT L.Id AS Id, L.StartedAt AS StartedAt, L.StartHalf AS StartHalf, L.EndHalf AS EndHalf, L.EndedAt AS EndedAt, L.LeaveType AS LeaveType, L.EffectOnPay AS EffectOnPay, L.Reason AS Reason, L.Status AS Status, L.RespondedBy AS RespondedBy, L.RespondedAt AS RespondedAt, L.CreatedAt AS CreatedAt, U.Name AS RespondedByName FROM {$this->table} L JOIN user U ON U.Id = L.RespondedBy";
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

    public function reviewLeave($data, $operation) {
        $curDT = Date('Y-m-d');
        $query = "UPDATE {$this->table} SET RespondedBy = ?, RespondedAt = '$curDT', Status = '$operation', UpdatedAt = '$curDT' WHERE {$this->primaryKey['name']} = ?";
        $result = true;
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ii', $data['RespondedBy'], $data['Id']);
            $result = $stmt->execute();
        } catch (Exception $e)  {
            if($this->conn->errno == 1062) {
                return 'duplicate';
            }
            return false;
        }
        $stmt->close();
        if(!$result) {
            return false;
        }
        return true;
    }
};
