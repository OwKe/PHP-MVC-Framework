<?php

/**
 * PDO Database Class
 *
 * Connect to DB
 * Create prepared statements
 * Bind values
 * Execute the prepared statement
 * Return rows and results
 *
 */

class Database {

    /**
     * @vars string DB Connection
     */
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    /**
     * @var PDO DB handler
     */
    private $dbh;
    /**
     * @var string SQL Statement
     */
    private $stmt;
    /**
     * @var string PDOException error message
     */
    private $error;

    /**
     * Connect to the DB.
     * Connections are established by creating instances of the PDO base class.
     *
     *  - Set the $dsn (Data Source Name) e.g. 'mysql:host=DB_HOST;dbname=DB_NAME'
     *  - Create options for the PFO DB connection array
     *  - Try and create new PDO instance assigned to $dbh (DB handler)
     *  - Catch and store any exceptions to $error
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true, // Increase performance by checking for existing connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // More elegant way to handle errors
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }

        catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Connection failed: ' . $e->getMessage();
        }

    }

    /**
     * Create prepared statements
     *
     * By using prepared statements we are eliminating the possibility of SQL injection attacks.
     * Prepared statements work by separating the SQL statement from any variables that are passed in.
     *
     *  - First we send the statement with the prepare() function, supplying any variables as a placeholder/parameter.
     *  - Secondly we bind any variables needed in the query to the placeholder/parameters to be sent later with the bindValue() function.
     *  - Lastly we execute the statement with the execute() function, which combines the above and runs the query.
     *
     * @param string $sql SQL query to run e.g. ("SELECT * FROM tbl_name WHERE column =:var_name")
     */
    public function query($sql) {

        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind Values
     *
     * If the $type value is null then use the switch conditional to check and set what the value actually is.
     *
     * @param string $param variable placeholder name e.g. ":email"
     * @param string $value value to bind to the corresponding $param placeholder
     * @param stdClass $type Type of value expressed as e.g. PDO::PARAM_INT
     */
    public function bind($param, $value, $type = null)
    {
        if(is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }


    /**
     * Execute the prepared statement ($stmt)
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function execute() {
        return $this->stmt->execute();
    }


    /**
     * @return array All of the result set rows as objects
     */
    public function get() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return object The Fetched single next row from a result set
     */
    public function first() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @return int The number of rows affected by the last SQL statement
     */
    public function count() {
        return $this->stmt->rowCount();
    }


    /**
     * Example method showing how the above can be used in a Model.
     *
     * @param array $data Some Array of user input
     * @return bool
     */
    public function register($data){

        // Create the query with placeholders for variables
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
        // Bind variable values to the placeholders
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if($this->db->execute()){
            //  return true;
        } else {
            //  return false;
        }

        // Return User with corresponding email address
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $data['email']);
        $row = $this->db->first();

        if($this->db->count() > 0){
            return true;
        } else {
            return false;
        }

    }


}