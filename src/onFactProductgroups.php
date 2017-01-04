<?PHP
namespace onFact;

/**
 * Productgroups class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Productgroups {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a productgroup
     * 
     * @param Array $productgroup array('Productgroup' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Productgroups-postProductgroup
     **/
    function add($productgroup) {
        $result = $this->api->post('productgroups',$productgroup);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    }
    
    /**
     * Get a list of productgroups
     * 
     **/
    function index() {
        $result = $this->api->get('productgroups');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['productgroups'];
        }
    }
    
    /**
     * Get a productgroup with the specified ID
     * 
     **/
    function view($productgroupId) {
        $result = $this->api->get('productgroups/' . $productgroupId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['productgroup'];
        }
    }
    
    
    /**
     * Updates an existing productgroup
     * 
     * @param String    $productgroupId Id of the productgroup that needs to be updated with the new productgroup data
     * @param Array     $productgroup   array('Productgroup' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Productgroups-postProductgroup
     **/
    function update($productgroupId, $productgroup) {
        $result = $this->api->put('productgroups/' . $productgroupId, $productgroup); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function delete($productgroupId) {
        $result = $this->api->delete('productgroups/' . $productgroupId); 
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