<script>
jQuery(function($){
    $('input[type=text], textarea').keypress(function (e) {
    var txt = String.fromCharCode(e.which);
    if (!txt.match(/[A-Za-z0-9&. ]/)) {
        return false;
    }
});
$( 'input[type=text], textarea' ).bind( 'copy paste', function (e) {
            var regex = new RegExp( "@" );
             
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
             
            if (!regex.test(key)) {
                alert ( "Not allowed to paste" ); // Put any message here
                e.preventDefault();
                return false;
            }
        });

});
</script>
