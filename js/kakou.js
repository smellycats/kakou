$(function(){ 
    $(".tab tr:odd").addClass("odd");        //加奇行样式 
    $(".tab tr:even").addClass("even");        //加偶行样式 
    //$(".tab tr:first").addClass("first");    //为第一行加样式 
    //$(".tab tr:last").addClass("last");        //为最后行加样式 
    //为行元素加上鼠标移入和移出事件 
    $(".tab tr").mouseover(function() { 
     $(this).addClass("mouseOver")    //加上样式 
 }).mouseout(function() { 
     $(this).removeClass("mouseOver")//去掉样式 
 }); 
}) 