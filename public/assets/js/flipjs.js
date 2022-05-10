var clocks = [];

(jQuery)(document).ready(function() {
  
  (jQuery)('.clock-1').each(function(){
  
    var time = (jQuery)(this).data("countdown");
    time = ((new Date(time))-(new Date().getTime()))/1000;
    
    var clock = (jQuery)(this).FlipClock(time, {
        countdown: true,
        clockFace: 'DailyCounter',
        callbacks: {
            stop: function() {
               reload()
            }
        }
    });
      
    clocks.push(clock);
    
  }); 

});