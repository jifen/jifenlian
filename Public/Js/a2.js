// JavaScript Document

  var speed1=30//速度数值越大速度越慢
  document.getElementById("demo22").innerHTML=document.getElementById("demo11").innerHTML
  function Marquee1(){
  if(document.getElementById("demo22").offsetWidth-document.getElementById("demo33").scrollLeft<=0){
  document.getElementById("demo33").scrollLeft-=document.getElementById("demo11").offsetWidth;
  }
  else{
  document.getElementById("demo33").scrollLeft++;
  }
  }
  var MyMar1=setInterval(Marquee1,speed1)
  document.getElementById("demo33").onmouseover=function () {clearInterval(MyMar1)}
  document.getElementById("demo33").onmouseout=function () {MyMar1=setInterval(Marquee1,speed1)}