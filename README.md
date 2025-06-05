Vehicle REST API Project
Objective
Implement a backend REST API using a Symfony to manage technical data about vehicles and their manufacturers.

Brief
Design a SQL database to store vehicle technical data (e.g., top speed, dimensions, engine data, type) and their make.

Create a REST API with the following endpoints:

Retrieve all vehicle makers by vehicle type
Retrieve all technical details of a specific vehicle
Update a specific technical parameter of a vehicle

Language: PHP
Framework: Symfony 
Testing: PHPUnit

Expected Behavior
RESTful responses for all endpoints

Authorized requests only—Unauthorized requests are declined

Technical parameters per vehicle: Limited to 10
==========

API Endpoints
Endpoint	Method	Description
 api_makers_by_type               GET      ANY      ANY    /api/makers/by-type/{type}
  api_vehicle_details              GET      ANY      ANY    /api/vehicle/{id}
  api_vehicle_tech_details         GET      ANY      ANY    /api/vehicle-tech-detail/{id}
  api_vehicle_tech_detail_update   PATCH    ANY      ANY    /api/vehicle-tech-detail/{id}
 -------------------------------- -------- -------- ------ -----------------------------------

Other critical endpoints for a standard REST API:
Can be all CURD related endpoints for vehicle/maker/vehicle-tech-detail, I created seprate vehicle-tech controller to manage that specific area task, can add api version on url too, for now its not there
POST /api/makers – Create a new maker
POST /api/vehicles – Create a new vehicle
DELETE /api/vehicles/{id} – Delete a vehicle
GET /api/vehicles – List all vehicles (with pagination/filtering)
Authentication endpoints (e.g., /api/login, /api/register) - can do this with JWT (if require proper admin site to operate/secure) for now used api key to authorised api end points 

Database Schema
used migrations for keeping change log of db structure 
Added “Screenshot 2025-06-05 151159.jpg”

Authentication
Generated application key - can provide key separately 
API endpoints require a valid api token/key.
Include the token in the Authorization header for protected endpoints.

Testing
Used phpunit test - wrote some test basic cases - can enhance more and make it more dynamic too
