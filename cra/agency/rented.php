<?php
include('../connect.php');
$sql = "SELECT * FROM `car_details`";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'result error: '. mysqli_connect_error();
}  
$code =mysqli_fetch_all($result, MYSQLI_ASSOC);
echo '
<table class="table table-hover table-bordered">
  <thead>
    <tr class="text-center">
      <th scope="col">Vehicle Model</th>
      <th scope="col">Vehicle Number</th>
      <th scope="col">Seating Capacity</th>
      <th scope="col">Rent per Day</th>
      <th scope="col">Rented (Days)</th>
      <th scope="col">Rented by</th>
    </tr>
  </thead>
  <tbody>';
  foreach($code as $code) :
echo '<tr class="text-center">';
   echo '<td>'.$code['vehiclemodel'].'</td>';
   echo '<td>'.$code['vehiclenumber'].'</td>';
   echo '<td>'.$code['seatingcapacity'].'</td>';
   echo '<td>'.$code['rentperday'].'</td>';
   echo '<td>'.$code['days'].'</td>';
   echo '<td>'.$code['cname'].'</td>';
echo '</tr>';
   endforeach;
   echo '</tbody>
   </table>';
mysqli_free_result($result);
mysqli_close($conn);
?>