define({ "api": [
  {
    "type": "POST",
    "url": "/products",
    "title": "Create new product",
    "name": "Create_new_product",
    "group": "Product",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 50",
            "optional": false,
            "field": "1c_id",
            "description": "<p>Id of product in 1C</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "position",
            "description": "<p>Product order on the site (need for custom sorting)</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": true,
            "field": "status",
            "defaultValue": "1",
            "description": "<p>Product status (visibility)</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "category_id",
            "description": "<p>id of product category.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "availability",
            "description": "<p>Product count.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "price",
            "description": "<p>Product price.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "oem",
            "description": "<p>Product OEM.</p>"
          },
          {
            "group": "Parameter",
            "type": "string[]",
            "optional": true,
            "field": "images",
            "description": "<p>Product images. <br><b>Note</b>: the first image in array is the main image</p>"
          },
          {
            "group": "Parameter",
            "type": "object[translations]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable Product attributes</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "translations.language",
            "description": "<p>Language</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 255 symbols",
            "optional": false,
            "field": "translations.language.title",
            "description": "<p>Product title</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.language.description",
            "description": "<p>Product description</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.language.short_description",
            "description": "<p>Product short description</p>"
          },
          {
            "group": "Parameter",
            "type": "number[]",
            "optional": false,
            "field": "analogs",
            "description": "<p>Array of analogs Product ids</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "characteristics",
            "description": "<p>Array of Product characteristics with their translations</p>"
          },
          {
            "group": "Parameter",
            "type": "object[characteristics]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "characteristics.language",
            "description": "<p>Language is a key of each element of characteristics array</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.title",
            "description": "<p>Title of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.measurement",
            "description": "<p>Measurement of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.value",
            "description": "<p>Value of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "usedIn",
            "description": "<p>Array of Product Used In with their translations</p>"
          },
          {
            "group": "Parameter",
            "type": "object[usedIn]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "usedIn.language",
            "description": "<p>Language is a key of each element of characteristics array</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.title",
            "description": "<p>Title of Product Used In</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.parent_title",
            "description": "<p>Parent Title of Product Used In</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "POST http://agrod-site.32server.in.ua/api/v1/products",
          "type": "curl"
        },
        {
          "title": "Request-Example:",
          "content": "   {\n\t\"1c_id\": \"222-asdasd-qweqew\",\n\t\"position\": 1,\n\t\"status\": 1,\n\t\"category_id\": 24,\n\t\"availability\": 10,\n\t\"price\": 1250.55,\n\t\"oem\": \"testString\",\n\t\"images\": [\n\t\t\"2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg\",\n\t\t\"35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg\",\n\t\t\"QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg\"\n\t\t],\n\t\"translations\": {\n\t\t\"uk-UA\": { \n\t\t\t\"description\": \"Опис до комбайну\",\n\t\t\t\"short_description\": \"Короткий опис до комбайну\",\n\t\t\t\"title\": \"Комбайн\"\n\t\t},\n\t\t\"en-US\": { \n\t\t\t\"title\": \"Combine\",\n\t\t\t\"short_description\": \"Short combine description\",\n\t\t\t\"description\": \"Combine description\"\n\t\t}\n\t},\n\t\"analogs\": [\n\t\t21,22\n\t\t],\n\t\"characteristics\": [\n\t\t{\n\t\t\"uk-UA\": {\n\t\t\t\"title\": \"Масимальна швидкість\",\n\t\t\t\"measurement\": \"км\",\n\t\t\t\"value\": \"45\"\n\t\t},\n\t\t\"en-US\": {\n\t\t\t\"title\": \"Max speed\",\n\t\t\t\"measurement\": \"km\",\n\t\t\t\"value\": \"45\"\n\t\t}\n\t},\n\t{\n\t\t\"uk-UA\": {\n\t\t\t\"title\": \"Виробник\",\n\t\t\t\"measurement\": null,\n\t\t\t\"value\": \"ХТЗ\"\n\t\t},\n\t\t\"en-US\": {\n\t\t\t\"title\": \"Manufacturer\",\n\t\t\t\"measurement\": null,\n\t\t\t\"value\": \"HTZ\"\n\t\t}\n\t}\n\t],\n   \"usedIn\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       }\n   }]\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "product",
            "description": "<p>Returns created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID of created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.1c_id",
            "description": "<p>Id of product in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "product.status",
            "description": "<p>visible status of created object (1 - visible, 0 - unvisible)</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.category_id",
            "description": "<p>id of product category</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.availability",
            "description": "<p>product count of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.price",
            "description": "<p>product price</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.oem",
            "description": "<p>oem of product</p>"
          },
          {
            "group": "Success 200",
            "type": "string[]",
            "optional": false,
            "field": "product.image",
            "description": "<p>Array with main image properties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.image.path",
            "description": "<p>path to main image location</p>"
          },
          {
            "group": "Success 200",
            "type": "object[object]",
            "optional": false,
            "field": "product.productAttachments",
            "description": "<p>array of additional product images with poperties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productAttachments.path",
            "description": "<p>path to additional product image</p>"
          },
          {
            "group": "Success 200",
            "type": "object[translations]",
            "optional": false,
            "field": "product.translations",
            "description": "<p>List of translateable Product attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.translations.language",
            "description": "<p>Language</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 255 symbols",
            "optional": false,
            "field": "product.translations.language.title",
            "description": "<p>Product title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.description",
            "description": "<p>Product description</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.short_description",
            "description": "<p>Product short description</p>"
          },
          {
            "group": "Success 200",
            "type": "number[]",
            "optional": false,
            "field": "product.analogs",
            "description": "<p>Array of Product analogs ids</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "product.characteristics",
            "description": "<p>Array of product characteristics with translations</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.characteristics.language",
            "description": "<p>Language as a key to array</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 255",
            "optional": false,
            "field": "product.characteristics.language.title",
            "description": "<p>Characteristic title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 255",
            "optional": false,
            "field": "product.characteristics.language.value",
            "description": "<p>Characteristic value</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 50",
            "optional": true,
            "field": "product.characteristics.language.measurement",
            "description": "<p>Characteristic measurement</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 201 Created\n    {\n   \"id\": 24,\n   \"1c_id\": null,\n   \"position\": 1,\n   \"status\": 1,\n   \"category_id\": 24,\n   \"availability\": 10,\n   \"price\": \"1250.55\",\n   \"oem\": \"testString\",\n   \"image\": {\n       \"path\": \"1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg\",\n       \"base_url\": \"http://storage.agrodruzi.local/source\",\n       \"type\": \"image/jpeg\",\n       \"size\": 1061959,\n       \"name\": null,\n       \"order\": null,\n       \"timestamp\": 1521722357\n   },\n   \"productAttachments\": [\n       {\n           \"id\": 47,\n           \"product_id\": 24,\n           \"path\": \"1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       },\n       {\n           \"id\": 48,\n           \"product_id\": 24,\n           \"path\": \"1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       }\n   ],\n   \"translations\": {\n       \"en-US\": {\n           \"title\": \"Combine\",\n           \"description\": \"Combine description\",\n           \"language\": \"en-US\"\n       },\n       \"uk-UA\": {\n           \"title\": \"Комбайн\",\n           \"description\": \"Опис до комбайну\",\n           \"language\": \"uk-UA\"\n       }\n   },\n   \"analogs\": [\n       \"21\",\n       \"22\"\n   ],    \n   \"characteristics\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"Виробник\",\n           \"measurement\": null,\n           \"value\": \"ХТЗ\"\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"Manufacturer\",\n           \"measurement\": null,\n           \"value\": \"HTZ\"\n       }\n   }],\n   \"usedIn\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       }\n   }]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductController.php",
    "groupTitle": "Product"
  },
  {
    "type": "DELETE",
    "url": "/products/:id",
    "title": "Delete Product by id",
    "name": "Delete_product",
    "group": "Product",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Product id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "DELETE http://agrod-site.32server.in.ua/api/v1/products/1",
          "type": "curl"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No Content",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductController.php",
    "groupTitle": "Product"
  },
  {
    "type": "GET",
    "url": "/products/:id",
    "title": "Get product",
    "name": "Get_product",
    "group": "Product",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Id of product</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "usedIn",
            "description": "<p>Array of Product Used In with their translations</p>"
          },
          {
            "group": "Parameter",
            "type": "object[usedIn]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "usedIn.language",
            "description": "<p>Language is a key of each element of characteristics array</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.title",
            "description": "<p>Title of Product Used In</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.parent_title",
            "description": "<p>Parent Title of Product Used In</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "POST http://agrod-site.32server.in.ua/api/v1/products/5",
          "type": "curl"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "product",
            "description": "<p>Returns created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID of created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.1c_id",
            "description": "<p>Id of product in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "product.status",
            "description": "<p>visible status of created object (1 - visible, 0 - unvisible)</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.category_id",
            "description": "<p>id of product category</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.availability",
            "description": "<p>product count of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.price",
            "description": "<p>product price</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.oem",
            "description": "<p>oem of product</p>"
          },
          {
            "group": "Success 200",
            "type": "string[]",
            "optional": false,
            "field": "product.image",
            "description": "<p>Array with main image properties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.image.path",
            "description": "<p>path to main image location</p>"
          },
          {
            "group": "Success 200",
            "type": "object[object]",
            "optional": false,
            "field": "product.productAttachments",
            "description": "<p>array of additional product images with poperties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productAttachments.path",
            "description": "<p>path to additional product image</p>"
          },
          {
            "group": "Success 200",
            "type": "object[translations]",
            "optional": false,
            "field": "product.translations",
            "description": "<p>List of translateable Product attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.translations.language",
            "description": "<p>Language</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 255 symbols",
            "optional": false,
            "field": "product.translations.language.title",
            "description": "<p>Product title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.description",
            "description": "<p>Product description</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.short_description",
            "description": "<p>Product short description</p>"
          },
          {
            "group": "Success 200",
            "type": "number[]",
            "optional": false,
            "field": "product.analogs",
            "description": "<p>Array of Product analogs ids</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "product.characteristics",
            "description": "<p>Array of product characteristics with translations</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.characteristics.language",
            "description": "<p>Language as a key to array</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 255",
            "optional": false,
            "field": "product.characteristics.language.title",
            "description": "<p>Characteristic title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 255",
            "optional": false,
            "field": "product.characteristics.language.value",
            "description": "<p>Characteristic value</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "..max 50",
            "optional": true,
            "field": "product.characteristics.language.measurement",
            "description": "<p>Characteristic measurement</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n   \"id\": 24,\n   \"1c_id\": null,\n   \"position\": 1,\n   \"status\": 1,\n   \"category_id\": 24,\n   \"availability\": 10,\n   \"price\": \"1250.55\",\n   \"oem\": \"testString\",\n   \"image\": {\n       \"path\": \"1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg\",\n       \"base_url\": \"http://storage.agrodruzi.local/source\",\n       \"type\": \"image/jpeg\",\n       \"size\": 1061959,\n       \"name\": null,\n       \"order\": null,\n       \"timestamp\": 1521722357\n   },\n   \"productAttachments\": [\n       {\n           \"id\": 47,\n           \"product_id\": 24,\n           \"path\": \"1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       },\n       {\n           \"id\": 48,\n           \"product_id\": 24,\n           \"path\": \"1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       }\n   ],\n   \"translations\": {\n       \"en-US\": {\n           \"title\": \"Combine\",\n           \"description\": \"Combine description\",\n           \"language\": \"en-US\"\n       },\n       \"uk-UA\": {\n           \"title\": \"Комбайн\",\n           \"description\": \"Опис до комбайну\",\n           \"language\": \"uk-UA\"\n       }\n   },\n   \"analogs\": [\n       \"21\",\n       \"22\"\n   ],\n   \"characteristics\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"Виробник\",\n           \"measurement\": null,\n           \"value\": \"ХТЗ\"\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"Manufacturer\",\n           \"measurement\": null,\n           \"value\": \"HTZ\"\n       }\n   }],\n   \"usedIn\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       }\n   }]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductController.php",
    "groupTitle": "Product"
  },
  {
    "type": "PUT",
    "url": "/products/:id",
    "title": "Update product",
    "name": "Update_product",
    "group": "Product",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 50",
            "optional": false,
            "field": "1c_id",
            "description": "<p>Id of product in 1C</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "position",
            "description": "<p>Product order on the site (need for custom sorting)</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": true,
            "field": "status",
            "defaultValue": "1",
            "description": "<p>Product status (visibility)</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "category_id",
            "description": "<p>id of product category.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "availability",
            "description": "<p>Product count.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "price",
            "description": "<p>Product price.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "oem",
            "description": "<p>Product OEM.</p>"
          },
          {
            "group": "Parameter",
            "type": "string[]",
            "optional": true,
            "field": "images",
            "description": "<p>Product images. <br><b>Note</b>: the first image in array is the main image</p>"
          },
          {
            "group": "Parameter",
            "type": "object[translations]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable Product attributes</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "translations.language",
            "description": "<p>Language</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 255 symbols",
            "optional": false,
            "field": "translations.language.title",
            "description": "<p>Product title</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.language.description",
            "description": "<p>Product description</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.language.short_description",
            "description": "<p>Product short description</p>"
          },
          {
            "group": "Parameter",
            "type": "number[]",
            "optional": false,
            "field": "analogs",
            "description": "<p>Array of analogs Product ids</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "characteristics",
            "description": "<p>Array of Product characteristics with their translations</p>"
          },
          {
            "group": "Parameter",
            "type": "object[characteristics]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "characteristics.language",
            "description": "<p>Language is a key of each element of characteristics array</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.title",
            "description": "<p>Title of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.measurement",
            "description": "<p>Measurement of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "characteristics.language.value",
            "description": "<p>Value of Product characteristic</p>"
          },
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "usedIn",
            "description": "<p>Array of Product Used In with their translations</p>"
          },
          {
            "group": "Parameter",
            "type": "object[usedIn]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "usedIn.language",
            "description": "<p>Language is a key of each element of characteristics array</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.title",
            "description": "<p>Title of Product Used In</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "usedIn.language.parent_title",
            "description": "<p>Parent Title of Product Used In</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "PUT http://agrod-site.32server.in.ua/api/v1/products",
          "type": "curl"
        },
        {
          "title": "Request-Example:",
          "content": "   {\n\t\"1c_id\": \"222-asdasd-qweqew\",\n\t\"position\": 1,\n\t\"status\": 1,\n\t\"category_id\": 24,\n\t\"availability\": 10,\n\t\"price\": 1250.55,\n\t\"oem\": \"testString\",\n\t\"images\": [\n\t\t\"2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg\",\n\t\t\"35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg\",\n\t\t\"QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg\"\n\t\t],\n\t\"translations\": {\n\t\t\"uk-UA\": { \n\t\t\t\"description\": \"Опис до комбайну\",\n\t\t\t\"short_description\": \"Короткий опис до комбайну\",\n\t\t\t\"title\": \"Комбайн\"\n\t\t},\n\t\t\"en-US\": { \n\t\t\t\"title\": \"Combine\",\n\t\t\t\"short_description\": \"Short combine description\",\n\t\t\t\"description\": \"Combine description\"\n\t\t}\n\t},\n\t\"analogs\": [\n\t\t21,22\n\t\t],\n\t\"characteristics\": [\n\t\t{\n\t\t\"uk-UA\": {\n\t\t\t\"title\": \"Масимальна швидкість\",\n\t\t\t\"measurement\": \"км\",\n\t\t\t\"value\": \"45\"\n\t\t},\n\t\t\"en-US\": {\n\t\t\t\"title\": \"Max speed\",\n\t\t\t\"measurement\": \"km\",\n\t\t\t\"value\": \"45\"\n\t\t}\n\t},\n\t{\n\t\t\"uk-UA\": {\n\t\t\t\"title\": \"Виробник\",\n\t\t\t\"measurement\": null,\n\t\t\t\"value\": \"ХТЗ\"\n\t\t},\n\t\t\"en-US\": {\n\t\t\t\"title\": \"Manufacturer\",\n\t\t\t\"measurement\": null,\n\t\t\t\"value\": \"HTZ\"\n\t\t}\n\t}\n\t],\n   \"usedIn\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       }\n   }]\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "product",
            "description": "<p>Returns created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID of created Product object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.1c_id",
            "description": "<p>Id of product in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "product.status",
            "description": "<p>visible status of created object (1 - visible, 0 - unvisible)</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.category_id",
            "description": "<p>id of product category</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.availability",
            "description": "<p>product count of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "product.price",
            "description": "<p>product price</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.oem",
            "description": "<p>oem of product</p>"
          },
          {
            "group": "Success 200",
            "type": "string[]",
            "optional": false,
            "field": "product.image",
            "description": "<p>Array with main image properties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.image.path",
            "description": "<p>path to main image location</p>"
          },
          {
            "group": "Success 200",
            "type": "object[object]",
            "optional": false,
            "field": "product.productAttachments",
            "description": "<p>array of additional product images with poperties</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productAttachments.path",
            "description": "<p>path to additional product image</p>"
          },
          {
            "group": "Success 200",
            "type": "object[translations]",
            "optional": false,
            "field": "product.translations",
            "description": "<p>List of translateable Product attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.translations.language",
            "description": "<p>Language</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 255 symbols",
            "optional": false,
            "field": "product.translations.language.title",
            "description": "<p>Product title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.description",
            "description": "<p>Product description</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.translations.language.short_description",
            "description": "<p>Product short description</p>"
          },
          {
            "group": "Success 200",
            "type": "number[]",
            "optional": false,
            "field": "product.analogs",
            "description": "<p>Array of Product analogs ids</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "product.characteristics",
            "description": "<p>Array of product characteristics with translations</p>"
          },
          {
            "group": "Success 200",
            "type": "object[]",
            "allowedValues": [
              "uk-UA",
              "en-US"
            ],
            "optional": false,
            "field": "product.characteristics.language",
            "description": "<p>Language as a key to array</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 255",
            "optional": false,
            "field": "product.characteristics.language.title",
            "description": "<p>Characteristic title</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 255",
            "optional": false,
            "field": "product.characteristics.language.value",
            "description": "<p>Characteristic value</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "size": "max 50",
            "optional": true,
            "field": "product.characteristics.language.measurement",
            "description": "<p>Characteristic measurement</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n   \"id\": 24,\n   \"1c_id\": \"asdad-123123-asdasd-asd\",\n   \"position\": 1,\n   \"status\": 1,\n   \"category_id\": 24,\n   \"availability\": 10,\n   \"price\": \"1250.55\",\n   \"oem\": \"testString\",\n   \"image\": {\n       \"path\": \"1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg\",\n       \"base_url\": \"http://storage.agrodruzi.local/source\",\n       \"type\": \"image/jpeg\",\n       \"size\": 1061959,\n       \"name\": null,\n       \"order\": null,\n       \"timestamp\": 1521722357\n   },\n   \"productAttachments\": [\n       {\n           \"id\": 47,\n           \"product_id\": 24,\n           \"path\": \"1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       },\n       {\n           \"id\": 48,\n           \"product_id\": 24,\n           \"path\": \"1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg\",\n           \"base_url\": \"http://storage.agrodruzi.local/source\",\n           \"created_at\": 1521735435,\n           \"updated_at\": 1521735435,\n           \"order\": null\n       }\n   ],\n   \"translations\": {\n       \"en-US\": {\n           \"title\": \"Combine\",\n           \"description\": \"Combine description\",\n           \"language\": \"en-US\"\n       },\n       \"uk-UA\": {\n           \"title\": \"Комбайн\",\n           \"description\": \"Опис до комбайну\",\n           \"language\": \"uk-UA\"\n       }\n   },\n   \"analogs\": [\n       \"21\",\n       \"22\"\n   ],\n   \"characteristics\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"Виробник\",\n           \"measurement\": null,\n           \"value\": \"ХТЗ\"\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"Manufacturer\",\n           \"measurement\": null,\n           \"value\": \"HTZ\"\n       }\n   }],\n   \"usedIn\": [{\n       \"uk-UA\": {\n           \"language\": \"uk-UA\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       },\n       \"en-US\": {\n           \"language\": \"en-US\",\n           \"title\": \"COMMANDOR\",\n           \"parent_title\": \"Комбайн (укр)\",\n       }\n   }]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductController.php",
    "groupTitle": "Product"
  },
  {
    "type": "post",
    "url": "/product-categories",
    "title": "Create new category",
    "name": "Create_new_category",
    "group": "Product_Category",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 50",
            "optional": false,
            "field": "1c_id",
            "description": "<p>Id of category in 1C</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "position",
            "description": "<p>category order on the site</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "parent_id",
            "defaultValue": "null",
            "description": "<p>id of parent category. If this category is parent set this value as null</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": true,
            "field": "visible",
            "defaultValue": "1",
            "description": "<p>category visibility</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[translations]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "POST http://agrod-site.32server.in.ua/api/v1/product-categories",
          "type": "curl"
        },
        {
          "title": "Request-Example:",
          "content": "{\n\"position\": 1,\n\"parent_id\": null,\n\"1c_id\": \"1cfd-sdf-sdf-sdf\",\n\"visible\": 1,\n\"translations\": {\n\t\"uk-UA\": { \n\t\t\"title\": \"NEW Category Name\"\n\t\t\"description\": \"NEW test description\",\n\t},\n\t\"en-US\": { \n\t\t\"title\": \"first_category\",\n\t\t\"description\": \"test description\"\n     }\n }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "ProductCategory",
            "description": "<p>Returns created ProductCategory object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "ProductCategory.1c_id",
            "description": "<p>Id of category in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.id",
            "description": "<p>ID of created ProductCategory</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.parent_id",
            "description": "<p>id of parent category of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.visible",
            "description": "<p>visible status of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 201 OK\n{\n\"id\" : 5, \n\"position\": 1,\n\"parent_id\": null,\n\"visible\": 1,\n\"translations\": {\n\t\"uk_UA\": { \n\t\t\"title\": \"first_category\",\n\t\t\"description\": \"test description\"\n\t},\n\t\"en-US\": { \n\t\t\"title\": \"first_category\",\n\t\t\"description\": \"test description\"\n\t}\n}\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductCategoryController.php",
    "groupTitle": "Product_Category"
  },
  {
    "type": "DELETE",
    "url": "/product-categories/:id",
    "title": "Delete category by id",
    "name": "Delete_category",
    "group": "Product_Category",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>category id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "DELETE http://agrod-site.32server.in.ua/api/v1/product-categories/1",
          "type": "curl"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 204 No Content",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductCategoryController.php",
    "groupTitle": "Product_Category"
  },
  {
    "type": "GET",
    "url": "/product-categories",
    "title": "Get all product categories",
    "name": "Get_all_product_categories",
    "group": "Product_Category",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "examples": [
        {
          "title": "Call api method example:",
          "content": "GET http://agrod-site.32server.in.ua/api/v1/product-categories",
          "type": "curl"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "ProductCategory",
            "description": "<p>Returns created ProductCategory object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "ProductCategory.1c_id",
            "description": "<p>Id of category in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.id",
            "description": "<p>ID of created ProductCategory</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.parent_id",
            "description": "<p>id of parent category of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.visible",
            "description": "<p>visible status of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 201 OK\n[\n     {\n         \"id\": 24,\n         \"1c_id\": null,\n         \"position\": 1,\n         \"parent_id\": null,\n         \"visible\": 1,\n         \"translations\": [\n             {\n                 \"title\": \"Комбайн\",\n                 \"description\": \"Описание для категории\"\n             },\n             {\n                 \"title\": \"Combine\",\n                 \"description\": \"Description of combine category2\"\n             }\n         ]\n     },\n     {\n         \"id\": 25,\n         \"1c_id\": null,\n         \"position\": 1,\n         \"parent_id\": null,\n         \"visible\": 1,\n         \"translations\": [\n             {\n                 \"title\": \"Комбайн\",\n                 \"description\": \"Описание для категории\"\n             },\n             {\n                 \"title\": \"Combine\",\n                 \"description\": \"Description of combine category2\"\n             }\n         ]\n     }\n  ]",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductCategoryController.php",
    "groupTitle": "Product_Category"
  },
  {
    "type": "GET",
    "url": "/product-categories/:id",
    "title": "Get product category by id",
    "name": "Get_product_category_by_id",
    "group": "Product_Category",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Product Category id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "GET http://agrod-site.32server.in.ua/api/v1/product-categories/5",
          "type": "curl"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "ProductCategory",
            "description": "<p>Returns created ProductCategory object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "ProductCategory.1c_id",
            "description": "<p>Id of category in 1C</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.id",
            "description": "<p>ID of created ProductCategory</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.parent_id",
            "description": "<p>id of parent category of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.visible",
            "description": "<p>visible status of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 OK     \n    {\n        \"id\": 1,\n        \"1c_id\": null,\n        \"position\": 1,\n        \"parent_id\": null,\n        \"visible\": 1,\n        \"translations\": [\n            {\n                \"title\": \"Комбайн\",\n                \"description\": \"Описание для категории\"\n            },\n            {\n                \"title\": \"Combine\",\n                \"description\": \"Description of combine category2\"\n            }\n        ]\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductCategoryController.php",
    "groupTitle": "Product_Category"
  },
  {
    "type": "PUT",
    "url": "/product-categories/:id",
    "title": "Update category",
    "name": "Update_category",
    "group": "Product_Category",
    "version": "1.0.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Content-Type",
            "description": "<p>application/json</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>uses HTTP Basic Authentication</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Basic YXBpZG9jOmFwaWRvYw==\" \n    \n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "size": "max 50",
            "optional": false,
            "field": "1c_id",
            "description": "<p>Id of category in 1C database</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "position",
            "description": "<p>category order position on the site</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "parent_id",
            "defaultValue": "null",
            "description": "<p>id of parent category. If this category is parent set this value as null</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "allowedValues": [
              "0",
              "1"
            ],
            "optional": true,
            "field": "visible",
            "defaultValue": "1",
            "description": "<p>category visibility</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[translations]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Call api method example:",
          "content": "PUT http://agrod-site.32server.in.ua/api/v1/product-categories/1",
          "type": "curl"
        },
        {
          "title": "Request-Example:",
          "content": "{\n\"1c_id\": \"123-asd-231-asd\",\n\"position\": 1,\n\"parent_id\": null,\n\"visible\": 1,\n\"translations\": {\n\t\"uk-UA\": { \n\t\t\"title\": \"NEW Category Name\"\n\t\t\"description\": \"NEW test description\",\n\t},\n\t\"en-US\": { \n\t\t\"title\": \"first_category\",\n\t\t\"description\": \"test description\"\n     }\n }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "ProductCategory",
            "description": "<p>Returns created ProductCategory object</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "ProductCategory.1c_id",
            "description": "<p>Id of category in 1C database</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.id",
            "description": "<p>ID of created ProductCategory</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.position",
            "description": "<p>order position of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.parent_id",
            "description": "<p>id of parent category of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "ProductCategory.visible",
            "description": "<p>visible status of created object</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "translations",
            "description": "<p>List of translateable category attributes</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.title",
            "description": "<p>Category title</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "translations.description",
            "description": "<p>Category description</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n\"1c_id\": \"123-asd-231-asd\",\n\"id\" : 5, \n\"position\": 1,\n\"parent_id\": null,\n\"visible\": 1,\n\"translations\": {\n\t\"uk_UA\": { \n\t\t\"title\": \"New first_category\",\n\t\t\"description\": \"New test description\"\n\t},\n\t\"en-US\": { \n\t\t\"title\": \"first_category\",\n\t\t\"description\": \"test description\"\n\t}\n}\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/ProductCategoryController.php",
    "groupTitle": "Product_Category"
  }
] });
