$(function(){ 
    $(".tab tr:odd").addClass("odd");        //��������ʽ 
    $(".tab tr:even").addClass("even");        //��ż����ʽ 
    //$(".tab tr:first").addClass("first");    //Ϊ��һ�м���ʽ 
    //$(".tab tr:last").addClass("last");        //Ϊ����м���ʽ 
    //Ϊ��Ԫ�ؼ������������Ƴ��¼� 
    $(".tab tr").mouseover(function() { 
     $(this).addClass("mouseOver")    //������ʽ 
 }).mouseout(function() { 
     $(this).removeClass("mouseOver")//ȥ����ʽ 
 }); 
}) 