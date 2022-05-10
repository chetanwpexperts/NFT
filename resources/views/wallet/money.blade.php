@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
    th {
        color:#f9f9f9;
    }
    input#show {
        background: #EECB1C;
        border: #0a0a09;
        box-shadow: 0px 6px 12px -12px #f39c12;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        padding: 1rem 3rem;
    }
    .table-responsive {
        display: inline-table;
    }
    .paymode {
        background: #139f4b26;
        padding: 0.6rem;
        color: #ffffff;
        border-radius: 1rem;
        box-shadow: 1px 2px 11px -5px #000000;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
    }
</style>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Money in wallet</h3>
				</div>
				<div class="wallet_money">
                    @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Error!</strong> {{ $message }}
                        </div>
                    @endif
                        <div class="alert alert-success success-alert alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> <span class="success-message"></span>
                        </div>
                    {{ Session::forget('success') }}
					<ul>
						<li><img src="{{ URL::asset('public/assets/dashboard/images/wallet-money.png'); }}" class="img-responsive money_img"/></li>
						<li><h3>&#8377;
                            <?php
                            if($walletamount != 0)
                            {
                                ?>
                                {{number_format($walletamount,2)}}
                                <?php 
                            }else{
                                ?>
                                0.00
                                <?php
                            }
                            ?>
                            </h3> </li>
					</ul>
					
				</div>
			</div>
          </div>
		  <div class="col-lg-6 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Add Money To Wallet</h3>
				</div>
				<div class="add_btn">
                    <div class="money_form">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control amount" id="money" aria-name="amount" placeholder="Enter Amount" style="width:56%;">
                            </div>
                            <a href="#" class="btn btn_add" id="rzp-button1">Add</a>
                        </form>					
                    </div>	
				</div>
			</div>
          </div>
		  <div class="col-lg-4 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Withdraw Money</h3>
				</div>
				<div class="money_form">
					<form>
                        @csrf
						<div class="form-group">
							<input type="text" class="form-control" id="money" aria-describedby="emailHelp" placeholder="Enter Amount">
						</div>
						<a href="#" class="btn btn_withdraw">Withdraw</a>
					</form>					
				</div>
			</div>
          </div>
          <!-- ./col -->
        </div>
         <div class="row">
              <div class="col-lg-11 col-12"> 
                <div class="money-wallet">
                    <div class="wallet-title">
                        <h3>Payments History</h3>
                    </div>
                    <div class="money_form">
                        <table class="table table-striped table-responsive" id="statmentloadmore" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Amount</th>
                                    <th> </th>
                                    <th>Mode</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            if(!empty($myStatements))
                            {
                                $i=1;
                                foreach($myStatements as $statement)
                                {
                                    date_default_timezone_set("Asia/Calcutta"); 
                                    $now = new \DateTime;
                                    $ago = new \DateTime($statement->created_at);
                                    $diff = $now->diff($ago);

                                    $diff->w = floor($diff->d / 7);
                                    $diff->d -= $diff->w * 7;

                                    $string = array(
                                         'y' => 'year',
                                         'm' => 'month',
                                         'w' => 'week',
                                         'd' => 'day',
                                         'h' => 'hour',
                                         'i' => 'minute',
                                         's' => 'second',
                                     );
                                     foreach ($string as $k => &$v) {
                                         if ($diff->$k) {
                                             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                         } else {
                                             unset($string[$k]);
                                         }
                                     }

                                     $target_date = $string ? implode(', ', $string) . ' ago' : 'just now';
                                     $imgsrc = "";
                                     switch($statement->mode)
                                     {
                                        case "EMD charges";
                                        case "offer charges";
                                            $imgsrc = URL::asset('public/assets/img/money.png');
                                            break;
                                             
                                        case "credit";
                                            $imgsrc = URL::asset('public/assets/img/get-money.png');
                                            break;
                                             
                                        case "debit";
                                            $imgsrc = URL::asset('public/assets/img/pay.png'); 
                                            break;
                                        case "service charges";
                                            $imgsrc = URL::asset('public/assets/img/box.png'); 
                                            break;
                                        case "refund";
                                            $imgsrc = URL::asset('public/assets/img/refund.png'); 
                                            break;
                                     }
                                    
                                     $statmentMode = str_replace("offer", "EMD", $statement->mode);
                                    ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{number_format($statement->amount,2)}}</td>
                                        <td style="text-align:right;"><img src="{{$imgsrc}}" style="width:50%;vertical-align:text-bottom;"></td>
                                        <td><div class="paymode">{{ucwords($statmentMode)}}</div></td>
                                        <td>{{$target_date}}</td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="12">Not Entry Found!</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <input id="show" type="button" value="Show More" />  
                    </div>


                </div>
              </div>
          </div>
        <!-- /.row -->
        <!-- Main row -->
       
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@include('layouts.dashboard.footer')
<script>
$(function() 
{
    var scrolled = 0;
    var totalrowshidden;
    var rows2display=4;
    var rem=0;
    var rowCount=0;
    var forCntr;
    var forCntr1;
    var MaxCntr=0;
    $('#hide').click(function() 
    {  
        var rowCount = $('#statmentloadmore tr').length;

        rowCount=rowCount/2;
        rowCount=Math.round(rowCount)
     
        for (var i = 0; i < rowCount; i++) 
        {
            $('tr:nth-child('+ i +')').hide(300); 
        }                            
    });

    $('#show').click(function() 
    {
        rowCount = $('#statmentloadmore tr').length;
  
        MaxCntr=forStarter+rows2display;
 
        if (forStarter<=$('#statmentloadmore tr').length)
        {

            for (var i = forStarter; i < MaxCntr; i++)
            { 
               $('tr:nth-child('+ i +')').show(200);
            }

            forStarter=forStarter+rows2display
       
         }
         else{
            $('#show').hide();
         }
        
        $('html, body').animate({
            scrollTop: $("#show").offset().top
        }, 2000);
     });   

    $(document).ready(function() 
    {
        var rowCount = $('#statmentloadmore tr').length;
      
      
        for (var i = $('#statmentloadmore tr').length; i > rows2display; i--) 
        {
            rem=rem+1
            $('tr:nth-child('+ i +')').hide(200);
        }
        forCntr=$('#statmentloadmore tr').length-rem;
        forStarter=forCntr+1;
        
        $('html, body').animate({
            scrollTop: $(".money-wallet").offset().top
        }, 2000);

    });
});
</script>