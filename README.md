/README.md

## How to run the app?

### **Git clone**

- In terminal access to your local server environment root directory.

- Run
```
    git clone https://github.com/nikolacarapic02/ResenjeZadatka.git
```

### **Usage**

- Use QuantoxPraksa.sql database dump in additions folder to create database on your computer.

- Set the parameters for the database in the config.php file in folder config.

- Use the route below in your browser or other application launch environment to populate the database with random data.
```http
GET /faker
```
- In a browser or other application launch environment, use one of the routes listed in the [Api Reference](#api-reference) section.

- Pay attention to whether the app is in the root directory or in one of subdirectories.

## API Endpoints

- praktikanti
```json
{
    "read"
    "read_single"
    "create"
    "update"
    "delete"
}
```
- mentor
```json
{
    "read"
    "read_single"
    "create"
    "update"
    "delete"
    "komentar"
}
```
- grupe
```json
{
    "read"
    "read_single"
    "create"
    "update"
    "delete"
    "listing"
}
```

## API Reference

<!-- api-start -->

### **Read**

```http
GET /praktikanti/read
GET /mentori/read
```

- Response

```json
[
    {
        "id": "int",
        "ime": "string",
        "prezime": "string",
        "email": "string",
        "telefon": "string",
        "id_grupe": "int",
        "naziv_grupe": "string"
    }
]
```

```http
GET /grupe/read
```

- Response

```json
[
    {
        "id": "int",
        "naziv": "string",
        "mentori": "string",
        "praktikanti": "string"
    }
]
```

### **ReadSingle**

```http
GET /praktikanti/read_single/id
GET /praktikanti/read_single            //Default: Loads page for id=1

GET /mentori/read_single/id
GET /mentori/read_single                //Default: Loads page for id=1
```

- Response

```json
[
    {
        "id": "int",
        "ime": "string",
        "prezime": "string",
        "email": "string",
        "telefon": "string",
        "id_grupe": "int",
        "naziv_grupe": "string"
    }
]
```

```http
GET /grupe/read_single/id
GET /grupe/read_single                  //Default: Loads page for id=1
```

- Response

```json
[
    {
        "id": "int",
        "naziv": "string",
        "mentori": "string",
        "praktikanti": "string"
    }
]
```

### **Listing**

```http
GET /grupe/listing/page
GET /grupe/listing                 //Default: Loads the page 1 
```

- Response

```json
[
    {
        "redni_broj": "int",
        "pozicija": "string",
        "ime": "string",
        "prezime": "string"
    }
]
```

### **Create**

* During the POST request, the JSON object is sent, not the form data!!

```http
POST /praktikanti/create
POST /mentori/create
```

- Values

```json
[
    {  
        "ime":"string",
        "prezime":"string",
        "email":"string",
        "telefon":"string",
        "id_grupe":"int"
    }
]
```

```http
POST /grupe/create
```

- Values

```json
[
    {  
        "naziv":"string"
    }
]
```

### **Update**

```http
PUT /praktikanti/update
PUT /mentori/update
```

- Values

```json
[
    {  
        "id":"int",         //Id must have a value
        "ime":"string",
        "prezime":"string",
        "email":"string",
        "telefon":"string",
        "id_grupe":"int"    //You must fill at least one column
    }
]
```

```http
PUT /grupe/update
```

- Values

```json
[
    {  
        "id":"int",         //Id must have a value
        "naziv":"string"    //You must fill at least one column
    }
]
```

### **Komentar**

```http
PUT /mentori/komentar
```

- Values

```json
[
    {  
        "komentar":"string",    //All columns must have a value
        "id_m":"int",
        "id_p":"int"          
    }
]
```

### **Delete**

```http
DELETE /praktikanti/delete
DELETE /mentori/delete
DELETE /grupe/delete
```

- Values

```json
[
    {  
        "id":"int"      //Id must have a value         
    }
]
```

### **Faker**

```http
GET /faker
```

- Response

```json
[
    {  
        "code": 200,
        "message": "The database was successfully filled!!" 
    }
]
```

<!-- api-end -->
