<?php

class Dashboard extends
    CI_Controller
{
    public function index()
    {
        $_SESSION['title']='Dashboard';
        if (!$_SESSION['user']['username'])
            redirect('/accounts/login');
        if ($_SESSION['user']['is_admin']==0)
            redirect('/home/index');
        $this->load->model('Order_model');
        $orders = $this->getOrders();
        $orders=array_slice($orders, 0, 5);
        $today_order = $this->Order_model->today_order();
        $revenue = $total_order = 0;
        foreach ($today_order as $value=>$item) {
            var_dump($today_order);
            $revenue += $value['payable'];
            $total_order++;
        }

        $this->load->model('Product_model');
        $stock_out = $this->Product_model->stock_out();
        $stock_out=array_slice($stock_out, 0, 5);
        $this->load->view('dashboard/index', [
            'orders' => $orders,
            'revenue' => $revenue,
            'total_order' => $total_order,
            'stock_out' => $stock_out
        ]);
    }
    public function getOrders(): array
    {

        $this->load->model('Order_model');
        $config = array();
        $config["base_url"] = base_url() . "dashboard";
        $config["total_rows"] = $this->Order_model->get_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 2;
        $config['full_tag_open'] = '<div class="mt-2 pagination pagination-large"><ul class="flex gap-2">';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] =  '<li class="active bg-indigo-500 text-white w-6 h-6 text-center rounded"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $orders["links"] = $this->pagination->create_links();
        $orders['orders'] = $this->Order_model->all_orders($config["per_page"], $page);
        return $orders;
    }
}