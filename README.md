<p align="center"><img src="https://i.imgur.com/PtAzIZ6.png" alt="dollseCRUB" align="center" width="200" style="border-radius:5px" ></p>

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

```html
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

1. [Where/Or Where Condition](#to-use-whereor-where-condition "Where Condition")
2. [Select Columns for View (in List)](#select-columns-for-view-in-list "Select Columns for View (in List)")
3. [Select Columns for View](#select-columns-for-view "Select Columns for View")
4. [Select Columns for Edit Form](#select-columns-for-edit-form "Select Columns for Edit Form")
5. [Select Columns for Add Form](#select-columns-for-add-form "Select Columns for Add Form")
6. [Select Bootstrap Version](#select-bootstrap-version "Select Bootstrap Version")
7. [Unset Jquery, Bootstrap, Jquery UI](#unset-jquery-bootstrap-jquery-ui "Unset Jquery, Bootstrap, Jquery UI")
8. [Unset Edit, Add,Remove or Detail View](#unset-edit-add-or-detail-view "Unset Edit, Add or Detail View")
9. [Custom Button](#custom-button "Custom Button")
10. [Edit Titles](#edit-titles "Edit Titles")
11. [Miscellaneous Functions](#miscellaneous-functions "Miscellaneous Functions")

### To use Where/Or Where Condition:

```php
$this->load->library('dollse_crud'); /// loaded Library
$this->dollse_crud->table('market'); /// Set table
$this->dollse_crud->where(array('id'=> 7, 'email'=>'example@dd.com')); /// called where condition in array format
$this->dollse_crud->or_where(array('name'=>'User One')); /// called or where condition in array format
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

### Unset Edit, Add or Detail View
> If you choose not to allow editing, adding or detail view of perticular table you may try below:
```php
$this->dollse_crud->unset_view(); /// to unset detail view option
$this->dollse_crud->unset_edit(); /// to unset edit option
$this->dollse_crud->unset_remove(); /// to unset remove option
$this->dollse_crud->unset_add(); /// to unset add option
```

### Custom Button
> If you want to add custom button in list view you may try this
```php
$this->dollse_crud->button(array('Receipt', 'url', 'html'));
/// id will be automatically appended after url. eg: abcd.com/site/receip/id
```

### Edit Titles
> You may change titles using simple functions
```php
$this->dollse_crud->list_title('List of Users');
$this->dollse_crud->edit_title('Edit User Record');
$this->dollse_crud->view_title('Detail of User');
$this->dollse_crud->add_title('Add New User');
$this->dollse_crud->add_button_title('Add User'); // Title to set at Add Button
```
### Miscellaneous Functions
> Fetch (Pull) Specific id from different table using given id.
```php
$this->dollse_crud->pull_data($field_name, $table_name, $column_name);
        /// $column_name = column name of currrent table
        /// $table_name = table name of second table
        /// $field_name = column name of second table that we want to select;
## Example: $this->dollse_crud->pull_data('name', 'member', 'member_id');
## Suppose current table name is "profile" then this will fetch record from member table like this way:
## SELECT member.name FROM member WHERE id = profile.member_id ; //this is not JOIN, just an example
```
