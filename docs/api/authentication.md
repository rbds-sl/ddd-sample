# API Authentication

## Bearer Token Authentication

All API endpoints in this application are protected by bearer token authentication. To access the API, you must include a valid bearer token in the `Authorization` header of your HTTP requests.

### Configuration

The API token is configured using the `COVER_CORE_TOKEN` environment variable, which is accessed through the configuration system at `services.cover-core.token`. Make sure to set this variable in your `.env` file:

```
COVER_CORE_TOKEN=your_secure_token_here
```

### Making Authenticated Requests

To make an authenticated request to the API, include the bearer token in the `Authorization` header:

```
Authorization: Bearer your_secure_token_here
```

### Example using cURL

```bash
curl -X POST https://your-api-domain.com/api/group/created \
  -H "Authorization: Bearer your_secure_token_here" \
  -H "Content-Type: application/json" \
  -d '{"app": "cover-manager", "id": "group-id"}'
```

### Example using JavaScript (fetch)

```javascript
fetch('https://your-api-domain.com/api/group/created', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer your_secure_token_here',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    app: 'cover-manager',
    id: 'group-id'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### Error Responses

If you don't include a valid bearer token, the API will respond with a `401 Unauthorized` status code and an error message:

```json
{
  "error": "Unauthorized"
}
```

If the API token is not configured on the server, the API will respond with:

```json
{
  "error": "API token not configured"
}
```
