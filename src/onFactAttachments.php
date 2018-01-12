<?PHP
namespace onFact;

/**
 * Attachments class
 * 
 * @author  Kevin Van Gyseghem  <kevin@infinwebs.be>
 **/
class Attachments {
    
    function __construct(&$api) {
        $this->api = $api;
    }
    
    /**
     * Creates an attachment
     * 
     * @param Array $attachment array('Invoice' => array('customer_name' => 'Kevin', ...)). see http://apidoc.onfact.be/#api-Invoices-postInvoice
     **/
    function add($attachment) {
        $tmpfname = tempnam(sys_get_temp_dir(), 'FOO');
        file_put_contents($tmpfname, base64_decode($attachment['Attachment']['file']));
        if (function_exists('curl_file_create')) { // php 5.5+
          $cFile = curl_file_create($tmpfname);
        } else { // 
          $cFile = '@' . realpath($tmpfname);
        }
        $post = array('file'=> $cFile);
        $query = http_build_query(['name' => $attachment['Attachment']['name'], 'model' => $attachment['Attachment']['model'], 'model_id' => $attachment['Attachment']['model_id']]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(       
            'session_key: ' . $this->api->apiKey,
        ));    
        curl_setopt($ch, CURLOPT_URL, Api::$apiRoot . "attachments.json?" . $query);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);                                                             
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       
        $result = json_decode(curl_exec ($ch), TRUE);
        curl_close ($ch);  
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['id'];
        }
    }
    
    /**
     * Get a attachment or attachment with the specified ID
     * 
     **/
    function index() {
        $result = $this->api->get('attachments');
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['attachments'];
        }
    }
    
    /**
     * Get a attachment or attachment with the specified ID
     * 
     **/
    function view($attachmentId) {
        $result = $this->api->get('attachments/' . $attachmentId);
        if(isset($result['errors'])) { 
            $this->errors = $result['errors'];
            return false;
        } else {
            return $result['attachment'];
        }
    } 
    
    function delete($attachmentId) {
        $result = $this->api->delete('attachments/' . $attachmentId); 
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