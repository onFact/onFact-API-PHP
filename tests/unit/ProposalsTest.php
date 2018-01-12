<?PHP
require_once('src/onFactApi.php');

class Proposals extends \PHPUnit_Framework_TestCase
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
        $contact = array(
            'Contact' => array(
                'type' => 'customer',
                'name' => 'Kevin Van Gyseghem',
                'street' => 'Stationsstraat',
                'streetnumber' => '102',
                'city' => 'Asse',
                'citycode' => '1730',
                'email' => 'kevin@infinwebs.be',
                'phone' => '01/12348613'
            )
        );
        $proposal = array(
            'Proposal' => array(
                'date' => date('Y-m-d'),
                'term' => '21', // Proposal should be payed within 21 days afther the proposal date 
                'customer_name' => $contact['Contact']['name'],
                'customer_street' =>  $contact['Contact']['street'],
                'customer_streetnumber' =>  $contact['Contact']['streetnumber'],
                'customer_city' =>  $contact['Contact']['city'],
                'customer_citycode' =>  $contact['Contact']['citycode'],
                'vattype' => 'excl', // all prices in the lines will be VAT exclusive,
                'discount' => 5,
                'discount_type' => 'procent', // A total discount of 5% on the proposal
            ),
            'Proposalitem' => array(
                array(
                    'order' => 0,
                    'items' => 10,
                    'price' => 5.99,
                    'vat' => '21',
                    'name' => 'Service contract',
                    'text' => 'From ' . date('d-m-Y') . ' to ' . date('d-m-Y',mktime(0,0,0,date('n'), date('j'), date('Y') + 1)),
                    'discount' => 0,
                    'discount_type' => 'euro', 
                ),
                array(
                    'order' => 1,
                    'items' => 5,
                    'price' => 49.99,
                    'vat' => '6',
                    'name' => 'Equipment', 
                    'discount' => 0,
                    'discount_type' => 'euro', 
                )    
            )
        );
        $id = $onFact->Proposals->add($proposal);  
        $this->assertTrue(is_numeric($id));
        
        $proposalApi = $onFact->Proposals->view($id);   
        $this->assertArrayContainsArray($proposal, $proposalApi);
        
        $updatedProposal = $proposal;
        $updatedProposal['Proposal']['customer_name'] = 'Jan Van Gyseghem';
        $updatedProposal['Proposal']['term'] = '30';
        unset($updatedProposal['Proposalitem']); // Either update none or update all
         
        $update = $onFact->Proposals->update($id, $updatedProposal);  
        $this->assertTrue($update);
        
        $proposalApi = $onFact->Proposals->view($id);    
        $this->assertArrayContainsArray($updatedProposal, $proposalApi);
        
        $delete = $onFact->Proposals->delete($id);
        $this->assertTrue($delete);

    }
    
    /**
     * Basic create - read - update ( - read ) - delete test
     **/
    public function testErrors() { 
        $onFact = new onFact\Api(ONFACT_TEST_KEY);
        $proposal = array( // Empty contact
            'Proposal' => array( 
            )    
        ); 
        $id = $onFact->Proposals->add($proposal);  
        $this->assertFalse($id);
        
        $this->assertArrayContainsArray(
            array(
                'customer_name'=>array('notemptyCreate')
            ), 
            $onFact->Proposals->getErrors()
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
