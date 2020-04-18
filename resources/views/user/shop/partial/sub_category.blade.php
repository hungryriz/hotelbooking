
@forelse($Shop->categories as $Category)
<h3 class="nomargin_top" id="{{$Category->name}}">{{$Category->name}}</h3>
<p>
   {{$Category->description}}
</p>
    
        @forelse($Category->subcategories as $SubCategory)
            <h3 class="nomargin_top" id="{{$Category->name}}">{{$SubCategory->name}}</h3>
            <p>
               {{$SubCategory->description}}
            </p>
            <table class="table table-striped cart-list">
                <thead>
                    <tr>
                        <th>
                            Item
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Order
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($SubCategory->products as $Index => $Product)
                    <tr>
                       <td>
                        <a href="{{url('product/details/'.base64_encode($Product->id.'-'.$Shop->id).'/c/'.$Shop->name.'/'.$Product->name)}}"> 
                            @if(count($Product->images)>0)
                            <figure class="thumb_menu_list"><img src="{{$Product->images[0]->url}}" alt="thumb"></figure>
                            @endif
                            <h5>{{$Index+1}}. {{$Product->name}}</h5>
                            </a>
                            <p>
                                {{$Product->description}}
                            </p>
                        </td>
                        <td>
                            <strong> {{currencydecimal(@$Product->prices->price)}}</strong>
                        </td>
                        <td class="options">
                            <div class="dropdown dropdown-options">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="icon_plus_alt2"></i></a>
                                <div class="dropdown-menu">
                                    <form  action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST">
                                        <h5>Quantity</h5>
                                        <div>
                                            {{csrf_field()}}
                                            <!-- <label>Select Quantity</label> -->
                                            <input type="hidden" value="{{$Product->shop_id}}" name="shop_id" >
                                            <input type="hidden" value="{{$Product->id}}" name="product_id" >
                                            <input type="number" value="1" name="quantity" class="form-control" placeholder="Enter Quantity" min="1" max="100">
                                            <input type="hidden" value="{{$Product->name}}" name="name" >
                                            <input type="hidden" value="{{@$Product->prices->price}}" name="price" />
                                        </div>
                                        <button type="submit" class="btn add_to_basket">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3"> No Product Found!</td></tr>
                    @endforelse
                </tbody>
            </table>
            <hr>
    
        @empty

        @endforelse
    
@empty

@endforelse
               