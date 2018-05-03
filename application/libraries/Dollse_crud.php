<?php
/**
 * Dollse CRUD
 *
 * An open source Database CRUB library for Codeigniter 3+.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c), Dollse (www.dollse.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package      Dollse CRUD
 * @author       Dollse Developer Team
 * @lead         Developer: Haren Sarma (facebook.com/harensarmax)
 * @copyright    Copyright (c) Dollse IT Services Private Limited (www.dollse.com)
 * @license      http://opensource.org/licenses/MIT	MIT License
 * @link         https://dollse.com/crud
 * @since        Version 1.0.0
 * @filesource
 * @filetype     Codeigniter Custom Library
 */

class Dollse_crud
{

    private $table;
    private $where = "";
    private $where2 = ""; /// Optional
    private $order_by_start = "";
    private $order_by_end = "";
    private $limit_start = "";
    private $limit_end = "";
    private $field_names = "";
    private $view_columns = "";
    private $edit_columns = "";
    private $add_columns = "";
    private $load_add = 1;
    private $load_view = 1;
    private $load_edit = 1;
    private $load_remove = 1;
    private $load_jquery = 1;
    private $load_bootstrap = 1;
    private $load_jquery_ui = 1;
    private $button = '';
    private $list_title = '';
    private $edit_title = '';
    private $view_title = '';
    private $add_title = '';
    private $add_button_title = '';

    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();
        $this->CI->load->model('crud_model');
    }

    public function unset_view()
    {
        $this->load_view = 0;
    }

    public function unset_add()
    {
        $this->load_add = 0;
    }

    public function unset_edit()
    {
        $this->load_edit = 0;
    }

    public function unset_remove()
    {
        $this->load_remove = 0;
    }

    public function unset_jquery()
    {
        $this->load_jquery = 0;
    }

    public function unset_jqueryui()
    {
        $this->load_jquery_ui = 0;
    }

    public function unset_bootstrap()
    {
        $this->load_bootstrap = 0;
    }

    public function set_bootstrap($version)
    {
        $this->CI->crud_model->set_bootstrap($version);
    }

    public function list_title($title)
    {
        $this->list_title = $title;
    }

    public function edit_title($title)
    {
        $this->edit_title = $title;
    }

    public function view_title($title)
    {
        $this->view_title = $title;
    }

    public function add_title($title)
    {
        $this->add_title = $title;
    }

    public function add_button_title($title)
    {
        $this->add_button_title = $title;
    }

    public function header()
    {
        $params = array(
            'add'       => $this->load_add,
            'view'      => $this->load_view,
            'edit'      => $this->load_edit,
            'remove'    => $this->load_remove,
            'jquery'    => $this->load_jquery,
            'bootstrap' => $this->load_bootstrap,
            'jquery_ui' => $this->load_jquery_ui,
        );

        return $this->CI->crud_model->header($params, $this->table);
    }

    public function table($table_name)
    {
        $this->table = $table_name;

    }

    public function button($array)
    {
        $this->button = $array;
    }

    public function where($condition_array, $param2)
    {
        if (trim($param2) == ""):
            $this->where = $condition_array;
        else:
            $this->where  = $condition_array;
            $this->where2 = $param2;
        endif;
    }

    public function order_by($start, $end = 'ASC')
    {
        $this->order_by_start = $start;
        $this->order_by_end   = $end;

    }

    public function limit($start, $end = 0)
    {
        $this->limit_start = $start;
        $this->limit_end   = $end;
    }

    public function field_names($columns)
    {
        $this->field_names = $columns;
    }

    public function view_columns($columns)
    {
        $this->view_columns = $columns;
    }

    public function edit_columns($columns)
    {
        $this->edit_columns = $columns;
    }

    public function add_columns($columns)
    {
        $this->add_columns = $columns;
    }

    public function view($select = '*')
    {
        if ($this->CI->uri->segment('3') == "view"):
            $this->where  = "id";
            $this->where2 = $this->CI->uri->segment(4);
            if (trim($this->view_columns) == "") {
                $this->view_columns = $select;
            } else {
                $select = $this->view_columns;
            }
            $data = $this->generate_query($select);
            return $this->CI->crud_model->view($data, $this->view_columns, $this->view_title);
        elseif ($this->CI->uri->segment('5') == "edit"):
            $this->where  = "id";
            $this->where2 = $this->CI->uri->segment(4);

            $array = array();
            foreach ($_POST as $name => $value) {
                $array = array_merge($array, array($name => html_escape($value)));
            }
            $this->CI->db->where('id', $this->CI->uri->segment(4));
            $this->CI->db->update($this->table, $array);
            $this->CI->load->library('session');
            $this->CI->session->set_flashdata('dollsecrud_flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> The record is successfully updated.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
            redirect(site_url($this->CI->router->fetch_class() . '/' . $this->CI->router->fetch_method()));
        elseif ($this->CI->uri->segment('4') == "save"):

            $array = array();
            foreach ($_POST as $name => $value) {
                $array = array_merge($array, array($name => html_escape($value)));
            }
            $this->CI->db->insert($this->table, $array);
            $id = $this->CI->db->insert_id();
            $this->CI->load->library('session');
            if (trim($id) <= 0) {
                $this->CI->session->set_flashdata('dollsecrud_flash', '<div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
  <strong>Database Error !</strong> Unable to save your records. Please Try Later.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
                redirect(site_url($this->CI->router->fetch_class() . '/' . $this->CI->router->fetch_method() . '/add'));
            } else {
                $this->CI->session->set_flashdata('dollsecrud_flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> The record is successfully Saved. The Id is: <strong>' . $id . '</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
                redirect(site_url($this->CI->router->fetch_class() . '/' . $this->CI->router->fetch_method()));
            }
        elseif ($this->CI->uri->segment('3') == "edit"):
            $this->where  = "id";
            $this->where2 = $this->CI->uri->segment(4);
            if (trim($this->edit_columns) == "") {
                $this->edit_columns = $select;
            } else {
                $select = $this->edit_columns;
            }
            $data = $this->generate_query($select);
            return $this->CI->crud_model->edit($data, $this->edit_columns, $this->edit_title);
        elseif ($this->CI->uri->segment('3') == "add"):
            if (trim($this->add_columns) == "") {
                $this->add_columns = $select;
            } else {
                $select = $this->add_columns;
            }
            return $this->CI->crud_model->add($this->table, $select, $this->add_title);
        elseif ($this->CI->uri->segment('3') == "remove"):

            $this->CI->crud_model->remove($this->table);
            $this->CI->load->library('session');
            $this->CI->session->set_flashdata('dollsecrud_flash', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success!</strong> The record is successfully deleted.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
            redirect(site_url($this->CI->router->fetch_class() . '/' . $this->CI->router->fetch_method()));
        else:
            if (trim($this->field_names) !== "") {
                $select = $this->field_names;
            } else {
                $this->field_names = $select;
            }
            $data = $this->generate_query($select);
            return $this->CI->crud_model->template_list($data, $this->field_names, $this->button, $this->list_title, $this->add_button_title);
        endif;

    }

    private function generate_query($fields)
    {
        return $this->CI->crud_model->query(
            $this->table,
            $fields,
            $this->where,
            $this->where2,
            $this->order_by_start,
            $this->order_by_end,
            $this->limit_start,
            $this->limit_end
        );
    }

}
