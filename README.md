Treat address (rua, bairro, numero) on form submission (Guavira register);
LOGIC ORDER: HTML sends form to Controller. Controller parses form and if endereço was selected,
             endereço fields are concatenated to query data via API call (geocode method);
             If geocode returns success, Guavira registration proceeds normally (latitude and longitude) are parsed and saved. If geocode fails, user gets an error message and repeats form submission;
             
Add more information to Guavira model if user selects to register Guavira as a vendor/commerchant/enterprise;
Start applying middlewares for authentication and permissions;
Pass to front-end and then blade.php.
