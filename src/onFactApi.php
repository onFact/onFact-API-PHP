<?PHP
namespace onFact;

require_once('onFactCustomers.php');
require_once('onFactContactPeople.php');
require_once('onFactInvoices.php');
require_once('onFactProductgroups.php');
require_once('onFactEmails.php');
require_once('onFactDocumentevents.php');

class Api {
    
    static private $apiRoot = "https://api.onfact.be/";
    private $apiKey;
    
    function __construct($apiKey) {
        $this->apiKey = $apiKey;
        
        $this->Customers        = new Customers($this);
        $this->ContactPeople    = new ContactPeople($this);
        $this->Invoices         = new Invoices($this);
        $this->Productgroups    = new Productgroups($this);
        $this->Emails           = new Emails($this);
        $this->Documentevents   = new Documentevents($this);
    } 
     
    function get($endpoint) {      
        $ch = curl_init(Api::$apiRoot . str_replace('.json','',$endpoint) . '.json');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(       
            'session_key: ' . $this->apiKey,
        ));                                                    
        try {
            $result = curl_exec($ch);
            return json_decode($result, true);
        } catch(Exception $e) {
            die($e->getMessage());
        } 
    }
    
    function post($endpoint, $data) {     
        $json = json_encode($data); 
        $ch = curl_init(Api::$apiRoot . str_replace('.json','',$endpoint) . '.json');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json),
            'session_key: ' . $this->apiKey,
        ));                                                
        try {
            $result = curl_exec($ch);
            return json_decode($result, true);
        } catch(Exception $e) {
            die($e->getMessage());
        } 
    }
    
    function put($endpoint, $data) {     
        $json = json_encode($data); 
        $ch = curl_init(Api::$apiRoot . str_replace('.json','',$endpoint) . '.json');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json),
            'session_key: ' . $this->apiKey,
        ));                                                    
        try {
            $result = curl_exec($ch);
            return json_decode($result, true);
        } catch(Exception $e) {
            die($e->getMessage());
        } 
    }
    
    function delete($endpoint) {     
        $ch = curl_init(Api::$apiRoot . str_replace('.json','',$endpoint) . '.json');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(      
            'session_key: ' . $this->apiKey,
        ));                                                    
        try {
            $result = curl_exec($ch);
            return json_decode($result, true);
        } catch(Exception $e) {
            die($e->getMessage());
        } 
    }
    
}