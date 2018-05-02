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
2. [Select Columns for View (in List)](#select-columns-for-view-in-list "Select Columns for View (in List)")
3. [Select Columns for View](#select-columns-for-view "Select Columns for View")
4. [Select Columns for Edit Form](#select-columns-for-edit-form "Select Columns for Edit Form")
5. [Select Columns for Add Form](#select-columns-for-add-form "Select Columns for Add Form")
6. [Select Bootstrap Version](#select-bootstrap-version "Select Bootstrap Version")

### To use Where Condition:

```php
$this->load->library('dollse_crud'); /// loaded Library
$this->dollse_crud->table('market'); /// Set table
$this->dollse_crud->where('id', 7); /// called where condition
```
### Select Columns for View (in List)
> This will select specific columns at list view, not editing or adding or not in detail view.
```php
$this->dollse_crud->field_names('id, name, address');
```
### Select Columns for View
> This will select specific columns for display purpose only in detail, not editing nor adding nor list view
```php
$this->dollse_crud->view_columns('id, name, address');
```
### Select Columns for Edit Form
> This will select specific columns to show in editing form
```php
$this->dollse_crud->edit_columns('id, name, address');
```
### Select Columns for Add Form
> This will select specific columns to show in Add Record form
```php
$this->dollse_crud->add_columns('id, name, address');
```
### Select Bootstrap Version
> Either You may Use Bootstrap 3 or Bootstrap 4. (Default is Bootstrap 4)
```php
$this->dollse_crud->set_bootstrap('3'); /// 3 or 4 (It will load via CDN)
```
### Unset Jquery, Bootstrap, Jquery UI
> Either You may choose not to load jquery, bootstrap or jquery ui
```php
$this->dollse_crud->unset_jquery(); /// to unset jquery from loading
$this->dollse_crud->unset_jqueryui(); /// to unset jqueryui from loading
$this->dollse_crud->unset_bootstrap(); /// to unset bootstrap from loading
```