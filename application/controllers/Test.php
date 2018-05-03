<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function index()
    {
        $this->load->library('dollse_crud');
        $this->dollse_crud->table('member');
        //$this->dollse_crud->where('id', 7);
        $this->dollse_crud->add_columns('id, currency_name, market_code');
        $this->dollse_crud->list_title('List of Users');
        $this->dollse_crud->edit_title('Edit User Record');
        $this->dollse_crud->view_title('Detail of User');
        $this->dollse_crud->add_title('Add New User');
        $this->dollse_crud->add_button_title('Add User');
        //  $this->dollse_crud->button(array('Receipt', 'url'));
        $data['header'] = $this->dollse_crud->header();
        $data['view']   = $this->dollse_crud->view();
        $this->load->view('site_index', $data);
    }
}
