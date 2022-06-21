$(document).ready(function() {
    function getExchangeRate(){
        let CRYPTO_CURRENCIES = ['BTC', 'ETH', 'DOGE', 'LTC']; 
 
        $.ajax({
            url: "/index.php?r=exchange_rate/default/index",
        }).done(function(data) {
            let dataJson = JSON.parse(data);

            for(i = 0; i < CRYPTO_CURRENCIES.length; i++){
                let index = CRYPTO_CURRENCIES[i]
                let course = "<p>" + index +" - "+ dataJson["rates"][index] + "</p>";
                $("#crypto_currency_container").append(course);
            } 
        }); 
    }

    getExchangeRate();

    $("#refresh_course").click(function(){
        $("#crypto_currency_container").html('');
        getExchangeRate();
    });
});
