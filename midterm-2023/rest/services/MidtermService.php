<?php
require_once __DIR__."/../dao/MidtermDao.php";

class MidtermService {
    protected $dao;

    public function __construct(){
        $this->dao = new MidtermDao();
    }

    /** TODO
    * Implement service method to return detailed cap-table
    */
    public function cap_table() {
        $rawData = $this->dao->cap_table();
        $output = [];
    
        foreach ($rawData as $row) {
            $class_id = $row['class_id'];
            $category_id = $row['category_id'];
            $investor_id = $row['investor_id'];
            $shares = $row['shares'];
    
            $class = $this->dao->get_share_class($class_id);
            $category = $this->dao->get_share_category($category_id);
            $investor = $this->dao->get_investor($investor_id);
    
            $investor_name = $investor['first_name'] . ' ' . $investor['last_name'];
    
            $output[$class_id]['class'] = $class['description'];
            $output[$class_id]['categories'][$category_id]['category'] = $category['description'];
            $output[$class_id]['categories'][$category_id]['investors'][$investor_id]['investor'] = $investor_name;
            $output[$class_id]['categories'][$category_id]['investors'][$investor_id]['shares'] = $shares;
        }
            $output = array_values($output);
        foreach ($output as &$class) {
            $class['categories'] = array_values($class['categories']);
            foreach ($class['categories'] as &$category) {
                $category['investors'] = array_values($category['investors']);
            }
        }
    
        return $output;
    }
    
    /** TODO
    * Implement service method to return cap-table summary
    */
    public function summary(){
        return $this->dao->summary();
    }

    /** TODO
    * Implement service method to return list of investors with their total shares amount
    */
    public function investors(){
        return $this->dao->investors();
    }
}
?>
