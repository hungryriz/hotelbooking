<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
        <div class="main-menu-content">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                <li class=" navigation-header"><span>General</span><i data-toggle="tooltip" data-placement="right" data-original-title="General" class=" ft-minus"></i>
                </li>
                <li class="@if(Request::segment(2)=='home') active  @endif nav-item">
                    <a href="{{ route('admin.home') }}"><i class="ft-home"></i><span data-i18n="" class="menu-title">@lang('menu.admin.dashboard')</a>
                </li>
                <li class="@if(Request::segment(2)=='orders') active  @endif nav-item">
                    <a href="{{ route('admin.orders.index') }}?t=pending"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">@lang('menu.admin.dispatcher')</span></a>
                </li>
                @if(@Auth::user()->hasRole('Admin'))
                <li class="nav-item @if(Request::segment(2)=='disputes') active  @endif  has-open">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i>
                        <span data-i18n="" class="menu-title">@lang('menu.admin.dispute')</span>
                    </a>
                    <ul class="menu-content">
                        <li><a href="{{ url('admin/disputes/user') }}" class="menu-item">@lang('menu.admin.user_dispute')</a></li>
                        <li><a href="{{ url('admin/disputes/deliverypeople') }}" class="menu-item">@lang('menu.admin.db_dispute')</a></li>
                        <li><a href="{{ url('admin/disputes/shop') }}" class="menu-item">@lang('menu.admin.shop_dispute')</a></li>
                        <li><a href="{{ url('admin/disputehelp') }}" class="menu-item">@lang('menu.admin.help_dispute')</a></li>
                        
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='shops') active  @endif nav-item"><a href="#"><i class="fa fa-cutlery"></i><span data-i18n="" class="menu-title">@lang('menu.admin.restaurant')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.shops.index') }}" class="menu-item">@lang('menu.admin.list_restaurant')</a></li>
                        <li><a href="{{ route('admin.shops.create') }}" class="menu-item">@lang('menu.admin.add_restaurant')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='transporters') active  @endif nav-item"><a href="#"><i class="fa fa-motorcycle"></i><span data-i18n="" class="menu-title">@lang('menu.admin.delivery_boy')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.transporters.index') }}" class="menu-item">@lang('menu.admin.list_delivery_boy')</a></li>
                        <li><a href="{{ route('admin.transporters.create') }}" class="menu-item">@lang('menu.admin.add_delivery_boy')</a></li>
                        <li><a href="{{ url('admin/transporters-shift') }}" class="menu-item">@lang('menu.admin.list_delivery_boy_shift')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='dispute-user') active  @endif nav-item"><a href="#"><i class="fa fa-user-circle"></i><span data-i18n="" class="menu-title">@lang('menu.admin.dispute_manager')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.dispute-user.index') }}" class="menu-item">@lang('menu.admin.list_dispute_manager')</a></li>
                        <li><a href="{{ route('admin.dispute-user.create') }}" class="menu-item">@lang('menu.admin.add_dispute_manager')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='cuisines') active  @endif nav-item"><a href="#"><i class="fa fa-book"></i><span data-i18n="" class="menu-title">@lang('menu.admin.cuisines')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.cuisines.index') }}" class="menu-item">@lang('menu.admin.list_cuisines')</a></li>
                        <li><a href="{{ route('admin.cuisines.create') }}" class="menu-item">@lang('menu.admin.add_cuisines')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='promocodes') active  @endif nav-item"><a href="#"><i class="fa fa-percent"></i><span data-i18n="" class="menu-title">@lang('menu.admin.promocode')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.promocodes.index') }}" class="menu-item">@lang('menu.admin.list_promocode')</a></li>
                        <li><a href="{{ route('admin.promocodes.create') }}" class="menu-item">@lang('menu.admin.add_promocode')</a></li>
                    </ul>
                </li>
                 <li class="@if(Request::segment(2)=='banner') active  @endif nav-item"><a href="#"><i class="fa fa-image"></i><span data-i18n="" class="menu-title">@lang('menu.admin.resturant_banner')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{route('admin.banner.index')}}" class="menu-item">@lang('menu.admin.list_resturant_banner')</a></li>
                        <li><a href="{{route('admin.banner.create')}}" class="menu-item">@lang('menu.admin.add_resturant_banner')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='notice') active  @endif nav-item"><a href="#"><i class="fa fa-comment"></i><span data-i18n="" class="menu-title">@lang('menu.admin.notice_board')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{route('admin.notice.index')}}" class="menu-item">@lang('menu.admin.list_notice_board')</a></li>
                        <li><a href="{{route('admin.notice.create')}}" class="menu-item">@lang('menu.admin.add_notice_board')</a></li>
                        <li><a href="{{url('admin/send/push')}}" class="menu-item">@lang('menu.admin.custom_push')</a></li>
                    </ul>
                </li>
                <li class="@if(Request::segment(2)=='users') active  @endif nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="" class="menu-title">@lang('menu.admin.customer')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{route('admin.users.index')}}" class="menu-item">@lang('menu.admin.list_customer')</a></li>
                        <li><a href="{{route('admin.users.create')}}" class="menu-item">@lang('menu.admin.add_customer')</a></li>
                    </ul>
                </li>

                <li class="@if(Request::segment(2)=='users') active  @endif nav-item"><a href="#"><i class="fa fa-columns"></i><span data-i18n="" class="menu-title">@lang('menu.admin.pages')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{route('admin.about')}}" class="menu-item">@lang('menu.admin.about')</a></li>
                        <li><a href="{{route('admin.faq')}}" class="menu-item">@lang('menu.admin.faq')</a></li>
                        <li><a href="{{route('admin.privacy')}}" class="menu-item">@lang('menu.admin.privacy')</a></li>
                        <li><a href="{{route('admin.contact')}}" class="menu-item">@lang('menu.admin.contact')</a></li>
                        <li><a href="{{route('admin.terms')}}" class="menu-item">@lang('menu.admin.terms')</a></li>
                        <li><a href="{{route('admin.refund')}}" class="menu-item">@lang('menu.admin.refund')</a></li>
                        <li><a href="{{route('admin.otherterms')}}" class="menu-item">@lang('menu.admin.otherterms')</a></li>
                        <li><a href="{{route('admin.queries')}}" class="menu-item">@lang('menu.admin.queries')</a></li>
                        <li><a href="{{route('admin.help')}}" class="menu-item">@lang('menu.admin.help')</a></li>
                    </ul>
                </li>
                 <li class="@if(Request::segment(2)=='') active  @endif nav-item"><a href="#"><i class="fa fa-address-card"></i><span data-i18n="" class="menu-title">@lang('menu.admin.lead')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{route('admin.leadres')}}" class="menu-item">@lang('menu.admin.list_restuarant')</a></li>
                        <li><a href="{{route('admin.enquiry_delivery')}}" class="menu-item">@lang('menu.admin.list_transporters')</a></li>
                        <li><a href="{{route('admin.newsletter')}}" class="menu-item">@lang('menu.admin.list_newsletter')</a></li>
                    </ul>
                </li>
               
               
               
                <li class="@if(Request::segment(2)=='email_template') active  @endif nav-item"><a href="#"><i class="fa fa-envelope"></i><span data-i18n="" class="menu-title">@lang('menu.admin.email_template')</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.emailtemplate.index') }}" class="menu-item">@lang('menu.admin.list_emailtemplate')</a></li>
                        <li><a href="{{ route('admin.emailtemplate.create') }}" class="menu-item">@lang('menu.admin.add_emailtemplate')</a></li>
                    </ul>
                </li>
                <li class="@if(@Request::get('list')==true) active  @endif nav-item">
                    <a href="{{ route('admin.orders.index', ['list'=>'true']) }}"><i class="fa fa-shopping-basket"></i><span data-i18n="" class="menu-title">@lang('menu.admin.delivery')</span></a>
                </li>
               
                    @if(in_array(url('/'),['http://foodie.appoets.co']))
                    <li class="@if(Request::segment(2)=='demoapp') active  @endif nav-item"><a href="#"><i class="fa fa-shopping-bag"></i><span data-i18n="" class="menu-title">Manage App</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ route('admin.demoapp.index') }}" class="menu-item">App List</a></li>
                            <li><a href="{{ route('admin.demoapp.create') }}" class="menu-item">Add Demo</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(Setting::get('DEMO_MODE') == 1)
                <li class=" nav-item">
                    <a href="{{ route('admin.translation.index') }}"><i class="fa fa-language"></i><span data-i18n="" class="menu-title">@lang('menu.admin.translation')</span></a>
                </li>
                <li class="@if(Request::segment(2)=='settings') active  @endif nav-item"><a href="#"><i class="fa fa-cog"></i><span data-i18n="" class="menu-title">@lang('menu.admin.setting')</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ route('admin.settings') }}"><i class="fa fa-cog"></i><span data-i18n="" class="menu-title">@lang('menu.admin.site_setting')</a></li>
                          
                        </ul>
                </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>