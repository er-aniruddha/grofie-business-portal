<!-- Operation Modal Start -->
<form method="POST" id="productform" enctype="multipart/form-data" name="productEditform">
<!-- <form method="POST" id="{{route('product.store')}}" enctype="multipart/form-data"> -->
  @csrf
<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ></h4>
            </div>
            <div class="modal-body">             
              <div class="form-group">
                  <label for="product_name">Product Name</label>
                  <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name">
                  <h6 class="text-danger">
                    <strong id="name-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                  <label for="product_description">Product Description</label>                  
                  <input type="text" class="form-control" name="product_description" id="product_description" placeholder="Enter text">
                  <h6 class="text-danger">
                    <strong id="description-error"></strong>
                  </h6>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-6">
                    <label for="image">Image</label>                  
                  <input type="file" name="image" id="image">                              
                  <h6 class="text-danger">
                    <strong id="image-error"></strong>
                  </h6>                    
                  </div>
                  <div class="col-lg-6">                    
                      <img class="img-thumbnail" id="show-img"/>                                
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6" width="100%">
                  <div class="form-group">
                    <label>Brands</label>
                    <select class="form-control" name="brand_id" id="brand_id" style="width: 100%;">
                      <option selected="selected" value="0">Select Brand</option>
                        @if ( $brands)
                          @foreach( $brands as  $brand)
                            @if($brand->publication_status == 1)
                              <option value="{{ $brand->brand_id}}">{{ $brand->brand_name}}</option>
                            @else
                              <option value="{{ $brand->brand_id}}" disabled="disabled">{{ $brand->brand_name}}</option>
                            @endif
                          @endforeach
                        @endif
                    </select>
                    <h6 class="text-danger">
                      <strong id="brand-error"></strong>
                    </h6> 
                  </div>
            
                  <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id" id="category_id" style="width: 100%;" >
                      <option selected="selected" value="0">Select Category</option>
                      @if ( $categories)
                      @foreach( $categories as  $category)
                      @if($category->publication_status == 1)
                      <option value="{{ $category->category_id}}" >{{ $category->category_name}}</option>
                      @else
                      <option value="{{ $category->category_id}}" disabled="disabled">
                        {{ $category->category_name}}</option>
                      @endif  
                      @endforeach
                      @endif
                    </select>  
                    <h6 class="text-danger">
                      <strong id="category-error"></strong>
                    </h6> 
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                      <label>Unit</label>
                      <select class="form-control select2" name="unit_id" id="unit_id" style="width: 100%;" >
                        <option selected="selected" value="0">Select Unit</option>
                        @if ( $unites)
                        @foreach( $unites as  $unit)
                        <option value="{{ $unit->unit_id}}" >{{ $unit->unit_name_lm}}</option>
                        @endforeach
                        @endif
                      </select>
                      <h6 class="text-danger">
                        <strong id="unit-error"></strong>
                      </h6> 
                    </div> 
                  <div class="form-group">
                    <label>Sub-Category</label>
                    <select class="form-control" name="sub_cat_id" id="sub_cat_id" style="width: 100%;" >
                      <option selected="selected" value="0">Select Sub-Category</option>
                      @if ( $sub_categories)
                      @foreach( $sub_categories as  $sub_category)
                      @if($sub_category->publication_status == 1)
                      <option value="{{ $sub_category->sub_cat_id}}" >{{ $sub_category->sub_cat_name}}</option>
                      @else
                      <option value="{{ $sub_category->sub_cat_id}}" disabled="disabled">
                        {{ $sub_category->sub_cat_name}}</option>
                      @endif  
                      @endforeach
                      @endif
                    </select>  
                    <h6 class="text-danger">
                      <strong id="sub-category-error"></strong>
                    </h6> 
                  </div>
                </div>  
              </div>
              <p class="text-danger">
                <strong>TAXES</strong>
              </p>
              <div class="row">
                <div class="col-lg-6">                    
                    <div class="form-group">
                        <label>CGST</label>
                      <select class="form-control" name="cgst_rate" id="cgst_rate" style="width: 100%;" >
                        <option selected="selected" value="0">Not Applicable</option>
                        @if ( $taxes)
                        @foreach( $taxes as  $tax)
                        @if($tax->cgst_name)
                        <option value="{{$tax->cgst_rate}}" >{{ $tax->cgst_name}}</option>
                        @endif
                        @endforeach
                        @endif
                      </select>                   
                    </div>
                     <div class="form-group">
                      <label>SGST</label>
                      <select class="form-control" name="sgst_rate" id="sgst_rate" style="width: 100%;" >
                        <option selected="selected" value="0">Not Applicable</option>
                        @if ( $taxes)
                        @foreach( $taxes as  $tax)
                        @if($tax->sgst_name)
                        <option value="{{ $tax->sgst_rate}}" >{{ $tax->sgst_name}}</option>
                        @endif
                        @endforeach
                        @endif
                      </select>
                    </div>
                </div>
                <div class="col-lg-6">
                     <div class="form-group">
                      <label>IGST</label>
                      <select class="form-control" name="igst_rate" id="igst_rate" style="width: 100%;" >
                        <option selected="selected" value="0">Not Applicable</option>
                        @if ( $taxes)
                        @foreach( $taxes as  $tax)
                        @if($tax->igst_name)
                        <option value="{{ $tax->igst_rate}}" >{{ $tax->igst_name}}</option>
                        @endif
                        @endforeach
                        @endif
                      </select>
                    </div>
                     <div class="form-group">
                      <label>UGST</label>
                      <select class="form-control" name="ugst_rate" id="ugst_rate" style="width: 100%;" >
                        <option selected="selected" value="0">Not Applicable</option>
                        @if ( $taxes)
                        @foreach( $taxes as  $tax)
                        @if($tax->ugst_name)
                        <option value="{{ $tax->ugst_rate}}" >{{ $tax->ugst_name}}</option>
                        @endif
                        @endforeach
                        @endif
                      </select>
                    </div>
                </div>
                
              </div>                         
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Buy Price</label>
                    <input class="form-control" type="number" name="product_buy_price" id="product_buy_price" placeholder="Buy Price">
                    <h6 class="text-danger">
                        <strong id="buy-price-error"></strong>
                      </h6>
                  </div>
                  <div class="form-group">
                    <label>Buy Qty</label>
                    <input class="form-control" type="number" name="product_buy_qty" id="product_buy_qty" placeholder="Buy Qty">
                    <h6 class="text-danger">
                      <strong id="buy-qty-error"></strong>
                    </h6>
                  </div>
                   <div class="form-group">
                    <label>Sell Price</label>
                    <input class="form-control" type="number" name="product_sell_price" id="product_sell_price" placeholder="Sell Price">
                    <h6 class="text-danger">
                      <strong id="sell-price-error"></strong>
                    </h6>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>% Offer</label>
                    <input class="form-control" type="number" name="product_offers" id="product_offers" placeholder="% offer">
                    <h6 class="text-danger">
                      <strong id="offer-error"></strong>
                    </h6>
                  </div>
                  <div class="form-group">
                    <label>Offer Price</label>
                    <input class="form-control" type="number" id="product_sell_price_after_offer" disabled="">
                   
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Slider Image 1</label>
                  <input type="file" name="image1" id="image1" >
                  <h6 class="text-danger">
                      <strong id="image1-error"></strong>
                    </h6>
              </div>

              <div class="form-group">
                  <label for="exampleInputFile">Slider Image 2</label>
                  <input type="file" name="image2" id="image2" >
                 <h6 class="text-danger">
                      <strong id="image2-error"></strong>
                    </h6>
              </div>
              <div class="form-group">
                  <label for="exampleInputFile">Slider Image 3</label>
                  <input type="file" name="image3" id="image3" >
                  <h6 class="text-danger">
                      <strong id="image3-error"></strong>
                    </h6>
              </div>
              <div class="form-group">
                  <label for="exampleInputFile">Slider Image 4</label>
                  <input type="file" name="image4" id="image4" >
                  <h6 class="text-danger">
                      <strong id="image4-error"></strong>
                    </h6>
              </div>
              <!-- <div class="form-group">
                  <label for="exampleInputFile">Slider Image 5</label>
                  <input type="file" name="image5"  id="image5" >
                  <h6 class="text-danger">
                      <strong id="image5-error"></strong>
                    </h6>
              </div> -->
              <div class="form-group status">
                <label>Status</label>
                <label class="radio-inline">
                    <input type="radio" name="product_stat" id="product_stat" value="1">Active
                </label>
                <label class="radio-inline">
                    <input type="radio" name="product_stat" id="product_stat" value="2">Deactive
                </label>
                <h6 class="text-danger">
                  <strong id="status-error"></strong>
                </h6>               
              </div>
            
            </div>
            <div class="modal-footer">
            <input type="hidden" name="product_id" id="product_id" />
   
            <input type="submit" name="add_productBtn" id="add_productBtn" class="btn btn-primary" value="Create"/>
            <button type="button" class="btn btn-default" name="closBtn" id="closBtn" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</form>
<!-- Operation Modal End-->
