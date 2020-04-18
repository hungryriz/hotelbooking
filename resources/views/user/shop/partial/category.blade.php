 <!-- Restaurant Food List Ends -->
                            @if(count($Shop->categories)>0)
                            @forelse($Shop->categories as $Categoryy)
                            <!-- Restaurant Food List Starts -->
                            <div class="restaurant-food-list" id="{{str_replace(' ', '_', $Categoryy->name)}}">
                                <!-- Restaurant Filter Head Starts -->
                                <div class="res-filter-list-head">
                                    <h5>{{$Categoryy->name}}</h5>
                                    <p class="food-item-txt">{{count($Categoryy->products)}} Items</p>
                                </div>
                                <!-- Restaurant Filter Head Ends -->
                                <div class="food-list-view">
                                    <!-- Foot List View Section Starts -->
                                    <div class="food-list-view-section">
                                        <div class="food-list-sec-head">
                                            <!-- <h5>24 Veg Main Course</h5> -->
                                        </div>
                                        @forelse($Categoryy->products as $Index => $Product)
                                        <!-- Food List View Box Starts -->
                                        <div class="food-list-view-box row @if($Product->food_type=='veg') veg @else nonveg @endif">
                                            <div class="col-sm-9">
                                                <div class="row m-0">
                                                     @if($Product->food_type=='veg')
                                                    <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">
                                                    @else
                                                    <img src="{{asset('assets/user/img/non-veg.jpg')}}" class="veg-icon">
                                                    @endif
                                                    <div class="food-menu-details food-list-details">
                                                        <h6>{{$Product->name}}</h6>
                                                        @if($Product->prices->discount)
                                                            <p>
                                                            <strike>{{currencydecimal($Product->prices->price)}}</strike>
                                                            {{currencydecimal($Product->prices->orignal_price)}}
                                                            </p>
                                                            @else
                                                            <p>{{currencydecimal($Product->prices->price)}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="add-btn-wrap text-right">
                                                    <form  action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST">           
                                                        {{csrf_field()}}
                                                        <!-- <label>Select Quantity</label> -->
                                                        <input type="hidden" value="{{$Product->shop_id}}" name="shop_id" >
                                                        <input type="hidden" value="{{$Product->id}}" name="product_id" >
                                                        <input type="hidden" value="1" name="quantity" id="quantity_{{$Product->id}}" class="form-control" placeholder="Enter Quantity" min="1" max="100">
                                                        <input type="hidden" value="{{$Product->name}}" name="name" >
                                                        <input type="hidden" value="{{@$Product->prices->price}}" name="price" id="product_price_{{$Product->id}}" />
                                                        @if(Auth::user()) 
                                                            @if($Product->out_of_stock=='NO')              
                                                                @if(count($Product->addons)==0)
                                                                <button type="submit" class=" add-btn">Add</button>
                                                                @else
                                                                <button type="button" class="custom-add-btn add_to_basket" data-foodtype="{{$Product->food_type}}" data-productid="{{$Product->id}}" >Add<i class="ion-android-add custom-plus"></i>
                                                                </button>
                                                                <span class="custom-txt">Customisable</span>
                                                                @endif
                                                            @endif
                                                        @else

                                                            <a href="#" class="login-item add-btn" onclick="$('#login-sidebar').asidebar('open')">@lang('user.add_to_cart')</a>
                                                           
                                                         @endif
                                                    </form>
                                                    <!-- <a href="javascript:void(0);" class="add-btn1">
                                                        <div class="numbers-row">
                                                            <input type="text" name="add-quantity" class="add-sec" id="add-quantity" value="1">
                                                        </div>
                                                    </a> -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Food List View Box Ends -->
                                        @empty
                                        @endforelse
                                       
                                    </div>
                                   
                                </div>
                            </div>
                            <!-- Restaurant Food List Ends -->
                            @empty

                            @endforelse
                            @else
                            <p>No category Found!</p>
                            @endif  