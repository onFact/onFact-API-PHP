<?PHP
namespace onFact;

/**
 * ContactPeople class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class ContactPeople {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a customer
     * 
     * @param Array $contact_person array('ContactPerson' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Contacts-postContact
     **/
    function add($contact_person) {
        $result = $this->api->post('contact_people',$contact_person);
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
        $result = $this->api->get('contact_people');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['contact_people'];
        }
    }
    
    /**
     * Get a customer or contact with the specified ID
     * 
     **/
    function view($contact_personId) {
        $result = $this->api->get('contact_people/' . $contact_personId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['contact_person'];
        }
    }
    
    
    /**
     * Updates an existing customer
     * 
     * @param String    $contact_personId Id of the customer that needs to be updated with the new customer data
     * @param Array     $contact_person   array('Contact' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Contacts-postContact
     **/
    function update($contact_personId, $contact_person) {
        $result = $this->api->put('contact_people/' . $contact_personId, $contact_person); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function delete($contact_personId) {
        $result = $this->api->delete('contact_people/' . $contact_personId); 
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