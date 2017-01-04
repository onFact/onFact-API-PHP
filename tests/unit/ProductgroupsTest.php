<?PHP
require_once('src/onFactApi.php');

class Productgroups extends \PHPUnit_Framework_TestCase
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
        $productgroup = array(
            'Productgroup' => array( 
                'name' => 'Car parts', 
            )    
        ); 
        $id = $onFact->Productgroups->add($productgroup);  
        $this->assertTrue(is_numeric($id));
        
        $productgroupApi = $onFact->Productgroups->view($id);   
        $this->assertArrayContainsArray($productgroup, $productgroupApi);
        
        $updatedProductgroup = array(
            'Productgroup' => array(
                'name' => 'Car paint', 
            )
        );
        $update = $onFact->Productgroups->update($id, $updatedProductgroup);  
        $this->assertTrue($update);
        
        $productgroupApi = $onFact->Productgroups->view($id);    
        $this->assertArrayContainsArray($updatedProductgroup, $productgroupApi);
        
        $delete = $onFact->Productgroups->delete($id);
        $this->assertTrue($delete);

    }
    
    /**
     * Basic create - read - update ( - read ) - delete test
     **/
    public function testErrors() { 
        $onFact = new onFact\Api(ONFACT_TEST_KEY);
        $productgroup = array( // Empty productgroup
            'Productgroup' => array( 
            )    
        ); 
        $id = $onFact->Productgroups->add($productgroup);  
        $this->assertFalse($id);
        
        $this->assertArrayContainsArray(
            array(
                'name'=>array('notEmptyCreate')
            ), 
            $onFact->Productgroups->getErrors()
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
