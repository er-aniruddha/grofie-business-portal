<script>
$('.conf-page').hide();
$('.setpin-page').hide();
$('.spinner-btn').hide();
$('.head-title').text('Log In');
$(document).ready(function(){ 
  $(document).on('click','.loginBtn',function(event){
    $('.loginBtn').hide();
    $('.spinner-btn').show();
    event.preventDefault()    
      var postData = new FormData($("#submitLoginForm")[0]);          
      $('#phone-error').html( "" );     
      $.ajax({
       type:'POST',
       url:"{{route('delivery.login')}}", 
       contentType: false,
       cache: false,
       processData: false,
       dataType:"json",
       data : postData,
          success:function(data) {
              if(data.errors) {
                $('.loginBtn').show();
                $('.spinner-btn').hide();
                if(data.errors.phone){
                $( '#phone-error' ).html( data.errors.phone[0] );               
                }                           
              }
              if(data.notverified)
              {
                $('.head-title').text('Hi, '+data.notverified.f_name);
                $('.spinner-btn').hide();
                $('.phone-page').hide();
                $('.confirm-page').hide();
                $('.setpin-page').show();
                $('.forget-pin').hide();
                $("#submitLoginForm")[0].reset();
              }
              if(data.verified)
              {
                $('.head-title').text('Hi, '+data.verified.f_name);
                $('.spinner-btn').hide();
                $('.phone-page').hide();
                $('.setpin-page').hide();
                $('.conf-page').show();                 
                $("#submitLoginForm")[0].reset();
              }
            },
          }); 
      });
  // Set PIN
  $(document).on('click','.setPinBtn',function(event){
    $('.setPinBtn').hide();
    $('.footer-page').hide();
    $('.spinner-btn').show();
    event.preventDefault()    
      var postData = new FormData($("#setPinForm")[0]);          
      $('#setpin-error').html( "" );  
      $('#confpin-error').html( "" );     
      $.ajax({
       type:'POST',
       url:"{{route('delivery.setpin')}}", 
       contentType: false,
       cache: false,
       processData: false,
       dataType:"json",
       data : postData,
        success:function(data) {
              if(data.errors){
                $('.setPinBtn').show();
                $('.spinner-btn').hide();
                $( '#setpin-error' ).html( data.errors.pin[0] ); 
              }
              if(data.invalid){
                $('.setPinBtn').show();
                $('.spinner-btn').hide();
                $( '#setpin-error' ).html( data.invalid);  
              }
              if(data.success)
              { 
                $('.setPinBtn').hide();
                $("#setPinForm")[0].reset();                  
                window.location="{{route('delivery.dashboard')}}"
              }
          },
        }); 
      });
// Login Confirm page
$(document).on('click','.confBtn',function(event){
    $('.confBtn').hide();
    $('.spinner-btn').show();
    event.preventDefault()    
      var postData = new FormData($("#loginConfirmForm")[0]);          
      $('#pin-error').html( "" );  
      $.ajax({
       type:'POST',
       url:"{{route('delivery.login.confirm')}}", 
       contentType: false,
       cache: false,
       processData: false,
       dataType:"json",
       data : postData,
          success:function(data) {
            console.log(data);               
              if(data.errors) {
                $('.confBtn').show();
                $('.spinner-btn').hide();
                $( '#pin-error' ).html( data.errors.pin[0] );                   
              }  
              if(data.invalid) {
                $('.confBtn').show();
                $('.spinner-btn').hide();
                $( '#pin-error' ).html( data.invalid);                   
              }         
              if(data.success == 1){
                $('.confBtn').hide(); 
                $("#loginConfirmForm")[0].reset();               
                window.location="{{route('delivery.dashboard')}}"
              }
            },
          }); 

      });
});
</script>