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
		                <a href="http://flights.travelandleisure.com/en-US/flights/" data-tab="flights">
		                    <i class="fa fa-plane" aria-hidden="true"></i>
		                    <span data-i18n="breadcrumbs.flights">Flights</span>
		                </a>
		            </li>
		        </ul>
		    </div>
	 		<div id="search" class="container-search flights-search-control">
	 		<form method="get" id="form" action="search">
	 			<div class="places-control">
		 			<div class="field-box flex">
			 			<div class="place-selector">
					        <div class="place-selector__root clearfix">
					            <input type="text" name="originplace" id="origin-input" placeholder="Origin Place" class="place-selector__cover text-ellipsis populated" onclick="this.focus();this.select()" value="Ha noi" />
					        </div>
					    </div>
				    </div>
				    <div class="field-box flex">
			 			<div class="place-selector">
					        <div class="place-selector__root clearfix" tabindex="1">
					            <input type="text" name="destinationplace" id="destination-input" placeholder="Destination Place" class="place-selector__cover text-ellipsis populated" onclick="this.focus();this.select()" value="Ho Chi Minh">
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
			    			<div class="field-caption field-box__caption">Depart</div>
			    			<input id="date-depart" name="outbounddate" class="search-date-depart picker__input"></input>
			    			<button class="search-date-cover date-depart" type="button">
			    				<div class="month">OCt</div>
			    				<div class="day">28</div>
			    				<div class="dayofweek">Friday</div>
			    			</button>
			    		</div>
			    	</div>
			    	<div class="search-date field-box inactive" id="search-date-depart">
			    		<div class="field-cover-bg stripe">
			    			<div class="field-caption field-box__caption">Depart</div>
			    			<input id="date-return" name="inbounddate" class="search-date-return picker__input"></input>
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
				    					<span class="caret"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								</ul>
			    			</div>
			    		</div>
			    		<div class="people-selector__item" title="Childrens under 12">
			    			<div class="dropdown">
			    				<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults under 12">
			    					<div>
									    <i class="fa fa-child pax-icon" aria-hidden="true"></i>
									    <span class="js-dropdown-toggle-name">0</span>
				    					<span class="caret"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								</ul>
			    			</div>
			    		</div>
			    		<div class="people-selector__item" title="Adults 12+">
			    			<div class="dropdown">
			    				<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults 12+">
			    					<div>
									    <i class="fa fa-female pax-icon" aria-hidden="true"></i>
									    <span class="js-dropdown-toggle-name">0</span>
				    					<span class="caret"></span>
									</div>
			    				</button>
		    					<ul class="dropdown-menu dropdown-items">
								    <li><a role="menuitem" class="dropdown-item" data-value="1" >1</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="2" >2</a></li>
								    <li><a role="menuitem" class="dropdown-item" data-value="3" >3</a></li>
								</ul>
			    			</div>
			    		</div>
			    	</div>
			    	<div id="service-class" class="field-box">
				    	<div class="dropdown">
				    		<button class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" area-label="Adults 12+">
		    					<div>
							    <span class="js-dropdown-toggle-name">Economy</span>
		    					<span class="caret"></span>
							</div>
		    				</button>
	    					<ul class="dropdown-menu dropdown-items">
							    <li><a role="menuitem" class="dropdown-item" data-value="Economy" >Economy</a></li>
							    <li><a role="menuitem" class="dropdown-item" data-value="Premium Economy" >Premium Economy</a></li>
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
			</form>
	 	</section>
	 </div>
	 <!-- end form -->
</div>

<div class="suggestion container">

	<div id="suggestion-header">
		<span id="caption">Suggestion</span>
		<span>|</span>
		<span>everything look like shit</span>
		<span class="right">everything look like shit</span>
	</div>
	<div class="col-lg-offset-1">
		<h2>Việt Nam</h2>
	</div>
	<div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-6 col-xs-12">
	   <a href="#click"> 
		   <div class="hovereffect">
	        	<img class="img-responsive" src="{{ url('/images/image350x250.png') }}" alt="">
	            <div class="overlay">
	                <h2>Hải Phòng</h2>
	                <h4>12.000.00 đ</h4>
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
	        	<img class="img-responsive" src="{{ url('/images/image350x250.png') }}" alt="">
	            <div class="overlay">
	                <h2>Mù Cang Chải</h2>
	                <h4>12.000.00 đ</h4>
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
	        	<img class="img-responsive" src="{{ url('/images/image350x250.png') }}" alt="">
	            <div class="overlay">
	                <h2>Hồ Chí Minh</h2>
	                <h4>12.000.00 đ</h4>
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
	        	<img class="img-responsive" src="{{ url('/images/image350x250.png') }}" alt="">
	            <div class="overlay">
	                <h2>Hải Phòng</h2>
	                <h4>12.000.00 đ</h4>
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
	        	<img class="img-responsive" src="{{ url('/images/image350x250.png') }}" alt="">
	            <div class="overlay">
	                <h2>Hải Phòng</h2>
	                <h4>12.000.00 đ</h4>
					<p> 
						Chi Tiết
					</p> 
	            </div>
		    </div>
	    </a>
	</div>
</div>

    <script type="text/javascript">
    </script>

    <script type="text/javascript">
    //   $(document).ready(function () {

    //     $('#form').validate({ // initialize the plugin
            
    //         submitHandler: function(form) {
    //             $("#form").attr("action", "/search/" + $('#origin-input').val().replace(/ /g,"-") + "/" + $('#destination-input').val().replace(/ /g,"-"));
    //             form.submit();
    //           }
    //     });
    // });
    </script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
		$('.picker__input').datepicker({
			format: "yyyy/mm/dd",
			startDate: 'd',
			minDate: new Date(),
    	});
		$('.date-depart').click(function(){
			$('#date-depart').focus();
		});
		$('.date-return').click(function(){
			$('#date-return').focus();
		});
		$('.adults .dropdown-items li > a').click(function(e){
		    $('#adults').val($(this).attr('data-value'));;
		    $('.adults .js-dropdown-toggle-name').text($(this).attr('data-value'));
		});
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQZWI0R8e412mvB1k44OOigCcPe5FTh0&libraries=places&callback=autocompletePlace"
        async defer></script>
@endsection
@section('footer')
	@include('layouts.footer')
@endsection