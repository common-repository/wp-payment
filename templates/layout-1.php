<section id="bootstrap">
      <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
      <form class="well form-horizontal" name="paymentSubmit" action="" method="POST" id="paymentSubmit">
        <fieldset>
          <legend>User Details</legend>
          <div class="form-group">
            <label class="col-md-4 control-label">Name</label>  
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  name="your_name" id="your_name" placeholder="Name" class="form-control"  type="text">
                <div id="elmNameError" class="errorMsg"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label">E-Mail</label>  
              <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input name="email" id="email" placeholder="E-Mail Address" class="form-control"  type="text">
                    <div id="elmEmailError" class="errorMsg"></div>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">Comments</label>
            <div class="col-md-8 inputGroupContainer">
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                  <textarea class="form-control" name="comments" id="comments" placeholder="Any thing you want to say for this donation."></textarea>
              </div>
            </div>
          </div>
          <legend>Payment Details</legend>
          <?php 
          $paypal_title = get_option('paypal_title') ? esc_attr( get_option('paypal_title') ) : 'By PayPal';
          $auth_title = get_option('auth_title') ? esc_attr( get_option('auth_title') ) : 'Credit Card (by Authorize.NET)';
          $auth_status = get_option('auth_status') ? esc_attr( get_option('auth_status') ) : 'enable';
          $paypal_status = get_option('paypal_status') ? esc_attr( get_option('paypal_status') ) : 'enable'; 
          ?>
          <?php 
            if($auth_status == 'disable' && $paypal_status == 'disable') { 
              echo "Payment system is not available.";
            }else
            {
          ?>
              <div class="form-group"> 
                <label class="col-md-4 control-label">Payment Through</label>
                <div class="col-md-8 selectContainer">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                    <select name="choosePayment" id="choosePayment" onChange="enable();" class="form-control selectpicker">
                      <?php if($auth_status == 'enable'){ ?>
                      <option value="authorize"><?php echo $auth_title; ?></option>
                      <?php } ?>
                      <?php if($paypal_status == 'enable'){ ?>
                      <option value="paypal"><?php echo $paypal_title; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <?php if($paypal_status == 'enable'){ ?>
              <div id="paypal">
                <div class="form-group">
                  <label class="col-md-4 control-label">Amount(in USD)<span class="required">*</span></label>
                  <div class="col-md-8 selectContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                      <input type="text" name="paypal_amount" class="input-field" id="paypal_amount" placeholder="Donation Amount" />
                      <div id="elmPaypalAmountError" class="errorMsg"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Card Type</label>
                  <div class="col-md-8 selectContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                      <select name="_paypal_card_type" class="form-control selectpicker">
                        <option value="mastercard">MasterCard</option>
                        <option value="visa">Visa</option>
                        <option value="amex">American Express</option>
                        <option value="discover">Discover</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Card No.<span class="required">*</span></label>
                  <div class="col-md-8 selectContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                      <input type="text" id="cardNo1" rel="19" name="_paypal_card_no" class="input-field" placeholder="Card Number"/>
                      <div id="elmCardNo1Error" class="errorMsg"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Expiry Date</label>  
                    <div class="col-md-4 selectContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-dashboard"></i></span>
                        <select name="_paypal_card_exp_month" class="form-control selectpicker" >
                          <?php for($i=1;$i<=12;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 selectContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <select name="_paypal_card_exp_year" class="form-control selectpicker" >
                          <?php for($i=2018;$i<=2050;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">CVV / CVV2</label>  
                  <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-qrcode"></i></span>
                      <input placeholder="CVV" class="form-control"  type="text" rel="19" name="_paypal_cvv2" id="_paypal_card_cvv2">
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <?php if($auth_status == 'enable'){ ?>
              <div id="authorize">
                <?php $auth_typeofpay = get_option('auth_typeofpay') ? esc_attr( get_option('auth_typeofpay') ) : 'onetime'; ?>
                <?php if($auth_typeofpay == 'both'){ ?>
                  <div class="form-group"> 
                    <label class="col-md-4 control-label">Type Of Payment</label>
                      <div class="col-md-8 selectContainer">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                        <select name="type_of_pay" id="type_of_pay" onchange="front_recurring_check();" class="form-control selectpicker" >
                          <option value="one_time">One Time</option>
                          <option value="recurring">Recurring</option>
                        </select>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <?php if($auth_typeofpay == 'onetime'){ ?>
                  <div class="form-group">
                    <label class="col-md-4 control-label">One Time Amount(in USD)</label>  
                      <div class="col-md-8 inputGroupContainer">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                          <input name="onetime_auth_amount" id="auth_amount" placeholder="One Time Amount" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <?php if($auth_typeofpay != 'onetime'){ ?>
                  <div id="auth_onetime_details">
                    <div class="form-group">
                      <label class="col-md-4 control-label">One Time Amount(in USD)</label>  
                        <div class="col-md-8 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                            <input name="onetime_auth_amount" id="auth_amount" placeholder="One Time Amount" class="form-control"  type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="auth_recurring_details">
                    <?php $auth_renewlength_set_by = get_option('auth_renewlength_set_by') ? esc_attr( get_option('auth_renewlength_set_by') ) : 'admin'; ?>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Recurring Amount(in USD)</label>  
                        <div class="col-md-8 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                            <input name="recurring_auth_amount" id="recurring_auth_amount" placeholder="Recurring Amount" class="form-control"  type="text">
                            <div id="elmAuthAmountError" class="errorMsg"></div>
                        </div>
                      </div>
                    </div>
                    <?php 
                      if($auth_renewlength_set_by == 'admin')
                      { 
                        $auth_renewlength = get_option('auth_renewlength') ? esc_attr( get_option('auth_renewlength') ) : 7;
                        $auth_relengthunit = get_option('auth_relengthunit') ? esc_attr( get_option('auth_relengthunit') ) : 7;
                    ?>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Recurring Amount per</label>  
                        <div class="col-md-4 inputGroupContainer">
                          <?php echo $auth_renewlength; ?> <?php echo $auth_relengthunit; ?>
                        </div>
                      </div>
                    <?php
                      }else{
                    ?>
                            <div class="form-group">
                              <label class="col-md-4 control-label">Recurring Amount per</label>  
                                <div class="col-md-4 inputGroupContainer">
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-dashboard"></i></span>
                                      <input type="number" intOnly="true"  name="auth_renew_length" id="auth_renew_length" class="form-control auth_renew_length" value="7"/>
                                  </div>
                                </div>
                                <div class="col-md-4 selectContainer">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <select name="interval_length_unit" class="form-control selectpicker" >
                                      <option value="days">Day(s)</option>
                                      <option value="months">Month(s)</option>
                                      <option value="years">Year(s)</option>
                                    </select>
                                  </div>
                              </div>
                            </div>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="form-group">
                  <label class="col-md-4 control-label">Card Number</label>  
                  <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                      <input  type="text" id="cardNo2" rel="19" name="_auth_card_no" class="form-control"  placeholder="Card Number"/>
                      <div id="elmCardNo2Error" class="errorMsg"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Expiry Date</label>  
                    <div class="col-md-4 selectContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-dashboard"></i></span>
                        <select name="_auth_card_exp_month" class="form-control selectpicker" >
                          <?php for($i=1;$i<=12;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 selectContainer">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <select name="_auth_card_exp_year" class="form-control selectpicker" >
                          <?php for($i=2018;$i<=2050;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">CVV / CVV2</label>  
                  <div class="col-md-8 inputGroupContainer">
                  <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-qrcode"></i></span>
                  <input  name="_auth_card_cvv" placeholder="CVV" class="form-control"  type="text">
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <input type="hidden" name="redirectUrl" value="<?php echo get_permalink();?>" />
              <?php 
                if(isset($_GET['wp_payment_msg']))
                {
                  
                  if($_GET['appr_status'] == 1)
                  {
                    ?>
                      <div class="alert alert-success" role="alert" id="success_message"><i class="glyphicon glyphicon-thumbs-up"></i> 
                        <?php print_r($_GET['wp_payment_msg']);?>
                      </div>
                    <?php
                  }
                  if($_GET['appr_status'] == 0)
                  {
                    ?>
                       <div class="alert alert-failure" role="alert" id="failure_message"><i class="glyphicon glyphicon-thumbs-down"></i> 
                        <?php print_r($_GET['wp_payment_msg']);?>
                      </div>
                    <?php
                  }

                }
              ?>
              
              <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4">
                  <!-- <button type="submit" class="btn btn-warning">Donate <span class="glyphicon glyphicon-send"></span></button> -->
                  <span class="icon-input-btn">
                    <span class="glyphicon glyphicon-send"></span> 
                    <input type="submit" class="btn btn-primary btn-lg" value="Donate" name="submit">
                  </span>
                    <!-- <input type="submit" class="btn btn-warning" value="submit" name="submit"> -->
              </div>
          <?php 
            } ?>

        </fieldset>
      </form>
</section>
<style type="text/css">
    .bs-example{
      margin: 20px;
    }
    .icon-input-btn{
        display: inline-block;
        position: relative;
    }
    .icon-input-btn input[type="submit"]{
          background: white;
          color: black;
          font-size: 17px;
          font-weight: 100;
          border: 1px solid black;
          border-radius: 4px;
          padding: 12px 0px 12px 23px;
          width: 102px;
    }
    .icon-input-btn .glyphicon{
        display: inline-block;
        position: absolute;
        left: 0.65em;
        top: 30%;
    }
</style>
