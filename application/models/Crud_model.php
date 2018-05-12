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
 * @copyright    Copyright (c) Dollse IT Services Private Limited (www.dollse.com)
 * @license      http://opensource.org/licenses/MIT	MIT License
 * @link         https://dollse.com/crud
 * @since        Version 1.0.0
 * @filesource
 * @filetype     Codeigniter Model
 */
class Crud_model extends CI_Model
{

    private $table_name;
    private $allow_edit;
    private $allow_view;
    private $allow_remove;
    private $allow_add;
    private $bootstrap_version = 4;
    private $pull_data;

    public function __construct()
    {
        parent::__construct();

    }

    public function set_bootstrap($version)
    {
        $this->bootstrap_version = $version;
    }

    public function query
    (
        $table_name,
        $select_data,
        $where_1,
        $where_2,
        $order_by_start,
        $order_by_end,
        $limit_start,
        $limit_end,
        $pull_data
    )
    {
        $this->table_name = $table_name;
        if ($select_data !== "*") {
            $select_data = "id," . $select_data;
        }
        $this->db->select($select_data);
        if (trim($where_1) !== "" || trim($where_2) !== ""):
            if (trim($where_2) == "") {
                $this->db->where($where_1);
            } else {
                $this->db->where($where_1, $where_2);
            }
        endif;
        if (trim($order_by_start) !== ""):
            $this->db->order_by($order_by_start, $order_by_end);
        endif;

        if (trim($limit_start) !== ""):
            $this->db->limit($limit_start, $limit_end);
        endif;

        $this->pull_data = $pull_data;

        $data = $this->db->get($table_name)->result_array();
        return $data;
    }

    public function header($params, $table)
    {
        $this->allow_view   = $params['view'];
        $this->allow_edit   = $params['edit'];
        $this->allow_remove = $params['remove'];
        $this->allow_add    = $params['add'];

        $data = null;
        if ($params['bootstrap'] === 1) {
            $data = $this->bootstrap_css();
        }
        if ($params['jquery_ui'] === 1) {
            $data .= $this->jquery_ui_css();
        }
        $data .= $this->icon();
        if ($params['jquery'] === 1) {
            $data .= $this->jquery();
        }
        if ($params['jquery_ui'] === 1) {
            $data .= $this->jquery_ui_js();
        }
        if ($params['bootstrap'] === 1) {
            $data .= $this->bootstrap_js();
        }
        return $data;
    }

    private function select($field_name, $table_name, $where)
    {
        $this->db->select($field_name)->where($where);
        return $this->db->get($table_name)->row()->$field_name;
    }

    public function template_list($data, $field_names, $button = '', $title, $add_btn_title)
    {
        $this->load->library('session');
        $result = null;
        if ($this->allow_add === 1) {
            $result .= '<p><a href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '/add' . '" class="btn btn-sm btn-info">' . ($add_btn_title ? $add_btn_title : 'Add Record') . '</a></p>
' . $this->session->flashdata('dollsecrud_flash') . '
';
        }
        $result .= '<div class="col-sm-1"></div>
        <div class="table-responsive" style="margin: 10px">
        <h4 class="float-right pull-left text-secondary">' . ($title ? $title : 'List of Records') . '</h4>
<table id="' . $this->table_name . '" class="table table-striped table-hover" width="100%" cellspacing="0">
<thead style="background-color: #4a4a4a; color:#fff">
    <tr><th>SN.</th>';
        if ($field_names == "*") {
            $field_data = $this->db->list_fields($this->table_name);
            foreach ($field_data as $val) {
                if ($val !== "id"):
                    $val    = str_ireplace("_", " ", $val);
                    $result .= '<th>' . ucwords($val) . '</th>';
                endif;
            }
        } else {
            $fields = explode(',', trim($field_names));
            foreach ($fields as $val) {
                if ($val !== "id" || in_array('id', explode(',', $field_names)) === true):
                    $val    = str_ireplace("_", " ", $val);
                    $result .= '<th>' . ucwords($val) . '</th>';
                endif;
            }
        }
        if ($this->allow_view == true || is_array($button) || $this->allow_edit == true || $this->allow_remove == true):
            $result .= '
<th style="text-align: right">#</th>';
        endif;
        $result .= '</tr>
</thead>
<tbody>';
        $sn     = 1;
        foreach ($data as $e => $val) {
            $result .= '<tr><td>' . $sn++ . '</td>';
            foreach ($val as $key => $value):
                if ($key == 'id' && $field_names == "*") {
                    echo 1;
                    unset($value);
                } else if ($key == 'id' && $field_names !== "*" && in_array('id', explode(',', $field_names)) === false) {
                    unset($value);
                } else {
                    if (trim($this->pull_data) !== "" && $this->pull_data[2] == $key) {
                        $value = $this->select($this->pull_data[0], $this->pull_data[1], array('id' => $value));
                    }
                    $result .= '
    <td>
    ' . $value . '
</td>';
                }
            endforeach;
            if ($this->allow_view == true || is_array($button) || $this->allow_edit == true || $this->allow_remove == true):
                $dollsecrud_style = '';
                if ($this->bootstrap_version == '3') {
                    $dollsecrud_style = 'style="padding:2px; padding-right:4px"';
                }

                $result .= '<td><div class="btn-group float-right pull-right" role="group" aria-label="Action Buttons">';
                if (is_array($button)) {
                    $result .= '<a class="btn btn-sm btn-xs btn-info" ' . $dollsecrud_style . ' href="' . $button[1] . '/' . $val['id'] . '">' . $button[0] . $button[2] . '</a>';
                }
                if ($this->allow_view == true) {
                    $result .= '<a class="btn btn-sm btn-warning" href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '/view/' . $val['id'] . '"><span class="oi oi-eye"></span></a>';
                }
                if ($this->allow_edit == true) {
                    $result .= '<a class="btn btn-sm btn-warning" href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '/edit/' . $val['id'] . '"><span class="oi oi-pencil"></span></a>';
                }
                if ($this->allow_remove == true) {
                    $result .= '<a onclick="return confirm(\'Are you sure to delete this record ?\')" class="btn btn-sm btn-danger" href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '/remove/' . $val['id'] . '"><span class="oi oi-delete"></span></a>';
                }
                $result .= '</div></td></tr>';
            endif;
        }

        $result .= '
</tbody>
</table></div><div class="col-sm-1"></div>
';

        return $result;
    }

    private function bootstrap_css()
    {
        if ($this->bootstrap_version == 3) {
            return '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
        } else {
            return '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">';
        }
    }

    private function bootstrap_js()
    {
        if ($this->bootstrap_version == 3) {
            return '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
        } else {
            return '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>';
        }
    }

    private function jquery()
    {
        return '
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
    }

    private function jquery_ui_css()
    {
        return '
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/theme.min.css">';
    }

    private function jquery_ui_js()
    {
        return '
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>';
    }

    private function icon()
    {
        return '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">';
    }

    public function view($data, $field_names, $title)
    {
        $view = '<div class="card panel panel-default" style="margin-top: 5px">
  <div class="card-header text-white bg-dark panel-heading" style="background-color: #2A2730; color:#fff">
    ' . ($title ? $title : 'Detail View') . '
  </div>
  <div class="card-body panel-body">
    <p class="card-text">';
        if ($field_names == "*") {
            $field_data = $this->db->list_fields($this->table_name);
            foreach ($field_data as $val) {
                foreach ($data as $fields_val):
                    if ($val !== 'id' && $field_names == "*") {
                        $orginal_val = trim($val);
                        $val         = str_replace("_", " ", $val);
                        $view        .= '<div style="margin-top:2px"><strong>' . ucwords($val) . '</strong>';
                        $view        .= ' :' . $fields_val[$orginal_val] . '</div>';
                    }
                endforeach;
            }
        } else {
            $fields = explode(',', trim($field_names));
            foreach ($fields as $val) {
                foreach ($data as $fields_val):
                    if ($val !== 'id' && $field_names !== "*" && strpos($field_names, 'id') !== false) {
                        $orginal_val = trim($val);
                        $val         = str_replace("_", " ", $val);
                        $view        .= '<div style="margin-top:2px"><strong>' . ucwords($val) . '</strong>';
                        $view        .= ' :' . $fields_val[$orginal_val] . '</div>';
                    }
                endforeach;
            }
        }
        if ($this->bootstrap_version == 4) {
            $outline = '-outline';
        }
        $view .= '</p>
    <a href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '" class="btn btn-sm btn' . $outline . '-info">&larr; Go Back</a>
    <a href="' . current_url() . '" class="btn btn' . $outline . '-warning"><span class="oi oi-reload"></span></a>
  </div>
</div>';
        return $view;
    }

    public function edit($data, $field_names, $title)
    {
        $this->load->helper('form');
        $view       = '<div class="card panel panel-default" style="margin-top: 5px">
  <div class="card-header text-white bg-dark panel-heading" style="background-color: #2A2730; color:#fff">
   ' . ($title ? $title : 'Edit Record') . '
  </div>
  ' . form_open(current_url() . '/edit') . '
  <div class="card-body panel-body">
    <p class="card-text">';
        $form_group = 'form-group-sm';
        if ($this->bootstrap_version == "3") {
            $form_group = 'form-group';
        }
        if ($field_names == "*") {
            $field_data = $this->db->list_fields($this->table_name);
            foreach ($field_data as $val) {
                foreach ($data as $fields_val):
                    if ($val !== 'id' && $field_names == "*") {
                        $orginal_val = trim($val);
                        $val         = str_replace("_", " ", $val);
                        $view        .= '<div class="' . $form_group . '"><label class="font-weight-normal text-dark">' . ucwords($val) . '</label>';
                        $view        .= '<input type="text" style="font-size:12px" class="form-control form-control-lg" value="' . $fields_val[$orginal_val] . '" name="' . $orginal_val . '"></div>';
                    }
                endforeach;
            }
        } else {
            $fields = explode(',', trim($field_names));
            foreach ($fields as $val) {
                foreach ($data as $fields_val):
                    if ($val !== 'id' && $field_names !== "*" && strpos($field_names, 'id') !== false) {
                        $orginal_val = trim($val);
                        $val         = str_replace("_", " ", $val);
                        $view        .= '<div class="form-group-sm"><label class="font-weight-normal text-dark">' . ucwords($val) . '</label>';
                        $view        .= '<input type="text" style="font-size:12px" class="form-control form-control-lg" value="' . $fields_val[$orginal_val] . '" name="' . $orginal_val . '"></div>';
                    }
                endforeach;
            }
        }
        if ($this->bootstrap_version == 4) {
            $outline = '-outline';
        }
        $view .= '</p>
    <a href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '" class="btn btn-sm btn' . $outline . '-info">&larr; Go Back</a>
    <button type="submit" class="btn btn-sm btn-primary"><span class="oi oi-cloud-upload"></span> Save</button>
    <button type="reset" class="btn btn-sm btn' . $outline . '-info">Reset</button>
  </div>
  ' . form_close() . '
</div>';
        return $view;
    }

    public function remove($table_name)
    {
        $this->db->where('id', $this->uri->segment(4));
        $this->db->delete($table_name);
        return;
    }

    public function add($table_name, $field_names = "*", $title)
    {
        $this->load->helper('form');
        $this->load->library('session');
        $view = '<div class="card panel panel-default" style="margin-top: 5px">
  <div class="card-header text-white bg-dark panel-heading" style="background-color: #2A2730; color:#fff">
     ' . ($title ? $title : 'Add Record') . '
  </div>
  ' . $this->session->flashdata('dollsecrud_flash') . '
  ' . form_open(current_url() . '/save') . '
  <div class="card-body panel-body">
    <p class="card-text">';
        if ($field_names == "*") {
            $field_data = $this->db->list_fields($table_name);
            foreach ($field_data as $val) {
                if ($val !== 'id' && $field_names == "*") {
                    $orginal_val = trim($val);
                    $val         = str_replace("_", " ", $val);
                    $form_group  = 'form-group-sm';
                    if ($this->bootstrap_version == "3") {
                        $form_group = 'form-group';
                    }
                    $view .= '<div class="' . $form_group . '"><label class="font-weight-normal text-dark">' . ucwords($val) . '</label>';
                    $view .= '<input type="text" style="font-size:12px" class="form-control form-control-lg" name="' . $orginal_val . '"></div>';
                }
            }
        } else {
            $fields = explode(',', trim($field_names));
            foreach ($fields as $val) {
                if ($val !== 'id' && $field_names !== "*" && strpos($field_names, 'id') !== false) {
                    $orginal_val = trim($val);
                    $val         = str_replace("_", " ", $val);
                    $view        .= '<div class="form-group-sm"><label class="font-weight-normal text-dark">' . ucwords($val) . '</label>';
                    $view        .= '<input type="text" style="font-size:12px" class="form-control form-control-lg" name="' . $orginal_val . '"></div>';
                }
            }
        }
        if ($this->bootstrap_version == 4) {
            $outline = '-outline';
        }
        $view .= '</p>
    <a href="' . site_url($this->router->fetch_class() . '/' . $this->router->fetch_method()) . '" class="btn btn-sm btn' . $outline . '-info">&larr; Go Back</a>
    <button type="submit" class="btn btn-sm btn-primary"><span class="oi oi-task"></span> Add</button>
    <button type="reset" class="btn btn-sm btn' . $outline . '-info">Reset</button>
  </div>
  ' . form_close() . '
</div>';
        return $view;

    }
}
