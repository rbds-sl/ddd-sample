# Cover Client API Specification

## Overview
This document provides the specification for the Cover Client API, which allows clients to retrieve client data from the Cover Core service.

## Base URL
The base URL for the API is configured in the application settings as `services.cover-core.url`.

## Authentication
All API requests require authentication using a Bearer token. The token is configured in the application settings as `services.cover-core.token`.

Example:
```
Authorization: Bearer {token}
```

## Endpoints

### Get Client by ID
Retrieves a specific client by its ID.

**URL**: `/api/internal/client/{clientId}`

**Method**: `GET`

**URL Parameters**:
- `clientId` (string, required): The ID of the client to retrieve

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
{
  "id": 123,
  "restaurantId": 456,
  "marketingSubscription": {
    "optInAt": 1609459200,
    "optOutAt": null
  },
  "identification": {
    "firstName": "John",
    "lastName": "Doe",
    "email": "john.doe@example.com",
    "phone": "1234567890",
    "phoneCountryCode": "+1"
  },
  "preferences": {
    "foodPreferences": "Vegetarian",
    "foodRestrictions": "Gluten-free",
    "sittingPreferences": "Window seat",
    "waiterPreferences": "Prefers minimal interaction",
    "notes": "Regular customer",
    "accessibility": "Wheelchair access needed"
  },
  "language": "en",
  "company_name": "Example Corp",
  "address": {
    "city": "New York",
    "address": "123 Main St",
    "postalCode": "10001",
    "countryCode": "US",
    "additionalPhone": "0987654321",
    "additionalPhone_country_code": "+1"
  },
  "integrations": [
    {
      "integration": "THE_FORK",
      "id": "mc-123456"
    }
  ],
  "dob": "1980-01-01",
  "customProperties": {
    "property1": "value1",
    "property2": "value2"
  }
}
```

### Get Clients by Restaurant ID
Retrieves a list of clients belonging to a specific restaurant, with pagination.

**URL**: `/api/internal/restaurant/{restaurantId}/clients`

**Method**: `GET`

**URL Parameters**:
- `restaurantId` (string, required): The ID of the restaurant to retrieve clients for

**Query Parameters**:
- `limit` (integer, required): The maximum number of clients to return
- `offset` (integer, required): The offset for pagination

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
[
  {
    "id": 123,
    "restaurantId": 456,
    "marketingSubscription": {
      "optInAt": 1609459200,
      "optOutAt": null
    },
    "identification": {
      "firstName": "John",
      "lastName": "Doe",
      "email": "john.doe@example.com",
      "phone": "1234567890",
      "phoneCountryCode": "+1"
    },
    "preferences": {
      "foodPreferences": "Vegetarian",
      "foodRestrictions": "Gluten-free",
      "sittingPreferences": "Window seat",
      "waiterPreferences": "Prefers minimal interaction",
      "notes": "Regular customer",
      "accessibility": "Wheelchair access needed"
    },
    "language": "en",
    "company_name": "Example Corp",
    "address": {
      "city": "New York",
      "address": "123 Main St",
      "postalCode": "10001",
      "countryCode": "US",
      "additionalPhone": "0987654321",
      "additionalPhone_country_code": "+1"
    },
    "integrations": [
      {
        "integration": "MAILCHIMP",
        "id": "mc-123456"
      }
    ],
    "dob": "1980-01-01",
    "customProperties": {
      "property1": "value1",
      "property2": "value2"
    }
  },
  {
    "id": 124,
    "restaurantId": 456,
    "marketingSubscription": {
      "optInAt": 1609459200,
      "optOutAt": null
    },
    "identification": {
      "firstName": "Jane",
      "lastName": "Smith",
      "email": "jane.smith@example.com",
      "phone": "0987654321",
      "phoneCountryCode": "+1"
    },
    "preferences": {
      "foodPreferences": "Pescatarian",
      "foodRestrictions": "Dairy-free",
      "sittingPreferences": "Booth",
      "waiterPreferences": null,
      "notes": "New customer",
      "accessibility": null
    },
    "language": "en",
    "company_name": null,
    "address": {
      "city": "Los Angeles",
      "address": "456 Oak St",
      "postalCode": "90001",
      "countryCode": "US",
      "additionalPhone": null,
      "additionalPhone_country_code": null
    },
    "integrations": [],
    "dob": "1985-05-15",
    "customProperties": {
      "property1": "value1",
      "property2": "value2"
    }
  }
]
```

## Error Handling
If an error occurs, the API will return an appropriate HTTP status code along with a JSON response containing error details.

Example error response:
```json
{
  "error": "Client not found",
  "code": "NOT_FOUND"
}
```

Common error status codes:
- 400 Bad Request: The request was malformed or missing required parameters
- 401 Unauthorized: Authentication failed
- 404 Not Found: The requested resource was not found
- 500 Internal Server Error: An unexpected error occurred on the server