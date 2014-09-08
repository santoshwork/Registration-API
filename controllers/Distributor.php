<?php
class Distributor
{
	private $_params;
	
	public function __construct($params)
	{
		$this->_params = $params;
	}
	
	public function createAction()
	{
		//create a new Distributor Company
		$dist = new Company();
		$dist->company_name = $this->_params['company_name'];
		$dist->user_type = $this->_params['user_type'];
		$dist->department = $this->_params['department'];
		$dist->first_name = $this->_params['first_name'];
		$dist->last_name = $this->_params['last_name'];
		$dist->phone_1 = $this->_params['phone_1'];
		$dist->phone_2 = $this->_params['phone_2'];
		$dist->location_name = $this->_params['location_name'];
		$dist->address_1 = $this->_params['address_1'];
		$dist->address_2 = $this->_params['address_2'];
		$dist->city = $this->_params['city'];
		$dist->state = $this->_params['state'];
		$dist->postal_code = $this->_params['postal_code'];
		$dist->country = $this->_params['country'];
		$dist->is_done = 'false';
		
		//pass the user's email as username and password to authenticate the user
		$dist->save($this->_params['email'], $this->_params['password']);
		
		//return the Distributor Company in array format
		return $dist->toArray();
	}
	
	public function readAction()
	{
		//read all the Distributor Company while passing the user's email as username and password to authenticate
		$dist_company = Company::getAllItems($this->_params['email'], $this->_params['password']);
		
		//return the list
		return $dist_company;
	}
	
	public function updateAction()
	{
		//update a Distributor
		//retrieve Distributor first
		$dist = Company::getItem($this->_params['dist_id'], $this->_params['email'], $this->_params['password']);
		
		//update the Distributor
		$dist = new Distributor();
		$dist->company_name = $this->_params['company_name'];
		$dist->user_type = $this->_params['user_type'];
		$dist->department = $this->_params['department'];
		$dist->first_name = $this->_params['first_name'];
		$dist->last_name = $this->_params['last_name'];
		$dist->phone_1 = $this->_params['phone_1'];
		$dist->phone_2 = $this->_params['phone_2'];
		$dist->location_name = $this->_params['location_name'];
		$dist->address_1 = $this->_params['address_1'];
		$dist->address_2 = $this->_params['address_2'];
		$dist->city = $this->_params['city'];
		$dist->state = $this->_params['state'];
		$dist->postal_code = $this->_params['postal_code'];
		$dist->country = $this->_params['country'];
		$dist->is_done = $this->_params['is_done'];
		
		//pass the user's username and password to authenticate the user
		$dist->save($this->_params['email'], $this->_params['password']);
		
		//return the newly updated Distributor
		//in array format
		return $dist->toArray();
	}
	
	public function deleteAction()
	{
		//delete a Distributor
		//retrieve the Distributor
		$dist = Company::getItem($this->_params['dist_id'], $this->_params['email'], $this->_params['password']);
		
		//delete the Distributor while passing the username and password to authenticate
		$dist->delete($this->_params['email'], $this->_params['password']);
		
		//return the deleted Distributor
		//in array format, for display purposes
		return $dist->toArray();
	}
}