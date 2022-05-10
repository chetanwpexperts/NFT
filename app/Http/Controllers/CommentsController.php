<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $formData['user_id'] = $user->creator_id;
            $formData['nftid'] = $request->input('nftid');
            $formData['comment'] = $request->input('comment');
        
            $rsult = Comments::insert($formData);
            if($rsult)
            {
                $comment = DB::table('comments')->where(['user_id'=>$user->creator_id])->orderBy('id', 'desc')->first();
                $userDetails = User::where('creator_id', $comment->user_id)->first();
                $user_avatar = "";
                if($userDetails->dp == "")
                {
                    $user_avatar = asset("storage/app/public/".$userDetails->avatar);
                }else{
                    $user_avatar = asset("storage/app/public/".$userDetails->dp);
                }
                ob_start();
                ?>
                <div class="media">
                      <div class="media-left media-middle">
                        <a href="javascript:void(0);">
                          <img class="media-object" src="<?=$user_avatar?>" alt="user-img" style="border-radius:50%;height:50px;">
                        </a>
                      </div>
                      <div class="media-body">
                        <?php
                        //if (!$full) $string = array_slice($string, 0, 1);
                        $date = date('Y-m-d H:i:s');

                        $time1 = new DateTime($date);
                        $now = new DateTime();
                        $interval = $time1->diff($now);


                        if ($interval->y) $date = $interval->y . ' years';
                        elseif ($interval->m) $date = $interval->m . ' months';
                        elseif ($interval->d) $date = $interval->d . ' days';
                        elseif ($interval->h) $date = $interval->h . ' hours';
                        elseif ($interval->i) $date = $interval->i . ' minutes';
                        $postedDate = $this->time_elapsed_string($date, $full = false);
                        ?>
                        <h4 class="media-heading"><?=$userDetails->name?> <span><?=$postedDate?><!--2d--></span></h4>
                        <p><?=$comment->comment?>.</p>
                      </div>
                </div>
                <?php
                $html = ob_get_clean();
                echo $html;
            }else{
                echo 0;
            }
        }else{
            echo 2; // not logged in
        }
        die();
    }
    
    
    function load_data(Request $request)
    {
        $userarr = array();
        if($request->ajax())
        {
            $output = '';
            $last_id = '';
            $comments = Comments::where('nftid', $request->input('nftid'))->limit(25)->get();
            foreach($comments as $comment)
            {
                $userDetails = User::where('creator_id', $comment->user_id)->first();
                $user_avatar = "";
                if($userDetails->dp == "")
                {
                    $user_avatar = asset("storage/app/public/".$userDetails->avatar);
                }else{
                    $user_avatar = asset("storage/app/public/".$userDetails->dp);
                }
                $comment['dp'] = $user_avatar;
                $comment['name'] = $userDetails->name;
                $userarr[] = $comment;
            }
            $comments = $userarr;

            if(!empty($comments))
            {
                foreach($comments as $comment)
                {
                    ?>
                    <div class="media">
                        <div class="media-left media-middle">
                            <a href="#">
                                <img class="media-object" src="<?=$comment->dp?>" alt="user-img" style="border-radius:50%;height:50px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <?php
                            //if (!$full) $string = array_slice($string, 0, 1);
                            $date = $comment->created_at;

                            $time1 = new DateTime($date);
                            $now = new DateTime();
                            $interval = $time1->diff($now);


                            if ($interval->y) $date = $interval->y . ' years';
                            elseif ($interval->m) $date = $interval->m . ' months';
                            elseif ($interval->d) $date = $interval->d . ' days';
                            elseif ($interval->h) $date = $interval->h . ' hours';
                            elseif ($interval->i) $date = $interval->i . ' minutes';
                            $postedDate = $this->time_elapsed_string($date, $full = false);
                            ?>
                            <h4 class="media-heading"><?=$comment->name?><span><?=$postedDate?></span></h4>
                            <p><?=$comment->comment?>.</p>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <!--<div class="load-more">
                    <button class="btn btn-success" id="load_more_button">Load More</button>
                </div>-->
                <?php
            }else{
                ?>
                <div class="media">
                    <div class="media-body">
                        <p>No comments yet!</p>
                    </div>
                </div>
                <?php
            }
        }
    }
    
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
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

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
