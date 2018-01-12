![Build](https://travis-ci.org/onFact/onFact-API-PHP.svg?branch=master)
# onFact-API-PHP
PHP classes that can be used to connect to the onFact API
 
## Supported endpoints:
* Contacts (customers)
* ContactPeople
* Invoices
* Proposals
* Productgroups
* Products
* Documentevents
* Attachments
 
## Easy setup
Installation using composer:
```
composer require onfact/onfact-php-api
```

Include composer autoload (modify path as needed):
```
<?PHP
require_once('vendor/autoload.php');
?>
```

Connect and use API
```
<?PHP
define('ONFACT_API_KEY', '...');
$onFact = new onFact\Api(ONFACT_API_KEY);
$id = $onFact->Customers->add(array(
    'Contact' => array(
        'name' => 'John Dhoe',
    )
));
$customer = $onFact->Customer->view($id);
echo $customer['Contact']['name']; // John Dhoe
?>
```




© [onFact Facturatie Software](https://www.onfact.be)