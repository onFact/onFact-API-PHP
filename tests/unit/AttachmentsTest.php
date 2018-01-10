<?PHP
require_once('src/onFactApi.php');

class Attachments extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    } 
    
    /**
     * Basic create - read - update ( - read ) - delete test
     **/
    public function testCrud() { 
        $onFact = new onFact\Api(ONFACT_TEST_KEY);
        $customer = array(
            'Contact' => array(
                'type' => 'customer',
                'name' => 'Kevin Van Gyseghem',
                'email' => 'kevin@infinwebs.be',
            )    
        ); 
        $id = $onFact->Customers->add($customer);  
        $this->assertTrue(is_numeric($id));
        
        $attachment = array(
            'Attachment' => array(
                'file' => 'testbestand',
                'name' => 'test.txt',
                'model' => 'Contact',
                'model_id' => $id,
            )    
        );
        $attachmentId = $onFact->Attachments->add($attachment);   
        $this->assertTrue($attachmentId > 0);
        
        $id = $onFact->Customers->delete($id);  
        $onFact->Attachments->delete($attachmentId);
    }
     
    
}
