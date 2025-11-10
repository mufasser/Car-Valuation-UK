
<?php

// ***************************************************************************
// Please note that this example is for PHP version 8 and above
// ***************************************************************************

// Constants for the UK Vehicle Data API
define('UKVD_ENDPOINT', 'https://uk.api.vehicledataglobal.com/r2/lookup');

// Process the command line arguments
// Since PHP does not have a direct equivalent of C#'s args, we use $argv for command line arguments.
$apiKey = 'e387636a-8360-48fd-9d47-fde0e75fd40d';
$packageName = 'ValuationDetailsv2';
$vrm = ''; // Placeholder for vehicle registration mark, to be assigned a value later.


// Encode the query parameters
$queryParams = http_build_query([
    'packageName' => $packageName,
    'vrm' => $vrm,
]);

// Create the full URL with the query string
$fullUrl = UKVD_ENDPOINT . '?' . $queryParams;

// Create a stream context for the HTTP request
$options = [
    'http' => [
        'header'  => "Authorization: Bearer $apiKey",
        'method'  => 'GET'
    ]
];
$context = stream_context_create($options);

// Making the HTTP request to the UK Vehicle Data API with query parameters
$response = file_get_contents($fullUrl, false, $context);

// Check if the request was successful
if ($response === FALSE) {
    die('Error making the request');
}

// Decode the JSON response
$responseData = json_decode($response, true);

// Check if the API call was successful
if (!$responseData || $responseData['success'] !== true) {
    die('Error in API response');
}

// ***************************************************************************
// This is the model class for the response from the API call
// The model contains all the data based on the specific package given
// If you change the package data on your control panel, you will need to
// regenerate this model class.
// ***************************************************************************

class UkvdResponse
{
    public function __construct(
        public RequestInformation $requestInformation,
        public ResponseInformation $responseInformation,
        public BillingInformation $billingInformation,
        public LookupResults $results
    ) {}
}

class RequestInformation
{
    public function __construct(
        public string $packageName, // Package Name : The name of the package that was used to make the request.
        public string $searchTerm, // Search Term : The value used to do the look up.
        public string $searchType, // Search Type : Which data item that is being looked up.
        public string $requestIp // Request IP Address : The IP address where the request was made from.
    ) {}
}
class ResponseInformation
{
    public function __construct(
        public int $statusCode, // Status Code Number : The status of the response
        public string $statusMessage, // Status Code Text : The status of the response as text
        public bool $isSuccessStatusCode, // Is Status Code Successful : This returns whether the status of the response indicates that the request was successful.
        public int $queryTimeMs, // Query Time : This is the amount of time the query took to execute in milliseconds
        public string $responseId // Response Identifier : This is the unique identifier of the report. Use this when referring to any issues with the results with support.
    ) {}
}
class BillingInformation
{
    public function __construct(
        public ?string $billingTransactionId, // Billing Transaction Id : This is the unique reference to the billing transaction for this lookup. If missing this transaction did not require any billing to take place.
        public int $accountType, // Account Type : This is the current type of account that defines how the account is billed.
        public ?float $accountBalance, // Account Balance : The current balance of the account if this is a pay as a go account.
        public ?float $transactionCost, // Transaction Cost : The total cost of the transaction if the transaction required billing.
        public int $billingResult, // Billing Result : Whether the account was billed
        public string $billingResultMessage, // Billing Result Text : Whether the account was billed in text format
        public ?float $refundAmount, // Refund Amount : The amount that was required to be refunded depending on what package data was able to be returned and how the package was set up.
        public ?int $refundResult, // Refund Result : Whether the transaction had a refund
        public string $refundResultMessage // Refund Result Text : Whether the transaction had a refund in text format
    ) {}
}

class LookupResults
{
    public function __construct(
        public VehicleCodes $vehicleCodes,
        public UkvdValuationDetails $ukvdValuationDetails
    ) {}
}

class VehicleCodes
{
    public function __construct(
        public string $ukvdId, // UKVD Id : UK Vehicle Data Vehicle record Id.
        public string $uvc // UVC : Universal Vehicle Code. UK Vehicle Data internal vehicle model code. Code is unique to each vehicle model.
    ) {}
}
class UkvdValuationDetails
{
    public function __construct(
        public DateTime $valuationTime, // Valuation Time : The Date and Time this valuation was requested.
        public int $valuationMileage, // Mileage : Valuation based on this vehicle mileage.
        public string $valuationBook, // Valuation Book : The valuation book used (if applicable).
        public string $vehicleDescription, // Vehicle Description : Description of the vehicle.
        public ?DateTime $dateOfFirstRegistration, // Date of First Registration : The date when this vehicle was first registered.
        public ?UkvdValuationDetails_ValuationFiguresSection $valuationFigures, // ValuationFigures : Object containing the valuation figures provided for this valuation.
        public int $statusCode, // Status Code : API Response Status Code.
        public string $statusMessage, // Status Message : API Response Status Message. Human description describing the API response.
        public int $documentVersion // Document Version : Data Source Versioning.
    ) {}
}
class UkvdValuationDetails_ValuationFiguresSection
{
    public function __construct(
        public ?int $onTheRoad, // On The Road : The on the road (OTR) price for this vehicle. OTR does not include any optional extras.
        public ?int $dealerForecourt, // Dealer Forecourt : Estimated value a Franchised Dealer could potentially sell the vehicle for - in Excellent condition.
        public ?int $tradeRetail, // Trade Retail : Estimated value a Trade dealer could potentially sell the vehicle for - in Clean/Excellent condition..
        public ?int $privateClean, // Private Clean : Vehicle in Clean/Excellent condition. Estimated value a consumer/non trade user could potentially sell the vehicle for.
        public ?int $privateAverage, // Private Average : Vehicle in Average condition. Estimated value a consumer/non trade user could potentially sell the vehicle for.
        public ?int $partExchange, // Part Exchange : Estimated value when used as a part exchange against another vehicle at a Franchise or Trade dealer.
        public ?int $auction, // Auction : Estimated auction value when purchasing the vehicle at an auction. Note this is an estimate, base model (no options) and in Clean, working condition.
        public ?int $tradeAverage, // Trade Average : Estimated value a Trade dealer could potentially sell the vehicle for - in Average condition.
        public ?int $tradePoor // Trade Poor : Estimated value a Trade dealer could potentially sell the vehicle for - in Poor condition.
    ) {}
}

?>
