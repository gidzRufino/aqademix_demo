<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class Install_model extends CI_Model {
    
    function insertDetails($dbCon,$details)
    {
        if($dbCon->insert('settings', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
       
    }
    function createTable($tablename, $query)
    {
        if(!$this->db->table_exists($tablename)):
            $this->db->query($query);
        endif;
    }
    
    // Function to the database and tables and fill them with the default data
    function create_database($username, $password, $database)
    {
            // Connect to the database
            $mysqli = new mysqli('localhost',$username,$password,'');

            // Check for errors
            if(mysqli_connect_errno())
                    return false;

            // Create the prepared statement
            $mysqli->query("CREATE DATABASE IF NOT EXISTS ".$database);

            // Close the connection
            $mysqli->close();

            return true;
    }

    // Function to create the tables and fill them with the default data
    function create_tables($username, $password, $database, $file)
    {
            // Connect to the database
            $mysqli = new mysqli('localhost',$username,$password,$database);

            // Check for errors
            if(mysqli_connect_errno())
                    return false;

            // Open the default SQL file
            $query = file_get_contents(APPPATH.'modules/install/tables/'.$file);

            // Execute a multi query
            $mysqli->multi_query($query);

            // Close the connection
            $mysqli->close();

            return true;
    }
    // Function to create the tables and fill them with the default data
    function createSPRTables($database, $file)
    {
            // Connect to the database
            $mysqli = new mysqli('localhost', $this->db->username, $this->db->password,$database);

            // Check for errors
            if(mysqli_connect_errno())
                    return false;

            // Open the default SQL file
            $query = file_get_contents(APPPATH.'modules/install/tables/'.$file);

            // Execute a multi query
            $mysqli->multi_query($query);

            // Close the connection
            $mysqli->close();

            return true;
    }
}
