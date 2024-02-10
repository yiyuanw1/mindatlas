The solution is implemented to use API controller to manage different request according to the route of the api. 

### API folder
- [`index.php`](api/index.php): root route controller
- [`config.php`](api/config.php): configure the http header
- [`DB.class.php`](api/DB.class.php): database connection class with singleton pattern
- `class`: stores all the classes, all the API router handler classes for this scanerio
- `router`: initiate the API router handlers and handle the request
- `controller`: Interface functions between router and database