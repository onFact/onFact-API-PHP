<?PHP
namespace onFact;

/**
 * Customers class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Customers {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a customer
     * 
     * @param Array $customer array('Contact' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Contacts-postContact
     **/
    function add($customer) {
        $result = $this->api->post('contacts',$customer);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    }
    
    /**
     * Get a customer or contact with the specified ID
     * 
     **/
    function index() {
        $result = $this->api->get('contacts');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['contacts'];
        }
    }
    
    /**
     * Get a customer or contact with the specified ID
     * 
     **/
    function view($customerId) {
        $result = $this->api->get('contacts/' . $customerId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['contact'];
        }
    }
    
    
    /**
     * Updates an existing customer
     * 
     * @param String    $customerId Id of the customer that needs to be updated with the new customer data
     * @param Array     $customer   array('Contact' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Contacts-postContact
     **/
    function update($customerId, $customer) {
        $result = $this->api->put('contacts/' . $customerId, $customer); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function delete($customerId) {
        $result = $this->api->delete('contacts/' . $customerId); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function getErrors() {
        return $this->errors;
    }
    
}