<?PHP
namespace onFact;

/**
 * Emails class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Emails {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a productgroup
     * 
     * @param Array $email array('Email' => array('to' => 'info@example.com', ...)). see http://apidoc.onfact.be/#api-Emails-postEmail
     **/
    function add($email) {
        $result = $this->api->post('emails',$email);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    } 
    
    /**
     * Get a productgroup with the specified ID
     * 
     **/
    function view($emailId) {
        $result = $this->api->get('emails/' . $emailId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['email'];
        }
    }
    
    function getErrors() {
        return $this->errors;
    }
    
}