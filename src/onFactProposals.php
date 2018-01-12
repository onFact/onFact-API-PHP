<?PHP
namespace onFact;

/**
 * Proposals class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Proposals {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a proposal
     * 
     * @param Array $proposal array('Proposal' => array('customer_name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Proposals-postProposal
     **/
    function add($proposal) {
        $result = $this->api->post('proposals',$proposal); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    }
    
    /**
     * Get a proposal or proposal with the specified ID
     * 
     **/
    function index() {
        $result = $this->api->get('proposals');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['proposals'];
        }
    }
    
    /**
     * Get a proposal or proposal with the specified ID
     * 
     **/
    function view($proposalId) {
        $result = $this->api->get('proposals/' . $proposalId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['proposal'];
        }
    }
    
    
    /**
     * Updates an existing proposal
     * 
     * @param String    $proposalId Id of the proposal that needs to be updated with the new proposal data
     * @param Array     $proposal   array('Proposal' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Proposals-postProposal
     **/
    function update($proposalId, $proposal) {
        $result = $this->api->put('proposals/' . $proposalId, $proposal); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function delete($proposalId) {
        $result = $this->api->delete('proposals/' . $proposalId); 
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