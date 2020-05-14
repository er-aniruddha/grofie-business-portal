$(document).ready(function(){   		
/* Instant show image on upload */
$("#image").change(function(){
    readURL(this);
});  
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#show-img')
                .attr('src', e.target.result)
                .width(70)
                .height(70);
        };
        reader.readAsDataURL(input.files[0]);
    }
} 
   

});


$(document).ready(function() {
    $('.product-list').select2();
});
