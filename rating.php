<?php
class rating{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "tcm_books";    
	private $members_table = 'members';
	private $book_table = 'books';	
    private $book_rating_table = 'book_rating';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function get_data($sql_query)  {
		$result = mysqli_query($this->dbConnect, $sql_query);
		if(!$result){
			die('Error in query: '. mysqli_error($this->dbConnect));
		}
		$data= array();
		while ($row = $result->fetch_assoc()) {
			$data[]=$row;            
		}
		return $data;
	}
	private function get_num_rows($sql_query) {
		$result = mysqli_query($this->dbConnect, $sql_query);
		if(!$result){
			echo "error";
		}
		$num_rows = mysqli_num_rows($result);
		return $num_rows;
	}	
	public function user_login($user_token, $password){
		$sql_query = "
			SELECT * 
			FROM ".$this->members_table." 
			WHERE user_token='".$user_token."' AND pass='".$password."'";
        return  $this->get_data($sql_query);
	}		
	public function get_book_list(){
		$sql_query = "
			SELECT * FROM ".$this->book_table;
		return  $this->get_data($sql_query);	
	}
	public function get_book($book_id){
		$sql_query = "
			SELECT * FROM ".$this->book_table."
			WHERE book_id='".$book_id."'";
		return  $this->get_data($sql_query);	
	}
	public function get_book_rating($book_id){
		$sql_query = "
			SELECT r.book_rating_id, r.book_id,r.user_token, u.user, r.book_rating_number, r.title, r.comment, r.created, r.modified
			FROM ".$this->book_rating_table." as r
			LEFT JOIN ".$this->members_table." as u ON (r.user_token = u.user_token)
			WHERE r.book_id = '".$book_id."'";
		return  $this->get_data($sql_query);		
	}
	public function get_rating_average($book_id){
		$book_rating = $this->get_book_rating($book_id);
		$rating_number = 0;
		$count = 0;		
		foreach($book_rating as $book_rating_details){
			$rating_number+= $book_rating_details['book_rating_number'];
			$count += 1;			
		}
		$average = 0;
		if($rating_number && $count) {
			$average = $rating_number/$count;
		}
		return $average;	
	}
	public function save_rating($POST, $user_token){		
		$insert_rating = "INSERT INTO ".$this->book_rating_table." (book_id, user_token, book_rating_number, title, comment, created, modified) 
		VALUES ('".$POST['book_id']."', '".$user_token."', '".$POST['rating']."', '".$POST['title']."', '".$POST["comment"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
		mysqli_query($this->dbConnect, $insert_rating);	
	}
}
?>