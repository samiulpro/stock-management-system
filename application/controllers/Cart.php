<?php

class Cart extends
    CI_Controller
{
    public function index()
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        $this->load->model('Cart_model');
        $data = $this->Cart_model->index($_SESSION['user']['user_id']);
        $total_price = $this->Cart_model->total_price($_SESSION['user']['user_id']);
        if(count($data)==0){
            $item = array(
                'color' => 'red',
                'message' => 'Cart is empty'
            );
            $this->session->set_tempdata($item, NULL, 3);
        }
        $this->load->view('cart/index', ['data' => $data, 'total_price' => $total_price]);

    }

    public function add_cart()
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');

        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
        $this->load->model('Product_model');
        $this->load->model('Cart_model');
        $product = $this->Product_model->index($_SESSION['user']['user_id']);

        $data = array();
        $data['product'] = $data['quantity'] = $data['checked'] = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->form_validation->run() == false) {
                $data = $_POST;
                $this->load->view('cart/add_cart', ['data' => $data]);
            } else {
                $data['product'] = $_POST['product'];
                $data['quantity'] = $_POST['quantity'];
                $data['user_id'] = $_SESSION['user']['user_id'];
                $data['checked'] = 'no';

                //Query for product id
                $query = $this->Product_model->get_id($_POST['product'], $_SESSION['user']['user_id']);
                $id = $query['id'];
                $price = $query['price'];
                $stock = $query['stock'];

                //Updating net price
                $data['net_price'] = (int)$price * (int)$_POST['quantity'];

                //Query for product stock
                $updated_stock = (int)$stock - (int)$_POST['quantity'];
                $this->Product_model->update_stock($id, $updated_stock);

                $this->Cart_model->add_cart($data);
                redirect(base_url() . 'cart/index');
            }
        } else {
            $this->load->view('cart/add_cart', ['data' => $data, 'product' => $product]);
        }
    }

    public function update_cart($id)
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');

        $this->form_validation->set_rules('quantity', 'Quantity', 'required');

        $this->load->model('Product_model');
        $this->load->model('Cart_model');
        $product = $this->Product_model->index($_SESSION['user']['user_id']);

        $data = array();
        $data['product'] = $data['quantity'] = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->form_validation->run() == false) {
                $data = $_POST;
                $this->load->view('cart/update_cart', ['data' => $data, 'product' => $product]);
            } else {
                $data['product'] = $_POST['product'];
                $data['quantity'] = $_POST['quantity'];
                $data['user_id'] = $_SESSION['user']['user_id'];
                $data['checked'] = 'no';

                //Query for product id
                $query = $this->Product_model->get_id($_POST['product'], $_SESSION['user']['user_id']);
                $product_id = $query['id'];
                $price = $query['price'];
                $stock = (int)$query['stock'];

                //Query for product name
                $query = $this->Cart_model->get_name_quantity($id);
                $quantity = (int)$query['quantity'];
                $cart_quantity = (int)$_POST['quantity'];

                //Updating net price
                $data['net_price'] = (int)$price * (int)$_POST['quantity'];

                //Query for product stock
                $updated_stock = $quantity >= $cart_quantity ? $stock + ($quantity - $cart_quantity) : $stock - ($cart_quantity - $quantity);
                $this->Product_model->update_stock($product_id, $updated_stock);

                $this->Cart_model->update_cart($id, $data);
                redirect(base_url() . 'cart/index');
            }
        } else {
            $data = $this->Cart_model->get_cart($id);
            $this->load->view('cart/update_cart', ['data' => $data, 'product' => $product]);
        }
    }

    public function delete_cart($id)
    {
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');

        $this->load->model('Cart_model');
        $this->load->model('Product_model');

        //Query for product name
        $query = $this->Cart_model->get_name_quantity($id);
        $name = $query['product'];
        $quantity = $query['quantity'];

        //Query for product id
        $query = $this->Product_model->get_id($name);
        $product_id = $query['id'];
        $stock = $query['stock'];

        //Query for product stock
        $updated_stock = (int)$stock + (int)$quantity;
        $this->Product_model->update_stock($product_id, $updated_stock);

        $this->Cart_model->delete_cart($id);
        redirect(base_url() . 'cart/index');
    }
}
