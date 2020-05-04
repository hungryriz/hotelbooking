
<form  action="{{url('restaurants')}}" id="my_map_form" >
    <div class="row">
        <div class="form-group col-sm-6 col-md-3">
            <h4 class="title">Where</h4>
            <label>Your Destination</label>
            <input type="text" id="pac-input" name="search_loc"  class="search_loc" placeholder="Enter Your Delivery Location" required autofocus>
        </div>

        <div class="form-group col-sm-6 col-md-4">
            <h4 class="title">When</h4>
            <div class="row search-when" data-error-message1="Your check-out date is before your check-in date. Have another look at your date and try again." data-error-message2="Please select current or future dates for check-in and check-out.">
                <div class="col-xs-6">
                    <label>CHECK IN</label>
                    <div class="datepicker-wrap from-today">
                        <input name="check_in" type="text" class="input-text check_in" placeholder="mm/dd/yyyy" id="check_in" required>
                    </div>
                </div>
                <div class="col-xs-6">
                    <label>CHECK OUT</label>
                    <div class="datepicker-wrap">
                        <input name="check_out" type="text" class="input-text check_out" placeholder="mm/dd/yyyy" id="check_out" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-6 col-md-3">
            <h4 class="title">Who</h4>
            <div class="row">
                <div class="col-xs-4">
                    <label>Rooms</label>
                    <div class="selector">
                        <select name="rooms" class="full-width">
                            <option value="1" selected="">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>                                                  
                        </select>
                        <span class="custom-select full-width">1</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <label>Adults</label>
                    <div class="selector">
                        <select name="adults" class="full-width">
                            <option value="1" selected="">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>                                                  
                        </select>
                        <span class="custom-select full-width">1</span>
                    </div>
                </div>
                <div class="col-xs-4">
                    <label>Kids</label>
                    <div class="selector">
                        <select name="children" class="full-width">
                            <option value="0" selected="">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <span class="custom-select full-width">0</span>
                    </div>
                </div>
            </div>
            <div class="age-of-children no-display">
                <h5>Age of Children</h5>
                <div class="row">
                    <div class="col-xs-4 child-age-field">
                        <label>Child 1</label>
                        <div class="selector validation-field">
                            <select name="child_ages[]" class="full-width">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>                                                        
                            </select>
                            <span class="custom-select full-width">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
        <div class="form-group col-sm-6 col-md-2 fixheight">
            <label class="hidden-xs">&nbsp;</label>
            <span class="input-group-addon log-search-btn"><button>Find Food</button></span>
        </div>
    </div>

    <div id="my_map"   style="height:500px;width:100%;" ></div>
</form>

