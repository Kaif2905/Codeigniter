<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

 
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>


<style>
    h1{text-align:center;margin-bottom: 10px;background-color: rgb(0,0,0,0.4);padding: 10px;color:black}
    #container{

      margin-left: 350px;
      margin-right:350px;
    }
</style>
</head>
<body>

    <div id='container'><table id="myTable" class="table" border=2>
      <h1>Users-List</h1>
  <thead class="table-dark">
  <tr>
                <th>Party Name</th>
                <th>Address</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Details</th>
                <th>Remark</th>
            </tr>
  </thead>
        <tbody>
            <?php if(!empty($users)): ?>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['address'] ?></td>
                        <td><?= $user['material'] ?></td>
                        <td><?= $user['quantity'] ?></td>
                        <td><?= $user['detail'] ?></td>
                        <td><?= $user['remark'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
</body>
</html>
 