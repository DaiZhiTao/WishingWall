/**
 * Created by Dito on 2017/4/21.
 */
$(function () {
    var i = 0;
    $('.current').click(function(){

            if(i%2==0){
                $(this).css({
                    'transform':'rotateY(180deg)'
                });
            }else{
                $(this).css({
                    'transform':'rotateY(0deg)'
                });
            }
            i++;
            setTimeout(function(){
                $('.current .show').removeClass('show').siblings().addClass('show');
            },300);
        });
})