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
            if(isset($data[$column['name']])) {
                array_push($insertData, $data[$column['name']]);
            } else {
                if($column['required']) {
                    return false;
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

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param($paramType, ...$insertData);

        $stmt->execute();
        $stmt->close();
    }
};
