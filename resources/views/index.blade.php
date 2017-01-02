@extends('layouts.master')


@section('content')
<div class="search-container-fluid ">
      <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="http://content.skyscnr.com/5aec0fafb28897e4c9deb1a0b1855d00/BKKT-banner.jpg?resize=2000px:530px&quality=90" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Hà Nội</h1>
              <h3>Việt Nam</h3>
              <p>Tổng giá</p>
              <h3>12.000.000 đ</h3>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="http://content.skyscnr.com/b93ae449bc5af27d7e9d229542b9e148/SFOA-banner.jpg?resize=2000px:530px&quality=90" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Hồ Chí Minh</h1>
              <h3>Việt Nam</h3>
              <p>Tổng giá</p>
              <h3>12.000.000 đ</h3>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="http://content.skyscnr.com/1e3e39c36183fd8ea94cec3e9332469d/PARI-banner.jpg?resize=2000px:530px&quality=90" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Mù Cang Chải</h1>
              <h3>Việt Nam</h3>
              <p>Tổng giá</p>
              <h3>12.000.000 đ</h3>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="banner-arrow-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="banner-arrow-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->

    <!-- Form -->
	 <div class="search-wrapper-container">
	 	<section class="search-wrapper container">
	 		<div class="search-tabs-box">
		        <ul>
		            <li class="tab  active ">
		                <!-- <a href="http://flights.travelandleisure.com/en-US/flights/" data-tab="flights">
		                    <i class="fa fa-plane" aria-hidden="true"></i>
		                    <span data-i18n="breadcrumbs.flights">Flights</span>
		                </a> -->
		            </li>
		        </ul>
		    </div>
	 		<div id="search" class="container-search flights-search-control">
	 		<form method="get" id="form" action="search">
	 			<div class="places-control">
		 			<div class="field-box flex">
			 			<div class="place-selector">
					        <div class="place-selector__root clearfix">
					            <input type="text" name="originplace" id="origin-input" placeholder="Điểm đi" class="place-selector__cover text-ellipsis populated" onclick="this.focus();this.select()" value="" required="Nhập điểm đi" />
					        </div>
					    </div>
				    </div>
				    <div class="field-box flex">
			 			<div class="place-selector">
					        <div class="place-selector__root clearfix" tabindex="1">
					            <input type="text" name="destinationplace" id="destination-input" placeholder="Điểm đến" class="place-selector__cover text-ellipsis populated" onclick="this.focus();this.select()" value="" required="Nhập điểm đến">
					        </div>
					    </div>
				    </div>
				    <button class="btn-switch btn-change" type="button" title="Swap origin and destination">
	                    <i class="fa fa-exchange" aria-hidden="true"></i>
	                </button>
			    </div>
			    <div class="dates-control">
			    	<div class="search-date field-box active" id="search-date-depart">
			    		<div class="field-cover-bg">
			    			<div class="field-caption field-box__caption">Ngày Đi</div>
			    			<input id="date-depart" type="date" name="outbounddate" class="search-date-depart picker__input"></input>
			    			<button class="search-date-cover date-depart" type="button">
			    				<div class="month"></div>
			    				<div class="day"></div>
			    				<div class="dayofweek"></div>
			    			</button>
			    		</div>
			    	</div>
			    	<div class="search-date field-box inactive" id="search-date-depart">
			    		<div class="field-cover-bg stripe">
			    			<div class="field-caption field-box__caption">Ngày Về</div>
			    			<input id="date-return" type="date" name="inbounddate" class="search-date-return picker__input"></input>
			    			<button class="search-date-cover date-return" type="button">
			    				<span><i class="fa fa-plus" aria-hidden="true"></i></span>
			    			</button>
			    		</div>
			    	</div>
			    </div>
			    <div id="people-and-class">
			    	<div class="people-selector field-box">
			    		<div class="people-selector__item adults" title="Adults 12+">
			    			<input type="hidden" name="adults" id="adults" value="1">
			    			<div class="dropdown">
			    				<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults 12+">
			    					<div>
									    <i class="fa fa-male pax-icon" aria-hidden="true"></i>
									    <span class="js-dropdown-toggle-name">1</span>
				    					<span class="caret caret-right"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="4" >4</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="5" >5</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="6" >6</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="7" >7</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="8" >8</a></li>
								</ul>
			    			</div>
			    		</div>
			    		<div class="people-selector__item childrens" title="Trẻ em trên 12 tuổi">
			    			<input type="hidden" name="children" id="childrens" value="0">
			    			<div class="dropdown">
			    				<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="">
			    					<div>
									    <i class="fa fa-child pax-icon" aria-hidden="true"></i>
									    <span class="js-dropdown-toggle-name">0</span>
				    					<span class="caret caret-right"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="4" >4</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="5" >5</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="6" >6</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="7" >7</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="8" >8</a></li>
								</ul>
			    			</div>
			    		</div>
			    		<div class="people-selector__item kid" title="Trẻ sơ sinh">
			    			<input type="hidden" name="infants" id="kid" value="0">
			    			<div class="dropdown">
			    				<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults 12+" id="exceed">
			    					<div>
									    <i class="fa fa-female pax-icon" aria-hidden="true"></i>
									    <span class="js-dropdown-toggle-name">0</span>
				    					<span class="caret caret-right"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="4" >4</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="5" >5</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="6" >6</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="7" >7</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="8" >8</a></li>
								</ul>
			    			</div>
			    		</div>
			    	</div>
			    	<div id="service-class" class="field-box">
			    		<input type="hidden" name="cabinclass" id="cabinclass" value="Economy">
				    	<div class="dropdown">
				    		<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults 12+">
		    					<div>
							    <span class="js-dropdown-toggle-name">Economy</span>
		    					<span class="caret caret-right"></span>
							</div>
		    				</button>
	    					<ul class="dropdown-menu dropdown-items">
							    <li><a role="menuitem" class="dropdown-item" data-value="Economy" >Economy</a></li>
							    <li><a role="menuitem" class="dropdown-item" data-value="PremiumEconomy" >Premium Economy</a></li>
							    <li><a role="menuitem" class="dropdown-item" data-value="Business" >Business</a></li>
							    <li><a role="menuitem" class="dropdown-item" data-value="First" >First</a></li>
							</ul>
				    	</div>
				    </div>
			    </div>
			    <button class="field-box search-button" role="button" type="submit">
			    	<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</div>
			
            <input type="hidden" name="oPlaceId" value="" id="oPlaceId">
            <input type="hidden" name="dPlaceId" value="" id="dPlaceId">
            <input type="hidden" name="olat" value="" id="olat">
            <input type="hidden" name="olng" value="" id="olng">
            <input type="hidden" name="dlat" value="" id="dlat">
            <input type="hidden" name="dlng" value="" id="dlng">
			</form>
	 	</section>
	 </div>
	 <!-- end form -->
</div>

<div class="suggestion container">

	<div id="suggestion-header">
		<span id="caption">Suggestion</span>
		<span>|</span>
		<span></span>
		<span class="right"></span>
	</div>

	<div class="row-suggest">
		<div class="col-lg-offset-1">
			<h2>Việt Nam</h2>
		</div>
		<div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/1.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Thượng Hải</h2>
		                <h4>Từ 42.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/2.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Hà Nội</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/3.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Đà Nẵng</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/4.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Nha Trang</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/5.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Đà Lạt</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- temp -->
	<div class="row-suggest">
		<div class="col-lg-offset-1">
			<h2>Việt Nam</h2>
		</div>
		<div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/2.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Bangkok</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/4.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Singapore</h2>
		                <h4>Từ 32.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/5.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>Vienchan</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/1.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>HongKong</h2>
		                <h4>Từ 12.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
		   <a href="#click"> 
			   <div class="hovereffect">
		        	<img class="img-responsive" src="{{ url('/images/suggest/3.jpg') }}" alt="">
		            <div class="overlay">
		                <h2>New Deli</h2>
		                <h4>Từ 32.000.00 <sup>đ</sup></h4>
						<p> 
							Chi Tiết
						</p> 
		            </div>
			    </div>
		    </a>
		</div>
	</div>
</div>

@endsection
@section('footer')
	@include('layouts.footer')
@endsection

@section('scripts')
<script src="{{ elixir('js/homeScript.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQZWI0R8e412mvB1k44OOigCcPe5FTh0&libraries=places&callback=autocompletePlace&language=vi&region=VN"
async defer></script>
@endsection