@extends('user.layouts.app')

@section('title', 'Payment')

@section('content')

 <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <div class="profile blue-bg">
                <!-- Profile Head Starts -->
                 @include('user.layouts.partials.user_common')
                <!-- Profile Head Ends -->
                <!-- Profile Content Starts -->
                <div class="profile-content">
                    <div class="container-fluid">
                        <!-- Profile Inner Starts -->
                        <div class="profile-inner row">
                            <!-- Profile Left Starts -->
                           @include('user.layouts.partials.sidebar')
                            <!-- Profile Left Ends -->
                            <!-- Profile Right Starts -->
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="profile-right">
                                    <!-- Profile Right Head Starts -->
                                    <div class="profile-right-head">
                                        <h4>Payments</h4>
                                    </div>
                                    <!-- Profile Right Head Ends -->
                                    <div class="profile-right-content payments-section">
                                        <!-- Wallet Money Starts -->
                                        <div class="wallet-money row">
                                            <div class="col-md-6">
                                                <div class="wallet-money-inner row m-0">
                                                    <div class="foodie-money pull-left">
                                                        <span>Foodie Money : {{currencydecimal(Auth::user()->wallet_balance)}}</span>
                                                    </div>
                                                    <div class="statement pull-right">
                                                       <!--  <a href="#statement-modal" class="theme-link state-link" data-toggle="modal" data-target="#statement-modal">View Statement</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Wallet Money Ends -->
                                        <!-- Saved Cards Starts -->
                                        <div class="saved-cards">
                                            <h6>Saved Cards</h6>
                                            <div class="saved-cards-block row">
                                            @forelse($cards as $card)
                                             @if(@$card->is_default)
                                                <?php $card_id = $card->id; ?>
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <i class="fa fa-cc-visa"></i>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                            <!-- <p class="valid">Valid Till 10/2022</p> -->
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">

                                                            
                                                            <form action="{{route('card.destroy',$card->id)}}" method="POST" class="pull-right">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="card_id" value="{{$card->card_id}}">
                                                            <button onclick="return confirm('Are you sure?')" type="submit" class="card-delete theme-link show-btn" >Delete</button>

                                                           <a href="javascript:void(0);" class=" address-btn add-new" onclick="addmoney({{$card->id}});">Add Money in wallet</a>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                            @else
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <i class="fa fa-cc-visa"></i>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                            <!-- <p class="valid">Valid Till 10/2022</p> -->
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                           <form action="{{route('card.destroy',$card->id)}}" method="POST" class="pull-right">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="card_id" value="{{$card->card_id}}">
                                                            <button onclick="return confirm('Are you sure?')" type="submit" class="card-delete theme-link show-btn" >Delete</button>
                                                            <a href="#" class="address-btn add-new" onclick="addmoney({{$card->id}});">Add Money in wallet</a>

                                                           <!--  <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a> -->
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->

                                             @endif
                                            @empty
                                            <div>@lang('home.payment.no_card')</div>
                                            @endforelse
                                                <!-- Saved Cards Box Starts -->
                                                <a href="#" class="add-card-box row m-0" onclick="$('#addcard-sidebar').asidebar('open')">
                                                        <div class="add-card-left pull-left">
                                                            <i class="ion-plus-round address-icon"></i>
                                                        </div>
                                                        <div class="add-card-right">
                                                            <h6 class="address-tit">Add New</h6>
                                                            <!-- <p class="address-txt1">20% cashback on 1st &amp; every 3rd txn with Mastercard CC/DC (max Rs.75/txn).TnC</p> -->
                                                            <button class="address-btn add-new">Add Card</button>
                                                        </div>
                                                </a> 
                                            </div>
                                        </div>
                                        <!-- Saved Cards Ends -->
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Right Ends -->
                        </div>
                        <!-- Profile Inner Ends -->
                    </div>
                </div>
                <!-- Profile Content Ends -->
            </div>
        </div>
        <!-- Content Wrapper Ends -->
  
 <!-- Add Card Starts -->
    <div class="aside right-aside location" id="addcard-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Enter your card details</h5>
        </div>
        <div class="aside-contents">
            <!-- Login Content Starts -->
            <div class="login-content">
                @if(Setting::get('payment_mode')=='braintree')
                    @include('user.payment.partial.braintree')
                @else
                    @include('user.payment.partial.stripe')
                @endif
            </div>
            <!-- Login Content Ends -->
        </div>
    </div>
    <!-- Add Card Ends -->
    <!--Statement Modal Starts-->
     <div class="aside right-aside location" id="addmoney-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Enter your Money</h5>
        </div>
        <div class="aside-contents">
            <!-- Login Content Starts -->
            <div class="login-content">
                 <form class="edit-profile-section" action="{{ url('wallet') }}" method="POST" >
                 {{csrf_field()}}
                <!-- Edit Profile Box Starts -->
                <div class="edit-profile-box-outer">
                    <div class="edit-profile-box">
                        <!-- Edit Details Starts -->
                        
                        <!-- Edit form Section Starts -->
                        <div class="edit-form-sec-outer1">
                             <h6 class="edit-details-tit">Amount</h6>
                            <div class="edit-form-sec1">
                                <div class="form-group">
                                    <input type="number" name="amount" class="form-control" value="0">
                                    <input type="hidden" name="card_id" id="card_id" value="0"/>
                                </div>
                                <button  class="cmn-btn edit-cmn-btn">Add</button>
                            </div>
                        </div>
                        <!-- Edit form Section Ends -->
                    </div>
                </div>
                </form>
            </div>
            <!-- Login Content Ends -->
        </div>
    </div>
    <!-- Statement Modal Ends -->
 <!--Statement Modal Starts-->
    <div class="modal fade" id="statement-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ion-close-round"></span>
                    </button>
                    <h6>Foodie Money Transactions History</h6>
                </div>
                <div class="modal-body">
                    <div class="statement-table">
                        <table id="statement" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Credit/Debit</th>
                                    <th>Amount</th>
                                    <th class="text-right">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2018-02-02</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-01</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-02</td>
                                    <td>Credit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-01</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-02</td>
                                    <td>Credit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-01</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-02</td>
                                    <td>Credit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-02-01</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                                <tr>
                                    <td>2018-01-20</td>
                                    <td>Debit</td>
                                    <td>$20</td>
                                    <td class="text-right">Paid for Order 1128980890</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statement Modal Ends -->

   
 <script type="text/javascript">
       function addmoney(id){ 
        $('#addmoney-sidebar').asidebar('open');
        $('#card_id').val(id);
        }
   </script>
    
 @include('user.layouts.partials.footer')
@endsection

