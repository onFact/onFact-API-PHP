<?PHP
require_once('src/onFactApi.php');

class Emails extends \PHPUnit_Framework_TestCase
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
    public function testSend() { 
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
        
        // Send the document
        $email = array(
            'Email' => array( 
                'to' => 'testmail@infinwebs.be',
                'subject' => 'Test invoice',
                'text' => 'testmail '.rand(1000,9999),
                'model' => 'Invoice',
                'model_id' => $invoiceId,
                'document_as_attachment' => true,
            )    
        ); 
        $id = $onFact->Emails->add($email);  
        $this->assertTrue(is_numeric($id));
        
        unset($email['Email']['document_as_attachment']); // is not saved
        $emailApi = $onFact->Emails->view($id);   
        $this->assertArrayContainsArray($email, $emailApi);
        
        $documentApi = $onFact->Invoices->view($invoiceId);    
        $this->assertEquals($documentApi['Invoice']['status'],'sent');
        
        $onFact->Invoices->view($invoiceId);
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
