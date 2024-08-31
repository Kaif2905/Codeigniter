<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .container {
            padding: 20px;
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 10px;
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            padding: 10px;
        }
        #btn {
            display: block;
            margin: 20px auto;
        }
        #message {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Customer Requirement</h1>

    <form class="row g-3" id="myForm" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="a1" class="form-label">Name</label>
            <input type="text" class="form-control" id="a1" name="name" placeholder="Enter Company Name" required>
        </div>
        <div class="col-md-6">
            <label for="a2" class="form-label">Material</label>
            <input type="text" class="form-control" id="a2" name="material" placeholder="Enter Material" required>
        </div>
        <div class="col-md-6">
            <label for="a3" class="form-label">Detail's</label>
            <input type="text" class="form-control" id="a3" name="detail" placeholder="Enter Product Details" required>
        </div>
        <div class="col-md-6">
            <label for="a4" class="form-label">Material Quantity</label>
            <input type="text" class="form-control" id="a4" name="quantity" placeholder="Enter Material Quantity" required>
        </div>
        <div class="col-md-6">
            <label for="a5" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="a5" name="remark" accept="image/*" required><br>
        </div>
        <div class="col-12">
            <label for="a6" class="form-label">Address</label>
            <input type="text" class="form-control" id="a6" name="address" placeholder="Enter Your Address" required>
        </div>
        <div class="col-md-6">
            <label for="a7" class="form-label">City</label>
            <input type="text" class="form-control" id="a7" name="city" placeholder="Enter Your City" required>
        </div>
        <div class="col-md-4">
            <label for="a8" class="form-label">State</label>
            <select id="a8" name="state" class="form-select" required>
                <option selected>Choose...</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Nagpur">Nagpur</option>
                <option value="MP">MP</option>
                <option value="Delhi">Delhi</option>
                <option value="Mumbai">Mumbai</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="a9" class="form-label">Zip</label>
            <input type="text" class="form-control" id="a9" name="zip" required>
        </div>
        <div class="col-12">
            <button type="submit" id="btn" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<div id="message"></div>
<div id="box"></div>

<script>
    $(document).ready(function() {
        var tableCreated = false;
        var currentEditRow = null;
        var currentEditId = null;

        $('#myForm').on('submit', function(e) {
            e.preventDefault(); 

            var formData = new FormData(this); // Use FormData to handle file uploads

            if (!tableCreated) {
                var tableHeader = `
                    <div class="table-responsive">
                        <table class="table table-hover" id="inbox">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Material</th>
                                    <th>Details</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="dataList"></tbody>
                        </table>
                    </div>
                `;
                $('#box').html(tableHeader);
                tableCreated = true;
            }

            if (currentEditRow) {
                formData.append('id', currentEditId);

                $.ajax({
                    url: "<?= site_url('user/update') ?>", 
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $(currentEditRow).html(createRowContent(response.data));
                            currentEditRow = null;
                            currentEditId = null;
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#message').html('<div class="alert alert-danger">An error occurred: ' + xhr.responseText + '</div>');
                    }
                });
            } else {
                $.ajax({
                    url: "<?= site_url('user/store') ?>", 
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            var dataRow = `<tr data-id="${response.data.id}">${createRowContent(response.data)}</tr>`;
                            $('#dataList').append(dataRow);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#message').html('<div class="alert alert-danger">An error occurred: ' + xhr.responseText + '</div>');
                    }
                });
            }

            $('#myForm')[0].reset();
            $('#a5').val(''); // Reset the file input field
        });

        function createRowContent(data) {
            return `
                <td>${data.name}</td>
                <td>${data.material}</td>
                <td>${data.detail}</td>
                <td>${data.quantity}</td>
                <td><img src="<?= base_url('writable/uploads/') ?>${data.remark}" alt="Image" width="50"></td>
                <td>${data.address}</td>
                <td>${data.city}</td>
                <td>${data.state}</td>
                <td>${data.zip}</td>
                <td class="action-btns">
                    <button class="btn btn-warning btn-sm edit-btn">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                </td>
            `;
        }

        $(document).on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            currentEditRow = row;
            currentEditId = row.data('id');

            var data = {
                name: row.find('td:eq(0)').text(),
                material: row.find('td:eq(1)').text(),
                detail: row.find('td:eq(2)').text(),
                quantity: row.find('td:eq(3)').text(),
                address: row.find('td:eq(5)').text(),
                city: row.find('td:eq(6)').text(),
                state: row.find('td:eq(7)').text(),
                zip: row.find('td:eq(8)').text()
            };

            $('#a1').val(data.name);
            $('#a2').val(data.material);
            $('#a3').val(data.detail);
            $('#a4').val(data.quantity);
            $('#a6').val(data.address);
            $('#a7').val(data.city);
            $('#a8').val(data.state);
            $('#a9').val(data.zip);

            $('#a5').val(''); // Reset file input field on edit
        });

        $(document).on('click', '.delete-btn', function() {
            var row = $(this).closest('tr');
            var deleteId = row.data('id');

            $.ajax({
                url: "<?= site_url('user/delete') ?>", 
                type: 'POST',
                data: { id: deleteId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        row.remove();
                    }
                },
                error: function(xhr, status, error) {
                    $('#message').html('<div class="alert alert-danger">An error occurred: ' + xhr.responseText + '</div>');
                }
            });
        });
    });
</script>

</body>
</html>
