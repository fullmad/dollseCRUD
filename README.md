![Dollse CRUD](https://i.imgur.com/PtAzIZ6.png)

# Welcome to dollseCRUD

DollseCRUD is codeigniter 3 & bootstrap 3/4 based **Create, Retrieve, Update, Delete** library. Simple and full featured.

# Docmentation

- Configuration
- Simple Usages
- Available Functions

## CONFIGURATION:
Configuration is very simple.. Just copy and paste the library and model folder inside your codeigniter application directory.
> Requirement: database library need to be loaded.

## SIMPLE USAGES:
You can start using this library in just two steps.
1. In your view include  **<?php echo $header; ?>** in head and include **<?php echo $view ?>** inside body elements. example as given below:

```
<html>
<head>
    <?php echo $header; ?>
</head>

<body>
<div class="container">
<?php echo $view ?>
    </div>
</body>
</html>
```

2. In your conntroller just use as below:

```php
        $this->load->library('dollse_crud'); /// initialized dollseCRUD library
        $this->dollse_crud->table('market'); /// Table Name
        $data['header'] = $this->dollse_crud->header();
        $data['view']   = $this->dollse_crud->view();
        $this->load->view('site_index', $data); /// Sending data to view file
```
## AVAILABLE FUNCTIONS
> To use dollse_CRUB inbuilt functions, preferably just call after calling table name. example as given below:

1. [Where Condition](#to-use-where-condition "Where Condition")
2. 

### To use Where Condition:

```php
$this->load->library('dollse_crud'); /// loaded Library
$this->dollse_crud->table('market'); /// Set table
$this->dollse_crud->where('id', 7); /// called where condition
```
