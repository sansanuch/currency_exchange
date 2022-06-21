$(document).ready(function() {
    function convertRate(){
        let yourBalance = $("#your_wallet :selected").data("balance");
        let yourCurrency = $("#your_wallet :selected").data("currency"); 

        let recepientCurrency = $("#other_wallet :selected").data("currency");

        let amount = $("#transfer_amount").val(); 

        if(amount === 0 || amount === ""){
            return; 
        }

        $.ajax({
            url: "/index.php?r=exchange_rate/default/index",
        }).done(function(data) {
            let dataJson = JSON.parse(data);
            let resultConvertStr = 
                convertAlgorithm(dataJson, amount, yourCurrency, recepientCurrency); 
            
            $("#convert_result").html(resultConvertStr); 

        }); 
    }

    function convertAlgorithm(data, amount, yourCurrency, recepientCurrency){
        let convertResult = 0; 

        let yourCurrencyRate = parseFloat(data.rates[yourCurrency]);
        let recepientCurrencyRate = parseFloat(data.rates[recepientCurrency]);

        if(yourCurrency === "USD" && recepientCurrency !== "USD"){
            convertResult = amount / recepientCurrencyRate;
        }else if(yourCurrency !== "USD" && recepientCurrency === "USD"){
            convertResult = yourCurrencyRate * amount;
            console.log("test"); 
        }else if(yourCurrency === "USD" && recepientCurrency === "USD"){
            convertResult = amount;
        }else{
            convertResult = (yourCurrencyRate * amount) / recepientCurrencyRate; 
        }

        let resultConvertStr = 
            amount +" "+ yourCurrency + " = " + convertResult + " " + recepientCurrency; 
            
        return resultConvertStr; 
    }

    $('.js-example-basic-single').select2();

    $("#transfer_amount").keyup(function(){
        convertRate(); 
    });

    $("#transfer_amount").change(function(){
        convertRate(); 
    });

    $("select").change(function(){
        convertRate(); 
    });

    $("#send_btn").click(function(event){
        let yourBalance = $("#your_wallet :selected").data("balance");
        let amount = $("#transfer_amount").val(); 

        if(parseFloat(yourBalance) < parseFloat(amount)){
            alert("you do not have this amount in your account"); 
            event.preventDefault();  
        }
    });

});