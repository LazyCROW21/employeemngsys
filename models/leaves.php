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
        [ 'name' => 'EndedHalf', 'type' => 's', 'required' => true ],
        [ 'name' => 'LeaveType', 'type' => 's', 'required' => true ],
        [ 'name' => 'EffectOnPay', 'type' => 's', 'required' => true ],
        [ 'name' => 'Reason', 'type' => 's', 'required' => true ],
    ];
    
    private $status = [ 'name' => 'Status', 'type' => 's', 'required' => true ];
    private $respondedBy = [ 'name' => 'RespondedBy', 'type' => 'i', 'required' => true ];
    private $respondedAt = [ 'name' => 'RespondedAt', 'type' => 's', 'required' => true ];
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
        $sql = "SELECT * FROM {$this->table} WHERE {$this->status['name']} = 'Pending'";
        return $this->conn->query($sql);
    }

    public function findPastLeaves() {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->status['name']} != 'Pending'";
        return $this->conn->query($sql);
    }
};
