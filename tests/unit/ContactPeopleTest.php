<?PHP
require_once('src/onFactApi.php');

class ContactPeople extends \PHPUnit_Framework_TestCase
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
        
        $contactPerson = array(
            'ContactPerson' => array(
                'contact_id' => $id,
                'firstname' => 'Kevin',
                'lastname' => 'Van Gyseghem',
                'street' => 'Stationsstraat',
                'streetnumber' => '102',
                'citycode' => '1730',
                'city' => 'Asse',
                'email' => 'kevin@infinwebs.be'
            )    
        );
        
        $id = $onFact->ContactPeople->add($contactPerson);
        
        $contactPersonApi = $onFact->ContactPeople->view($id);   
        $this->assertArrayContainsArray($contactPerson, $contactPersonApi);
        
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
