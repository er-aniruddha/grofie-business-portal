<script>
$('.order-details-spinner-btn').hide();
$('.spiner-details').hide();
$('.orders-details').hide(); 
$(document).ready(function(){

 $(document).on('click','.orders-detailsBtn',function(event){
    event.preventDefault()
    var i=0, subtotal = 0, delcharges = 0 , kmDelCharges = 0;
    $('.orderConf').append(' <button type="submit" class="orderConfBtn btn btn-warning m-1 float-right" data-confurl="'+$(this).attr('orderId')+'">Confirm</button> ');
    $('.orders-detailsBtn').hide();
    $('.order-details-spinner-btn').show();
    $('.orders').hide();
    $('.order-id').text($(this).attr('orderId'));
    $('.name').text($(this).data('name'));
    var status = $(this).attr('status');
    if(status == 3)
    {
        $('.status2').append(''+'Delivered');
    }
    else
    {
        $('.status1').append(''+'On Way');
    }
    $('.order-date').append('<strong>Order date: </strong>'+($(this).attr('order-date')));
    /*Get value to show Invoice*/
    $.ajax({
    type:'GET',
    url: $(this).attr("url"), 
    dataType:"json",
    success:function(data) { 
        $('.name').text(data.orderDetails[0].f_name+' '+data.orderDetails[0].s_name);
        $("#place_name").text(data.orderDetails[0].place_name+', '+data.orderDetails[0].select_city);
        $("#phone").text(data.orderDetails[0].phone+'/'+data.orderDetails[0].alt_phone);
        $('.orders-details').show();   
        $('.spinner-btn').hide();
        $('.orderConf-spinner-btn').hide();
        $('.orders').hide();
        for(var count=0; count < data.orderDetails.length ; count++){
            if(i != data.orderDetails[count].order_id){

                i = data.orderDetails[count].order_id;
                delcharges = parseInt(data.orderDetails[count].delivery_charges ,10);
                kmDelCharges = parseInt(data.orderDetails[count].delivery_km_charges ,10);
            }
            if(data.orderDetails[count].order_stat == 2)
            {
                var cost = '';
                var price = '';
                if(data.orderDetails[count].offers > 0){
                    price = data.orderDetails[count].sell_price_after_offer;
                    cost = data.orderDetails[count].sell_price_after_offer * data.orderDetails[count].qty;
                }
                else{
                    price = data.orderDetails[count].sell_price;
                    cost = data.orderDetails[count].sell_price * data.orderDetails[count].qty;
                }             
                subtotal = subtotal+cost;
            $('#order-details-table').append('<tr class="order'+data.orderDetails[count].product_id+'">'
                +'<th>'+ data.orderDetails[count].product_name +'</th>'
                +'<td>'+ price +'</td>'
                +'<td>'+ data.orderDetails[count].qty +'</td>'
                +'<td>'+ cost +'</td>'
                +'<td class="rtn"><button type="button" rtn-url={{ url('/delivery/order/return/')}}/'+data.orderDetails[count].order_id+'/'+data.orderDetails[count].product_id+' class="rtnBtn btn btn-outline-warning btn-sm">Return</button></td>'+
                '</tr>'); 
            }   
        }  
        //Delivery Charges on Amount
        if(delcharges == 0){
            $('.deliveryAmount').text("Free");      
        }
        else{
            $('.deliveryAmount').text(delcharges);      
        }
        //Delivery Charges on KM
        if(kmDelCharges == 0){
            $('.deliverykm').text("Free");      
        }
        else{
            $('.deliverykm').text(kmDelCharges);      
        }
       total = subtotal + delcharges + kmDelCharges;
        // $('.subtotal').append('Sub total: <span>'+subtotal+'</span>');
        // $('.delivery').append('Delivery Charges: <span>'+delivery+'</span>');
        // $('.total').append('Total: <span>'+total+'</span>');
        $('.subtotal').text(subtotal);
        $('.total').text(total);
      }, 
    });
 });
$(document).on('click', '.rtnBtn', function(event){
    event.preventDefault()  
    $('.spiner-details').show();
    $('#order-details-table tbody').empty();
    $('.subtotal').text('');
    $('.delivery').text('');
    $('.total').text('');
    var rtn = $(this).attr('rtn-url');
    var subtotal = 0;
    var total = 0;
    var i = 0,  delcharges = 0 , kmDelCharges = 0;

    $.ajax({
    type:'GET',
    url:$(this).attr('rtn-url'),
    dataType:'json',
    success:function(data){
        $('.spiner-details').hide();
        $('.rtnBtn').show();
        $('.spinner-btn').hide();
        console.log(data);
        if(data.allreturned == 1)
        {           
            window.location="{{route('delivery.dashboard')}}";
        } 
        for(var count=0; count < data.returnOrder.length ; count++){ 
             if(i != data.returnOrder[count].order_id){

                i = data.returnOrder[count].order_id;
                delcharges = parseInt(data.returnOrder[count].delivery_charges ,10);
                kmDelCharges = parseInt(data.returnOrder[count].delivery_km_charges ,10);
            }
                    
            if(data.returnOrder[count].order_stat == 2)
            {
                var cost = '';
                var price = '';
                if(data.returnOrder[count].sell_price_after_offer > 0){
                    price = data.returnOrder[count].sell_price_after_offer;
                    cost = data.returnOrder[count].sell_price_after_offer * data.returnOrder[count].qty;
                }
                else{
                    price = data.returnOrder[count].sell_price;
                    cost = data.returnOrder[count].sell_price * data.returnOrder[count].qty;
                } 
                if(data.returnOrder[count].order_stat == -1) 
                {
                    $('.rtnBtn').hide();
                    $('.rtnBtnD').show();
                }           
                subtotal = subtotal+cost;
                $('#order-details-table').append('<tr>'
                +'<th>'+ data.returnOrder[count].product_name +'</th>'
                +'<td>'+ price +'</td>'
                +'<td>'+ data.returnOrder[count].qty +'</td>'
                +'<td>'+ cost +'</td>'
                +'<td class="rtn"><button type="button" rtn-url={{ url('/delivery/order/return/')}}/'+data.returnOrder[count].order_id+'/'+data.returnOrder[count].product_id+' class="rtnBtn btn btn-outline-warning btn-sm">Return</button></td>'+
              
                '</tr>'); 
            } 
        }
         //Delivery Charges on Amount
        if(delcharges == 0){
            $('.deliveryAmount').text("Free");      
        }
        else{
            $('.deliveryAmount').text(delcharges);      
        }
        //Delivery Charges on KM
        if(kmDelCharges == 0){
            $('.deliverykm').text("Free");      
        }
        else{
            $('.deliverykm').text(kmDelCharges);      
        }
       total = subtotal + delcharges + kmDelCharges;
        $('.subtotal').text(subtotal);
        $('.total').text(total);
       
        },
    });
});

$(document).on('click','.orderConfBtn',function(event){
    event.preventDefault()
    var url = "{{url('/')}}/delivery/order/confirm/" +($(this).data('confurl'));
    console.log(url);
    $('.orderConfBtn').hide();
    $('.orderConf-spinner').show();
    $.ajax({
        type:'GET',
        url:url,
        dataType:'json',
        success:function(data){
           console.log(data);
            if(data.success == 1){
                window.location = "{{route('delivery.dashboard')}}";
                 // console.log(data.success);
            }       
        },
    });
});

});

</script>