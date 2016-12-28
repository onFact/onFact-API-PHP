<?PHP
namespace onFact;

/**
 * Invoices class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Invoices {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates a invoice
     * 
     * @param Array $invoice array('Invoice' => array('customer_name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Invoices-postInvoice
     **/
    function add($invoice) {
        $result = $this->api->post('invoices',$invoice); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    }
    
    /**
     * Get a invoice or invoice with the specified ID
     * 
     **/
    function index() {
        $result = $this->api->get('invoices');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['invoices'];
        }
    }
    
    /**
     * Get a invoice or invoice with the specified ID
     * 
     **/
    function view($invoiceId) {
        $result = $this->api->get('invoices/' . $invoiceId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['invoice'];
        }
    }
    
    
    /**
     * Updates an existing invoice
     * 
     * @param String    $invoiceId Id of the invoice that needs to be updated with the new invoice data
     * @param Array     $invoice   array('Invoice' => array('name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Invoices-postInvoice
     **/
    function update($invoiceId, $invoice) {
        $result = $this->api->put('invoices/' . $invoiceId, $invoice); 
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return true;
        }
    }
    
    function delete($invoiceId) {
        $result = $this->api->delete('invoices/' . $invoiceId); 
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