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
GET /ResenjeZadatka/praktikanti/read
GET /ResenjeZadatka/mentori/read
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
GET /ResenjeZadatka/grupe/read
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
GET /ResenjeZadatka/praktikanti/read_single?id=value
GET /ResenjeZadatka/mentori/read_single?id=value
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
GET /ResenjeZadatka/grupe/read_single?id=value
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
GET /ResenjeZadatka/grupe/listing                 //Default: Loads the page 1 
GET /ResenjeZadatka/grupe/listing?page=value
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
POST /ResenjeZadatka/praktikanti/create
POST /ResenjeZadatka/mentori/create
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
POST /ResenjeZadatka/grupe/create
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
PUT /ResenjeZadatka/praktikanti/update
PUT /ResenjeZadatka/mentori/update
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
PUT /ResenjeZadatka/grupe/update
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
PUT /ResenjeZadatka/mentori/komentar
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
DELETE /ResenjeZadatka/praktikanti/delete
DELETE /ResenjeZadatka/mentori/delete
DELETE /ResenjeZadatka/grupe/delete
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
