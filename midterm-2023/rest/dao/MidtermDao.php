<?php


class MidtermDao {

    private $conn;

    public function __construct(){
      try {

      $host = "db-mysql-nyc1-51552-do-user-3246313-0.b.db.ondigitalocean.com";
      $dbname = "midterm-2023";
      $port = 25060;
      $user = "doadmin";
      $pass = "AVNS_sQwKZryHF62wtg6XNoi";

      $options = array(
        PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1g3sZDXiWK8HcPuRhS0nNeoUlOVSWdMAg/view?usp=share_link',
          PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
      );

      $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;", $user, $pass, $options);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
  }

  

    /** TODO
     * 
    * Implement DAO method used to get cap table
    */
    public function cap_table() {
      try {
          $sql = "SELECT * FROM cap_table";
          $statement = $this->conn->prepare($sql);
          $statement->execute();

          $result = $statement->fetchAll(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }


    /** TODO
    * Implement DAO method used to get summary
    */
    public function summary() {
      try {
          $sql = "SELECT COUNT(DISTINCT investor_id) as total_investors, SUM(diluted_shares) as total_diluted_shares FROM cap_table";
          $statement = $this->conn->prepare($sql);
          $statement->execute();

          $result = $statement->fetch(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }

    /** TODO
    * Implement DAO method to return list of investors with their total shares amount
    */
    public function investors() {
      try {
          $sql = "SELECT i.id, CONCAT(i.first_name, ' ', i.last_name) as investor, SUM(ct.diluted_shares) as total_diluted_shares
                  FROM cap_table ct
                  JOIN investors i ON ct.investor_id = i.id
                  GROUP BY i.id
                  ORDER BY i.id";
          $statement = $this->conn->prepare($sql);
          $statement->execute();

          $result = $statement->fetchAll(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }

    public function get_share_class($classId) {
      try {
          $sql = "SELECT * FROM share_classes WHERE id = :class_id";
          $statement = $this->conn->prepare($sql);
          $statement->bindParam(':class_id', $classId);
          $statement->execute();

          $result = $statement->fetch(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }

  public function get_share_category($categoryId) {
      try {
          $sql = "SELECT * FROM share_class_categories WHERE id = :category_id";
          $statement = $this->conn->prepare($sql);
          $statement->bindParam(':category_id', $categoryId);
          $statement->execute();

          $result = $statement->fetch(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }

  public function get_investor($investorId) {
      try {
          $sql = "SELECT * FROM investors WHERE id = :investor_id";
          $statement = $this->conn->prepare($sql);
          $statement->bindParam(':investor_id', $investorId);
          $statement->execute();

          $result = $statement->fetch(PDO::FETCH_ASSOC);

          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }

      return [];
  }
}
?>