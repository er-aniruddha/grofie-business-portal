

<div class="orders-details card">
    <div class="tab-content">
        <button type="button" class="backBtn btn btn-outline-dark m-1 float-right">Back</button>
        <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
            <div class="d-sm-flex mb-5">                
                <span class="m-auto"></span>
            </div>
            <!---===== Print Area =======-->
       
            <div id="print-area">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="font-weight-bold">Order Info</h4>
                        <p class="text-muted order-id"></p>
                    </div>
                    <div class="col-md-6 text-sm-right">
                        <strong>Order status:</strong>
                        <p class="status1 badge badge-warning"></p>
                        <p class="status2 badge badge-light"></p>
                        <p class="order-date"></p>
                    </div>
                </div>
                <div class="mt-3 mb-4 border-top"></div>
                <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-sm-0">
                        <h5 class="font-weight-bold">Address: </h5>
                        <p class="name"></p>
                        <span style="white-space: pre-line" id="place_name">
                           
                        </span>
                        <p id="phone"></p>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12 table-responsive">
                        <table class="table table-hover mb-3" id="order-details-table">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>

                        </table>
                        <div class="text-center spiner-details">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="invoice-summary">
                            <p>Sub total: <span class="subtotal"></span> </p>
                            <p>Delivery Charges on Amount: <span class="deliveryAmount"></span></p>
                            <p>Delivery Charges on KM: <span class="deliverykm"></span></p>
                            <h5 class="font-weight-bold">Total: <span class="total"></span></h5>
                        </div>
                    </div>
                </div>

            </div>
            <!--==== / Print Area =====-->
        </div>
    </div>
</div>