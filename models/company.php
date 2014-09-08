<?php
class Company
{
	public $dist_id;
	public $company_name;
	public $user_type;
	public $department;
	public $first_name;
	public $last_name;
	public $phone_1;
	public $phone_2;
	public $location_name;
	public $address_1;
	public $address_2;
	public $city;
	public $state;
	public $postal_code;
	public $country;
	public $is_done;		
	public static function getAllItems($username, $userpass)
	{
		self::_checkIfUserExists($username, $userpass);
		$userhash = sha1("{$username}_{$userpass}");
		$dist_comp = array();
		foreach( new DirectoryIterator(DATA_PATH."/{$userhash}") as $file_info ) {
			if( $file_info->isFile() == true ) {
				$dist_comp_serialized = file_get_contents($file_info->getPathname());
				$dist_comp_array = unserialize($dist_comp_serialized);
				$dist_comp[] = $dist_comp_array;
			}
		}
		
		return $dist_comp;
	}
	
	public static function getItem($dist_id, $username, $userpass)
	{
		self::_checkIfUserExists($username, $userpass);
		$userhash = sha1("{$username}_{$userpass}");
		
		if( file_exists(DATA_PATH."/{$userhash}/{$dist_id}.txt") === false ) {
			throw new Exception('Distributor id is invalid');
		}
		
		$dist_comp_serialized = file_get_contents(DATA_PATH."/{$userhash}/{$dist_id}.txt");
		$dist_comp_array = unserialize($dist_comp_serialized);
		
		$dist_record = new Company();
		$dist_record->company_name = $dist_comp_array['company_name'];
		$dist_record->user_type = $dist_comp_array['user_type'];
		$dist_record->department = $dist_comp_array['department'];
		$dist_record->first_name = $dist_comp_array['first_name'];
		$dist_record->last_name = $dist_comp_array['last_name'];
		$dist_record->phone_1 = $dist_comp_array['phone_1'];
		$dist_record->phone_2 = $dist_comp_array['phone_2'];
		$dist_record->location_name = $dist_comp_array['location_name'];
		$dist_record->address_1 = $dist_comp_array['address_1'];
		$dist_record->address_2 = $dist_comp_array['address_2'];
		$dist_record->city = $dist_comp_array['city'];
		$dist_record->state = $dist_comp_array['state'];
		$dist_record->postal_code = $dist_comp_array['postal_code'];
		$dist_record->country = $dist_comp_array['country'];
		$dist_record->is_done = 'false';
		
		return $dist_record;
	}
	
	public function delete($username, $userpass)
	{
		self::_checkIfUserExists($username, $userpass);
		$userhash = sha1("{$username}_{$userpass}");
		
		if( file_exists(DATA_PATH."/{$userhash}/{$this->dist_id}.txt") === false ) {
			throw new Exception('Distributor ID does not exist!');
		}
		
		unlink(DATA_PATH."/{$userhash}/{$this->dist_id}.txt");
		return true;
	}
	
	public function save($username, $userpass)
	{
		$userhash = sha1("{$username}_{$userpass}");
		if( is_dir(DATA_PATH."/{$userhash}") === false ) {
			mkdir(DATA_PATH."/{$userhash}");
		}
		
		//if the $dist_id isn't set yet, it means we need to create a new Distributor id
		if( is_null($this->dist_id) || !is_numeric($this->dist_id) ) {
			//the Distributor id is the current time
			$this->dist_id = time();
		}
		
		//get the array version of this Distributor
		$dist_comp_array = $this->toArray();
		
		//save the serialized array version into a file
		$success = file_put_contents(DATA_PATH."/{$userhash}/{$this->dist_id}.txt", serialize($dist_comp_array));
		
		//if saving was not successful, throw an exception
		if( $success === false ) {
			throw new Exception('Failed to save  Distributor records');
		}
		
		//return the array version
		return $dist_comp_array;
	}
	
	public function toArray()
	{
		//return an array version of the Distributor
		return array(
			'company_name' => $this->company_name,
			'user_type' => $this->user_type,
			'department' => $this->department,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'phone_1' => $this->phone_1,
			'phone_2' => $this->phone_2,
			'location_name' => $this->location_name,
			'address_1' => $this->address_1,
			'address_2' => $this->address_2,
			'city' => $this->city,
			'state' => $this->state,
			'postal_code' => $this->postal_code,
			'country' => $this->country,
			'dist_id' => $this->dist_id,
			'is_done' => $this->is_done
		);
	}
	
	private static function _checkIfUserExists($username, $userpass)
	{
		$userhash = sha1("{$username}_{$userpass}");
		if( is_dir(DATA_PATH."/{$userhash}") === false ) {
			throw new Exception('Username  or Password is invalid');
		}
		return true;
	}
}