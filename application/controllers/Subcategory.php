<?php

class Subcategory extends
    CI_Controller
{
    public function index()
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        $this->load->model('Home_model');
        $data = $this->Subcategory_model->index(($_SESSION['user']['user_id']));
        $this->load->view('subcategory/index', ['data' => $data]);
    }

    public function add_subcategory()
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        $this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'required');
        $this->form_validation->set_rules('is_visible', 'is_visible', 'required');

        $this->load->model('Category_model');
        $this->load->model('Home_model');
        $parent = $this->Category_model->index($_SESSION['user']['user_id']);
        $data = $this->Subcategory_model->index($_SESSION['user']['user_id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->form_validation->run() == false) {
                $this->load->view('subcategory/add_subcategory', ['parent' => $parent]);
            } else {
                $data = array();
                $data['name'] = $_POST['subcategory_name'];
                $data['category'] = $_POST['category_name'];
                $data['is_visible'] = $_POST['is_visible'];
                $data['user_id']= $_SESSION['user']['user_id'];
                $this->Subcategory_model->create_subcategory($data);
                redirect('subcategory/index');
            }
        } else {
            $this->load->view('subcategory/add_subcategory', ['parent' => $parent]);
        }
    }

    public function update_subcategory($id)
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        $this->load->model('Category_model');
        $this->load->model('Home_model');
        $parent = $this->Category_model->index($_SESSION['user']['user_id']);
        $data = $this->Subcategory_model->index($_SESSION['user']['user_id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('name', 'Subcategory Name', 'required');
            $this->form_validation->set_rules('is_visible', 'Visibility', 'required');

            if (array_key_exists('is_visible', $_POST) == false || $this->form_validation->run() == false) {
                $data = $this->Subcategory_model->get_subcategory($id);
                return $this->load->view('subcategory/update_subcategory', ['parent' => $parent, 'data' => $data]);
            } else {
                $data = array();
                $data['name'] = $_POST['name'];
                $data['category'] = $_POST['category_name'];
                $data['is_visible'] = $_POST['is_visible'];
                $data['user_id'] = $_SESSION['user']['user_id'];
                $this->Subcategory_model->update_subcategory($id, $data);
                return $this->index();
            }
        } else {
            $data = $this->Subcategory_model->get_subcategory($id);
            $this->load->view('subcategory/update_subcategory', ['parent' => $parent, 'data' => $data
            ]);
        }
    }

    public function delete_subcategory($id)
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        $this->load->model('Home_model');
        $this->Subcategory_model->delete_subcategory($id);
        return $this->index();
    }
}
