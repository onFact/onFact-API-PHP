<?PHP
namespace onFact;

/**
 * Documentevents class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Documentevents {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a productgroup
     * 
     * @param Array $documentevent array('Documentevent' => array('document_id' => '123', ...)). see http://apidoc.onfact.be/#api-Documentevents-postDocumentevent
     **/
    function add($documentevent) {
        $result = $this->api->post('documentevents',$documentevent);
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
    function delete($id) {
        $result = $this->api->delete('documentevents/' . $id);
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