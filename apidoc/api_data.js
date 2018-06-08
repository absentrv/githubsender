define({ "api": [
  {
    "type": "post",
    "url": "/users/send-message",
    "title": "Send messages to github users",
    "permission": [
      {
        "name": "logged user"
      }
    ],
    "name": "Send_message",
    "group": "User_Actions",
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
            "description": "<p>Uses BearerAuth</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\",\n    \"Authorization\": \"Bearer jVPxD-xmHH7OWWNP_jwpTKG_RUEdeSaz3jETF-xi\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Email message for users which will be sended</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "users",
            "description": "<p>Array of usernames from github.com</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "users[]",
            "description": "<p>First username</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"message\": \"Hello my dear developers!\",\n  \"users\": [\"samdark\", \"absentrv\"],\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>Returns result of api result</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Returned api data (for this method empty array is normal)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"success\": true,\n   \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Data",
            "description": "<p>validation errors</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Data-Validation-Error-Response:",
          "content": "HTTP/1.1 422 Data Validation Failed.\n{\n \"success\": false,\n \"data\": [\n   {\n       \"field\": \"message\",\n       \"message\": \"Message cannot be blank.\"\n   },\n   {\n       \"field\": \"users\",\n       \"message\": \"Users cannot be blank.\"\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/UserController.php",
    "groupTitle": "User_Actions"
  },
  {
    "type": "post",
    "url": "/users/sign-in",
    "title": "Sign in for registered user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "name": "Sign_in_user",
    "group": "User_Authorization",
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
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User e-mail</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User password</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"email\": \"test@test.com\",\n  \"password\": \"secredPassword123\",\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>Returns result of api result</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Created User data</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "data.id",
            "description": "<p>User's id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.original_image",
            "description": "<p>User's original avatar path</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.thumbnail",
            "description": "<p>User's avatar thumbnail path</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.access_token",
            "description": "<p>User's token to access api</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.email",
            "description": "<p>User's email</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"success\": true,\n   \"data\": {\n       \"id\": 43,\n       \"originalImage\": \"http://gitsender.local/images/uploads/5b1a34af28b33.png\",\n       \"access_token\": \"XSFb0Q10epQdIf9W1YgtzXUoaunkUpK9QXnPLKhj\",\n       \"email\": \"test@test.ua\",\n       \"thumbnail\": \"http://gitsender.local/images/uploads/thumbnail_5b1a34af28b33.png\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Data",
            "description": "<p>validation errors</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Data-Validation-Error-Response:",
          "content": "HTTP/1.1 422 Data Validation Failed.\n{\n \"success\": false,\n \"data\": [\n     {\n         \"field\": \"password\",\n         \"message\": \"Password cannot be blank.\"\n     },\n     {\n         \"field\": \"password\",\n         \"message\": \"Incorrect email or password.\"\n     }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/UserController.php",
    "groupTitle": "User_Authorization"
  },
  {
    "type": "post",
    "url": "/users/sign-up",
    "title": "Sign up for user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "name": "Sign_up_user",
    "group": "User_Authorization",
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
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Content-Type\": \"application/json\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User e-mail</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>User password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<p>User avatar encoded as base64</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"email\": \"test@test.com\",\n  \"password\": \"secredPassword123\",\n  \"avatar\": \"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMEAAAEFAA...\",\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>Returns result of api result</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Created User data</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.access_token",
            "description": "<p>User token</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "data.thumbnail",
            "description": "<p>User avatar thumbnail path</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 Created\n{\n   \"success\": true,\n   \"data\": {\n       \"access_token\": \"P7hoG41F-sIoIyGK_TcgRvIAy4pjcSr6ljJDEiZX\",\n       \"thumbnail\": \"http://gitsender.local/images/uploads/thumbnail_5b1a34af28b33.png\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Data",
            "description": "<p>validation errors</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Data-Validation-Error-Response:",
          "content": "HTTP/1.1 422 Data Validation Failed.\n{\n \"success\": false,\n \"data\": [\n     {\n         \"field\": \"password\",\n         \"message\": \"Password cannot be blank.\"\n     },\n     {\n         \"field\": \"email\",\n         \"message: \"E-mail \\\"test@test.ua\\\" has already been taken\"\n     }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "frontend/modules/api/v1/controllers/UserController.php",
    "groupTitle": "User_Authorization"
  }
] });
