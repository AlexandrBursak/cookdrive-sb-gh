<?php if (!empty($session['cart'])) : ?>
<div class="row">
    <div class="col-lg-12">
        <div class="cart_wrap clearfix">
            <div class="balance">
                <p class="balance_before">Ваш баланс<span>600</span>грн.</p>
                <p class="balance_after">баланс після замовлення<span>600</span>грн.</p>
            </div>
            <div class="cart_title">
                <span>Ваше замовлення</span>
            </div>
            <div class="order_item_wrap">
<?php  foreach ($session['cart'] as $id => $item): ?>

                <div class="one_order_item  clearfix">
                    <div class="one_order_item_img">
                        <img src="http://cookdrive.com.ua/var/catalog/products/thumbs/577cc94af3587.png
                        <?php 
                        // echo $item['img']
                        ?>" alt="img">
                    </div>
                    <div class="one_order_item_name">
                        <p><?php echo $item['name']?><span>(<?php echo $item['description']?>)</span></p>
                    </div>
                    <div class="one_order_item_info">
                        <div class="one_order_item_price">
                            <p><?php echo $item['price']?><span> грн.</span></p>
                        </div>
                        <div class="catalog_product_quantity">
                            <input type="text" data-id='<?php echo $id?>' value="<?php echo $item['qty']?>" maxlength="3">
                            <span class="plus"></span>
                            <span class="minus"></span>
                            <span class="unit">шт.</span>
                        </div>
                        <div class="one_order_item_price_all">
                            <p><?php echo ($item['qty'] * $item['price']) ?><span> грн.</span></p>
                        </div>
                        <a href="#" data-id='<?php echo $id?>' class="one_order_item_remove"></a>
                    </div>
                </div>

<?php  endforeach ?>

            </div>
            <div class="order_footer clearfix">
                <div class="order_remove">
                    <a href="#">Очистити кошик</a>
                </div>
                <div class="order_sum">
                    <p>Загальна сума замовлення:<span><?php echo $session['cart.sum'] ?></span>грн.</p>
                    <p>Загальна кількість:<span><?php echo $session['cart.qty'] ?></span>шт.</p>
                </div>
            </div>
            <div class="order_enter">
                <input type="submit" name="" value="Замовити">
            </div>
        </div>           
    </div>
</div>

<?php else:?>

<div class="row">
    <div class="col-lg-12">
    	<div class="cart_wrap clearfix">
	    	<div class="balance">
				<p class="balance_before">Ваш баланс<span>600</span>грн.</p>
			</div>
    		<div class="cart_title">
    			<span>Ваше замовлення</span>
    		</div>
    		<div class="order_item_wrap">
    			<div class="one_order_item  clearfix">
    				<p class="no_orders">Немає товарів</p>
    			</div>
    		</div>
    	</div>           
    </div>
</div>

<?php endif; ?>