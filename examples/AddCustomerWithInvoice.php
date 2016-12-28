<?PHP
// require_once '../vendor/autoload.php' // When using composer
require_once('../src/onFactApi.php');
$onFact = new onFact\Api('575e755203274f654506c6417b1548ee2b0522ce4698829d554b15c10fae8b5e');

/**
 * Create the customer
 **/
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
$customerId = $onFact->Customers->add($contact);


/** 
 * Create the invoice
 **/
$invoice = array(
    'Invoice' => array(
        'date' => date('Y-m-d'),
        'term' => '21', // Invoice should be payed within 21 days afther the invoice date
        'customer_id' => $customerId, // Link it to the created customer
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
if(!$invoiceId) {
    var_dump($onFact->Invoices->getErrors());
} else {
    $invoiceApi = $onFact->Invoices->view($invoiceId);
    var_dump($invoiceApi);
}