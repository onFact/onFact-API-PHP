<?PHP
require_once('src/onFactApi.php');

class Documentevents extends \PHPUnit_Framework_TestCase
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
    public function testUpdatestatus() { 
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
        $invoice = array(
            'Invoice' => array(
                'date' => date('Y-m-d'),
                'term' => '21', // Invoice should be payed within 21 days afther the invoice date 
                'customer_name' => $contact['Contact']['name'],
                'customer_street' =>  $contact['Contact']['street'],
                'customer_streetnumber' =>  $contact['Contact']['streetnumber'],
                'customer_city' =>  $contact['Contact']['city'],
                'customer_citycode' =>  $contact['Contact']['citycode'],
                'vattype' => 'excl', // all prices in the lines will be VAT exclusive,
                'discount' => 5,
                'discount_type' => 'procent', // A total discount of 5% on the invoice
            ),
            'Invoiceitem' => array(
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
        $invoiceId = $onFact->Invoices->add($invoice);  
        
        // Update the status of the invoice
        $documentevent = array(
            'Documentevent' => array(  
                'model' => 'Invoice',
                'document_id' => $invoiceId,
                'status' => 'payed',
            )    
        ); 
        $eventId = $onFact->Documentevents->add($documentevent);  
        $this->assertTrue(is_numeric($eventId));
         
        $documentApi = $onFact->Invoices->view($invoiceId);   
        //$this->assertArrayContainsArray($documentevent, $documentApi); 
        $this->assertEquals($documentApi['Invoice']['status'], 'payed');
         
        $onFact->Documentevents->delete($eventId);  
        $documentApi = $onFact->Invoices->view($invoiceId);    
        $this->assertEquals($documentApi['Invoice']['status'], 'concept');
        
        $onFact->Invoices->delete($invoiceId); 

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
