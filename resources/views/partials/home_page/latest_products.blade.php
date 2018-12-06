@if($latest_products->count()>0)
    <div id="shop" class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_bottom_85 banners__position">
        <div class="container responsive" style="padding-left: 0; padding-right: 0;">
            
        <div class="row gallery-firstrow">
        <div class="col-md-4 col-sm-4">
            <div class="gridview-pic">
                <img src="{{ asset('assets/images/first1.png') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
           
               <a href="{{ url('shop/online-shop') }}" class="btn btn-lg btn-block"><span>Wall Clock</span></a>
               </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="gridview-pic">
                <img src="{{ asset('assets/images/2nd-1.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
               <a href="{{ url('shop/farm-shop') }}" class="btn btn-lg btn-block"><span>Wood Art</span></a>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="gridview-pic">
                <img src="{{ asset('assets/images/first3.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
                <button class="btn btn-lg btn-block"><span>kids room art</span></button>
            </div>
        </div>
    </div>
        <div class="row gallery-firstrow2">
        <div class="col-md-3 col-sm-3">
            <div class="gridview-pic2">
                <img src="{{ asset('assets/images/2nd-1.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
                <a href="{{ url('shop/online-shop') }}" class="btn btn-lg btn-block"><span>Wall Clock</span></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="gridview-pic2">
                <img src="{{ asset('assets/images/2nd-2.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
                <button class="btn btn-lg btn-block"><span>Wood Art</span></button>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="gridview-pic2">
                <img src="{{ asset('assets/images/2nd-3.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
                <button class="btn btn-lg btn-block"><span>kids room art</span></button>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="gridview-pic2">
                <img src="{{ asset('assets/images/2nd-4.jpg') }}" alt="" style="width: 100%;">
            </div>
            <div class="overlay">
                <button class="btn btn-lg btn-block"><span>kids room art</span></button>
            </div>
        </div>
    </div>

           
     
      
            <!-- <div class="content-block-03" style="  padding-top: 55px;padding-bottom: 0px; text-align: center;">
                <h2 class="title-t3 text-sm-center eden-farm-text" style="margin-bottom: 10px;">Edenmill Farm</h2>
                <h2 class="title-t2 title-t2--padding text-sm-center eden-farm-text">Latest from our Shop and Smokery</h2>
            </div> -->
            <!-- featured Products sections -->
          <h3  class="title-featured text-center" style="    margin-bottom: 38px;     margin-top: 38px;"> <i class="fa fa-chevron-left"></i> <span>Featured Product</span> <i class="fa fa-chevron-right"></i></h3>
            
            @foreach($latest_products->chunk(5) as $products)
                <div class="row product-row">
                    @foreach($products as $product)
                        <div class="col-md-2-5" style="width: 20%;">
                            <figure class="banner-01__img">
                                <a class="banner-01__img-wrapp" href="{{ url('product/'.$product->slug) }}">
                                    @if($product->images->count()>0)
                                        <img style="position: relative;"  src="{{ asset('assets/images/products/'.$product->images->first()->image) }}" alt="{{ $product->name }}">
                                        <label class="tag">New</label>
                                    @else
                                        <img  src="{{ asset('assets/images/no-image.png') }}" alt="{{ $product->name }}">
                                    @endif
                                </a>
                            </figure>
                            <div class="banner-01__content">
                                <h5 class="card-dscrpt">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        {{ $product->name }} <br>
                                    <span>{{ $product->category['name'] }}</span></a>
                                </h5>
                                        
                                        <p class="text-center">${{ $product->price }}</p>
                                    
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <!-- End featured Products -->
            <!-- starting best Sellers -->
            <h3  class="title-featured text-center" style="    margin-bottom: 38px;     margin-top: 38px;"> <i class="fa fa-chevron-left"></i>  <span> Browe Our Best Sellers</span> <i class="fa fa-chevron-right"></i></h3>
                        @foreach($latest_products->chunk(5) as $products)
                            <div class="row product-row">
                                @foreach($products as $product)
                                    <div class="col-md-2-5" style="width: 20%;">
                                        <figure class="banner-01__img">
                                            <a class="banner-01__img-wrapp" href="{{ url('product/'.$product->slug) }}">
                                                @if($product->images->count()>0)
                                                    <img style="position: relative;"  src="{{ asset('assets/images/products/'.$product->images->first()->image) }}" alt="{{ $product->name }}">
                                                    <label class="tag">New</label>
                                                @else
                                                    <img  src="{{ asset('assets/images/no-image.png') }}" alt="{{ $product->name }}">
                                                @endif
                                            </a>
                                        </figure>
                                        <div class="banner-01__content">
                                            <h5 class="card-dscrpt">
                                                <a href="{{ url('product/'.$product->slug) }}">
                                                    {{ $product->name }} <br>
                                                <span>{{ $product->category['name'] }}</span></a>
                                            </h5>
                                                    
                                                    <p class="text-center">${{ $product->price }}</p>
                                                
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <!-- ending best Sellers -->
                        <!-- our Logs -->
                        <h3  class="title-featured text-center" style="    margin-bottom: 38px;     margin-top: 38px;"> <i class="fa fa-chevron-left"></i> <span>OUR bLog's</span> <i class="fa fa-chevron-right"></i></h3>
                                    @foreach($posts->chunk(5) as $products)
                                        <div class="row product-row">
                                            @foreach($products as $product)
                                                <div class="col-md-2-5" style="width: 20%;">
                                                    <figure class="banner-01__img">
                                                        <a class="banner-01__img-wrapp" href="{{ action('BlogController@showPost',$product->id) }}">
                                                                   @if($product->images_data)
                                                        <img style="position: relative;"  src="{{ asset('assets/images/blog/'.$product->images_data) }}" alt="{{ $product->meta_title }}">
                                                        <label class="tag">New</label>
                                                    @else
                                                        <img  src="{{ asset('assets/images/no-image.png') }}" alt="{{ $product->meta_title }}">
                                                    @endif
                                                           
                                                        </a>
                                                    </figure>
                                                    <div class="banner-01__content">
                                                        <h5 class="card-dscrpt">
                                                            <a href="{{ action('BlogController@showPost',$product->id) }}">
                                                               {{$product->meta_title}}<br>
                                                            </a>
                                                        </h5>
                                                            
                                                            
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                        <!-- ending our logs -->
        </div>
@endif
