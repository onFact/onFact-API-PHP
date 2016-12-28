<?PHP
require_once('src/onFactApi.php');

class Customers extends \PHPUnit_Framework_TestCase
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
        
        $customerApi = $onFact->Customers->view($id);   
        $this->assertArrayContainsArray($customer, $customerApi);
        
        $updatedCustomer = array(
            'Contact' => array(
                'name' => 'Jan Van Gyseghem',
                'email' => 'jan@infinwebs.be',
            )
        );
        $update = $onFact->Customers->update($id, $updatedCustomer);  
        $this->assertTrue($update);
        
        $customerApi = $onFact->Customers->view($id);    
        $this->assertArrayContainsArray($updatedCustomer, $customerApi);
        
        $delete = $onFact->Customers->delete($id);
        $this->assertTrue($delete);

    }
    
    /**
     * Basic create - read - update ( - read ) - delete test
     **/
    public function testErrors() { 
        $onFact = new onFact\Api(ONFACT_TEST_KEY);
        $customer = array( // Empty contact
            'Contact' => array( 
            )    
        ); 
        $id = $onFact->Customers->add($customer);  
        $this->assertFalse($id);
        
        $this->assertArrayContainsArray(
            array(
                'name'=>array('notEmptyCreate')
            ), 
            $onFact->Customers->getErrors()
        );
    }
 
 
    protected function assertArrayContainsArray($needle, $haystack)
    {
        foreach ($needle as $key => $val) {
            $this->assertArrayHasKey($key, $haystack);
 
            if (is_array($val)) {
                $this->assertArrayContainsArray($val, $haystack[$key]);
            } else {
                $this->assertEquals($val, $haystack[$key]);
            }
        }
    }
    
}
