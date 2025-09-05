<?php
// Get the resource path, e.g., '2021/02/21'
$resourcePath = $event['resource'];

// Extract year, month, and day from the resource path
list($year, $month, $day) = explode('/', $resourcePath);

// Validate year, month, and day
if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day) ||
    $month < 1 || $month > 12 || $day < 1 || $day > 31) {
    throw new \DreamFactory\Core\Exceptions\BadRequestException('Invalid year, month, or day.');
}

// Build the filter for the database query
$filter = sprintf('hire_date = "%s-%02d-%02d"', $year, $month, $day);

// Define the API path and query parameters
$apiPath = 'mysql/_table/employees';
$queryString = 'filter=' . rawurlencode($filter);

// Construct the full URL with query parameters
$fullUrl = $apiPath . '?' . $queryString;

// Execute the API call using the correct method
$api = $platform['api'];
$get = $api->get;
$response = $get($fullUrl);

// Return the response
return $response;
