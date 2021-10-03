/README.md

## API Endpoints

## **api**

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
GET /Zadatak2/praktikanti/read
GET /Zadatak2/mentori/read
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
GET /Zadatak2/grupe/read
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
GET /Zadatak2/praktikanti/read_single?id=value
GET /Zadatak2/mentori/read_single?id=value
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
GET /Zadatak2/grupe/read_single?id=value
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
GET /Zadatak2/grupe/listing                 //Default: Loads the page 1 
GET /Zadatak2/grupe/listing?page=value
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

```http
POST /Zadatak2/praktikanti/create
POST /Zadatak2/mentori/create
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
POST /Zadatak2/grupe/create
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
PUT /Zadatak2/praktikanti/update
PUT /Zadatak2/mentori/update
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
PUT /Zadatak2/grupe/update
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
PUT /Zadatak2/mentori/komentar
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
DELETE /Zadatak2/praktikanti/delete
DELETE /Zadatak2/mentori/delete
DELETE /Zadatak2/grupe/delete
```

- Values

```json
[
    {  
        "id":"int"      //Id must have a value         
    }
]
```

<!-- api-end -->
