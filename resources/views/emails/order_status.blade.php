<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ninya</title>
    <link rel="stylesheet" href="{{asset('css/pdfstyle.css')}}" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{asset('images/logo.jpg')}}"  height="200px" width="200px">
      </div>
      <div id="company">
        <h2 class="name">Ninya</h2>
        <div>455 Foggy Heights, AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@ninya.mx">company@ninya.mx</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name">{{@$order->deliveryuser->name}}</h2>
          <div class="address">{{@$order->deliveryuser->room_number}}</div>
          <div class="email"><a href="#">{{@$order->deliveryuser->phonenumber}}</a></div>
        </div>
        <div id="invoice">
          <h1>INVOICE #{{$order->id}}</h1>
          <div class="date">Date of Invoice: {{$order->created_at}}</div>
          <!-- <div class="date">Due Date: {{$order->created_at}}</div> -->
        </div>
      </div>
      <div>
      Hi {{$order->user->name}},
        Your order number {{$order->id}} is 
        @if($order->status=='RECEIVED')
          confirmed
        @elseif($order->status=='PROCESSING')
         Processed
        @elseif($order->status=='PICKEDUP')
        PickedUp
        @elseif($order->status=='COMPLETED')
         Delivered
        @endif
        successfully
      </div>
      <div id="thanks">Thank you!</div>
      <!-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> -->
    </main>
    <footer>
      
    </footer>
  </body>
</html>