<?php

$pageTitle = 'Items';

include 'init.php';
include 'database.php';
$db = new Database();

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage'){
    $rows = $db->getItems();
    ?>

    <h1 class='text-center'>Manage Items</h1>
    <div class='container'>
        <div class="table-responsive">
            <table class="main-table text-center manage-members  table table-bordered">
                <tr>
                    <td>#ID</td>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Adding Date</td>
                    <td>Category</td>
                    <td>Quentity</td>
                    <td>Control</td>
                </tr>
                <?php
                    while($item = mysqli_fetch_assoc($rows)){
                        echo "<tr>". 
                                    "<td>" . $item['BookID']. 
                                    "</td><td class='avatar-img'>";
                                if(empty($item['image'])){
                                    echo "<img src='layout/image/img.jpg' alt=''>";
                                }else{
                                    echo "<img src='upload/avatar/" . $item['image'] ."' alt=''>";
                                } 
                                echo "</td><td>" . $item['Name'] . 
                                    "<td class='td-decription'>" . $item['Description'] . 
                                    "<td>" . $item['Price'] . 
                                    "<td>" . $item['Date'] .
                                    "<td>" . $item['Category_Name'] .
                                    "<td>" . $item['quentity'] .
                                    "<td>" . 
                                            "<a href='items.php?do=Edit&itemid=" . $item['BookID'] . "' 
                                                class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>". 
                                            "<a href='items.php?do=Delete&itemid=" . $item['BookID'] . "' 
                                                class='btn btn-danger confirm'>
                                                <i class='fa fa-close'></i> Delete</a>";
                                            if($item['Status'] == 0){
                                                echo "<a href='items.php?do=Approve&itemid=" . $item['BookID'] . "' 
                                                        class='btn btn-info activate'>
                                                        <i class='fa fa-check'></i> Approve</a>"; 
                                            }
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
    </div>

    <?php
    // }
}elseif($do == 'Add'){ // Add Page ?>

    <h1 class="text-center">Add New Book</h1>
    <div class="container">
        <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
            <!-- Start Name Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10 col-md-9">
                    <input 
                            class="form-control"
                            type="text" 
                            name="name"  
                            placeholder="Name Of The Book">
                </div>
            </div>
            <!-- End Name Field -->
            <!-- Start Description Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10 col-md-9">
                    <input 
                            class="form-control" 
                            type="text" 
                            name="description"                                 
                            placeholder="Description of The Book">
                </div>
            </div>
            <!-- End Description Field -->
            <!-- Start Price Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10 col-md-9">
                    <input 
                            class="form-control" 
                            type="text" 
                            name="price" 
                            placeholder="Price of The Book">
                </div>
            </div>
            <!-- End Price Field -->
            <!-- Start Quentity Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Quentity</label>
                <div class="col-sm-10 col-md-9">
                    <input 
                            class="form-control" 
                            type="number" 
                            name="quentity" 
                            placeholder="Quentity of The Book">
                </div>
            </div>
            <!-- End Quentity Field -->
            <!-- Start Categories Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10 col-md-9">
                    <select name="category">
                        <option value="0">...</option>
                        <?php
                            $allCats = $db->getAllTable("*", "categories", "", '', "ID", "");
                            foreach($allCats as $cat){
                                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <!-- End Categories Field -->
            <!-- Start Image Field -->
            <div class="mb-2 row">
                <label class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10 col-md-9">
                    <input type="file" name="image" class="form-control" required="required">
                </div>
            </div>
            <!-- End Image Field -->
            <!-- Start Submit Field -->
            <div class="mb-2 row">
                <div class="offset-sm-2 col-sm-10">
                    <input type="submit" value="Add Item" class="btn btn-primary">
                </div>
            </div>
            <!-- End Submit Field -->
        </form>
    </div>

<?php

}elseif($do == 'Insert'){ // Insert Page

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        echo '<h1 class="text-center">Insert Page</h1>';
        echo '<div class="container">';

        // Upload Variable
        
            // Upload Variable
            
            $imageName = $_FILES['image']['name'];
            $imageType = $_FILES['image']['type'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp  = $_FILES['image']['tmp_name'];

            // List Of Allowed File Typed To Upload

            $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");

            // Get Avatar Extension

            @$imageExtension = strtolower(end(explode('.', $imageName)));

        // Get Variables From The Form

        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $price      = $_POST['price'];
        $category   = $_POST['category'];
        $quentity   = $_POST['quentity'];

        // Validate The Form

        
        $image = rand(0, 100000) . '_' . $imageName;
        move_uploaded_file($imageTmp, "upload\avatar\\" . $image);
        // $values = "VALUES(NULL, '".$name."', ".$desc."', ".$price."', now(), ".$quentity."', ".$image."', 0, ".$category."')";

        $resultData = $db->save("books", "VALUES(NULL, '".$name."', '".$desc."', '".$price."', now(), '".$quentity."', '".$image."', 0, '".$category."')");

        if($resultData){
            $TheMsg = "<div class='alert alert-success'> Record Inserted</div>";
            redirectHome($TheMsg, 'back');
        }else{
            echo "error";
        }
    }else{
        $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
        redirectHome($TheMsg);
    }
    echo '</div>';

}else{

    $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
    redirectHome($TheMsg);
}

include $tepl . 'footer.php';
?>