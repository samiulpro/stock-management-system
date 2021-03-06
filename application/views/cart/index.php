<?php include("application/views/inc/header.php") ?>
<?php include("application/views/inc/navbar.php") ?>
<?php include("application/views/inc/sidebar.php") ?>

<div class="col-span-10 flex flex-col justify-between mt-3 w-full gap-3 pr-3">
    <div class="container mx-auto my-3" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="flex justify-between mb-3 w-full">
            <h1 class="text-3xl font-semibold">Cart</h1>
            <a href="<?php echo base_url().'order/index' ?>"
               class="text-sm border bg-indigo-500 px-3 py-2 text-white rounded uppercase">Back</a>
        </div>
        <div class="flex-column md:flex gap-3 ">
            <div class="w-full h-min">
                <?php if (count($data)) { ?>

                    <!--
                    Showing information of products
                    -->

                    <table class="w-full bg-white p-3 ">
                        <thead>
                        <th class="border px-2 py-1 w-3/6">Name</th>
                        <th class="border px-2 py-1 w-1/6">Unit Price</th>
                        <th class="border px-2 py-1 w-6/6">Quantity</th>
                        <th class="border px-2 py-1 w-1/6">Net Price</th>
                        <th class="border px-2 py-1 w-6/6">Action</th>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($data as $key => $item) { ?>
                            <tr>
                                <td class="px-3 border"><?php echo $item['name']; ?></td>
                                <td class="px-3 border"><?php echo $item['price']; ?> BDT</td>
                                <td class="px-3 flex items-center gap-2">
                                    <a href="<?php echo base_url() . 'home/downCart/' . $key . '/' . $item['qty'] ?>"><i
                                                class="fas fa-minus text-xl text-indigo-400 font-semibold"></i></a>
                                    <?php echo $item['qty']; ?>
                                    <a href="<?php echo base_url() . 'home/upCart/' . $key . '/' . $item['qty'] ?>"><i
                                                class="fas fa-plus text-xl text-indigo-400 font-semibold"></i></a>
                                </td>
                                <td class="px-3 border"><?php echo $item['price'] * $item['qty']; ?> BDT</td>
                                <td class="text-center border"><a
                                            href="<?php echo base_url() . 'home/removeCart/' . $key ?>"><i
                                                class="fas fa-times text-red-400 text-xl font-semibold"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <hr>
                    <div class="flex justify-between py-2"><h1 class="text-xl">Total Payable <span
                                    class="font-bold"><?php echo $this->cart->total(); ?></span>BDT</h1>
                        <a href="<?php echo base_url() . 'home/deleteCart' ?>"
                           class="text-sm border bg-red-500 px-3 py-2 text-white rounded uppercase">Empty Cart</a>
                    </div>
                    <br>

                    <!--
                   Showing Delivery Information
                   -->

                    <div>
                        <h1 class="text-3xl font-semibold">Delivery Information</h1>
                        <?php
                        $info = isset($_SESSION['order_info']);
                        if ($info) {
                            $info = $_SESSION['order_info'];
                            ?>

                            <!--
               Showing Delivery Information in table
               -->
                            <div class="mt-3">
                                <table class="bg-white text-left w-full bg-white ">
                                    <thead>
                                    <th class="border px-2 py-1">Full name</th>
                                    <th class="border px-2 py-1">Phone no</th>
                                    <th class="border px-2 py-1">Division</th>
                                    <th class="border px-2 py-1">District</th>
                                    <th class="border px-2 py-1">Area</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="border px-2 py-1"><?php echo $info['name'] ?></td>
                                        <td class="border px-2 py-1"><?php echo $info['phone'] ?></td>
                                        <td class="border px-2 py-1"><?php echo $info['division'] ?></td>
                                        <td class="border px-2 py-1"><?php echo $info['district'] ?></td>
                                        <td class="border px-2 py-1"><?php echo $info['area'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="text-right mt-4">
                                    <a href="<?php echo base_url() . 'home/removeOrderInfo' ?>"
                                       class="bg-red-500 text-white px-3 py-2 rounded uppercase cursor-pointer">Clear
                                        Information</a>
                                </div>
                            </div>
                        <?php } else {
                            ?>

                            <!--
               Form for adding delivery information
               -->

                            <form action="" class="bg-white p-3 mt-2" method="post">
                                <div class="flex gap-3">
                                    <div class="w-full"><label for="name" class="text-sm font-semibold">Full
                                            name</label>
                                        <br>
                                        <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                placeholder="Your full name"
                                                value="<?php echo $form_data['name'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <span class="text-red-500">
                                        <?php echo form_error('name') ?>
                                    </span>
                                        <br>
                                        <label for="phone" class="text-sm font-semibold">Phone</label>
                                        <br>
                                        <input
                                                type="text"
                                                name="phone"
                                                id="phone"
                                                placeholder="Phone number"
                                                value="<?php echo $form_data['phone'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <br>
                                        <label for="user_id" class="text-sm font-semibold">User ID</label>
                                        <br>
                                        <input
                                                type="User ID"
                                                name="user_id"
                                                id="user_id"
                                                placeholder="Division"
                                                value="<?php echo $form_data['user_id'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <span class="text-red-500">
                                        <?php echo form_error('user_id') ?>
                                    </span>
                                        <br>
                                        <label for="txn" class="text-sm font-semibold">Transaction</label>
                                        <br>
                                        <input
                                                type="txn"
                                                name="txn"
                                                id="txn"
                                                placeholder="txn"
                                                value="<?php echo $form_data['txn'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <span class="text-red-500">
                                        <?php echo form_error('txn') ?>
                                        </span>
                                    </div>
                                    <div class=w-full>
                                        <label for="division" class="text-sm font-semibold">Division</label>
                                        <br>
                                        <input
                                                type="text"
                                                name="district"
                                                id="district"
                                                placeholder="Division"
                                                value="<?php echo $form_data['district'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <span class="text-red-500">
                                        <?php echo form_error('district') ?>
                                        </span>
                                        <label for="district" class="text-sm font-semibold">District</label><br>
                                        <input
                                                type="text"
                                                name="division"
                                                id="division"
                                                placeholder="District"
                                                value="<?php echo $form_data['division'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0">
                                        <span class="text-red-500">
                                        <?php echo form_error('division') ?>
                                    </span>
                                        <br>
                                        <label for="area" class="text-sm font-semibold">Area</label><br>
                                        <input
                                                type="text"
                                                name="area"
                                                id="area"
                                                placeholder="Area"
                                                value="<?php echo $form_data['area'] ?>"
                                                class="border rounded border-gray-300 w-full focus:border-indigo-500 px-3 py-1 focus:outline-0"><br>
                                        <span class="text-red-500">
                                        <?php echo form_error('area') ?>
                                    </span>
                                    </div>
                                </div>
                                <div class="text-right mt-2">
                                    <input type="submit" value="Save"
                                           class="bg-indigo-500 text-white px-3 py-1 rounded uppercase cursor-pointer">
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                <?php } else {
                    ?><p class="text-center text-red-500 font-bold text-2xl">Cart is empty;</p>
                <?php } ?></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type='text/javascript'>
        $(document).ready(function(){

            // Initialize
            $( "#autouser" ).autocomplete({
                source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url: "<?=base_url()?>index.php/User/userList",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#autouser').val(ui.item.label); // display the selected text
                    $('#userid').val(ui.item.value); // save selected id to input
                    return false;
                }
            });

        });
    </script>

</div>

<?php include("application/views/inc/footer.php") ?>
