<?php
/* @var $this yii\web\View */
use app\assets\AppAsset;
AppAsset::register($this);  
$this->registerJsFile(
    '@web/js/exchange.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<div class = "row">
    <div class = "col-lg-12 text-center">
        <h1 class="display-4">Welcome!</h1>
        <h2>Currency exchange form between wallets<h2/>
    </div>
</div>
<div class="row">
    
    <div class = "col-md-12">
    <form method = "POST" action="/index.php?r=exchange/exchange">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="form-group">
            <label for="your_wallet"><strong>Your wallet</strong></label>
            <select name = "your_wallet"
                 id= "your_wallet"
                  class="js-example-basic-single form-control"
            >
                <?php if(empty($user_wallet)): ?>
                    <option value="no">Wallet not found</option>
                <?php endif; ?>

                <?php foreach($user_wallet as $wallet): ?>    
                    <option value="<?=$wallet['id'] ?>"
                    data-currency="<?= \Yii::$app->params['currencies_all'][$wallet['currency_id']] ?>"
                    data-balance=<?= $wallet['balance'] ?>
                    ><?=$wallet["name"] ?>
                    Balance: <?= $wallet['balance'] ?> 
                    <?= \Yii::$app->params['currencies_all'][$wallet['currency_id']] ?>
                     </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="other_wallet"><strong>Wallet of the recipient</strong></label>
            <select 
                name = "recepient_wallet"
                id = "other_wallet" 
                class="js-example-basic-single form-control"
            >
                <?php if(empty($other_user_wallet)): ?>
                    <option value="no">Wallet not found</option>
                <?php endif; ?>
                    
                <?php foreach($other_user_wallet as $wallet): ?>    
                    <option value="<?=$wallet['id'] ?>"
                    data-currency="<?= \Yii::$app->params['currencies_all'][$wallet['currency_id']] ?>"
                    data-balance=<?= $wallet['balance'] ?>
                    ><?=$wallet["name"] ?>
                    Balance: <?= $wallet['balance'] ?> 
                    <?= \Yii::$app->params['currencies_all'][$wallet['currency_id']] ?>
                     </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="transfer_amount"><strong>Transfer amount</strong></label>
            <input name = "amount" required type="number" step="any" class="form-control" id="transfer_amount" >
        </div>
        <div id = "convert_result"></div>
        <button id = "send_btn" class="btn btn-primary">Submit</button>
    </form>
   
    </div>
</div>
