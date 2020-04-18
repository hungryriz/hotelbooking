<html>
<td colspan="8"><h1>Order Report of {{date('d-m-Y H:i:s')}}</h1></td>
<tr>
    <th>Order No.</th>
    <th>Customer Name</th>
    <th>Delivery People</th>
    <th>Restaurant</th>
    <th>Order date</th>
    <th>Order Total Price</th>
    <th>Order Delivery Price</th>
    <th>Status</th>
</tr>
    <?php $total_earning = $total_gross = $total_delivery =  $total_tips = 0; ?>
    @foreach($Orders as $Order)
    <?php $total_earning +=$Order['invoice']['net'];
                          $total_gross +=$Order['invoice']['gross'];
                          $total_delivery +=$Order['invoice']['delivery_charge'];
                          $total_delivery +=@$Order['invoice']['delivery_charge'];
                          $total_tips +=@$Order['invoice']['tips'];
                     ?>
    <tr>
    <td>{{$Order['id']}}</td>
    <td>{{$Order['user']['name']}}</td>
    <td>{{$Order['transporter']['name']}}</td>
    <td>{{$Order['shop']['name']}}</td>
    <td>{{$Order['created_at']}}</td>
    <td>{{currencydecimal($Order['invoice']['net'])}}</td>
    <td>{{currencydecimal($Order['invoice']['delivery_charge'])}}</td>
    <td>{{$Order['status']}}</td>
    </tr>
    @endforeach
    <?php 

            $total_food_commision = $total_gross*(Setting::get('COMMISION_OVER_FOOD')/100);
            $total_delivery_commision = $total_delivery*(Setting::get('COMMISION_OVER_DELIVERY_FEE')/100);
        ?>
    <tr><td colspan="8"><h1>Total Earning:-</h1></td></tr>
    <tr><td colspan="4">Total Earning:-</td><td colspan="4">{{currencydecimal($total_earning)}}</td></tr>
    <tr><td colspan="4">Total Delivery Fee:-</td><td colspan="4" >{{currencydecimal($total_delivery)}}</td></tr>
    <tr><td colspan="4">Commision from Food Items:-</td><td colspan="4" >{{currencydecimal($total_food_commision)}}</td></tr>
    <tr><td colspan="4">Commision from Delivery Charge:-</td><td colspan="4">{{currencydecimal($total_delivery_commision)}}</td></tr>
    <tr><td colspan="4">Total Commision:-</td><td colspan="4">{{currencydecimal($total_food_commision+$total_delivery_commision)}}</td></tr>
     <tr><td colspan="4">Total Tips:-</td><td colspan="4">{{currencydecimal($total_tips)}}</td></tr>

</html>