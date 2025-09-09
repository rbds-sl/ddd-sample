# Cover Restaurant API Specification

## Overview
This document provides the specification for the Cover Restaurant API, which allows clients to retrieve restaurant data from the Cover Core service.

## Base URL
The base URL for the API is configured in the application settings as `services.cover-core.url`.

## Authentication
All API requests require authentication using a Bearer token. The token is configured in the application settings as `services.cover-core.token`.

Example:
```
Authorization: Bearer {token}
```

## Endpoints

### Get Restaurant by ID
Retrieves a specific restaurant by its ID.

**URL**: `/api/internal/restaurant/{restaurantId}`

**Method**: `GET`

**URL Parameters**:
- `restaurantId` (string, required): The ID of the restaurant to retrieve

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
{
  "id": 123,
  "appRestaurantId": "rest-123",
  "groupId": 456,
  "name": "Restaurant Name",
  "customProperties": {
    "property1": "value1",
    "property2": "value2"
  }
}
```

### Get Restaurants by Group ID
Retrieves a list of restaurants belonging to a specific group, with pagination.

**URL**: `/api/internal/group/{groupId}/restaurants`

**Method**: `GET`

**URL Parameters**:
- `groupId` (integer, required): The ID of the group to retrieve restaurants for

**Query Parameters**:
- `limit` (integer, required): The maximum number of restaurants to return
- `offset` (integer, required): The offset for pagination

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
[
  {
    "id": 123,
    "appRestaurantId": "rest-123",
    "groupId": 456,
    "name": "Restaurant Name 1",
  },
  {
    "id": 124,
    "appRestaurantId": "rest-124",
    "groupId": 456,
    "name": "Restaurant Name 2",
  }
]
```

### Get All Restaurants
Retrieves a list of all restaurants, with pagination.

**URL**: `/api/internal/restaurant`

**Method**: `GET`

**Query Parameters**:
- `limit` (integer, required): The maximum number of restaurants to return
- `offset` (integer, required): The offset for pagination

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
[
  {
    "id": 123,
    "appRestaurantId": "rest-123",
    "groupId": 456,
    "name": "Restaurant Name 1",
  },
  {
    "id": 124,
    "appRestaurantId": "rest-124",
    "groupId": 789,
    "name": "Restaurant Name 2",
  }
]
```

## Error Handling
If an error occurs, the API will return an appropriate HTTP status code along with a JSON response containing error details.

Example error response:
```json
{
  "error": "Restaurant not found",
  "code": "NOT_FOUND"
}
```

Common error status codes:
- 400 Bad Request: The request was malformed or missing required parameters
- 401 Unauthorized: Authentication failed
- 404 Not Found: The requested resource was not found
- 500 Internal Server Error: An unexpected error occurred on the server