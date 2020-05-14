<script>
$('.order-details-spinner-btn').hide();
$('.spiner-details').hide();
$('.orders-details').hide(); 
$(document).ready(function(){
 $(document).on('click','.orders-detailsBtn',function(event){
 	event.preventDefault()
    var subtotal = 0;
    var total = 0;
    var i = 0 , delcharges=0 , kmDelCharges =0;
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
        $('.name').text(data.deliveryDetails[0].f_name+' '+data.deliveryDetails[0].s_name);
        $("#place_name").text(data.deliveryDetails[0].place_name+', '+data.deliveryDetails[0].select_city);
        $("#phone").text(data.deliveryDetails[0].phone+'/'+data.deliveryDetails[0].alt_phone);
        $('.orders-details').show();   
        $('.spinner-btn').hide();
        $('.orderConf-spinner-btn').hide();
        $('.orders').hide();
        for(var count=0; count < data.deliveryDetails.length ; count++){  
            if(i != data.orderDetails[count].order_id){

                i = data.orderDetails[count].order_id;
                delcharges = parseInt(data.orderDetails[count].delivery_charges ,10);
                kmDelCharges = parseInt(data.orderDetails[count].delivery_km_charges ,10);
            }   
            if(data.deliveryDetails[count].order_stat == 3)
            {
                var cost = '';
                var price = '';
                if(data.deliveryDetails[count].sell_price_after_offer > 0){
                    price = data.deliveryDetails[count].sell_price_after_offer;
                    cost = data.deliveryDetails[count].sell_price_after_offer * data.deliveryDetails[count].qty;
                }
                else{
                    price = data.deliveryDetails[count].sell_price;
                    cost = data.deliveryDetails[count].sell_price * data.deliveryDetails[count].qty;
                }             
                subtotal = subtotal+cost;
            $('#order-details-table').append('<tr class="order'+data.deliveryDetails[count].product_id+'">'
                +'<th>'+ data.deliveryDetails[count].product_name +'</th>'
                +'<td>'+ price +'</td>'
                +'<td>'+ data.deliveryDetails[count].qty +'</td>'
                +'<td>'+ cost +'</td>'
                
                +'</tr>'); 
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
$(document).on('click' ,'.backBtn',function(){
    $('.orders').show(); 
    $('.orders-details').hide();  
    $('.orders-detailsBtn').show();
    $('.order-details-spinner-btn').hide();

});

});

</script>