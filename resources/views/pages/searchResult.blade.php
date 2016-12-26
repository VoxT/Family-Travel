@extends('layouts.master')


@section('content')
<div class="container-fluid">
<div class="raw">
<!-- Form -->
    <div class="search-bar" id="search-bar">
      <form action="" method="GET" id="search-form-bar" class="form-inline">
      {!! csrf_field() !!}
      <div class="form-group">
        <label class="sr-only" for="origin-input">Nhập địa điểm</label>
        <div class="input-group">
          <div class="input-group-addon" id="from-label">Đi</div>
          <input type="text" class="form-control" name="originplace" id="origin-input" placeholder="Nhập điểm đi" required="Vui lòng nhập điểm đi">
          <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
        </div>
        <div id="switch" class="form-control"><i class="fa fa-exchange" aria-hidden="true"></i></div>
      </div>
        <div class="form-group">
        <label class="sr-only" for="destination-input">Nhập địa điểm</label>
        <div class="input-group">
          <div class="input-group-addon">Đến</div>
          <input type="text" class="form-control" name="destinationplace" id="destination-input" placeholder="Nhập điểm đến" required="Vui lòng nhập điểm đến">
          <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
        </div>
      </div>
      </form>

      <div class="view-report">
        <a href="{{ url('current_report') }}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Xem Chuyến Đi</a>
      </div>
    </div>
    <!-- /.form -->

    <div id="map"></div>
    <!-- results marker on map-->
    <div id="results" > </div>
    <div style="display: none">
        <div id="info-content" >
            <div class="row" >
               <div id="iw-icon"></div>
               <div id="iw-url" class="url_name"></div>
               <p class="views"> Cảnh đẹp, nơi giải trí ,....</p>
               <div> <hr class="line" /></div>
               <div id="iw-rating-row" > 
                   <p class="iw-rating"> Đánh giá: <span id="iw-rating"></span></p>
<!-- 
                 <div class="add">
                   <button type="button" class="btn" id="addPlace" title="Thêm vào chuyến đi"><i class="fa fa-plus" aria-hidden="true"></i></button>
                 </div> -->
               </div>
            </div>       
        </div>
    </div>   
    <div  id="iw-reviews-row">
      <div id="review-image"></div><br>
      <div id= "review-url" class="review-url"></div>
      <br>
      <div id ="reviews"></div>
      
    </div> 

    <div class="fixed list-result">
      <div class="list-group">
      <button type="button" class="list-group-item" id="plane"  data-toggle="modal" data-target="#planeModal">
        <span class="badge plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
        <span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
        <h4>Bay từ Hà Nội</h2>
        <p>Sắp xếp theo giá rẻ nhất</p>
        <span class="price-right"></span>
      </button>
      <button type="button" class="list-group-item" id="hotel" data-toggle="modal" data-target="#hotelModal">
        <span class="badge hotel"><i class="fa fa-bed" aria-hidden="true"></i></span>
        <span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
        <h4>Đặt khách sạn tại Hồ Chí Minh</h2>
        <p>Theo giá hợp lý nhất</p>
      </button>
      <button type="button" class="list-group-item" id="car" data-toggle="modal" data-target="#carModal">
        <span class="badge car"><i class="fa fa-car" aria-hidden="true"></i></span>
        <span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
        <h4>Thuê xe tại Hồ Chí Minh</h2>
        <p>Theo giá hợp lý nhất</p>
      </button>
      <button type="button" class="list-group-item" id="things" data-toggle="modal" data-target="#thingsModal">
        <span class="badge things"><i class="fa fa-university" aria-hidden="true"></i></span>
        <span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
        <h4>Địa điểm vui chơi tại Hồ Chí Minh</h2>
        <p>Những địa điểm hấp dẫn nhất</p>
      </button>
    </div>

    </div>
</div>
</div>



<!-- Flight Modal -->
<div class="modal fadeLeft fade" id="planeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="planeModalLabel"><i class="fa fa-plane" aria-hidden="true"></i> Bay từ Hanoi đến Ho Chi Minh City</h2>
        <div class="flight-form-modal">
        <button type="button" class="depart" id="depart"><i class="fa fa-calendar" aria-hidden="true"></i>
             <span>27/10/2016</span>
            <input type="date" name="outbounddate" id="outbounddate">
        </button>
        <button type="button" class="arrival" id="arrival"><i class="fa fa-calendar" aria-hidden="true"></i> 
            <span> --/--/---- </span>
            <input type="date" name="inbounddate" id="inbounddate">
        </button>
        <button type="button" class="moreInfo" id="moreInfo"><span> 1 người, ghế thương gia</span> <span class="caret"></span></button>
        <button type="button" class="flight-search btn-search" id="flight-search">Tìm Kiếm</button>
        <div class="popover-flight container" style="display: none;">
            <div class="form-horizontal">
              <div class="form-group">
            <label for="adults">Người lớn</label>
            <select class="form-control" id="adults">
              <option selected>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
              <div class="form-group">
            <label for="childrens">Trẻ trên 12</label>
            <select class="form-control" id="childrens">
              <option selected>0</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
              <div class="form-group">
            <label for="kid">Trẻ dưới 12</label>
            <select class="form-control" id="kid">
              <option selected>0</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
            </div>
            <div class="cabinclass">
              <h4>Loại Ghế</h4>
              <label class="form-check-label col-md-6">
                  <input class="form-check-input" type="radio" name="cabinclass" id="gridRadios1" value="Economy" checked>
                  Economy
               </label>
              <label class="form-check-label col-md-6">
                  <input class="form-check-input" type="radio" name="cabinclass" id="gridRadios1" value="PremiumEconomy" >
                  Premium Eco
              </label>
              <label class="form-check-label col-md-6">
                  <input class="form-check-input" type="radio" name="cabinclass" id="gridRadios1" value="Business" >
                  Business
              </label>
              <label class="form-check-label col-md-6">
                  <input class="form-check-input" type="radio" name="cabinclass" id="gridRadios1" value="First" >
                  First
              </label>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="result-list">
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal flight details -->
<div class="modal fade" id="flightdetailsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Thông Tin Chuyến Bay</h3>
      </div>
      <div class="modal-body">
       
      </div>
    </div>
  </div>
</div>
<!-- Car Model -->
<div class="modal fadeLeft fade" id="carModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="modalLabel"><i class="fa fa-car" aria-hidden="true"></i> Thuê xe tại Ho Chi Minh City</h2>
        <div class="flight-form-modal">
        <button type="button" class="depart" id="pickupdate"><i class="fa fa-calendar" aria-hidden="true"></i>
             <span>27/10/2016</span>
            <input type="date" name="pickupdate" id="pickupdate-input">
        </button>
      <i class="fa fa-clock-o" aria-hidden="true"></i>
        <select class="picktime" id="pickuptime">
          <option>8:00</option>
          <option>8:30</option>
          <option>9:00</option>
          <option>9:30</option>
      </select>
        <button type="button" class="arrival" id="dropoffdate"><i class="fa fa-calendar" aria-hidden="true"></i> 
            <span> --/--/---- </span>
            <input type="date" name="dropoffdate" id="dropoffdate-input">
        </button>
      <i class="fa fa-clock-o" aria-hidden="true"></i>
        <select class="picktime" id="dropofftime">
          <option>8:00</option>
          <option>8:30</option>
          <option>9:00</option>
          <option>9:30</option>
      </select>
          <input type="date" name="pickupdatetime" id="pickupdatetime">
          <input type="date" name="dropoffdatetime" id="dropoffdatetime">
        <button type="button" class="flight-search btn-search" id="car-search">Tìm Kiếm</button>
        </div>
      </div>  
      <div class="modal-body">
        <div class="result-list">
          <div class="loading">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            <p>Đang tìm kiếm ...</p>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Hotel Model -->
<div class="modal fadeLeft fade" id="hotelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="modalLabel"><i class="fa fa-bed" aria-hidden="true"></i> Khách sạn tại Ho Chi Minh City</h2>
         <div class="flight-form-modal">
        <button type="button" class="depart" id="depart"><i class="fa fa-calendar" aria-hidden="true"></i>
             <span>27/10/2016</span>
            <input type="date" name="checkindate" id="checkindate">
        </button>
        <button type="button" class="arrival" id="arrival"><i class="fa fa-calendar" aria-hidden="true"></i> 
            <span> --/--/---- </span>
            <input type="date" name="checkoutdate" id="checkoutdate">
        </button>
        <button type="button" class="moreInfo" id="moreHotelInfo"><span>1 Người, 1 Phòng</span> <span class="caret"></span></button>
        <button type="button" class="flight-search btn-search" id="hotel-search">Tìm Kiếm</button>
        <div class="popover-hotel container" style="display: none;">
            <div class="form-horizontal">
              <div class="form-group">
            <label for="guests">Số Người</label>
            <select class="form-control" id="guests">
              <option selected>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
              <div class="form-group">
            <label for="rooms">Số Phòng</label>
            <select class="form-control" id="rooms">
              <option selected>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
            </select>
          </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>  
      <div class="modal-body">
        <div class="result-list">
          <div class="loading">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            <p>Đang tìm kiếm ...</p>
          </div>
          <!-- list item here -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal hotel details -->
<div class="modal fade" id="hoteldetailsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Thông Tin Khách Sạn</h3>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<!-- Hotel Model -->
<div class="modal fadeLeft fade" id="thingsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="modalLabel"><i class="fa fa-university" aria-hidden="true"></i> Địa điểm vui chơi, ăn uống</h2>
      </div>  

      <div class="place-review-first"></div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#museum">Bảo tàng</a></li>
            <li><a data-toggle="tab" href="#parks">Công viên</a></li>
            <li ><a data-toggle ="tab" href="#restaurant">Nhà hàng</a></li>
            <li ><a data-toggle ="tab" href="#other">Điểm Thú Vị Khác</a></li>
        </ul>
         <div class="clearfix"> </div>
        <div class="tab-content">
          <div id="museum" class="tab-pane fade in active">
          </div>
          <div id="parks" class="tab-pane fade">    
          </div>
          <div  id="restaurant" class="tab-pane fade">
          </div>
          <div  id="other" class="tab-pane fade">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--begin modal window-->
<div class="modal fade" id="imageModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

      <!--begin carousel-->
        <div id="myGallery" class="carousel" data-interval="false">
          <div class="carousel-inner">
            
          <!--end carousel-inner--></div>
          <!--Begin Previous and Next buttons-->
          <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myGallery" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
        <!--end carousel--></div>
        </div>
      </div><!--end modal-content-->
  </div><!--end modal-dialoge-->
</div><!--end myModal-->


<!--begin modal window-->
<div class="modal animated zoomIn" id="tourModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      <p>lol</p>
      </div>
    </div><!--end modal-content-->
  </div><!--end modal-dialoge-->
</div><!--end myModal-->

<!-- booking flight -->
<form action="/booking/" method="post" target="_blank" id="book" enctype='application/json'>
   {{ csrf_field() }}
  <input type="hidden" name="details" value="">
</form>

  

@endsection

@section('footer')
@endsection

@section('scripts')
<!-- --------------------------------------------------- -->

<script type="text/javascript">
  var request = JSON.parse('{{ $request}}'.replace(/&quot;/g,'"'));
  var tourId = '{{$tourId}}';
  var isLogin = {{$login? 'true':'false'}};

  $('#switch').click(function(){
    var originInput = $('#origin-input').val();
    $('#origin-input').val($('#destination-input').val());
    $('#destination-input').val(originInput);
  });
  $('#planeModal').on('hide.bs.modal', function (e) {

  });
</script>

  <script src="{{ elixir('js/mapScript.js') }}"></script> 
  <script src="{{ elixir('js/apiScript.js') }}"></script> 
  <script src="{{ elixir('js/homeScript.js') }}"></script>
  <script src="{{ elixir('js/searchResult.js') }}"></script>

<script src="{{ elixir('js/template.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvf3SMKYOCFlAtjUTKotmrF6EFrEk2a40&callback=initMap&language=vi&region=VN&libraries=places">
</script>
@endsection