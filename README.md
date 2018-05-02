![Dollse CRUD]({{site.baseurl}}/https://i.imgur.com/PtAzIZ6.png)

## Welcome to dollseCRUD

DollseCRUD is codeigniter 3 & bootstrap 3/4 based **Create, Retrieve, Update, Delete** library. Simple and full featured.

## Docmentation

- Configuration
- Simple Usages
- Available Functions

### CONFIGURATION:
Configuration is very simple.. Just copy and paste the library and model folder inside your codeigniter application directory.
> Requirement: database library need to be loaded.

### SIMPLE USAGES:
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
