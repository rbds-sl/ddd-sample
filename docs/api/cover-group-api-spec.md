# Cover Group API Specification

## Overview
This document provides the specification for the Cover Group API, which allows clients to retrieve group data from the Cover Core service.

## Base URL
The base URL for the API is configured in the application settings as `services.cover-core.url`.

## Authentication
All API requests require authentication using a Bearer token. The token is configured in the application settings as `services.cover-core.token`.

Example:
```
Authorization: Bearer {token}
```

## Endpoints

### Get Group by ID
Retrieves a specific group by its ID.

**URL**: `/api/internal/group/{groupId}`

**Method**: `GET`

**URL Parameters**:
- `groupId` (string, required): The ID of the group to retrieve

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
{
  "id": 456,
  "name": "Group Name",
  "type": "RESTAURANT_GROUP",
  "groupCRMStatus": "ACTIVE",
  "status": "ACTIVE",
  "groupClientsMergeCriteria": "EMAIL",
  "customProperties": {
    "property1": "value1",
    "property2": "value2"
  }
}
```

### Get Groups by Restaurant ID
Retrieves a list of groups associated with a specific restaurant, with pagination.

**URL**: `/api/internal/restaurant/{restaurantId}/groups`

**Method**: `GET`

**URL Parameters**:
- `restaurantId` (string, required): The ID of the restaurant to retrieve groups for

**Query Parameters**:
- `limit` (integer, required): The maximum number of groups to return
- `offset` (integer, required): The offset for pagination

**Response**:
- Status Code: 200 OK
- Content Type: application/json
- Body:
```json
[
  {
    "id": 456,
    "name": "Group Name 1",
    "type": "RESTAURANT_GROUP",
    "groupCRMStatus": "ACTIVE",
    "status": "ACTIVE",
    "groupClientsMergeCriteria": "EMAIL",
  },
  {
    "id": 457,
    "name": "Group Name 2",
    "type": "RESTAURANT_GROUP",
    "groupCRMStatus": "ACTIVE",
    "status": "ACTIVE",
    "groupClientsMergeCriteria": "EMAIL",
  }
]
```

## Error Handling
If an error occurs, the API will return an appropriate HTTP status code along with a JSON response containing error details.

Example error response:
```json
{
  "error": "Group not found",
  "code": "NOT_FOUND"
}
```

Common error status codes:
- 400 Bad Request: The request was malformed or missing required parameters
- 401 Unauthorized: Authentication failed
- 404 Not Found: The requested resource was not found
- 500 Internal Server Error: An unexpected error occurred on the server