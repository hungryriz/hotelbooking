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
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
        @forelse($order->items  as $key => $item)
          <tr>
            <td class="no">{{$key+1}}</td>
            <td class="desc"><h3>{{$item->product->name}}</h3></td>
            <td class="unit">{{$item->product->prices->currency}}{{$item->product->prices->price}}</td>
            <td class="qty">{{$item->quantity}}</td>
            <td class="total">{{$item->product->prices->currency}}{{$item->quantity*$item->product->prices->price}}</td>
          </tr>
            @if(count($item->cart_addons)>0)
                @forelse($item->cart_addons  as $keyy => $addonitem)
                    <tr>
                        <td class="no">{{$key+1}}.{{$keyy+1}}</td>
                        <td class="desc"><h3>{{$addonitem->addon_product->addon->name}}</h3></td>
                        <td class="unit">{{$item->product->prices->currency}}{{$addonitem->addon_product->price}}</td>
                        <td class="qty">{{$addonitem->quantity}}</td>
                        <td class="total">{{$item->product->prices->currency}}{{$addonitem->quantity*$addonitem->addon_product->price}}</td>

                    </tr>
                @empty
                @endforelse
          @endif
          @empty
          @endforelse
         <!--  <tr>
            <td class="no">02</td>
            <td class="desc"><h3>Chicken kabab</h3>Developing a Content Management System-based Website</td>
            <td class="unit">$40.00</td>
            <td class="qty">80</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="no">03</td>
            <td class="desc"><h3>Chicken manchurian</h3>Optimize the site for search engines (SEO)</td>
            <td class="unit">$40.00</td>
            <td class="qty">20</td>
            <td class="total">$800.00</td>
          </tr> -->
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>{{$item->product->prices->currency}}{{$order->invoice->gross}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TAX {{Setting::get('tax')}}%</td>
            <td>{{$item->product->prices->currency}}{{$order->invoice->tax}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">DELIVERY CHARGE </td>
            <td>{{$item->product->prices->currency}}{{Setting::get('delivery_charge')}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>{{$item->product->prices->currency}}{{$order->invoice->payable}}</td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <!-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> -->
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>